@extends('subadmin.layouts.main')
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
                <form id="LoginValidation" action="{{route('classrooms.update',$data->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">contacts</i>
                            </div>
                            <h4 class="card-title">Class Room Form</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Name *</label>
                                        <input type="text" class="form-control" id="name" required="true" name="name" value="{{$data->name}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="examplePasswords" class="bmd-label-floating"> Calss Code *</label>
                                        <input type="text" class="form-control" id="class_code" required="true" name="class_code" value="{{$data->class_code}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-control" aria-invalid="false" name="status" required>
                                            <option value="Publish" {{ ( $data->status == "Publish") ? 'selected' : '' }}>Publish</option>
                                            <option value="Unpublish" {{ ( $data->status == "Unpublish") ? 'selected' : '' }}>Unpublish</option>
                                        </select>
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

