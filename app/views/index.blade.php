@extends('layouts/master')
@section('title')
@parent Home
@stop
@section('before')
@include('partials._homeJumbotron')
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="content-box content-box-dark text-center padding-top-5">
            <span class="lead weight-mid medium perl spaced">Recent Items</span>
        </div>
    </div>
    @include('items.partials._itemblocks')
</div>
@stop

