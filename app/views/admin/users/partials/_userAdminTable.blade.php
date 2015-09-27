<div class="content-box content-box-dark">
    @if (!$users->isEmpty())
        <table class="table">
            <thead>
                <tr class="grey">
                    <th>Username</th>
                    <th class="hidden-sm hidden-xs">Name</th>
                    <th class="hidden-sm hidden-xs">Email</th>
                    <th class="hidden-sm hidden-xs">Created</th>
                    <th class="hidden-sm hidden-xs">Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr onclick="go('{{$user->present->showUrl}}')">
                    <td>{{ $user->present->username }}</td>
                    <td class="hidden-sm hidden-xs">{{ $user->present->fullname }}</td>
                    <td class="hidden-sm hidden-xs">{{ $user->present->email }}</td>
                    <td class="hidden-sm hidden-xs">{{ $user->present->created_at }}</td>
                    <td class="hidden-sm hidden-xs">{{ $user->present->updated_at }}</td>
                    <td>
                    @if(!$user->trashed())
                    {{ Former::open()->method('patch')->action(route('admin.users.active',$user->id))->class('display-inline')}}
                        <button type="submit"
                        class="btn {{ $user->active ? 'btn-success btn-darksuccess green-link' : 'btn-danger btn-darkdanger red-link' }} btn-xs tiny"
                        title="{{$user->present->active}}">
                               <span class="glyphicon glyphicon-user" title="{{$user->present->active}}"></span>
                        </button>
                    {{ Former::close() }}
                    {{ Former::open()->method('patch')->action(route('admin.users.suspend',$user->id))->class('display-inline')}}
                        <button type="submit" class="btn btn-danger btn-darkdanger btn-xs tiny" title="Suspend">
                           <span class="glyphicon glyphicon-remove red"></span>
                        </button>
                    {{ Former::close() }}
                    @else
                    {{ Former::open()->method('patch')->action(route('admin.users.restore',$user->id))->class('display-inline')}}
                        <button type="submit" class="btn btn-success btn-darksuccess btn-xs tiny" title="Restore">
                           <span class="glyphicon glyphicon-ok green" ></span>
                        </button>
                    {{ Former::close() }}
                    {{ Former::open()->method('delete')->action(route('admin.users.destroy',$user->id))->class('display-inline')}}
                            <button type="submit" class="btn btn-danger btn-darkdanger btn-xs tiny" title="Delete">
                                <span class="glyphicon glyphicon-floppy-remove red"></span>
                            </button>
                    {{ Former::close() }}
                    @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
    <div class="text-center padding-bt-2">
        <span class"tiny">There are currently no users</span>
    </div>
    @endif
</div>