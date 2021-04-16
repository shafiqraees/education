
<div class="sidebar" data-color="rose" data-background-color="white" data-image="{{asset('public/assets/img/sidebar-1.jpg')}}">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
    <div class="logo"><a href="{{route('admin.home')}}" class="simple-text logo-mini">
        </a>
        <a href="{{route('admin.home')}}" class="simple-text logo-normal">
            <img src="{{asset('public/assets/img/Educatioo.png')}}" style="max-width: 60%">
        </a>
    </div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                <img src="{{Storage::disk('public')->exists('md/'.Auth::guard('admin')->user()->profile_photo_path) ? Storage::disk('public')->url('md/'.Auth::guard('admin')->user()->profile_photo_path) : Storage::disk('public')->url('default.png')}}" />
            </div>
            <div class="user-info">
                <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                {{Auth::guard('admin')->user()->name}}
                <b class="caret"></b>
              </span>
                </a>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('admin.edit.profile')}}">
                                <span class="sidebar-mini"> P </span>
                                <span class="sidebar-normal"> Profile </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            <li class="nav-item active ">
                <a class="nav-link" href="{{route('admin.home')}}">
                    <i class="material-icons">dashboard</i>
                    <p> Dashboard </p>
                </a>
            </li>

            {{--<li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#subadmin">
                    <i class="material-icons">people_alt</i>
                    <p> Sub Admins
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="subadmin">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('subadmin.index')}}">
                                <span class="sidebar-mini"> All </span>
                                <span class="sidebar-normal"> All Sub Admin
                    </span>
                            </a>

                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('subadmin.create')}}">
                                <span class="sidebar-mini"> Add </span>
                                <span class="sidebar-normal">Add Sub Admin</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>--}}
            <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#teacher">
                    <i class="material-icons">people_alt</i>
                    <p> Trainer
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="teacher">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('teacher.index')}}">
                                <span class="sidebar-mini"> All </span>
                                <span class="sidebar-normal"> All Trainer
                    </span>
                            </a>

                        {{--<li class="nav-item ">
                            <a class="nav-link" href="{{route('teacher.create')}}">
                                <span class="sidebar-mini"> Add </span>
                                <span class="sidebar-normal">Add Teacher</span>
                            </a>
                        </li>--}}

                    </ul>
                </div>
            </li>
            <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#pagesExamples">
                    <i class="material-icons">image</i>
                    <p> Trianee Group
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="pagesExamples">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('classroom.index')}}">
                                <span class="sidebar-mini"> CR </span>
                                <span class="sidebar-normal"> Trianee Group </span>
                            </a>
                        </li>
                        {{--<li class="nav-item ">
                            <a class="nav-link" href="{{route('classroom.create')}}">
                                <span class="sidebar-mini"> ACR </span>
                                <span class="sidebar-normal">Add Class Room </span>
                            </a>
                        </li>--}}
                    </ul>
                </div>
            </li>
            <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#componentsExamples">
                    <i class="material-icons">people_alt</i>
                    <p> Trainee
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="componentsExamples">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('student.index')}}">
                                <span class="sidebar-mini"> All </span>
                                <span class="sidebar-normal"> All Trainee
                    </span>
                            </a>

                        {{--<li class="nav-item ">
                            <a class="nav-link" href="{{route('student.create')}}">
                                <span class="sidebar-mini"> Add </span>
                                <span class="sidebar-normal">Add Trainee</span>
                            </a>
                        </li>--}}

                    </ul>
                </div>
            </li>
            <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#quiz">
                    <i class="material-icons">not_listed_location</i>
                    <p> Courses
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="quiz">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('quiz.all')}}">
                                <span class="sidebar-mini"> All </span>
                                <span class="sidebar-normal"> All Courses </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('admin.launch.quiz')}}">
                                <span class="sidebar-mini"> l </span>
                                <span class="sidebar-normal"> Launched Courses </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{--<li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#transaction">
                    <i class="material-icons">receipt_long</i>
                    <p> Transactions
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="transaction">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('transaction')}}">
                                <span class="sidebar-mini"> All </span>
                                <span class="sidebar-normal"> All Transaction </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>--}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.logout') }}"
                   onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="material-icons">log_out</i>Signout</span>
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
    <div class="sidebar-background"></div>
</div>
