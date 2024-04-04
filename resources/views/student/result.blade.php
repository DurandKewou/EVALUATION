@extends('layout/student-layout')

@section('space-work')
    <h2>Results</h2>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Exam</th>
                <th>Result</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $x=1;
            @endphp
            @if (count($attempts) > 0)
                @foreach ($attempts as $attempt)
                    <tr>
                        <td>{{$x++}}</td>
                        <td>{{$attempt->exam->exam_name}}</td>
                        <td>
                            @if ($attempt->status == 0)
                                Not Declared
                            @else
                                @if ($attempt->marks >= $attempt->pass_marks)
                                    <span style="color: green">Passed</span>
                                @else
                                    <span style="color: red">Failled</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if ($attempt->status == 0)
                                <span style="color: red">Pending</span>
                            @else
                                <a href="#" data-id="{{$attempt->id}}" class="reviewExam" data-bs-toggle="modal" data-bs-target="#reviewQnaModal">Review Q&A</a>
                            @endif
                        </td>
                    </tr>   
                @endforeach
            @else
                <tr>
                    <th colspan="5"> You not Attempt any Exam!</th>
                </tr>
            @endif
        </tbody>
    </table>

    <!--Add Students Modal -->
    <div class="modal fade" id="reviewQnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Review Exam</h1>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="">
                    @csrf
                    <div class="modal-body review-qna">
                        loading...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="explainationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">ExplainationModal</h1>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="">
                    @csrf
                    <div class="modal-body">
                       <p id="explaination"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function (){
            $('.reviewExam').click(function (){
                var id = $(this).attr('data-id');

                $.ajax({
                    url:"{{route('reviewStudentQna')}}",
                    type:"GET",
                    data:{attempt_id:id},
                    success:function(data){
                        //console.log(data);
                        var html = '';

                        if (data.success == true) {
                            var data = data.data;

                            if (data.length > 0) {
                                for (let i = 0; i < data.length; i++) {
                                    let answer = data[i]['answers']['answer'];

                                    let isCorrect = '<span style="color:red;" class="fa fa-close"></span>';

                                    if (data[i]['answers']['is_correct'] == 1) {
                                        isCorrect = '<span style="color:green;" class="fa fa-check"></span>';
                                    }
                                    html += `
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h6>Q(`+(i+1)+`). `+data[i]['question']['question']+` <h6>
                                                <p>Ans:-`+answer+` `+isCorrect+`</p>
                                            </div>
                                        </div>
                                    `;
                                    
                                }
                            } else {
                                html += `<h6>You didn't attempt any Question!`;
                            }
                        }else{
                            html += `<p>Havieng some issue on server side</p>`
                        }

                        $('.review-qna').html(html);
                    }
                });
            });
        });
    </script>
@endsection