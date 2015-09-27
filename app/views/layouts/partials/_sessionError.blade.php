@if(Session::has('error'))
<div class="col-lg-12">
    {{Alert::danger(Session::get('error'))->block();}}
</div>
@endif
