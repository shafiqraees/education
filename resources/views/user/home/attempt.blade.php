@extends('user.layouts.main')
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
                <form id="LoginValidation" action="{{route('quiz.save')}}" method="post" enctype="multipart/form-data">
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
                                @php
                                    $x = 'A';
                                @endphp
                                @if(!empty($data))
                                    @if(isset($data->getQuestion))
                                        <h4>1. {{$data->getQuestion->name}}?</h4>
                                        @if(!empty($data->getQuestion->image))
                                            <img src="{{Storage::disk('public')->exists('md/'.$data->getQuestion->image) ? Storage::disk('public')->url('md/'.$data->getQuestion->image) : Storage::disk('public')->url('default.png')}}" alt="option" style="height: 30px;width: 30px;">
                                        @endif
                                        @if(isset($data->getQuestion->option))
                                            @foreach($data->getQuestion->option as $key => $option)
                                                <div class="col-sm-12 checkbox-radios">
                                                    <div class="form-check">
                                                        <label class="form-check-label">{{$x}} </label>
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="radio" name="question_option_id" value="{{$option->id}}"> {{$option->name}}
                                                            <span class="circle">
                                                                <span class="check"></span>
                                                                </span>
                                                        </label>
                                                        <input type="hidden" name="user_quiz_id" value="{{$UserQuiz->id}}">
                                                        <input type="hidden" name="launch_quiz_id" value="{{$UserQuiz->launch_quiz_id}}">
                                                        <input type="hidden" name="question_id" value="{{$data->getQuestion->id}}">
                                                        <input type="hidden" name="question_paper_id" value="{{$UserQuiz->question_paper_id}}">
                                                        @if(!empty($option->image))
                                                            <img src="{{Storage::disk('public')->exists('md/'.$option->image) ? Storage::disk('public')->url('md/'.$option->image) : Storage::disk('public')->url('default.png')}}" alt="option" style="height: 30px;width: 30px;">
                                                        @endif                                                    </div>
                                                </div>
                                                @php   $x++; @endphp
                                            @endforeach
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="card-footer ml-auto  col-xs-offset-2 pull-right">
                            <button type="submit" class="btn btn-rose">Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
