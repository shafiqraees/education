@extends('teacher.layouts.main')
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
                    <h3 class="content-header-title mb-0 d-inline-block">Papers</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('teacher.home')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item"><a href="{{route('launch.quiz')}}">Launch Quiz</a> </li>
                                <li class="breadcrumb-item active">Launch Quiz </li>
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
                <form class="form-horizontal" id="formsss" method="post" action="{{route('launch.quiz.store')}}" name="specifycontent" enctype="multipart/form-data">
                    @csrf
                    <section id="card-bordered-options">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="card box-shadow-0 border-dark">
                                    <div class="card-header card-head-inverse bg-dark">
                                        <h4 class="card-title text-white">Launch Quiz</h4>
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            <fieldset class="form-group row" id="newData">
                                                <div class="col-md-6 mt-1">
                                                    <label class="inline-block " for="sel1">Choos Class Room</label>
                                                    <select class="form-control select2" aria-invalid="false" name="class_room" required>
                                                        @foreach($data as $room)
                                                            <option value="{{$room->id}}">{{$room->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-1">
                                                    <label class="inline-block" for="sel1">Choose Paper</label>
                                                    <select class="form-control select2" aria-invalid="false" name="paper_id" required>
                                                        @foreach($papers as $paper)
                                                            <option value="{{$paper->id}}">{{$paper->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2 mt-1">
                                                    <label class="inline-block" for="sel1">Require Name</label>
                                                    <input type="checkbox" name="setting[]" class="form-control heightinputs" value="Require Name">
                                                </div>
                                                <div class="col-md-2 mt-1">
                                                    <label class="inline-block" for="sel1">Shuffle Questions</label>
                                                    <input type="checkbox" name="setting[]" class="form-control heightinputs" value="Shuffle Questions">
                                                </div>
                                                <div class="col-md-2 mt-1">
                                                    <label class="inline-block" for="sel1">Shuffle Answers</label>
                                                    <input type="checkbox" name="setting[]" class="form-control heightinputs" value="Shuffle Answers">
                                                </div>
                                                <div class="col-md-2 mt-1">
                                                    <label class="inline-block" for="sel1">Show Question Feedback</label>
                                                    <input type="checkbox" name="setting[]" class="form-control heightinputs" value="Show Question Feedback">
                                                </div>
                                                <div class="col-md-2 mt-1">
                                                    <label class="inline-block" for="sel1">Show Final Score</label>
                                                    <input type="checkbox" name="setting[]" class="form-control heightinputs" value="Show Final Score">
                                                </div>
                                            </fieldset>
                                            <div class="form-actions float-right mt-0 pt-0 buttonbordertop">
                                                <button type="submit" class="btn  btn-dark btn-dark text-center  pr-1"> <span class="la la-check font-medium-3"></span> Create </button>
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

