@extends('layouts.master')
@section('title')
    @parent 
    User Profiles
@stop
@section('js')
@parent
<script type="text/javascript"> function go(url) { document.location.href = url; }</script>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        @include('admin.users.partials._userAdminTable')
    </div>
    <div class="col-md-12">
        @include('admin.users.partials._userAdminTableLegend')
    </div>
</div>
@stop