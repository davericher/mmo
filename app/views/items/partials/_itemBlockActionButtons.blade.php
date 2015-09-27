{{-- Draws the buttons for available actions within an ItemBlock --}}
{{-- Requires $item and will not display with the presence of $is_short --}}
{{-- $is_admin must be set in order for Persisted Actions--}}
@if (isset($item) and !isset($is_short))
    <dd class="dl-action-footer">
    @if (authIsOwner($item->user_id) or isset($is_admin))
        <a href="{{route('items.edit',$item->id)}}" class="btn btn-success btn-darksuccess btn-small btn-action" title="Update">
        <div class="action-button-container">
            <i class="fa fa-edit fa-fw green action-button-icon" ></i>
        </div>
        </a>
        {{ Former::open()->method('delete')->action(route('items.destroy',$item->id))->class('display-inline')}}
        {{ Former::hidden('_route')->value(Route::currentRouteName())}}
        {{ Former::hidden('_redirect')->value(URL::previous())}}
        <button type="submit" class="btn btn-danger btn-darkdanger btn-small btn-action" title="Delete">
        <div class="action-button-container">
            <i class="fa fa-trash-o fa-fw red action-button-icon"></i>
        </div>
        </button>
        {{ Former::close() }}
    @endif
    @if (!authIsOwner($item->user_id))
    <a href="mailto:{{{$item->user->email}}}" class="btn btn-email btn-small btn-action" title="Send Email" target="_blank">
    <div class="action-button-container">
        <i class="fa fa-envelope fa-fw action-button-icon" ></i>
    </div>
    </a>
    @endif
    <a href="https://www.facebook.com/sharer/sharer.php?u={{{route('items.show',$item->id)}}}" class="btn btn-facebook btn-small btn-action" title="Share on Facebook" target="_blank">
    <div class="action-button-container">
        <i class="fa fa-facebook fa-fw action-button-icon"></i>
    </div>
    </a>
    </dd>
@endif
