@if (isset($user) and !$user->roles->isEmpty() )
    @foreach ($user->roles as $role)
    <dl>
        <dt class="dl-header">{{{$role->name}}}</dt>
    @if (! $role->perms->isEmpty() )
        @foreach ($role->perms as $perms)
            <dd class="margin-side-5">
                {{{$perms->display_name}}}
            </dd>
        @endforeach
    @endif
    </dl>
    @endforeach
@endif