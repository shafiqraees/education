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
                <form id="LoginValidation" action="{{route('launch.store')}}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    @csrf
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">contacts</i>
                            </div>
                            <h4 class="card-title">Create Quiz Form</h4>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control select2" aria-invalid="false" name="class_room" required>
                                            <option value="">Select Class Room</option>
                                            @foreach($data as $room)
                                                <option value="{{$room->id}}">{{$room->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="paper_id" id="question"  class="form-control">
                                            <option value="">Select Quiz</option>
                                            @foreach($papers as $paper)
                                                <option value="{{$paper->id}}">{{$paper->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Require Name </label>
                                        <input type="checkbox" name="setting[]" class="form-control" value="Require Name">
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4" >
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Shuffle Questions </label>
                                        <input type="checkbox" name="setting[]" class="form-control" value="Shuffle Questions">
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Shuffle Answers </label>
                                        <input type="checkbox" name="setting[]" class="form-control " value="Shuffle Answers">
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Show Feedback </label>
                                        <input type="checkbox" name="setting[]" class="form-control " value="Show Question Feedback">
                                    </div>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <div class="form-group">
                                        <label for="exampleEmails" class="bmd-label-floating"> Show Final Score </label>
                                        <input type="checkbox" name="setting[]" class="form-control " value="Show Final Score">
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


