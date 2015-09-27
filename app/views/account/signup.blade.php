@extends('layouts.master')
@section('title')
    @parent
    Account Sign up
@stop
@section('content')
<div class="content-container">
    <div class="container content-box  form-signup">
                <div class="text-center">
                    <h1 class="text-shadow">Sign up</h1>
                    <h4 class="text-shadow">Start buying and selling today</h4>
                </div>
                {{ Former::open_for_files() }}
                @include('account.partials._form')
                {{ Former::close() }}
        </div>
</div>
@stop