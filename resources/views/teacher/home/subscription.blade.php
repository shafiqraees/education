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
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-6 " data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                        <div class="block-7">
                            <div class="text-center">
                                <span class="excerpt d-block">Basic Plan</span>
                                <span class="price"><sup>$</sup> <span class="number">72</span></span>
                                <div class="p-4 px-lg-5">
                                    <div class="el-content uk-panel uk-margin-top"><p><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>Price per month<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>$ 59 yearly<br><span style="color: #ff6600;"><strong>√&nbsp;&nbsp;</strong></span>1 user<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>14 day Free Trial<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>5 courses<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>10 students</p>
                                        <p><span style="color: #ff6600;"><strong>√</strong></span>&nbsp; Full product use</p></div>
                                </div>
                                <input id="amount" type="hidden" class="form-control" name="amount" value="72.0" autofocus>
                                <input id="name" type="hidden" class="form-control" name="name" value="Basic Plan" autofocus>
                                <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                    <input type="hidden" name="cmd" value="_s-xclick">
                                    <input type="hidden" name="hosted_button_id" value="9FMVMHKBNJUVY">
                                    <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                                    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="block-7">
                            <div class="text-center">
                                <span class="excerpt d-block">Premium</span>
                                <span class="price"><sup>$</sup> <span class="number">120</span></span>
                                <div class="p-4 px-lg-5">
                                    <div class="el-content uk-panel uk-margin-top"><p><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>Price per month<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>$ 97 yearly<br><span style="color: #ff6600;"><strong>√&nbsp;&nbsp;</strong></span>1 user<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>14 day Free Trial<br><strong><span style="color: #ff6600;">√</span>&nbsp; </strong>Unlimited<strong>&nbsp;</strong>courses<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>100 students</p>
                                        <p><span style="color: #ff6600;"><strong>√</strong></span>&nbsp; Full product use</p></div>
                                </div>
                                <input id="amount" type="hidden" class="form-control" name="amount" value="120.0" autofocus>
                                <input id="name" type="hidden" class="form-control" name="name" value="Premium package" autofocus>
                                <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                    <input type="hidden" name="cmd" value="_s-xclick">
                                    <input type="hidden" name="hosted_button_id" value="6VVYMDGAY94J2">
                                    <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                                    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection
