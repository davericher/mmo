@extends('layouts.master')
@section('title')
    @parent
    Item Edit
@stop
@section('content')
<div class="content-container">
    <div class="container form-signup content-box">
        <div class="text-center">
            <h1 class="text-shadow">Update</h1>
        </div>
        {{ Former::open_for_files()
            ->method('patch')
            ->action( route('items.update',$item->id) )
        }}
        {{ Former::populate( $item) }}
               @include('items.partials._form', ['isUpdate' => true])
        {{ Former::close() }}
    </div>
</div>
@stop
