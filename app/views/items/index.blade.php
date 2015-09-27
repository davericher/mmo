@extends('layouts.master')
@section('title')
    @parent Marketplace
@stop
@section('content')
@include('items.partials._itemBlockPaginator')
<div class="row">
    <div class="col-md-3">
        @include('items.partials._itemSearchBlock')
    </div>
    @include('items.partials._itemblocks',['errorColSize' => '9'])
</div>
@include('items.partials._itemBlockPaginator',['hidden' => true])
@stop
