<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('teacher.layouts.head')
<body class="">
<div class="wrapper ">
    @include('teacher.layouts.aside_bar')
    <div class="main-panel">
        @include('teacher.layouts.header')
        <div class="content">
            @section('content')
        </div>
    </div>
</div>
@show
@include('teacher.layouts.footer')
@include('teacher.layouts.footer_script')
</body>
</html>
