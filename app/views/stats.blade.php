@extends('layouts/master')
@section('title')
@parent Statistics
@stop
@section('content')
<div class="row perl text-center">
    <div class="col-md-12">
        <div class="content-box">
        <dl>
            <dt class="dl-header">
                <span class="text-shadow medium-big weight-mid">Statistics</span>
            </dt>
            <dd class="dl-content medium-small">
            Are you interested in how the site is doing? These numbers will help you measure our progress
            as we grow the only community made, maintained, and moderated second hand site in Sudbury! Check back
            hourly and watch the numbers reach the moon!
            </dd>
            <dd class="dl-footer small weight-mid">
                <i class="fa fa-refresh fa-fw fa-spin"></i>
                Results are updated hourly
            </dd>
        </dl>
        </div>
    </div>
</div>
<div id="statistics" class="row perl text-center text-shadow">
    <div class="col-md-3">
        <div class="content-box">
            <h1 class="big">{{{$user_count}}}</h1>
            <h3>{{{str_plural('Member',$user_count)}}}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="content-box">
            <h1 class="big">{{{$item_count}}}</h1>
            <h3>{{{str_plural('Item',$item_count)}}}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="content-box">
            <h1 class="big">{{{$comment_count}}}</h1>
            <h3>Comments</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="content-box">
            <h1 class="big">{{{$category_count}}}</h1>
            <h3>Categories</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="content-box">
            <h1 class="big">{{{$home_money}}}</h1>
            <h3>Market Value</h3>
        </div>
    </div>
</div>
@stop

