{{-- Show the form to comment on an item --}}
@if (Auth::check() and isset($item))
<div class="col-md-12">
    <div class="content-box">
        {{Former::open()->rules(Irony\Entities\Comment::$rules)->action(route('items.comments.store',$item->id))}}
        <dl>
            <dt class="dl-header">
                <i class="fa fa-fw fa-comments-o"></i>
                <span class="perl weight-mid">Comment</span>
            </dt>
            <dd class="dl-form-block">{{
            Former::textarea('body')
            ->rows(5)
            ->columns(20)
            ->addClass('form-control dl-form-control')
            ->label('')
            ->placeholder('What would you like to say?')
            }}</dd>
            <dd class="dl-footer clear-padding">
                <button class="btn btn-small btn-blue btn-block" type="submit">
                    <i class="fa fa-plus-square-o fa-fw"></i>
                    Share comment
                </button>
            </dd>
        </dl>
        {{Former::close()}}
    </div>
</div>
@else
<div class="col-md-12">
    <div class="content-box">
    <a class="btn btn-small btn-green btn-block" href="{{route('session.create')}}">
        <i class="fa fa-sign-in fa-fw"></i>
        Join the conversation!
    </a>
    </div>
</div>
@endif
