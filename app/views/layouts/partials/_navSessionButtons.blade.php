<div class="btn-group">
@if(!Auth::check())
<a href="{{{URL::route('session.create')}}}" class="btn navbar-btn btn-blue  {{{set_active('session.create')}}}">
<i class="fa fa-sign-in fa-fw nav-fa-right"></i>&nbsp;Sign in
</a>
<a href="{{{URL::route('account.signup')}}}" class="btn navbar-btn btn-blue  {{{set_active('account.signup')}}}">
<i class="fa fa-pencil fa-fw nav-fa-right"></i>&nbsp;Sign up
</a>
@else
{{-- Restful Signout button --}}
{{Former::open()->method('DELETE')->action(route('session.destroy','logout'))}}
<button type="submit" class="btn navbar-btn btn-blue">
<i class="fa fa-sign-out fa-fw nav-fa-right"></i>&nbsp;Sign out
</button>
{{Former::close()}}
@endif
</div>
