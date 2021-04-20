
<div class="sidebar" data-color="rose" data-background-color="white" data-image="{{asset('public/assets/img/sidebar-1.jpg')}}">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
    <div class="logo"><a href="{{route('teacher.home')}}" class="simple-text logo-mini">

        </a>
        <a href="{{route('teacher.home')}}" class="simple-text logo-normal">
            <img src="{{asset('public/assets/img/Educatioo.png')}}" style="max-width: 60%">
        </a>
    </div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                <img src="{{Storage::disk('public')->exists('md/'.Auth::guard('teacher')->user()->profile_photo_path) ? Storage::disk('public')->url('md/'.Auth::guard('teacher')->user()->profile_photo_path) : Storage::disk('public')->url('default.png')}}" />
            </div>
            <div class="user-info">
                <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                {{Auth::guard('teacher')->user()->name}}
                <b class="caret"></b>
              </span>
                </a>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('profile.edit')}}">
                                <span class="sidebar-mini"> P </span>
                                <span class="sidebar-normal"> Profile </span>
                            </a>
                        </li>
                        {{--<li class="nav-item">
                            <a class="nav-link" href="{{route('subs.plan')}}">
                                <span class="sidebar-mini"> S </span>
                                <span class="sidebar-normal"> Subscription Plan </span>
                            </a>
                        </li>--}}
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            {{--<li class="nav-item active">
                <a class="nav-link" href="{{route('teacher.home')}}">
                    <i class="material-icons">dashboard</i>
                    <p> Dashboard </p>
                </a>
            </li>--}}
            <li class="nav-item ">
                <a class="nav-link" href="{{route('launch.create')}}">
                    <i class="material-icons">dashboard</i>
                    <p> Start Course </p>
                </a>
            </li>
            {{--<li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#launch">
                    <i class="material-icons">launch</i>
                    <p>Launch Courses
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="launch">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('launch.index')}}">
                                <span class="sidebar-mini"> All </span>
                                <span class="sidebar-normal"> All Launch Courses </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('launch.create')}}">
                                <span class="sidebar-mini"> Add </span>
                                <span class="sidebar-normal"> Start Course </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>--}}
            <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#quiz">
                    <i class="material-icons">launch</i>
                    <p> Courses
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="quiz">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('quiz.index')}}">
                                <span class="sidebar-mini"> All </span>
                                <span class="sidebar-normal"> All Courses </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('quiz.create')}}">
                                <span class="sidebar-mini"> Add </span>
                                <span class="sidebar-normal">New Course </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#pagesExamples">
                    <i class="material-icons">image</i>
                    <p> Trainee Groups
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="pagesExamples">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('classrooms.index')}}">
                                <span class="sidebar-mini"> CR </span>
                                <span class="sidebar-normal"> Trainee Groups </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('classrooms.create')}}">
                                <span class="sidebar-mini"> ACR </span>
                                <span class="sidebar-normal">Create New Group </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{--<li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#componentsExamples">
                    <i class="material-icons">people_alt</i>
                    <p> Trainee
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="componentsExamples">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('students.index')}}">
                                <span class="sidebar-mini"> All </span>
                                <span class="sidebar-normal"> All Trainee
                    </span>
                            </a>

                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('students.create')}}">
                                <span class="sidebar-mini"> Add </span>
                                <span class="sidebar-normal">Create New Trainee</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>--}}
            <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#formsExamples">
                    <i class="material-icons">content_paste</i>
                    <p> MCQs
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="formsExamples">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('question.index')}}">
                                <span class="sidebar-mini"> All </span>
                                <span class="sidebar-normal"> All MCQs </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('question.create')}}">
                                <span class="sidebar-mini"> Add </span>
                                <span class="sidebar-normal"> Create New MCQ </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#Results">
                    <i class="material-icons">launch</i>
                    <p> Results
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="Results">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('result.quiz')}}">
                                <span class="sidebar-mini"> All </span>
                                <span class="sidebar-normal"> Results </span>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('archive.quiz')}}">
                                <span class="sidebar-mini"> A </span>
                                <span class="sidebar-normal">Archive </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{--<li class="nav-item">
                <a class="nav-link" href="{{ route('teacher.logout') }}"
                   onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="material-icons">log_out</i>Signout</span>
                </a>
                <form id="logout-form" action="{{ route('teacher.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>--}}
        </ul>
    </div>
    <div class="sidebar-background"></div>
</div>
