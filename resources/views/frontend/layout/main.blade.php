<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('frontend.layout.head')
<body>
@include('frontend.layout.header')
@section('content')
@show
@include('frontend.layout.footer')
@include('frontend.layout.footer_script')
</body>
</html>
