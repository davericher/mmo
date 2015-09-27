@if (isset($comments) and isset($item) and !$comments->isEmpty())
    @foreach( $comments as $comment)
    <div class="col-md-12">
        <div class="content-box">
        <dl>
            <dt class="dl-header">
                <div class="display-inline push-left">
                    <div class="display-inline weight-mid {{{$comment->user_id == $item->user_id ? 'blue':'white'}}}">
                        <i class="fa fw fa-comment-o "></i>
                        <span class="weight-mid">

                            {{{$comment->user->present->username}}}
                        </span>
                    </div>
                </div>
                <div class="display-inline pull-right">
                @if( can_edit_posts($comment->user_id,$item->user_id,Auth::user()))
                {{Former::open()->action(route('items.comments.destroy',$comment->id))->method('delete')}}
                <button title="Remove" type="submit" class="btn btn-link red-link small commentDelete">
                    <i class="fa fa-trash-o grey"></i>
                </button>
                {{ Former::close() }}
                @endif
                </div>
            </dt>
            <dd class="dl-content">
                <span class="weight-mid perl item-comment">
                    {{{$comment->present->body}}}
                </span>
            </dd>
            <dd class="dl-footer">
                <span class="brown small weight-mid">
                {{{$comment->present->created_at}}}
                </span>
            </dd>
        </dl>
    </div>
    </div>
    @endforeach
    @if ($comments->getTotal() > Irony\Services\ItemServices::$commentsPaginate)
    <div class="col-md-12 text-center">
        <div class="content-box padding-top-5">
            {{$comments->fragment('comments')->links()}}
        </div>
    </div>
    @endif
@endif