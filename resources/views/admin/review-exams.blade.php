@extends('layout/admin-layout')

@section('space-work')

    <h2 class="mb-4">Student Exam</h2>


    <table class="table mt-5">
        <thead>
            <th>#</th>
            <th>Name</th>
            <th>Exam</th>
            <th>Statut</th>
            <th>Review</th>
        </thead>
        <tbody>
            @if (count($attempts) > 0)
                @php
                    $x = 1;
                @endphp
                @foreach ($attempts as $attempt)
                    <tr>
                        <td>{{$x++}}</td>
                        <td>{{$attempt->user->name}}</td>
                        <td>{{$attempt->exam->exam_name}}</td>
                        <td>
                            @if ($attempt->status == 0)
                                <span style="color: red">Pending</span>
                            @else
                                <span style="color: green">Approved</span>
                            @endif
                        </td>
                        <td>
                            @if ($attempt->status == 0)
                               <a href="#" class="reviewExam" data-id="{{$attempt->id}}" data-bs-toggle="modal" data-bs-target="#reviewExamModal">Review & Approved</a>
                            @else
                                Complet
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5">Student not Attempt Exams!</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!--Add Students Modal -->
    <div class="modal fade" id="reviewExamModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Review Exam</h1>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="reviewForm">
                    @csrf
                    <input type="hidden" name="attempt_id" id="attempt_id">
                    <div class="modal-body review-exam">
                        loading...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary approved-btn">Approved </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function (){
            $('.reviewExam').click(function (){
                var id = $(this).attr('data-id');
                $('#attempt_id').val(id);

                $.ajax({
                    url:"{{route('reviewQna')}}",
                    type:"GET",
                    data:{attempt_id:id},
                    success:function(data){
             
                        var html = '';
                        if (data.success == true) {
                            var data = data.data;
                            if (data.length>0) {
                               // console.log(data);
                                for (let i = 0; i < data.length; i++) {
                                    let isCorrect = '<span style="color:red" class="fa fa-close"></span>';
                                    if (data[i]['answers']['is_correct'] == 1) {
                                        isCorrect = '<span style="color:green" class="fa fa-check"></span>';
                                    }
                                    let answer = data[i]['answers']['answer'];

                                    html +=`
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h6>Q(`+(i+1)+`).`+data[i]['question']['question']+`</h6>
                                                <p>Ans:-`+answer+` `+isCorrect+`</p>
                                            </div>
                                        </div>
                                    `;
                                }
                            }else{
                                html +=`<h6>Student not Attempt any Question </h6>
                                    <p>If you Approve this Exam Student will faill </p>
                                `;
                            }
                        } else {
                            html += `<p>Having some serve issue </p>`;
                        }

                        $('.review-exam').html(html);
                    }
                });
            });

            //approve Exam
            $('#reviewForm').submit(function(event){
                event.preventDefault();

                $('.approved-btn').html('Please Wait <i class="fa fa-spinner fa-spin"></i>')

                var formDate = $(this).serialize();
                $.ajax({
                    url:"{{route('approvedQna')}}",
                    type:"POST",
                    data:formDate,
                    success:function(data){
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                })
            });
        });
    </script>

@endsection