<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('user.layouts.head')
<body class="">
<div class="wrapper ">
    {{--@include('user.layouts.aside_bar')--}}
    <div class="main-panel">
        @include('user.layouts.header')
        <div class="content">
            @section('content')
        </div>
    </div>
</div>
@show
{{--@include('user.layouts.footer')--}}
@include('user.layouts.footer_script')
</body>
</html>
