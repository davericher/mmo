{{-- Requires a Paginator object --}}
{{-- Will hide on Large or medium displays if $hidden is set --}}
@if (isset($items) and $items->getTotal() > Irony\Services\ItemServices::$paginate)
<div class="row">
    <div class="col-md-12 {{ isset($hidden) ? 'hidden-lg hidden-md' : '' }}">
        <div class="content-box content-box-dark padding-top-5 text-center">
            {{$items->links()}}
        </div>
    </div>
</div>
@endif