<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});

App::after(function($request, $response)
{
    //
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
        return Redirect::guest(route('session.create'))->withMessage(Lang::get('filters.auth_message'));
});

Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::route('home')->withError(Lang::get('filters.guest_error'));
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token')) return Redirect::home()
        ->withError(Lang::get('filters.csrf_error'));
        //throw new Illuminate\Session\TokenMismatchException;
});

/* User can edit a user if the account has the manage_users permission or it is the users own account */
Route::filter('canManageUsers', function()
{
    if ((!Entrust::can('manage_users')) )
        return Redirect::intended()->withError(Lang::get('filters.canManageUsers_error'));
});

/**
 * Filter will check if the item is being edited by either its owner
 * or a user with permissions to edit it
 * Presumes the auth filter has been called before it
 */
Route::filter('canManageItem', function ($route)
{
    $item_id = $route->getParameter('items');
    try
    {
        $item = Irony\Entities\Item::findOrFail($item_id,['user_id']);
        $user = Auth::user('id');
        if ( !($item->user_id == $user->id or $user->can('manage_items')) )
            return Redirect::intended()->withError(Lang::get('filters.canManageItem_error'));
    }
    catch (Illuminate\Database\Eloquent\ModelNotFoundException $e)
    {
        return Redirect::intended()->withError(Lang::get('items.missing'));
    }
});

Route::filter('canManageComments', function ($route)
{
    $comment_id = $route->getParameter('id');
    try
    {
        $comment = Irony\Entities\Comment::findOrFail($comment_id)->load(['item.user','user']);
        if (! can_edit_posts($comment->user->id, $comment->item->user->id, Auth::user()))
            return Redirect::intended()->withError(Lang::get('canManageComment_error'));
    }
    catch (Illuminate\Database\Eloquent\ModelNotFoundException $e)
    {
        return Redirect::intended()->withError(Lang::get('comments.missing'));
    }
});

/*
 * Filter isRoot will check the entrust role for the root priv
 */
Route::filter('isRoot', function()
{
    if (! Entrust::hasRole('Root') ) // Checks the current user
        return Redirect::home()->withError(Lang::get('filters.isRoot_error'));
});

