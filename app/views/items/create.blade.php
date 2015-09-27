@extends('layouts.master')
@section('title')
    @parent
    Account Sign up
@stop
@section('content')
<div class="content-container">
    <div class="container form-signup content-box">
        <div class="row">
            <div  class="col-lg-12">
                <div class="text-center">
                    <h1 class="text-shadow">New Item</h1>
                </div>
                {{ Former::open_for_files()->class('dropzone')->action(route('items.store'))}}
                       @include('items.partials._form')
                {{ Former::close() }}
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
    @parent
    {{-- Consider later HTML::script('js/vendor/dropzone.js')--}}
@stop
