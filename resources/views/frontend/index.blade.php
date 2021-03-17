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
                                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
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
                                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                            </div>
                            <a href="#" class="btn btn-primary btn-outline-primary d-block px-2 py-3">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                    <div class="block-7">
                        <div class="text-center">
                            <span class="excerpt d-block">Premium Plan</span>
                            <span class="price"><sup>$</sup> <span class="number">109K</span></span>
                            <div class="p-4 px-lg-5">
                                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                            </div>
                            <a href="#" class="btn btn-primary btn-outline-primary d-block px-2 py-3">Get Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                    <div class="block-7">
                        <div class="text-center">
                            <span class="excerpt d-block">Ultimate Plan</span>
                            <span class="price"><sup>$</sup> <span class="number">149K</span></span>
                            <div class="p-4 px-lg-5">
                                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                            </div>
                            <a href="#" class="btn btn-primary btn-outline-primary d-block px-2 py-3">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
