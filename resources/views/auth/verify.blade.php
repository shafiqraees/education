@extends('authentication.layout.layout')
@section('content')
    <div class="row">
        <div class="col-md-10 ml-auto mr-auto">
            <div class="card card-signup" style="margin-top: 1vh;">
                <h2 class="card-title text-center">Log In Trainee</h2>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 ml-auto mr-auto">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                                <div class="social text-center"> EDUCATIOO </div>
                                <label>Room name</label>
                                <div class="alert alert-warning">
                                     {{ $room->name }}
                                    <a href="{{route('login')}}" class="pull-right"><p>Change Room</p></a>
                                </div>

                           {{-- <form id="LoginValidation" method="post" action="{{ route('trainee.key') }}" class="form">--}}
                                @csrf
                                <div class="form-group has-default">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons"><span class="material-icons">vpn_key</span></i>
                                            </span>
                                        </div>
                                        <input type="text" name="pin_code" class="form-control" id="pin_code" required="true" placeholder="Enter Trainee Key">
                                        <input type="hidden" id="url" name="url"value="{{ route('trainee.key') }}">
                                        <input type="hidden" id="traineelogin" name="traineelogin"value="{{ route('trainee.login') }}">
                                        <input type="hidden" id="home" name="home"value="{{ route('home') }}">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button class="btn btn-primary btn-round mt-4 ajax">Sign In</button>
                                </div>

                        </div>
                        <div class="col-md-5 ml-auto mr-auto">
                            <img src="{{asset('public/assets/img/image.png')}}" style="max-width: 100%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{asset('public/assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script>

    $(document).on('click','.ajax',function(e){
        e.preventDefault();
        var pin_code = $('#pin_code').val();
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
                        toastr.success('Login Successfully!')
                        window.location = home;
                    }
                });

            } else {
                swal("Cancelled","Your profile is safe.");
            }
        });
    }

</script>
