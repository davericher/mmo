@extends('layouts/master')
@section('title')
    @parent User Login
@stop
@section('content')
<div class="content-container">
    <div class="container form-signin content-box">
        <div class="text-center">
            <h1 class="text-shadow">Sign in</h1>
        </div>
        {{ Former::open()->method('POST')->action( route('session.store'))  }}
        <div class="row">
            <div class="col-lg-12">
            {{ Former::email('email')
                ->addClass('form-control')
                ->label('Email Address')
                ->placeholder('Email Address')
                ->autofocus()
                ->required()
            }}
           </div>
        </div>
        <div class="row">
           <div class="col-lg-12">
            {{ Former::password('password')
                ->addClass('form-control')
                ->label('Password')
                ->placeholder('Password')
                ->required()
            }}
            </div>
        </div>
        <div cass="row padded-row">
            {{ Former::checkbox('remember')
                ->addClass('form-group')
                ->label('')
                ->value('1')
                ->text('Remember me')
            }}
        </div>
        <div class="row padded-row">
            <div class="col-lg-12">
            <button type="submit" class="btn btn-blue btn-large btn-block">
                <i class="fa fa-sign-in fa-fw"></i>
                Sign in
            </button>
            </div>
        </div>
        {{ Former::close() }}
         <div class="row text-right">
            <div class="col-lg-12">
                <a href="{{{route('account.signup')}}}" class="btn btn-green btn-block">
                    <i class="fa fa-pencil fa-fw"></i>
                    Sign Up
                </a>
            </div>
        </div>
        <div class="row text-right">
            <div class="col-lg-12">
            {{ link_to(route('reminder.create'),'Forgot Password?',['class' => 'btn btn-sm btn-link ']) }}
            </div>
        </div>
    </div>
</div>
@stop