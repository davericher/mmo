<!DOCTYPE html >
@include('layouts.partials._htmlCompat')
<head>
@section ('meta')
@include('layouts.partials._meta')
@show
@section ('css')
@include ('layouts.partials._css')
@show
<title>
@section('title') My Market Ottawa
@show
</title>
@include('layouts.partials._headCompat')
</head>
<body>
@include('layouts.partials._bodyCompat')
@section('modals')
@show
<div id="siteWrapper" class="container">
    @include('layouts.partials._nav')
    @include('layouts.partials._sessionSection')
    @include('layouts.partials._breadcrumbSection')
    @yield('before')
    <section id="contentSection">
    @yield('content')
    </section>
</div>
<footer id="footer" class="container">
    @section('footer')
    @show
    @include('layouts/partials/_footer')
</footer>
@section ('js')
@include('layouts.partials._js')
@show
</body>
</html>