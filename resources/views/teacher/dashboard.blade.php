@extends('teacher.layouts.main')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card card-stats">
                        <img src="{{asset('public/assets/img/Educatioo.png')}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
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

                            <div class="col-md-6 ml-auto ">
                                <label>Basic Plan</label>
                                <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">

                                    <input type="hidden" name="hosted_button_id" value="EJGPP2YQR4T2N">
                                    <input type="hidden" name="business" value="seller@designerfotos.com">
                                    <input type="hidden" name="item_name" value="hat">
                                    <input type="hidden" name="item_number" value="123">
                                    <input type="hidden" name="amount" value="15.00">
                                    <input type="hidden" name="first_name" value="John">
                                    <input type="hidden" name="last_name" value="Doe">
                                    <input type="hidden" name="address1" value="9 Elm Street">
                                    <input type="hidden" name="address2" value="Apt 5">
                                    <input type="hidden" name="city" value="Berwyn">
                                    <input type="hidden" name="state" value="PA">
                                    <input type="hidden" name="zip" value="19312">
                                    <input type="hidden" name="night_phone_a" value="610">
                                    <input type="hidden" name="night_phone_b" value="555">
                                    <input type="hidden" name="night_phone_c" value="1234">

                                    <input type="hidden" name="email" value="jdoe@zyzzyu.com">

                                    <input type="hidden" name="cmd" value="_s-xclick">
                                    <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribe_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                                    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                                </form>
                            </div>

                            <div class="col-md-6 ml-auto ">
                                <label>Premium Plan</label>
                                <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                    <input type="hidden" name="cmd" value="_s-xclick">
                                    <input type="hidden" name="hosted_button_id" value="2J6Y6F4S8Z49S">
                                    <table>
                                        <tr style="display: none"><td><input type="hidden" name="on0" value="teacher_id">teacher_id</td></tr><tr><td><input type="text" name="os0" maxlength="200" style="display: none"></td></tr>
                                    </table>
                                    <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                                    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
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

@endsection
<script src="{{asset('public/assets/js/core/jquery.min.js')}}" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        //$('#exampleModal').modal('show');
        $('#exampleModal').modal({backdrop: 'static', keyboard: false})
        $('#exampleModal').modal('show');
    });
</script>
