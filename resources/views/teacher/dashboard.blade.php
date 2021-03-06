@extends('teacher.layouts.main')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
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
                    {{--<div class="card card-stats">--}}
                        <img src="{{asset('public/forntend/images/trainer-educatioo.png')}}" style="-webkit-filter: blur(5px);" width="80%"; >
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>
    @if( $transaction == "0")
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buy Packages</h5>
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-md-6 ">
                                <a href="javascript:void(0)"> <img src="{{asset('public/assets/img/Educatioo-Basic.png')}}" style="width: 150px;margin-left: 28px;";>

                                <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                    <input type="hidden" name="cmd" value="_s-xclick">
                                    <input type="hidden" name="hosted_button_id" value="EJGPP2YQR4T2N">
                                    <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribe_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" style="margin-left: 52px;margin-top: 10;">
                                    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" >
                                </form>
                                </a>
                            </div>

                            <div class="col-md-6 ">
                                <a href="javascript:void(0)"> <img src="{{asset('public/assets/img/Educatioo-Premium.png')}}" style="width: 150px;margin-left: 28px;";></a>
                                <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                    <input type="hidden" name="cmd" value="_s-xclick">
                                    <input type="hidden" name="hosted_button_id" value="2J6Y6F4S8Z49S">
                                    <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribe_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" style="margin-left: 54px;margin-top: 10;">
                                    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" >
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
    @endif
@endsection
<script src="{{asset('public/assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
<script>

    $(document).ready(function(){
        $('#exampleModal').modal({backdrop: 'static', keyboard: false})
        $('#exampleModal').modal('show');
    });
</script>
