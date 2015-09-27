<?php

/*Test SQL queries */
//Event::listen('illuminate.query', function($sql) {
//    var_dump($sql);
//});

/**
 * Handle pagination so query strings do not get removed
 */
View::composer(Paginator::getViewName(), function($view) {
    $query = array_except( Input::query(), Paginator::getPageName() );
    $view->paginator->appends($query);
});
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
*/

/** Home Page Route */
Route::get('/',
    [
        'as' => 'home',
        'uses' => 'HomeController@getHome'
    ]
);
/** Statistic Route */
Route::get('statistics',
    [
        'as' => 'statistics',
        'uses' => 'HomeController@getStats'
    ]
);


Route::resource('items', 'ItemsController');
Route::post('items/modify',
    [
        'as' => 'items.modify',
        'uses' => 'ItemsController@postBack'
    ]
);
Route::get('marketplace',
    [
        'as' => 'marketplace',
        'uses' => 'ItemsController@index'
    ]
);
Route::get('marketplace/{catslug?}',[
    'as'    =>  'submarket',
    'uses'  =>  'ItemsController@index'
]);

/* Fix */
Route::get('logout',
	[
		'as'	=>	'logout',
		'uses' =>	'SessionController@destroy'
]);

/* Session Routes (Login / logout) */
Route::resource('session','SessionController', [ 'only' => [ 'create', 'store', 'destroy' ] ] );

/* Reminder routes for user password reset */
Route::resource('reminder','ReminderController', [ 'only' => [ 'create','store','show','destroy' ]]
);
/* Account Confirmation Routes */
Route::resource('confirm','ConfirmationController', ['only' =>  [ 'show' ]]);

/* Item Comments route */
Route::post('items/comment/{item_id?}',
    [ 'as' => 'items.comments.store', 'uses' => 'CommentsController@store' ]
)->where('item_id', '[0-9]+');

Route::delete('items/comment/{id?}',
    [ 'as' => 'items.comments.destroy', 'uses' => 'CommentsController@destroy' ]
)->where('id', '[0-9]+');


/** Administrative Section */
Route::group(
    ['prefix'   => 'admin'],
    function()
    {
        Route::get('/',
        [
            'as' => 'admin',
            'uses' => 'AdminController@getIndex'
        ]);
        Route::patch('users/active/{id}',
            [
                'as' => 'admin.users.active',
                'uses' => 'AdminUsersController@active'
            ]);
        Route::patch('users/restore/{id}',
            [
                'as' => 'admin.users.restore',
                'uses' => 'AdminUsersController@restore'
            ]);
        Route::patch('users/suspend/{id}',
            [
                'as' => 'admin.users.suspend',
                'uses' => 'AdminUsersController@suspend'
            ]);
        Route::resource('users','AdminUsersController',
            [
                'only' => [ 'index','show','destroy' ]
            ]
        );

    }
);

/** Users Section */
Route::group (
    ['prefix'    =>  'account'],
    function ()
    {
        /* Root route */
        Route::get('/', [
            'as' => 'account',
            'uses' => 'AccountController@getProfile'
        ])->before('auth');

        Route::get('profile', [
            'as' => 'account.profile',
            'uses' => 'AccountController@getProfile'
        ])->before('auth');

        /* User Sign up */
        Route::get('signup', [
            'as' => 'account.signup',
            'uses' => 'AccountController@getSignup'
        ])->before('guest');

        Route::post('signup', [
            'as' => 'account.signup',
            'uses' => 'AccountController@postSignup'
        ])->before('csrf|guest');

        /* User Settings */
        Route::get('settings', [
            'as' => 'account.settings',
            'uses' => 'AccountController@getSettings'
        ])->before('auth');

        Route::post('settings', [
            'as' => 'account.postSettings',
            'uses' => 'AccountController@postSettings'
        ])->before('csrf|auth');

        Route::patch('avatar/delete', [
            'as' => 'account.patchDeleteAvatar',
            'uses' => 'AccountController@patchDeleteAvatar'
        ])->before('csrf|auth');
    }
);
