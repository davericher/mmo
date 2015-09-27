@if (Session::has('message') or Session::has('error') or Session::has('errors'))
<section id="errorSection" class="row">
    @section ('sessionMessage')
        @include('layouts.partials._sessionMessage')
    @show
    @section ('sessionError')
        @include('layouts.partials._sessionError')
    @show
    @section ('sessionErrors')
        @include('layouts.partials._sessionErrors')
    @show
</section>
@endif