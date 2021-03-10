
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item"><a href="{{route('teacher.home')}}"><i class="la la-dashboard"></i><span class="menu-title" data-i18n="nav.dash.main">Dashboard</span></a> </li>
            <li class="nav-item"><a href="{{route('all.class.room')}}"><i class="la la-money"></i><span class="menu-title" data-i18n="nav.add_on_block_ui.main">Class Rooms</span></a> </li>
            <li class="nav-item"><a href="{{route('all.students')}}"><i class="icon-volume-2"></i><span class="menu-title" data-i18n="nav.add_on_image_cropper.main">Students</span></a> </li>
            <li class="nav-item"><a href="{{route('all.queston')}}"><i class="la la-repeat"></i><span class="menu-title" data-i18n="nav.form_repeater.main">Questions</span></a> </li>
            <li class=" nav-item"><a href="{{route('all.paper')}}"><i class="ft-users"></i><span class="menu-title" data-i18n="nav.add_on_drag_drop.main">Test Paper</span></a> </li>
            <li class=" nav-item"><a href="{{route('launch.quiz')}}"><i class="la la-comments"></i><span class="menu-title" data-i18n="">Launch Quiz</span></a> </li>
           {{-- <li class=" nav-item"><a href="#"><i class="la la-dollar"></i><span class="menu-title" data-i18n="">Results</span></a> </li>--}}
            <!-- la la-bullseye -->
            <li class=" nav-item"><a href="{{ route('logout') }}"
                                     onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="ft-power"></i><span class="menu-title" data-i18n="nav.morris_charts.main">Signout</span></a> <form id="logout-form" action="{{ route('teacher.logout') }}" method="POST" class="d-none">
                    @csrf
                </form></li>
        </ul>
    </div>
</div>

