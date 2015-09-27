@extends('layouts.master')
@section('title')
    @parent
    {{ $user->present->username(true) }} Settings
@stop
@section('content')
<div class="content-container">
    <div class="container form-signup content-box">
        <div class="text-center">
            <h1 class="text-shadow">Settings</h1>
        </div>
                {{ Former::open_for_files()
                    ->method('post')
                    ->action( route('account.postSettings') )
                }}
                {{ Former::populate( $user) }}
               @include('account.partials._form', ['isUpdate' => true])
               {{ Former::close() }}
    </div>
</div>
@stop
