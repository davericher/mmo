<nav id="nav" class="margin-bt-5 navbar-inverse" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <a title="New Item" class="btn btn-green navbar-brand" href="{{route('items.create')}}">
                <i class="fa fa-plus-circle"></i>
                New Item
            </a>
        </div>
        @include('layouts.partials._navCollapse')
</nav>