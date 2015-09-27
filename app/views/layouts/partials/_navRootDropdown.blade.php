@if(Entrust::hasRole('Root'))
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <span class="{{{set_active('admin.users.index','white')}}}">Admin</span>&nbsp;<b class="caret"></b>
</a>
<ul class="dropdown-menu">
    <li><a href="#">Dashboard</a></li>
    <li class="{{{set_active('admin.users.index')}}}">
    <a href="{{{URL::route('admin.users.index')}}}">Users</a>
    </li>
</ul>
</li>
@endif