<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('authentication.layout.head')
<body class="vertical-layout vertical-menu-modern 2-columns menu-expanded fixed-navbar bg-full-screen-image" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
@section('content')
@show
@include('authentication.layout.footer_script')
</body>
</html>