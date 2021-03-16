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
                <form id="LoginValidation" action="{{route('subadmin.update',$data->id)}}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">contacts</i>
                            </div>
                            <h4 class="card-title">Edit Sub Admin Form</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Name *</label>
                                        <input type="text" class="form-control" id="name" required="true" name="name" value="{{$data->name}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="examplePasswords" class="bmd-label-floating"> email *</label>
                                        <input type="email" name="email" value="{{$data->email}}" class="form-control" id="class_code" required="true">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Phone Number *</label>
                                        <input type="text" class="form-control" id="name" required="true" name="phone" value="{{$data->phone}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="gender" id="class_room" class="form-control" required="true">
                                            <option value="Male" {{ ( $data->gender == "Male") ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ ( $data->gender == "Female") ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="status" id="status" class="form-control">
                                            <option value="">Select Status</option>
                                            <option value="true" {{ ( $data->is_active == "true") ? 'selected' : '' }}>Active</option>
                                            <option value="false" {{ ( $data->is_active == "false") ? 'selected' : '' }}>DeActive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-4">
                                    <h4 class="title">Profile Image</h4>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput" style="display: block !important;">
                                        <div class="fileinput-new thumbnail">
                                            <img src="{{Storage::disk('public')->exists('md/'.$data->profile_photo_path) ? Storage::disk('public')->url('md/'.$data->profile_photo_path) : Storage::disk('public')->url('default.png')}}" alt="avatar">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail">

                                        </div>
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
                            <button type="submit" class="btn btn-rose">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


