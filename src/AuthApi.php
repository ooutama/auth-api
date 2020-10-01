<?php

namespace OutamaOthmane\AuthApi;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use OutamaOthmane\AuthApi\Exceptions\PrivateUserResourceNotFound;
use OutamaOthmane\AuthApi\Http\Controllers\LoginController;
use OutamaOthmane\AuthApi\Http\Controllers\LogoutController;
use OutamaOthmane\AuthApi\Http\Controllers\MeController;
use OutamaOthmane\AuthApi\Http\Controllers\RegisterController;

class AuthApi
{
	protected $privateUserResource;

	public function userModelClass()
	{
		if (Config::get('auth-api.user_model')) {
			return Config::get('auth-api.user_model');
		}

		return Config::get('auth.providers.users.model');
	}

	public function username()
	{
		return Config::get('auth-api.username', 'email');
	}

	public function prefix()
	{
		return Config::get('auth-api.route_prefix', 'api/auth');
	}

	public function middleware()
	{
		return Config::get('auth-api.middleware', null);
	}

	public function setPrivateUserResource($privateUserResource)
	{
		if ( ! class_exists($privateUserResource)) {
			throw new PrivateUserResourceNotFound("'{$privateUserResource}' does not exists!");
		}

		$this->privateUserResource = $privateUserResource;
	}

	public function getPrivateUserResource()
	{
		return $this->privateUserResource;
	}

	public function availableRoutes()
	{
		return [
			'login'		=> 	Route::post('login', LoginController::class),
			'register'	=>	Route::post('register', RegisterController::class),
			'logout'	=> 	Route::post('logout', LogoutController::class),
			'me'		=> 	Route::get('me', MeController::class),
		];
	}

	public function routes()
	{
		$exclude_routes = (array)Config::get('auth-api.exclude_routes');

		if (in_array("*", $exclude_routes)) {
			return;
		}

		return array_values(Arr::except($this->availableRoutes(), $exclude_routes));
	}
}
