@extends('admin.layouts.main')
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
                <form id="LoginValidation" action="{{route('student.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">contacts</i>
                            </div>
                            <h4 class="card-title">Create Student Form</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Name *</label>
                                        <input type="text" class="form-control" id="name" required="true" name="name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="examplePasswords" class="bmd-label-floating"> email *</label>
                                        <input type="email" name="email" class="form-control" id="class_code" required="true">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Password *</label>
                                        <input type="password" class="form-control" id="name" required="true" name="password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="examplePasswords" class="bmd-label-floating"> Password Conformation *</label>
                                        <input type="password" name="password_confirmation" class="form-control" id="class_code" required="true">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Roll Number *</label>
                                        <input type="text" class="form-control" id="roll_number" required="true" name="roll_number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="class_room" id="class_room" class="form-control" required="true">
                                            <option value="">Select Calss Room</option>
                                            @if(!empty($class))
                                                @foreach($class as $name)
                                                    <option value="{{  $name->id }}">{{  $name->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="status" id="status" class="form-control">
                                            <option value="">Select Status</option>
                                            <option value="true">Active</option>
                                            <option value="false">DeActive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-4">
                                    <h4 class="title">Profile Image</h4>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput" style="display: block !important;">
                                        <div class="fileinput-new thumbnail">
                                            <img src="{{asset('public/assets/img/image_placeholder.jpg')}}" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                              <span class="btn btn-rose btn-round btn-file">
                                                <span class="fileinput-new">Select image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg" />
                                              </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-rose">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
