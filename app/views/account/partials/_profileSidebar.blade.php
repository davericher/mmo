<div id="profileSidebar" class="content-box content-box-dark">
    @include('account.partials._userAvatar')
    @include('account.partials._userInfoTable')
    <a href="{{{route('account.settings')}}}" class="btn btn-blue btn-xs btn-block">
        <i class="fa fa-fw fa-pencil-square-o"></i>
        Update
    </a>
</div>

<div class="content-box">
    @include('account.partials._rolePermDataTable')
</div>