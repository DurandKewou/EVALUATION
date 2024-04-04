@extends('layout/admin-layout')

@section('space-work')
    <h2 class="mb-4">Subjects</h2>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubjectModal">
        Add Subject
    </button>

    <table class="table mt-5">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Subject</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
          </tr>
        </thead>
        <tbody>
            @if (count($subjects) > 0)
                @foreach ($subjects as $subject)
                    <tr>
                        <td>{{ $subject->id }}</td>
                        <td>{{ $subject->subject }}</td>
                        <td><button class="btn btn-info editButton" data-id = "{{$subject->id}}" data-subject = "{{$subject->subject}}" data-bs-toggle="modal" data-bs-target="#editSubjectModal">Edit</button></td>
                        <td><button class="btn btn-danger deleteButton" data-id = "{{$subject->id}}" data-bs-toggle="modal" data-bs-target="#deleteSubjectModal">Delete</button></td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">Subject not Found!</td>
                </tr>
            @endif
        </tbody>
    </table>
  
    <!--Add Subject Modal -->
    <div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form id="addSubject">
                @csrf

                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Subject</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="">Subject:-</label>
                        <input type="text" name="subject" id="" placeholder="Enter Subject name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--Edit Subject Modal -->
    <div class="modal fade" id="editSubjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Subject</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>  
                    <form id="editSubject">
                        @csrf
    
                        <div class="modal-body">
                            <label for="">Subject:-</label>
                            <input type="text" name="subject"  placeholder="Enter Subject name" id="edit_Subject" required>
                            <input type="hidden" name="id" id="edit_subject_id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>    
                </div>
            
        </div>
    </div>

    <!--Delete Subject Modal -->
    <div class="modal fade" id="deleteSubjectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
    
            <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Subject</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>  
                        <form id="deleteSubject">
                            @csrf
        
                            <div class="modal-body">
                                <p>Are you Sure you want to delete Subject</p>
                                <input type="hidden" name="id" id="delete_subject_id">
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
            
            $("#addSubject").submit(function(e){
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{route('addSubject')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if (data.success == true) 
                        {
                            location.reload();
                        }else{
                            alert(data.msg);
                        }
                    }
                });
            });

            //edit subject
            $(".editButton").click(function(){
                var subject_id = $(this).attr('data-id');
                var subject = $(this).attr('data-subject');
                $("#edit_subject").val(subject);
                $("#edit_subject_id").val(subject_id);
            });

            $("#editSubject").submit(function(e){
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{route('editSubject')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if (data.success == true) 
                        {
                            location.reload();
                        }else{
                            alert(data.msg);
                        }
                    }
                });
            });

            //delete subject
            $(".deleteButton").click(function(e){

                var subject_id = $(this).attr('data-id');

                $("#delete_subject_id").val(subject_id);
            });

            $("#deleteSubject").submit(function(e){
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: "{{route('deleteSubject')}}",
                    type:"POST",
                    data:formData,
                    success:function(data){
                        if (data.success == true) 
                        {
                            location.reload();
                        }else{
                            alert(data.msg);
                        }
                    }
                });
            })
        });
    </script>

@endsection