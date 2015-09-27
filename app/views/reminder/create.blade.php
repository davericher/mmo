@extends('layouts.master')
@section('title')
    @parent User Password Reminder
@stop
@section('content')
<div class="content-container">
    <div class="container form-remind content-box">
        <div class="text-center">
            <h1 class="text-shadow">Reminder</h1>
            <h4 class="text-shadow">So, it seems like you have forgotten something...</h4>
            <p>Not a problem. Simply tell me what email you registerd your account with and I will send on
            over a password reset confirmation!</p>
        </div>
        {{ Former::open()->action(route('reminder.store')) }}
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
        <div class="row padded-row">
            <div class="col-lg-12">
            <button type="submit" class="btn btn-blue btn-large btn-block">
                <i class="fa fa-envelope-o fa-fw"></i>
                Send Reminder
            </button>
            </div>
        </div>
        {{ Former::close() }}
    </div>
</div>
@stop