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
                                <li class="breadcrumb-item"><a href="{{route('all.paper')}}">Papers</a> </li>
                                <li class="breadcrumb-item active">Paper Create </li>
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
                <form class="form-horizontal" id="formsss" method="post" action="{{route('paper.store')}}" name="specifycontent" enctype="multipart/form-data">
                    @csrf
                    <section id="card-bordered-options">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="card box-shadow-0 border-dark">
                                    <div class="card-header card-head-inverse bg-dark">
                                        <h4 class="card-title text-white">Create Paper</h4>
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            <fieldset class="form-group row" id="newData">
                                                <div class="col-md-6 mt-1">
                                                    <label class="inline-
                                                    block" for="sel1">Name</label>
                                                    <input type="text" name="paper_name" class="form-control heightinputs " id="basicInput" required>
                                                </div>
                                                <div class="col-md-6 mt-1">
                                                    <label class="inline-
                                                    block" for="sel1">Paper Code</label>
                                                    <input type="text" name="paper_code" class="form-control heightinputs " id="basicInput" required>
                                                </div>
                                                <div class="col-md-6 mt-1">
                                                    <label class="inline-block" for="sel1">Status</label>
                                                    <select class="form-control" aria-invalid="false" name="status" required>
                                                        <option value="Publish">Publish</option>
                                                        <option value="Unpublish">Unpublish</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-1">
                                                    <label class="inline-block" for="sel1">Question</label>
                                                    <select class="form-control select2" name="quiz_id[]" id="question" aria-invalid="false" required>
                                                        <option value="">Select first Question</option>
                                                        @foreach($data as $room)
                                                            <option value="{{$room->id}}">{{$room->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" id="ajaxurl" name="url" value="{{route('getoption')}}">
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

