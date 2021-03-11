
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

            <li class=" nav-item"><a href="{{ route('admin.logout') }}"
                                     onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="ft-power"></i><span class="menu-title" data-i18n="nav.morris_charts.main">Signout</span></a> <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form></li>
        </ul>
    </div>
</div>

