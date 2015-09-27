<table class="table">
    <thead>
        <tr>
            <td colspan="3"  class="text-center">
                <span class="item-username weight-mid blue">{{{$user->present->username}}}</span>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr><td>Name</td><td >{{{$user->present->fullname}}}</td></tr>
        <tr><td>Created</td><td>{{{$user->present->created_at}}}</td></tr>
        <tr><td>Modified</td><td>{{{$user->present->updated_at}}}</td></tr>
    </tbody>
    <tfoot>
        <tr><td class="text-center" colspan="3">{{{$user->present->email}}}</td></tr></tr>
    </tfoot>
</table>
