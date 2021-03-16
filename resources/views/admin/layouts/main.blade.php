<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('admin.layouts.head')
<body class="">
<div class="wrapper ">
    @include('admin.layouts.aside_bar')
    <div class="main-panel">
        @include('admin.layouts.header')
        <div class="content">
            @section('content')
        </div>
    </div>
</div>
@show
@include('admin.layouts.footer')
@include('admin.layouts.footer_script')
</body>
</html>
