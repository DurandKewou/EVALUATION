@extends('layout/admin-layout')

@section('space-work')

    <h2 class="mb-4">Students</h2>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
        Add Students
    </button>

    <!--Add Students Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Students</h1>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addStudent">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="w-100" name="name" placeholder="Entrez le Nom" id="" required>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <input type="email" class="w-100" name="email" placeholder="Entrez l'Email" id="" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Student </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Edit Students Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Students</h1>

                    <button type="button" class="btn-close"  data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editStudent">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="id" id="id">
                                <input type="text" class="w-100" name="name" id="name" placeholder="Entrez le Nom"  required>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <input type="email" class="w-100" name="email" id="email" placeholder="Entrez l'Email"  required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary updateButton">Edit Student </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Delete Students Modal -->
    <div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Students</h1>

                    <button type="button" class="btn-close"  data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteStudent">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <p>Are your Sure you want to delete  Student !</p>
                                <input type="hidden" name="id" id="student_id">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary updateButton">Delete Student </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <table class="table mt-5">
        <thead>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
        <tbody>
            @if (count($students) >0)
                @foreach ($students as $student)
                    <tr>
                        <td>{{$student->id}}</td>
                        <td>{{$student->name}}</td>
                        <td>{{$student->email}}</td>
                        <td>
                            <button class="btn btn-info editButton" data-id="{{$student->id}}" data-name="{{$student->name}}" data-email="{{$student->email}}" data-bs-toggle="modal" data-bs-target="#editStudentModal">Edit</button>
                        </td>
                        <td>
                            <button class="btn btn-danger deleteButton" data-id ="{{ $student->id }}" data-bs-toggle="modal" data-bs-target="#deleteStudentModal">Delete</button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3">Students not found </td>
                </tr>
            @endif
        </tbody>
    </table>

    <script>
        $(document).ready(function (){
            $("#addStudent").submit(function(e){
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{route('addStudent')}}",
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

            //edit button
            $(".editButton").click(function(){
                $("#id").val($(this).attr('data-id'));
                $("#name").val($(this).attr('data-name'));
                $("#email").val($(this).attr('data-email'));
            });

            $("#editStudent").submit(function(e){
                e.preventDefault();
                $('.updateButton').prop('disabled',true);

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{route('editStudent')}}",
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

            //delete Student
            $(".deleteButton").click(function(){
                var id = $(this).attr('data-id');
                $("#student_id").val(id);
            });

            $("#deleteStudent").submit(function(e){
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url:"{{route('deleteStudent')}}",
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
        });
    </script>

@endsection