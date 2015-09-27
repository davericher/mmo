{{-- $is_owner, or $is_admin : Will display Edit boxes --}}
{{-- $is_short will display only Username, price, Created at --}}
{{-- pass $errorColSize variable to adjust col of area --}}
@if (!isset($items) or $items->isEmpty())
<div class="col-md-{{ isset($errorColSize) ? $errorColSize : '12'}}">
    <div class="content-box content-box-dark text-center">
    <a href="{{ route('items.create') }}" class="btn btn-green btn-block">
        <i class="fa fa-plus-circle fa-fw"></i>
        New Item
    </a>
    </div>
</div>
@else
@include('items.partials._itemBlock')
@endif