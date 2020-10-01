<?php

return [
	/*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | Update this option to the default user model.
    | Most of the applications work with 'App\User::class'
    | But for applications that runs Laravel 8.0 you may use 'App\Models\User::class'
    |
    */
	'user_model'	=>	OutamaOthmane\AuthApi\Tests\Fixtures\User::class,
	
	/*
    |--------------------------------------------------------------------------
    | Username
    |--------------------------------------------------------------------------
    |
    | You may use another column that exists on your users table as login.
    | E.x.: username
    |
    */
	'username'		=>	'email',
		
	/*
    |--------------------------------------------------------------------------
    | Routes prefix
    |--------------------------------------------------------------------------
    |
    | If you want to change the prefix of the routes.
    | By using "api/auth" that means:
    | - /api/auth/login is the url of the login page
    | - /api/auth/register is the url of the register page
    | ...
    |
    */
	'route_prefix'	=> 'api/auth',
	
	/*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | You may specify multiple middleware. As in the example under, I'm using
    | 'api' middleware because, those urls are for api :)
    |
    */
	'middleware'	=> ['api'],

    /*
    |--------------------------------------------------------------------------
    | Exclude routes
    |--------------------------------------------------------------------------
    |
    | You may specify multiple routes that you do not want to be available
    | on your application.
    | Available routes: 'login', 'register', 'logout', 'me'
    | 
    */
    'exclude_routes'    => [],

    /*
    |--------------------------------------------------------------------------
    | User resource
    |--------------------------------------------------------------------------
    |
    | The name of the resource that the me route will use to show user information.
    | Use the command make:resource to create your own resource. 
    | For more details check: https://laravel.com/docs/eloquent-resources#introduction
    | 
    */
    'user_resource'     => null,
];
