@if (isset($user) and $user->avatar)
    <div class="img-container">
        <div class="text-center">
            <img src="{{{$user->present->avatarSrc('content-box')}}}"
                alt="User Profile Photo"
                class="img-responsive profile-avatar"
            >
        </div>
        <div class="img-caption">
            {{ Former::open()->method('patch')->action(route('account.patchDeleteAvatar'))->class('display-inline')}}
            <button type="submit" class="btn btn-link btn-image-caption" title="Delete Avatar">
                    <i class="fa fa-trash-o"></i>
            </button>
            {{ Former::close() }}
        </div>
    </div>
@endif