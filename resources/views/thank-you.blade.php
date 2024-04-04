@extends('layout/layout-common')

@section('space-work')
    <div class="container">
        <div class="text-center">
            <h2>Thank Your For Submit Your Exam, {{Auth::user()->name}}</h2>
            <p>We will review your exam and Update you soon by mail</p>
            <a href="/dashbord" class="btn btn-info"> Go Back</a>
        </div>
    </div>
@endsection