<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('user.layout.head')
<body class="vertical-layout vertical-menu-modern 2-columns menu-expanded fixed-navbar"
      data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
@include('user.layout.header')
@include('user.layout.aside_bar')
@section('content')
@show
@include('user.layout.footer')
@include('user.layout.footer_script')
</body>
</html>
