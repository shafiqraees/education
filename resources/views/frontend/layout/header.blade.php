<div class="top-wrap">
    <div class="container">
        <div class="row">
            <div class="col-md col-xl-5 d-flex align-items-center">
                <a class="navbar-brand align-items-center" href="{{url('/')}}">
                    Educatioo
                    <span>Online Education &amp; Learning</span>
                </a>
            </div>
            {{--<div class="col-md d-flex align-items-center">
                <div class="con d-flex">
                    <div class="icon"><span class="flaticon-clock"></span></div>
                    <div class="text">
                        <span>Monday - Friday</span>
                        <strong>8:00AM-8:00PM</strong>
                    </div>
                </div>
            </div>
            <div class="col-md d-flex align-items-center">
                <div class="con d-flex">
                    <div class="icon"><span class="flaticon-telephone"></span></div>
                    <div class="text">
                        <span>Call Us</span>
                        <strong>+2 392 3929 210</strong>
                    </div>
                </div>
            </div>--}}
            <div class="col-md d-flex justify-content-end align-items-center">
                <div class="social-media">
                    <p class="mb-0 d-flex">
                        {{--<a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-facebook"><i class="sr-only">Facebook</i></span></a>
                        <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-twitter"><i class="sr-only">Twitter</i></span></a>
                        <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-instagram"><i class="sr-only">Instagram</i></span></a>
                        <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-dribbble"><i class="sr-only">Dribbble</i></span></a>
                        <a href="#" class="d-flex align-items-center justify-content-center"><span class="fa fa-sign-in"><i class="sr-only">Login</i></span></a>
--}}
                        <button type="button" class="btn btn-primary align-items-center justify-content-center" data-toggle="modal" data-target="#exampleModal">
                            Login
                        </button>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Login as</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-6 ml-auto ">
                            <label>Trainer</label>
                            <a href="{{route('teacher.login')}}" target="_blank"> <img src="{{asset('public/forntend/images/trainer-educatioo.png')}}" style="width: 150px"></a>
                        </div>

                        <div class="col-md-6 ml-auto ">
                            <label>Trainee</label>
                            <a href="{{route('login')}}" target="_blank"> <img src="{{asset('public/assets/img/image.png')}}" style="width: 150px"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

