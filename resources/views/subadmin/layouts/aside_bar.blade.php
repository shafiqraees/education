
<div class="sidebar" data-color="rose" data-background-color="white" data-image="{{asset('public/assets/img/sidebar-1.jpg')}}">
    <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
    <div class="logo"><a href="{{route('subadmin.home')}}" class="simple-text logo-mini">
        </a>
        <a href="{{route('subadmin.home')}}" class="simple-text logo-normal">
            <img src="{{asset('public/assets/img/Educatioo.png')}}" style="max-width: 60%">
        </a>
    </div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                <img src="{{Storage::disk('public')->exists('md/'.Auth::guard('subadmin')->user()->profile_photo_path) ? Storage::disk('public')->url('md/'.Auth::guard('subadmin')->user()->profile_photo_path) : Storage::disk('public')->url('default.png')}}" />
            </div>
            <div class="user-info">
                <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                {{Auth::guard('subadmin')->user()->name}}
                <b class="caret"></b>
              </span>
                </a>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('subadmin.edit.profile')}}">
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
                <a class="nav-link" href="{{route('subadmin.home')}}">
                    <i class="material-icons">dashboard</i>
                    <p> Dashboard </p>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#teacher">
                    <i class="material-icons">people_alt</i>
                    <p> Teacher
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="teacher">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('teachers.index')}}">
                                <span class="sidebar-mini"> All </span>
                                <span class="sidebar-normal"> All Teacher
                    </span>
                            </a>

                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('teachers.create')}}">
                                <span class="sidebar-mini"> Add </span>
                                <span class="sidebar-normal">Add Teacher</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <li class="nav-item ">
                <a class="nav-link" data-toggle="collapse" href="#pagesExamples">
                    <i class="material-icons">image</i>
                    <p> Class Room
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="pagesExamples">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('all-class-rooms.index')}}">
                                <span class="sidebar-mini"> CR </span>
                                <span class="sidebar-normal"> Class Rooms </span>
                            </a>
                        </li>
                        {{--<li class="nav-item ">
                            <a class="nav-link" href="{{route('classrooms.create')}}">
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
                    <p> Students
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="componentsExamples">
                    <ul class="nav">
                        <li class="nav-item ">
                            <a class="nav-link" href="{{route('all-students.index')}}">
                                <span class="sidebar-mini"> All </span>
                                <span class="sidebar-normal"> All Students
                                </span>
                            </a>
                        </li>
                        {{--<li class="nav-item ">
                            <a class="nav-link" href="{{route('students.create')}}">
                                <span class="sidebar-mini"> Add </span>
                                <span class="sidebar-normal">Add Student</span>
                            </a>
                        </li>--}}

                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('subadmin.logout') }}"
                   onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="material-icons">log_out</i>Signout</span>
                </a>
                <form id="logout-form" action="{{ route('subadmin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
    <div class="sidebar-background"></div>
</div>
