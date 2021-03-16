@extends('teacher.layouts.main')
@section('content')
    <div class="container-fluid">
        @if (session()->has('success'))
            <div class="alert alert-success"> @if(is_array(session('success')))
                    <ul>
                        @foreach (session('success') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                @else
                    {{ session('success') }}
                @endif </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <form id="LoginValidation" action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">person</i>
                            </div>
                            <h4 class="card-title">Edit Profile Form</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Name *</label>
                                        <input type="text" class="form-control" id="name" required="true" name="name" value="{{$user->name}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="examplePasswords" class="bmd-label-floating"> email *</label>
                                        <input type="email" name="email" value="{{$user->email}}" class="form-control" id="class_code" required="true">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Password *</label>
                                        <input type="password" class="form-control" id="name" name="password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="examplePasswords" class="bmd-label-floating"> Password Conformation *</label>
                                        <input type="password" name="password_confirmation" class="form-control" id="class_code">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-4">
                                    <h4 class="title">Profile Image</h4>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput" style="display: block !important;">
                                        <div class="fileinput-new thumbnail">
                                            <img src="{{Storage::disk('public')->exists('md/'.$user->profile_photo_path) ? Storage::disk('public')->url('md/'.$user->profile_photo_path) : Storage::disk('public')->url('default.png')}}" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                              <span class="btn btn-rose btn-round btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="profile_pic" accept="image/x-png,image/gif,image/jpeg" />
                                              </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-rose">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
