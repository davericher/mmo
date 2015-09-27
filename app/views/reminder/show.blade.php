@extends('layouts.master')
@section('title')
    @parent Password Reset
@stop
@section('content')
<div class="content-container">
    <div class="container form-reset content-box">
        <div class="text-center">
            <h1 class="text-shadow">Reset</h1>
        </div>
        {{
        Former::open()
            ->action( route('reminder.destroy') )
            ->method('delete')
        }}
        {{ Former::hidden('token')->value($token)}}
        <div class="row">
            <div class="col-lg-12">
            {{ Former::email('email')
                ->addClass('form-control')
                ->label('Email Address')
                ->placeholder('Email Address')
                ->autofocus()
            }}
           </div>
        </div>
        <div class="row">
           <div class="col-lg-12">
            {{ Former::password('password')
                ->addClass('form-control')
                ->label('Password')
                ->placeholder('Password')
            }}
            </div>
        </div>
        <div class="row">
           <div class="col-lg-12">
            {{ Former::password('password_confirmation')
                ->addClass('form-control')
                ->label('Password Confirmation')
                ->placeholder('Password Confirmation')
            }}
            </div>
        </div>
        <div class="row padded-row">
            <div class="col-lg-12">
            {{ Former::actions()
                ->large_blue_block_submit('Reset')
            }}
            </div>
        </div>
        {{ Former::close() }}
    </div>
</div>
@stop
