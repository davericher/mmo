{{-- Produces a single Item block, requires a $items collection --}}
{{-- $is_owner - User owns item, $is_short Exclude non essential info, $is_admin User can Admin Items --}}
@if (isset($items))
@foreach ($items as $item)
<div class="col-md-3">
    <div class="content-box content-box-selectable item-box text-center">
        <dl class="index-item-info">
            <dt class="img-container">
                <a href="{{{route('items.show',$item->id)}}}" title="Click for more info">
                    <img src="{{{$item->present->photoSrc('content-box')}}}" alt="{{{$item->present->name}}}" class="img-responsive">
                    <div class="img-caption">
                        <i class="fa fa-external-link-square "></i>
                    </div>
                    @if (!isset($submarket))
                    <div class="img-caption img-caption-bottom-center itemblock-category">
                        <a href="{{{route('submarket',$item->category->slug)}}}">{{{$item->category->name}}}</a>
                    </div>
                    @endif
                </a>
            </dt>
            <dd class="margin-top-2 {{{isset($is_owner) ? 'block-text-24' : 'block-text-nested-24'}}}">
                <span class="perl weight-mid ">{{{$item->present->name}}}</span>
            </dd>
            <dd class="weight-mid small brown">{{{$item->present->created_at}}}</dd>
            <dd class="weight-high medium-small green">{{{$item->present->amount}}}</dd>
            @if (!isset($is_short) and !isset($is_owner))
            <dd class="blue weight-mid small-large">{{{$item->user->present->username}}}</dd>
            @endif
            @include('items.partials._itemBlockActionButtons')
        </dl>
    </div>
</div>
@endforeach
@endif