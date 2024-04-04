@extends('layout/admin-layout')

@section('space-work')

    <h2 class="mb-4">Q&A</h2>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQnaModal">
        Add Q&A
    </button>

    <table class="table mt-5">
        <thead>
            <th>#</th>
            <th>Question</th>
            <th>Answers</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
        <tbody>
            @if (count($questions) >0)
                @foreach ($questions as $question)
                    <tr>
                        <td>{{$question->id}}</td>
                        <td>{{$question->question}}</td>
                        <td>
                            <a href="#" class="ansButton btn btn-success" data-id="{{ $question->id }}" data-bs-toggle="modal" data-bs-target="#showAnsModal">See Answers</a>
                        </td>
                        <td>
                            <button class="btn btn-info editButton" data-id ="{{ $question->id }}" data-bs-toggle="modal" data-bs-target="#editQnaModal">Edit</button>
                        </td>
                        <td>
                            <button class="btn btn-danger deleteButton" data-id ="{{ $question->id }}" data-bs-toggle="modal" data-bs-target="#deleteQnaModal">Delete</button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">Question and Reponse not found </td>
                </tr>
            @endif
        </tbody>
    </table>

    <!--Add Q&A Modal -->
    <div class="modal fade" id="addQnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Q&A</h1>

                    <button id="addAnswer" class="ml-5 btn btn-info">Add Answer</button>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addQna">
                    @csrf
                    <div class="modal-body addModalAnswers">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="w-100" name="question" placeholder="Entrez la question" id="" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <textarea name="explaination" class="w-100" placeholder="Entrez L'explication(Optional)"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span class="error" style="color: red;"></span>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Q&A </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Show Answers Modal -->
    <div class="modal fade" id="showAnsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Show Answers</h1>
    
    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Answers</th>
                                <th>Is Correct</th>
                            </thead>
                            <tbody class="showAnswers">

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <span class="error" style="color: red;"></span>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
            </div>
        </div>
    </div>

    <!--Edit Q&A Modal -->
    <div class="modal fade" id="editQnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Q&A</h1>

                    <button id="addEditAnswer" class="ml-5 btn btn-info">Add Answer</button>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editQna">
                    @csrf
                    <div class="modal-body editModalAnswers">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="question_id" id="question_id">
                                <input type="text" class="w-100" name="question" id="question" placeholder="Entrez la question" id="" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <textarea name="explaination" id="explaination" class="w-100" placeholder="Entrez L'explication(Optional)"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span class="editError" style="color: red;"></span>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Q&A </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Delete Exam Modal -->
    <div class="modal fade" id="deleteQnaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Q&A</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="deleteQna">
                        @csrf
                        <div class="modal-body">
                            <p>Are your Sure you want to Delete  Q&A!</p>
                            <input type="hidden" name="exam_id" id="delete_qna_id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
    </div>

    <script>
        $(document).ready(function(){

            //form submit
            $("#addQna").submit(function(e){
                e.preventDefault();

                if ($(".answers").length < 2) {
                    $(".error").text("Please add minimun two answers")
                    setTimeout(function(){
                        $(".error").text("");
                    }, 2000);
                } else {
                    
                    var checkIscorrect = false;

                    for(let i=0; i<$(".is_correct").length; i++){
                        if ($(".is_correct:eq("+i+")").prop('checked') ==true ) {
                            checkIscorrect = true;

                            $(".is_correct:eq("+i+")").val($(".is_correct:eq("+i+")").next().find('input').val());
                        }
                    }

                    if (checkIscorrect) {
                        var formDate = $(this).serialize();

                        $.ajax({
                            url:"{{route('addQna')}}",
                            type:"POST",
                            data:formDate,
                            success:function(data){
                                console.log(data);
                                if(data.success == true){
                                    location.reload();
                                }else{
                                    alert(data.msg);
                                }
                            }
                        });
                    } else {
                        $(".error").text("Please select anyone correct answers")
                        setTimeout(function(){
                            $(".error").text("");
                        }, 2000);
                    }
                }
            });

            //add answers
            $("#addAnswer").click(function(){
                if ($(".answers").length >= 5) {
                    $(".error").text("You can add maximun 5 answers")
                    setTimeout(function(){
                        $(".error").text("");
                    }, 2000);
                } else {
                    var html = `
                            <div class="row mt-2 answers">
                                <input type="radio" name="is_correct" class="is_correct col-2">
                                <div class="col">
                                    <input type="text" class="w-100" name="answers[]" placeholder="Entrez la Reponse" id="" required>
                                </div>
                                <button class="col-5 btn btn-danger removeButton">Remove</button>
                            </div>
                    `;

                    $(".addModalAnswers").append(html);
                }
            });

            $(document).on("click",".removeButton",function(){
               $(this).parent().remove();
            });

            //Show Answers
            $(".ansButton").click(function() {

                var questions = @json($questions);

                var qid  = $(this).attr('data-id');

                var html = ``;

                //console.log(questions);

               for (let i = 0; i < questions.length; i++) {

                    if (questions[i]['id'] == qid) {

                        var answersLength = questions[i]['answers'].length;

                        for (let j = 0; j < answersLength ; j++) {

                            let is_correct = 'No';

                            if (questions[i]['answers'][j]['is_correct'] == 1) {
                                
                                is_correct = 'Yes';
                            }

                            html += `
                                <tr>
                                    <td>`+(j+1)+`</td>
                                    <td>`+questions[i]['answers'][j]['answer']+`</td>
                                    <td>`+is_correct+`</td>
                                </tr>
                            `;
                            
                        }

                        break;
                    }
                
               }

               $('.showAnswers').html(html);

            });

            //edit or update Q&A
            $("#addEditAnswer").click(function(){
                if ($(".editAnswers").length >= 5) {
                    $(".editError").text("You can add maximun 5 answers")
                    setTimeout(function(){
                        $(".editError").text("");
                    }, 2000);
                } else {
                    var html = `
                            <div class="row mt-2 editAnswers">
                                <input type="radio" name="is_correct" class="edit_is_correct col-2">
                                <div class="col">
                                    <input type="text" class="w-100" name="new_answers[]" placeholder="Entrez la Reponse" id="" required>
                                </div>
                                <button class="col-5 btn btn-danger removeButton">Remove</button>
                            </div>
                    `;

                    $(".editModalAnswers").append(html);
                }
            });

            $(".editButton").click(function(){
                var qid = $(this).attr('data-id');

                $.ajax({
                    url:"{{route('getQnaDetails')}}",
                    type:"GET",
                    data:{qid:qid},
                    success:function(data){
                        //console.log(data);
                        var qna = data.data[0];
                        $("#question_id").val(qna['id']);
                        $("#question").val(qna['question']);
                        $("#explaination").val(qna['explaination']);
                        
                        $(".editAnswers").remove();

                        var html = ``;

                        for (let i = 0; i < qna['answers'].length; i++) {

                            var checked = '';
                            if (qna['answers'][i]['is_correct'] == 1) {

                                checked = 'checked';

                            }

                                html += `
                                    <div class="row mt-2 editAnswers">
                                        <input type="radio" name="is_correct" class="edit_is_correct col-2 " `+checked+`>
                                        <div class="col">
                                            <input type="text" class="w-100" name="answers[`+qna['answers'][i]['id']+`]" placeholder="Entrez la Reponse" value="`+qna['answers'][i]['answer']+`" required>
                                        </div>
                                        <button class="col-5 btn btn-danger removeButton removeAnswer" data-id="`+qna['answers'][i]['id']+`">Remove</button>
                                    </div>
                                `;
                            
                        }

                        $(".editModalAnswers").append(html);
                    }
                })
            });

            //Upload submit
            $("#editQna").submit(function(e){
                e.preventDefault();

                if ($(".editAnswers").length < 2) {
                    $(".editError").text("Please add minimun two answers")
                    setTimeout(function(){
                        $(".editError").text("");
                    }, 2000);
                } else {
                    
                    var checkIscorrect = false;

                    for(let i=0; i<$(".edit_is_correct").length; i++){
                        if ($(".edit_is_correct:eq("+i+")").prop('checked') ==true ) {
                            checkIscorrect = true;

                            $(".edit_is_correct:eq("+i+")").val($(".edit_is_correct:eq("+i+")").next().find('input').val());
                        }
                    }

                    if (checkIscorrect) {

                        var formData = $(this).serialize();

                        $.ajax({
                            url:"{{route('updateQna')}}",
                            type:"POST",
                            data:formData,
                            success:function(data){
                                if (data.success == true) {
                                    location.reload();
                                }else{
                                    alert(data.msg);
                                }
                            }
                        });
                    } else {
                        $(".editError").text("Please select anyone correct answers")
                        setTimeout(function(){
                            $(".editError").text("");
                        }, 2000);
                    }
                }
            });

            //Remove Answers
            $(document).on('click','.removeAnswer',function(){
                var ansId = $(this).attr('data-id');

                $.ajax({
                    url:"{{route('deleteAns')}}",
                    type:"GET",
                    data:{id:ansId},
                    success:function(data){
                        if (data.success == true) {
                            console.log(data.msg);
                        }else{
                            alert(data.msg);
                        }
                    }
                });
            });

            //Delete Q&A
            $('.deleteButton').click(function(){
                var id = $(this).attr('data-id');
                $('#delete_qna_id').val(id);
            });

            $("#deleteQna").submit(function(e){
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{route('deleteQna')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        //console.log(data)
                        if (data.success == true) {
                            location.reload();
                        } else {
                            alert(data.msg);
                        }
                    }
                });
            });

        });
    </script>

@endsection