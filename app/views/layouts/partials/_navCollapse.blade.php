<div class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
        <li class="{{{set_active('home')}}}">
          <a href="{{{URL::route('home')}}}">Home</a>
        </li>
        <li class="{{{set_active('marketplace items.show')}}}">
          <a href="{{{URL::route('marketplace')}}}">Market</a>
        </li>
        <li class="{{{set_active('statistics')}}}">
          <a href="{{{URL::route('statistics')}}}">Statistics</a>
        </li>
        @if(Auth::check())
        <li class="{{{set_active('account.profile')}}}">
          <a href="{{{URL::route('account.profile')}}}">Profile</a>
        </li>
        @endif
        @include('layouts.partials._navRootDropdown')
    </ul>
    <div class="navbar-right">
        @include('layouts.partials._navSessionButtons')
    </div>
</div>