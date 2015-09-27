{{-- Provides Information about an Item in datalist format --}}
{{-- Requires an $item --}}
@if(isset($item))
<div class="content-box content-box-dark">
    <a class="pointer" data-toggle="modal" data-target="#modal" title="Click for unaltered Image">
        <div class="img-container">
            <img class="img-responsive" alt="{{{$item->present->name}}}" src="{{$item->present->photoSrc('full-size')}}">
            <div class="img-caption img-caption-item-show">
                <i class="fa fa-external-link-square"></i>
            </div>
            <div class="img-caption img-caption-bottom-right">
                <span class="itemshow-category">{{{$item->category->name}}}</span>
            </div>
        </div>
    </a>
</div>
<div class="content-box text-center">
    <dl class="magin-top-10">
        <dt class="dl-header">
            <span class="weight-mid item-name perl">{{{$item->present->name}}}</span>
        </dt>
        <dd class="big green text-shadow">{{{$item->present->amount}}}</dd>
        <dd class="small item-username weight-mid blue">
            {{{$item->user->present->username}}}
        </dd>
        @if ($item->isUpdated())
        <dd class="small item-updated-at brown">Updated:&nbsp;{{{$item->present->updated_at}}}</dd>
        @endif
        <dd class="small item-created-at border-under brown">{{{$item->present->created_at}}}</dd>
        <dd class="dl-content">
            <span class="medium perl">
                {{{$item->present->description}}}
            </span>
        </dd>
        @include('items.partials._itemBlockActionButtons')
    </dl>
</div>
    <div id="comments" class="row">
    @include('items.comments.partials._show')
    </div>
    <div class="row">
    @include('items.comments.partials._create')
    </div>
@endif