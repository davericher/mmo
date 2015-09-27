<?php
/**
 * Breadcrumbs allow for quick and painless navigation of a website
 * The follow file will map the routes to the appropriate site navigation structure
 *
 */

/** Home Route */
Breadcrumbs::register('home', function($breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});
/** Statistics Route */
Breadcrumbs::register('statistics', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Statistics', route('home'));
});
/** Session Routes */
Breadcrumbs::register('session.create', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Sign in', route('session.create'));
});

/** Password Reset Routes */
Breadcrumbs::register('reminder.create', function($breadcrumbs) {
    $breadcrumbs->parent('account');
    $breadcrumbs->push('Reminder', route('reminder.create'));

});

Breadcrumbs::register('reminder.show', function($breadcrumbs) {
    $breadcrumbs->parent('account');
    $breadcrumbs->push('Reset', route('reminder.show'));
});


/** Begin Account routes */
Breadcrumbs::register('account', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Account', route('account'));
});

Breadcrumbs::register('account.profile', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Profile', route('account.profile'));
});


	Breadcrumbs::register('account.signup', function($breadcrumbs) {
	    $breadcrumbs->parent('home');
	    $breadcrumbs->push('Sign up', route('account.signup'));
 	});

    Breadcrumbs::register('account.settings', function($breadcrumbs) {
        $breadcrumbs->parent('account');
        $breadcrumbs->push('Settings', route('account.settings'));
    });

/** End Account Routes */

/** Admin Routes */
Breadcrumbs::register('admin', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Admin', route('admin'));
});


Breadcrumbs::register('admin.users.index', function($breadcrumbs) {
    $breadcrumbs->parent('admin');
    $breadcrumbs->push('Users', route('admin.users.index'));
});

Breadcrumbs::register('admin.users.show', function($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.users.index');
    $breadcrumbs->push($id , route('admin.users.show', $id) );
});

	Breadcrumbs::register('admin.users.edit', function($breadcrumbs, $id) {
	    $breadcrumbs->parent('admin.users.show', $id);
	    $breadcrumbs->push('Edit', route('admin.users.edit', $id) );
	});
/** End Admin routes */

/** Item routes */
Breadcrumbs::register('items.index', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Market', route('items.index'));
});

Breadcrumbs::register('marketplace', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Marketplace', route('marketplace'));
});
    Breadcrumbs::register('items.create', function($breadcrumbs) {
        $breadcrumbs->parent('items.index');
        $breadcrumbs->push('Create', route('items.create'));
    });

/** End Item Routes */