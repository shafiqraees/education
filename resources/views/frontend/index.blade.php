@extends('frontend.layout.main')
@section('content')
    <section class="hero-wrap hero-wrap-2" style="background-image: url('{{Storage::disk('public')->exists('bg_2.webp') ? Storage::disk('public')->url('bg_2.webp') : Storage::disk('public')->url('default.png')}}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 pt-5 mt-5 text-center">
                    <p class="breadcrumbs"><span class="me-2"></span> <span>Pricing</span></p>
                    <h1 class="mb-0 bread">Choose The Right Plan</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                    <div class="block-7">
                        <div class="text-center">
                            <span class="excerpt d-block">Basic Plan</span>
                            <span class="price"><sup>$</sup> <span class="number">49K</span></span>
                            <div class="p-4 px-lg-5">
                                <div class="el-content uk-panel uk-margin-top"><p><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>Price per month<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>$ 59 yearly<br><span style="color: #ff6600;"><strong>√&nbsp;&nbsp;</strong></span>1 user<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>14 day Free Trial<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>5 courses<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>10 students</p>
                                    <p><span style="color: #ff6600;"><strong>√</strong></span>&nbsp; Full product use</p></div>
                            </div>
                            <a href="#" class="btn btn-primary btn-outline-primary d-block px-2 py-3">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <div class="block-7">
                        <div class="text-center">
                            <span class="excerpt d-block">Beginner Plan</span>
                            <span class="price"><sup>$</sup> <span class="number">79K</span></span>
                            <div class="p-4 px-lg-5">
                                <div class="el-content uk-panel uk-margin-top"><p><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>Price per month<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>$ 97 yearly<br><span style="color: #ff6600;"><strong>√&nbsp;&nbsp;</strong></span>1 user<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>14 day Free Trial<br><strong><span style="color: #ff6600;">√</span>&nbsp; </strong>Unlimited<strong>&nbsp;</strong>courses<br><strong><span style="color: #ff6600;">√</span>&nbsp;&nbsp;</strong>100 students</p>
                                    <p><span style="color: #ff6600;"><strong>√</strong></span>&nbsp; Full product use</p></div>
                            </div>
                            <a href="#" class="btn btn-primary btn-outline-primary d-block px-2 py-3">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                    <div class="block-7">
                        <div class="text-center">
                            <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{!! URL::route('paypal') !!}" >
                                {{ csrf_field() }}
                            <span class="excerpt d-block">Premium Plan</span>
                            <span class="price"><sup>$</sup> <span class="number">109K</span></span>
                            <div class="p-4 px-lg-5">
                                <div class="el-content uk-panel uk-margin-top"><p><strong><span style="color: #ff6600;">√&nbsp;</span>&nbsp;</strong>Discount&nbsp;prices<br><strong><span style="color: #ff6600;">√&nbsp;</span>&nbsp;</strong>Payment yearly<br><span style="color: #ff6600;"><strong>√&nbsp;&nbsp;</strong><span style="color: #000000;">From 6 users</span></span><br><strong><span style="color: #ff6600;">√&nbsp;</span>&nbsp;</strong>14 day Free Trial<br><strong><span style="color: #ff6600;">√&nbsp;</span>&nbsp;</strong>Unlimited&nbsp;courses<br><strong><span style="color: #ff6600;">√&nbsp;</span>&nbsp;</strong>100 students</p>
                                    <p><span style="color: #ff6600;"><strong>√&nbsp;</strong></span>&nbsp;Full product use</p></div>
                                <input id="amount" type="hidden" class="form-control" name="amount" value="1.0" autofocus>
                            </div>
                                <button type="submit" class="btn btn-primary btn-outline-primary d-block px-2 py-3">
                                    Get Started
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                    <div class="block-7">
                        <div class="text-center">
                            <span class="excerpt d-block">Ultimate Plan</span>
                            <span class="price"><sup>$</sup> <span class="number">149K</span></span>
                            <div class="p-4 px-lg-5">
                                <div class="el-content uk-panel uk-margin-top"><p><strong><span style="color: #ff6600;">√&nbsp;</span>&nbsp;</strong>Discount&nbsp;prices<br><strong><span style="color: #ff6600;">√&nbsp;</span>&nbsp;</strong>Payment yearly<br><span style="color: #ff6600;"><strong>√&nbsp;&nbsp;</strong><span style="color: #000000;">From 6 users</span></span><br><strong><span style="color: #ff6600;">√&nbsp;</span>&nbsp;</strong>14 day Free Trial<br><strong><span style="color: #ff6600;">√&nbsp;</span>&nbsp;</strong>Unlimited&nbsp;courses<br><strong><span style="color: #ff6600;">√&nbsp;</span>&nbsp;</strong>1000 students</p>
                                    <p><span style="color: #ff6600;"><strong>√&nbsp;</strong></span>&nbsp;Full product use</p></div>                            </div>
                            <a href="#" class="btn btn-primary btn-outline-primary d-block px-2 py-3">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
