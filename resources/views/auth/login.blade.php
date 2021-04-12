@extends('authentication.layout.layout')
@section('content')
    <div class="row">
        <div class="col-md-10 ml-auto mr-auto">
            <div class="card card-signup" style="margin-top: 1vh;">
                <h2 class="card-title text-center">Log In Trainee</h2>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 ml-auto mr-auto">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="social text-center"> EDUCATIOO </div>
                            <form id="LoginValidation" method="post" action="{{ route('courseid') }}" class="form">
                                @csrf
                                <div class="form-group has-default">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">code</i>
                                            </span>
                                        </div>
                                        <input type="text" name="course_coude" class="form-control" id="exampleEmails" required="true" placeholder="Course Code">                                    </div>
                                </div>
                                {{--<div class="form-group has-default">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                        </div>
                                        <input type="password" placeholder="Password" class="form-control" id="examplePasswords" required="true" name="password">
                                    </div>
                                </div>--}}
                                <div class="text-center">
                                    <button class="btn btn-primary btn-round mt-4">Sign In</button>
                                </div>
                                {{--<div class="form-group text-center">
                                    <mat-label> New Here? <a href="#"> Create Acccount Now</a></mat-label>
                                </div>--}}
                            </form>
                        </div>
                        <div class="col-md-5 ml-auto mr-auto">
                            <img src="{{asset('public/assets/img/image.png')}}" style="max-width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
