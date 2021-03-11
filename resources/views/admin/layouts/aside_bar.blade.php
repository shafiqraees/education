
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item"><a href="{{route('admin.home')}}"><i class="la la-dashboard"></i><span class="menu-title" data-i18n="nav.dash.main">Dashboard</span></a> </li>

            <li class=" nav-item"><a href="#"><i class="ft-users"></i><span class="menu-title" data-i18n="nav.pickers.main">Teacher</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{route('admin.teacher')}}" data-i18n="nav.pickers.pickers_date_time_picker">All Teacher</a> </li>
                    <li><a class="menu-item" href="{{route('admin.teacher.create')}}" data-i18n="nav.pickers.pickers_color_picker">Add New Teacher</a> </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="ft-users"></i><span class="menu-title" data-i18n="nav.pickers.main">Class Room</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{route('admin.class.room')}}" data-i18n="nav.pickers.pickers_date_time_picker">All Classes</a> </li>
                    <li><a class="menu-item" href="{{route('admin.create.class.room')}}" data-i18n="nav.pickers.pickers_color_picker">Add New class</a> </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="ft-users"></i><span class="menu-title" data-i18n="nav.pickers.main">Students</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{route('admin.all.students')}}" data-i18n="nav.pickers.pickers_date_time_picker">All Students</a> </li>
                    <li><a class="menu-item" href="{{route('admin.create.student')}}" data-i18n="nav.pickers.pickers_color_picker">Add New Student</a> </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="ft-users"></i><span class="menu-title" data-i18n="nav.pickers.main">Papers</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{route('admin.all.paper')}}" data-i18n="nav.pickers.pickers_date_time_picker">All Papers</a> </li>
                    <li><a class="menu-item" href="{{route('admin.launch.paper')}}" data-i18n="nav.pickers.pickers_color_picker">Launched Papers</a> </li>
                </ul>
            </li>
            <li class=" nav-item"><a href="{{ route('admin.logout') }}"
                                     onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="ft-power"></i><span class="menu-title" data-i18n="nav.morris_charts.main">Signout</span></a> <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>

