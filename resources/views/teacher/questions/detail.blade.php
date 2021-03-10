@extends('teacher.layouts.main')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Questions</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('teacher.home')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item"><a href="{{route('all.queston')}}">Questions</a> </li>
                                <li class="breadcrumb-item active">Question edit </li>
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
                <form class="form-horizontal" id="formsss" method="post" action="{{route('update.question',$data->id)}}" name="specifycontent" enctype="multipart/form-data">
                    @csrf
                    <section id="card-bordered-options">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="card box-shadow-0 border-dark">
                                    <div class="card-header card-head-inverse bg-dark">
                                        <h4 class="card-title text-white">Update Question</h4>
                                        <h4 class="card-title text-white" style="float: right">{{$data->id}}</h4>
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            <fieldset class="form-group row">
                                                <div class="col-md-6 mt-1">
                                                    <label class="inline-block" for="sel1">Name </label>
                                                    <input type="text" name="name" value="{{$data->name}}" class="form-control heightinputs" id="basicInput" required>
                                                </div>
                                                <div class="col-md-6 mt-1">
                                                    <label class="inline-block" for="sel1">Status</label>
                                                    <select class="form-control" aria-invalid="false" name="status" required>
                                                        <option value="Publish" {{ ( $data->status == "Publish") ? 'selected' : '' }}>Publish</option>
                                                        <option value="Unpublish" {{ ( $data->status == "Unpublish") ? 'selected' : '' }}>Unpublish</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-1">
                                                    <label class="inline-block" for="sel1">Type</label>
                                                    <select class="form-control" aria-invalid="false" name="type" required>
                                                        <option value="Multiple Choice" {{ ( $data->type == "Multiple Choice") ? 'selected' : '' }}>Multiple Choice</option>
                                                        <option value="True/False" {{ ( $data->type == "True/False") ? 'selected' : '' }}>True/False</option>
                                                        <option value="Short Answer" {{ ( $data->type == "Short Answer") ? 'selected' : '' }}>Short Answer</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-1">

                                                    <div class="form-group ">
                                                        <label class="inline-block" for="sel1">Images</label>

                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-dark border-dark white" id="basic-addon7 fonticon-container">
                                                            <div class="fonticon-wrap">
                                                                <i class="ft-image"></i>
                                                            </div>
                                                                    </span>
                                                            </div>
                                                            <input type="file" name="photo"  id="basicInputfiled" class="form-control  heightinputs errormessage " accept="image/*">

                                                        </div>
                                                    </div>
                                                </div>
{{--
                                                <img src="{{Storage::disk('public')->exists('xs/'.$data->image) ? Storage::disk('public')->url('xs/'.$data->image) : Storage::disk('public')->url('default.png')}}"  />
--}}                                        @if($data->type == "Multiple Choice")
                                                @foreach($data->option as $key => $option)

                                                        <div class="col-md-1 mt-1 MultipleChoice">
                                                            <label class="inline-block" for="sel1">Answer</label>

                                                            <input type="radio" name="answer" value="{{$key}}" {{ ($option->answer == $key)? "checked" : "" }}  class="form-control heightinputs " id="answerfiled">
                                                        </div>
                                                        <div class="col-md-4 mt-1 MultipleChoice">
                                                            <label class="inline-block" for="sel1">Option</label>
                                                            <input type="text" name="option[]" value="{{$option->name}}" class="form-control heightinputs " placeholder="please enter option" id="basicInput">
                                                        </div>
                                                        <div class="col-md-4 mt-1 MultipleChoice">
                                                            <label class="inline-block" for="sel1">File</label>
                                                            <input type="file" name="image[]" class="form-control heightinputs " id="basicInput">
                                                        </div>
                                                        <div class="col-md-3 mt-1 MultipleChoice">
                                                            <label class="inline-block" for="sel1">suggested Question Id</label>
                                                            <input type="number" name="question_id[]" value="{{$option->suggested_question_id}}" placeholder="please enter question Id" class="form-control heightinputs " id="basicInput" >
                                                        </div>

                                                    @endforeach
                                                @elseif($data->type == "True/False")
                                                    <div class="col-md-3 mt-1 TrueFalse" >
                                                        <label class="inline-block" for="sel1">True</label>
                                                        <input type="radio" name="truefalse" value="false"{{ ($data->option[0]->answer == "true")? "checked" : "" }} class="form-control heightinputs " id="basicInput">
                                                    </div>
                                                    <div class="col-md-3 mt-1 TrueFalse" >
                                                        <label class="inline-block" for="sel1">False</label>
                                                        {{--//<input type="file" name="image[]" class="form-control heightinputs " id="basicInput" required>--}}
                                                        <input type="radio" name="truefalse" value="false" {{ ($data->option[0]->answer == "false")? "checked" : "" }} class="form-control heightinputs " id="basicInput">
                                                    </div>
                                                    <div class="col-md-6 mt-1 TrueFalse" >
                                                        <label class="inline-block" for="sel1">suggested Question Id</label>
                                                        <input type="number" name="true_false_question_id" class="form-control heightinputs" value="{{$data->option[0]->suggested_question_id}}" id="basicInput" >
                                                    </div>
                                                @elseif($data->type == "Short Answer")
                                                    <div class="col-md-6 mt-1 ShortAnswer" >
                                                        <label class="inline-block" for="sel1">Short Answer</label>
                                                        <textarea name="ShortAnswer" class="form-control">{{$data->option[0]->answer}}</textarea>
                                                    </div>
                                                    <div class="col-md-6 mt-1 ShortAnswer">
                                                        <label class="inline-block" for="sel1">suggested Question Id</label>
                                                        <input type="number" name="Short_question_id" value="{{$data->option[0]->suggested_question_id}}" class="form-control heightinputs " id="basicInput">
                                                    </div>
                                                @endif
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
