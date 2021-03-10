<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('teacher.layouts.head')
<body class="vertical-layout vertical-menu-modern 2-columns menu-expanded fixed-navbar"
      data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
@include('teacher.layouts.header')
@include('teacher.layouts.aside_bar')
@section('content')
@show
@include('teacher.layouts.footer')
@include('teacher.layouts.footer_script')
</body>
</html>
