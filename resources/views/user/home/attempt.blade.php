@extends('user.layouts.main')
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-8">
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
                <form id="LoginValidation" action="{{route('quiz.save')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">person</i>
                            </div>
                            <h4 class="card-title">Quiz form</h4>
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
                                                            <input class="form-check-input selectedbutton" type="radio" name="question_option_id" value="{{$option->id}}"> {{$option->name}}
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
                        <input type="hidden" id="quizanswer" name="quizanswer" value="{{isset($answer_data->name) ? $answer_data->name : "" }}">
                        <input type="hidden" id="question_data" name="Question" value="{{isset($question_data->name) ? $question_data->name : "" }}">
                        <input type="hidden" id="option_data" name="option_data" value="{{isset($option_data->name) ? $option_data->name : "" }}">
                        <input type="hidden" id="attempt_data" name="attempt_data" value="{{isset($attempt->question_count) ? $attempt->question_count : "" }}">
                        <input type="hidden" id="result" name="result" value="{{isset($result) ? $result : "" }}">
                        <input type="hidden" id="attempted_option" name="attempted_option" value="{{isset($attempted_option) ? $attempted_option : "" }}">
                        <input type="hidden" id="logout_url" name="logout_url" value="{{route('logout.user') }}">
                        <div class="card-footer ml-auto  col-xs-offset-2 pull-right">
                            <button type="submit" class="btn btn-rose nextbutton">Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
<script src="{{asset('public/assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
<script>


    /*$(document).on('click','.nextbutton',function(e){
        e.preventDefault();
        var pin_code = $('#pin_code').val();
        var check = $('.selectedbutton:checked').val();
        alert(check);
        return false;
        var url = $('#url').val();
        var trainee_login  = $('#traineelogin').val();
        var _token =  $('meta[name="csrf-token"]').attr('content');
        if (pin_code){
            ajaxOnChangeRequest(pin_code,url,_token,trainee_login);
        } else {
            toastr.warning('Please enter trainee pin!')
        }

    });
    function ajaxOnChangeRequest(pin_code,url,_token,trainee_login) {
        var str = '';
        $.ajax({
            url:url,
            type:"post",
            data:{
                pin_code:pin_code,
                _token: _token
            },
            success:function(response){
                console.log(response);
                traineeLogin(response,trainee_login,_token);
            },
            error     : function (result){
                toastr.error('Sorry Record not foud!')
            }
        });
    }
    function traineeLogin(response,url,_token) {
        var home  = $('#home').val();
        swal({
            title: "Are you"+ response.data['name']+"?",
            icon: "warning",
            showCancelButton: true,
            buttons: {
                cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "btn-dark",
                    closeModal: false,
                },
                confirm: {
                    text: "Ok",
                    value: true,
                    visible: true,
                    className: "btn-dark",
                    closeModal: false
                }
            }
        }).then(isConfirm => {

            if (isConfirm) {

                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }

                });

                $.ajax({
                    type:'post',
                    url:url,
                    data:{id:response.data['id']},
                    success: function (results) {
                        console.log(results);
                        if (results.data) {
                            toastr.success('Login Successfully!')
                            window.location = home;
                        } else {
                            swal("Error!", results.message, "error");
                        }
                    }
                });

            } else {
                swal("Cancelled","Your profile is safe.");
            }
        });
    }*/
    $(document).ready(function() {
        var question_data = $('#question_data').val();
        var quizanswer = $('#quizanswer').val();
        var option_data = $('#option_data').val();
        var attempt_data = $('#attempt_data').val();
        var result = $('#result').val();
        var attempted_option = $('#attempted_option').val();
        var logout_url = $('#logout_url').val();
        var status = "Incorrect";
        if (option_data === quizanswer){
            status = "Correct"
        }
        if (question_data) {
            swal({
                title: status,
                text: "Question:" +"\n" + question_data +"\n" + "Correct Answer: "+"\n" + quizanswer,
                icon: "success",
                showCancelButton: true,
                buttons: {
                    cancel: {
                        text: "Cancel",
                        value: null,
                        visible: true,
                        className: "btn-dark",
                        closeModal: false,
                    },
                    confirm: {
                        text: "Ok",
                        value: true,
                        visible: true,
                        className: "btn-dark",
                        closeModal: false
                    }
                }
            }).then(isConfirm => {

                if (isConfirm) {
                    swal("Ok","Attempt next question.");
                } else {
                    swal("Ok","Attempt next question.");
                }
            });
        }
        if (result) {
            swal({
                title: 'Finished',
                text: "Score:" +"\n" + attempted_option +"/" +attempt_data +"\n" + "Percent: "+"\n" + result,
                icon: "success",
                showCancelButton: true,
                buttons: {
                    confirm: {
                        text: "Ok",
                        value: true,
                        visible: true,
                        className: "btn-dark",
                        closeModal: true
                    }
                }
            }).then(isConfirm => {
                if (isConfirm) {

                    $.ajaxSetup({

                        headers: {

                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                        }

                    });

                    $.ajax({
                        type:'post',
                        url:logout_url,
                        success: function (results) {
                            location.reload();
                        }
                    });

                } else {
                    location.reload();
                }
            });
        }

    });
</script>
