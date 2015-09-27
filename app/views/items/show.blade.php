@extends('layouts.master')
@section('meta')
    @parent
    @include('items.partials._itemMetaData')
@stop
@section('title')
@parent {{{$item->present->name}}}
@stop
@section('modals')
    @include('items.partials._itemModal')
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
    @include('items.partials._itemInfoDatalist')
    </div>
</div>
@stop
