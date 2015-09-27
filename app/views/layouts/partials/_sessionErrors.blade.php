@if(Session::has('errors'))
<div class="col-lg-12">
    <div class="panel panel-danger">
      <div class="panel-heading">
        <div class="panel-title">
            Errors
        </div>
      </div>
      <div id="errors" class="panel-body">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
    </div>
</div>
@endif