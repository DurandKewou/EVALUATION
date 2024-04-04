@extends('layout/layout-common')

@section('space-work')

    

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <p style="color:red">{{$error}}</p>
        @endforeach
        
    @endif

    @if (Session::has('error'))
        <p style="color: red">{{Session::get('error')}}</p>
    @endif

    <main class="form-signin w-100 m-auto">
        <form action="{{route('userLogin')}}" method="post">
            @csrf
          <h1>Login</h1>
      
          <div class="form-floating">
            <input type="text" class="form-control" id="floatingInput" name="name" placeholder="Enter Your Matricule">
            <label for="floatingPassword">User Name</label>
          </div>
          <br><br>
          <div class="form-floating">
            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Enter password">
            <label for="floatingPassword">Password</label>
          </div>

          <input type="submit" class="w-100 btn btn-lg btn-primary" value="Login">
          <p class="mt-5 mb-3 text-muted">&copy; 2023–2024</p>
        </form>

        <a href="/forget-password">Forget Password</a>
    </main>

    
@endsection