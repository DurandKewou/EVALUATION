@extends('layout/admin-layout')

@section('space-work')

    <h2 class="mb-4">Exams</h2>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExamModal">
        Add Exams
    </button>

    <!--Add Exam Modal -->
    <div class="modal fade" id="addExamModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Exam</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addExam">
                    @csrf
                    <div class="modal-body">
                        <input type="text" name="exam_name" id="" placeholder="Enter Exam name" class="w-100" required>
                        <br><br>
                        <select name="subject_id" id=""required class="w-100">
                            <option value="">Select Subject</option>

                            @if (count($subjects) > 0)
                                @foreach ($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->subject}}</option>
                                @endforeach
                            @endif
                        </select>
                        <br><br>
                        <input type="date" name="date" class="w-100" id="" required min="@php echo date('Y-m-d'); @endphp">
                        <br><br>
                        <input type="time" name="time" class="w-100" id="" required>
                        <br><br>
                        <input type="number" min="1" name="attempt" placeholder="Enter Attempt Time" class="w-100" id="" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <table class="table mt-3">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Exam name</th>
            <th scope="col">Subject</th>
            <th scope="col">Date</th>
            <th scope="col">Time</th>
            <th scope="col">Attempt</th>
            <th scope="col">Add Question</th>
            <th scope="col">Show Question</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
          </tr>
        </thead>
        <tbody>
            @if ( count($exams) > 0)
                @foreach ($exams as $exam)
                    <tr>
                        <td>{{$exam->id}}</td>
                        <td>{{$exam->exam_name}}</td>
                        <td>{{$exam->subjects[0]['subject']}}</td>
                        <td>{{$exam->date}}</td>
                        <td>{{$exam->time}} Hrs</td>
                        <td>{{$exam->attempt}} Hrs</td>
                        <td>
                            <button class="btn btn-info addQuestion" data-id="{{ $exam->id }}" data-bs-toggle="modal" data-bs-target="#addQnaModal">Add Question</button>
                        </td>
                        <td>
                            <button class="btn btn-info seeQuestion" data-id="{{ $exam->id }}" data-bs-toggle="modal" data-bs-target="#seeQnaModal">See Question</button>
                        </td>
                        <td>
                            <button class="btn btn-info editButton" data-id="{{ $exam->id }}" data-bs-toggle="modal" data-bs-target="#editExamModal">Edit</button>
                        </td>
                        <td>
                            <button class="btn btn-danger deleteButton" data-id="{{ $exam->id }}" data-bs-toggle="modal" data-bs-target="#deleteExamModal">Delete</button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5"> Exams not Found!</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!--Edit Exam Modal -->
    <div class="modal fade" id="editExamModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Exam</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editExam">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="exam_id" id="exam_id">
                            <input type="text" name="exam_name" id="exam_name" placeholder="Enter Exam name" class="w-100" required>
                            <br><br>
                            <select name="subject_id" id="subject_id" required class="w-100">
                                <option value="">Select Subject</option>
    
                                @if (count($subjects) > 0)
                                    @foreach ($subjects as $subject)
                                        <option value="{{$subject->id}}">{{$subject->subject}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <br><br>
                            <input type="date"  name="date" class="w-100" id="date" required min="@php echo date('Y-m-d'); @endphp">
                            <br><br>
                            <input type="time" name="time" class="w-100" id="time" required>
                            <br><br>
                            <input type="number" min="1" name="attempt" placeholder="Enter Exam Attempt Time" class="w-100" id="attempt" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
    </div>

    <!--Delete Exam Modal -->
    <div class="modal fade" id="deleteExamModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">\
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Exam</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="deleteExam">
                        @csrf
                        <div class="modal-body">
                            <p>Are your Sure you want to Delete  Exam!</p>
                            <input type="hidden" name="exam_id" id="exam_id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
    </div>

    <!--Add Answer Modal -->
    <div class="modal fade" id="addQnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Question</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addQna">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="exam_id" id="addExamId">
                        <input type="search" name="search" id="search" onkeyup="searchTable()" class="w-100" id="" placeholder="Search Here !">
                        <br>
                        <table class="table" id="questionsTable">
                            <thead>
                                <th>Select</th>
                                <th>Question</th>
                            </thead>
                            <tbody class="addBody">

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Qna</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--see question Modal -->
    <div class="modal fade" id="seeQnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Question</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        <table class="table" id="">
                            <thead>
                                <th>S.No</th>
                                <th>Question</th>
                                <th>Delete</th>
                            </thead>
                            <tbody class="seeQuestionTable">

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){

            $("#addExam").submit(function(e){
                e.preventDefault(); 

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{route('addExam')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            $(".editButton").click(function(){
                var id = $(this).attr('data-id');
                $("#exam_id").val(id);

                var url = '{{route("getExamDetail","id")}}';
                url = url.replace('id',id);

                $.ajax({
                    url:url,
                    type:"GET",
                    success:function(data){
                        if (data.success == true) {
                            var exam = data.data;
                            $("#exam_name").val(exam[0].exam_name);
                            $("#subject_id").val(exam[0].subject_id);
                            $("#date").val(exam[0].date);
                            $("#time").val(exam[0].time);
                            $("#attempt").val(exam[0].attempt);
                        } else {
                            alert(data.msg)
                        }
                    }

                });
            });

            $("#editExam").submit(function(e){
                e.preventDefault(); 

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{route('updateExam')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            $(".deleteButton").click(function(){
                var id = $(this).attr('data-id');
                $("#exam_id").val(id);
            });

            $("#deleteExam").submit(function(e){
                e.preventDefault(); 

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{route('deleteExam')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            //add question
            $(".addQuestion").click(function(){
                var id = $(this).attr('data-id');
                $("#addExamId").val(id);

                $.ajax({
                    url:"{{route('getQuestion')}}",
                    type:"GET",
                    data:{exam_id:id},
                    success:function(data){
                        if (data.success == true) {
                            var questions = data.data;
                            var html= ``;
                            if (questions.length > 0) {
                                for (let i = 0; i < questions.length; i++) {
                                    html += `
                                        <tr>
                                            <td colspan="2"><input type="checkbox" value="`+questions[i]['id']+`" id="" name="questions_ids[]"></td>
                                            <td>`+questions[i]['questions']+`</td>
                                        </tr>
                                    `;
                                    
                                }
                            }else{
                                html += `
                                    <tr>
                                        <td colspan="2">Question not Available</td>
                                    </tr>
                                `;
                            }

                            $('.addBody').html(html);
                        }else{
                            alert(data.msg);
                        }
                    }
                });
            });

            $("#addQna").submit(function(e){
                e.preventDefault(); 

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{route('addQuestion')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

            $('.seeQuestion').click(function (){
                var id = $(this).attr('data-id');

                $.ajax({
                    url:"{{route('getExamQuestion')}}",
                    type:"GET",
                    data:{exam_id:id},
                    success:function(data){
                        //console.log(data);
                        var html=``;
                        var questions = data.data;
                        if (questions.length > 0) {
                            for (let i = 0; i < questions.length; i++) {
                                html +=`
                                    <tr>
                                        <td colspan="1">`+(i+1)+`</td>
                                        <td colspan="1">`+questions[i]['question'][0]['question']+`</td>
                                        <td>
                                            <button class="btn btn-danger deleteQuestion" data-id="`+questions[i]['id']+`">Delete</button>
                                        </td>
                                    </tr>
                                `;
                            }
                        } else {
                            html +=`
                                <tr>
                                    <td colspan="1">Questions not Available</td>
                                </tr>
                            `;
                        }
                        $(".seeQuestionTable").html(html);
                    }
                });
            });

            //Delete question
            $(document).on('click','.deleteQuestion',function(){
                var id = $(this).attr('data-id');
                var obj= $(this);

                $.ajax({
                    url:"{{route('deleteExamQuestion')}}",
                    type:"GET",
                    data:{id:id},
                    success:function(data){
                        if (data.success == true) {
                           obj.parent().parent().remove();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });
        });
    </script>

    <script>
        function searchTable(){
            var input , filter , table , tr, td , i ,txtvalue;
            input  = document.getElementById('search');
            filter = input.value.toUpperCase();
            table = document.getElementById('questionsTable');
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtvalue = td.textContent || td.innerText;
                    if (txtvalue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
                
            }
        }
    </script>
    
@endsection