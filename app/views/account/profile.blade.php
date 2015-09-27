@extends('layouts.master')
@section('title')
@parent {{{$user->present->username(true)}}} Profile
@stop
@section('content')
<div class="row">
<div class="col-md-3">
@include('account.partials._profileSidebar')
</div>
<div class="col-md-9">
<div class="row">
@include('account.partials._userNameBlock')
@include('items.partials._itemblocks', ['items' => $user->items,'is_owner' => true ])
</div>
</div>
</div>
@stop