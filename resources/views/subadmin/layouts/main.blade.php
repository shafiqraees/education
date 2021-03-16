<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('subadmin.layouts.head')
<body class="">
<div class="wrapper ">
    @include('subadmin.layouts.aside_bar')
    <div class="main-panel">
        @include('subadmin.layouts.header')
        <div class="content">
            @section('content')
        </div>
    </div>
</div>
@show
@include('subadmin.layouts.footer')
@include('subadmin.layouts.footer_script')
</body>
</html>
