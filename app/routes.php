<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::any('/', 'IndexController@index');
Route::any('index/{id}', 'IndexController@index');
Route::any('index', 'IndexController@index');
//Route::any('(:any)', 'IndexController@page');
//Route::any('(:any)/(:any)', 'IndexController@page');
//Route::any('(:any)/(:any)/(:any)', 'IndexController@page');

Event::listen('404', function() {
	return Response::error('404');
});

View::composer('admin.topnav', function($view) {
	$user = Auth::user();
	if($user) {
		if($user->has_role('user')) {
			$view->useroptions = View::make('admin.topnav.useroptions');
		}
		if($user->has_role('admin')) {
			$view->adminoptions = View::make('admin.topnav.adminoptions');
		}
		if($user->has_role('superadmin')) {
			$view->superadminoptions = View::make('admin.topnav.superadminoptions');
		}
	}
});
Route::group(array('prefix' => 'admin'), function() {
	/** Anyone can access these pages **/
	Route::get('', 'Admin\IndexController@index');
	Route::put('login', 'Admin\UserController@login');
	Route::put('logout', 'Admin\UserController@logout');
	Route::get('password/reset/{id}', 'Admin\UserController@resetView');
	Route::put('password/reset', 'Admin\UserController@reset');
	Route::get('password/forgot', 'Admin\UserController@forgetPasswordView');
	Route::put('password/forgot', 'Admin\UserController@forgetPassword');


	/** Need to have login credentials to access these pages **/
	Route::group(array('before' => 'authorize'), function() {
		Route::get('help', 'Admin\HelpController@help');
		Route::get('welcome', 'Admin\IndexController@welcome');
	});
	/** End user filter **/


	/** Need user role to access these pages **/
	Route::group(array('before' => 'authorize|userrole'), function() {
		Route::get('widgets', 'Admin\WidgetController@index');
		Route::get('widgets/edit/{id}', 'Admin\WidgetController@editView');
		Route::put('widgets/update/{id}', 'Admin\WidgetController@update');
		
	});
	/** End userrole filter **/


	/** Need admin role to access these pages **/
	Route::group(array('before' => 'authorize|adminrole'), function() {
		Route::get('widgets/add/{id}', 'Admin\WidgetController@addView');
		Route::get('widgets/delete/{id}', 'Admin\WidgetController@deleteView');
		Route::put('widgets/create/{id}', 'Admin\WidgetController@create');
		Route::post('widgets/delete/{id}', 'Admin\WidgetController@delete');

		Route::get('navigation', 'Admin\NavigationController@index');
		Route::put('navigation/update', 'Admin\NavigationController@update');

		Route::get('page', 'Admin\PageController@index');
		Route::get('page/edit/{id}', 'Admin\PageController@editView');
		Route::get('page/add', 'Admin\PageController@addView');
		Route::get('page/delete/{id}', 'Admin\PageController@deleteView');

		Route::put('page/update/{id}', 'Admin\PageController@update');
		Route::put('page/create', 'Admin\PageController@create');
		Route::put('page/delete/(:any)', 'Admin\PageController@delete');

		Route::get('sites/header/edit', 'Admin\SiteController@headerEditView');
		Route::put('sites/header/edit', 'Admin\SiteController@headerUpdate');
		Route::get('sites/footer/edit', 'Admin\SiteController@footerEditView');
		Route::put('sites/footer/edit', 'Admin\SiteController@footerUpdate');
	});
	/** End adminrole filter **/


	/** Need super admin role to access these pages **/
	Route::group(array('before' => 'authorize|superadminrole'), function() {
		Route::get('users', 'Admin\UserController@indexView');
		Route::get('users/add', 'Admin\UserController@addView');
		Route::get('users/edit/{id}', 'Admin\UserController@editView');
		Route::get('users/delete/{id}', 'Admin\UserController@deleteView');
		Route::get('users/rules/{id}', 'Admin\UserController@rulesView');
		
		Route::put('users/update/{id}', 'Admin\UserController@update');
		Route::put('users/create', 'Admin\UserController@create');
		Route::put('users/delete/{id}', 'Admin\UserController@delete');
		Route::put('users/rules/{id}', 'Admin\UserController@updateRules');

		Route::get('sites/add', 'Admin\SiteController@addView');
		Route::get('sites/edit/{id}', 'Admin\SiteController@editView');
		Route::get('sites/delete/{id}', 'Admin\SiteController@deleteView');
		Route::get('sites', 'Admin\SiteController@indexView');
		Route::put('sites/change', 'Admin\SiteController@change');
		Route::put('sites/update/{id}', 'Admin\SiteController@update');
		Route::put('sites/delete/{id}', 'Admin\SiteController@delete');
		Route::put('sites/create', 'Admin\SiteController@create');
	});
	/** End super admin role filter **/
});

Event::listen('404', function() {
	return Redirect::to('admin/welcome');
});

Route::filter('authorize', function() {
	if(!Auth::check()) {
		return Redirect::to('admin');
	}
});

Route::filter('adminrole', function() {
	if(!Auth::user()->has_role('admin')) {
		return Redirect::to('/admin/welcome');
	}
});

Route::filter('superadminrole', function() {
	if(!Auth::user()->has_role('superadmin')) {
		return Redirect::to('/admin/welcome');
	}
});

Route::filter('userrole', function() {
	if(!Auth::user()->has_role('user')) {
		return Redirect::to('/admin');
	}
});