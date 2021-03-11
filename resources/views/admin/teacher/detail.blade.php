@extends('admin.layouts.main')
<style>
    .dataTables_filter{
        display: none;
    }
</style>
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Teachers</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item"><a href="{{route('admin.teacher')}}">Teachers</a> </li>
                                <li class="breadcrumb-item active">Teacher edit </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
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
            <div class="content-body">
                <form class="form-horizontal" id="formsss" method="post" action="{{route('update.admin.teacher',$data->id)}}" name="specifycontent" enctype="multipart/form-data">
                    @csrf
                    <section id="card-bordered-options">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="card box-shadow-0 border-dark">
                                    <div class="card-header card-head-inverse bg-dark">
                                        <h4 class="card-title text-white">Teacher edit</h4>
{{--                                        <h4 class="card-title text-white" style="float: right">{{$data->id}}</h4>--}}
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            <fieldset class="form-group row">
                                                <div class="col-md-6 mt-1">
                                                    <label class="inline-block" for="sel1">Name </label>
                                                    <input type="text" name="name" value="{{$data->name}}" class="form-control heightinputs" id="basicInput" required>
                                                </div>
                                                <div class="col-md-6 mt-1">
                                                    <label class="inline-block" for="sel1">Email </label>
                                                    <input type="email" name="email" value="{{$data->email}}" class="form-control heightinputs" id="basicInput" readonly>
                                                </div>
                                                <div class="col-md-6 mt-1">
                                                    <label class="inline-block" for="sel1">Password </label>
                                                    <input type="password" name="password"  class="form-control heightinputs" id="basicInput">
                                                </div>
                                                <div class="col-md-6 mt-1">
                                                    <label class="inline-block" for="sel1">Confirm Password</label>
                                                    <input type="password" name="password_confirmation"  class="form-control heightinputs" id="basicInput">
                                                </div>
                                                <div class="col-md-6 mt-1">
                                                    <label class="inline-block" for="sel1">Phone</label>
                                                    <input type="tel" name="phone" value="{{$data->phone}}" class="form-control heightinputs " id="basicInput" required>
                                                </div>
                                                <div class="col-md-6 mt-1">
                                                    <label class="inline-block" for="sel1">Gender</label>
                                                    <select class="form-control" id="test_type" aria-invalid="false" name="gender" required>
                                                        <option value="Male" {{ ( $data->gender == "Male") ? 'selected' : '' }}>Male</option>
                                                        <option value="Female" {{ ( $data->gender == "Female") ? 'selected' : '' }}>Female</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-1">
                                                    <label class="inline-block" for="sel1">Status</label>
                                                    <select class="form-control" aria-invalid="false" name="status" required>
                                                        <option value="true" {{ ( $data->is_active == "true") ? 'selected' : '' }}>Active</option>
                                                        <option value="false" {{ ( $data->is_active == "false") ? 'selected' : '' }}>DeActive</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-1">

                                                    <div class="form-group ">
                                                        <label class="inline-block" for="sel1">Image</label>

                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-dark border-dark white" id="basic-addon7 fonticon-container">
                                                            <div class="fonticon-wrap">
                                                                <i class="ft-image"></i>
                                                            </div>
                                                                    </span>
                                                            </div>
                                                            <input type="file" name="profile_pic"  id="basicInputfiled" class="form-control  heightinputs errormessage " accept="image/*">
                                                        </div>

                                                        <a href="{{Storage::disk('public')->exists('lg/'.$data->profile_photo_path) ? Storage::disk('public')->url('lg/'.$data->profile_photo_path) : Storage::disk('public')->url('default.png')}}" target="_blank">  <img class="pt-2" src="{{Storage::disk('public')->exists('xs/'.$data->profile_photo_path) ? Storage::disk('public')->url('xs/'.$data->profile_photo_path) : Storage::disk('public')->url('default.png')}}"></a>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <div class="form-actions float-right mt-0 pt-0 buttonbordertop">
                                                <button type="submit" class="btn btn-social btn-dark btn-dark text-center  pr-1"> <span class="la la-check font-medium-3"></span> Update </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </div>
@endsection
