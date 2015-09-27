@if(Session::has('message'))
<div class="col-lg-12">
    {{Alert::success(Session::get('message'))->block()}}
</div>
@endif