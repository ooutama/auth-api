<?php

namespace OutamaOthmane\AuthApi;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use OutamaOthmane\AuthApi\Exceptions\UserResourceNotFound;
use OutamaOthmane\AuthApi\Http\Controllers\LoginController;
use OutamaOthmane\AuthApi\Http\Controllers\LogoutController;
use OutamaOthmane\AuthApi\Http\Controllers\MeController;
use OutamaOthmane\AuthApi\Http\Controllers\RegisterController;
use OutamaOthmane\AuthApi\Http\Resources\UserResource;

class AuthApi
{
	protected $userResource = null;

	public function __construct()
	{
		$this->setUserResource();
	}

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

	public function setUserResource()
	{
		$user_resource = Config::get('auth-api.user_resource');

		if (is_null($user_resource)) {
			$this->userResource = UserResource::class;
			return;
		}

		if ( ! class_exists($user_resource)) {
			throw new UserResourceNotFound("'{$user_resource}' does not exists!");
		}

		$this->userResource = $user_resource;
	}

	public function getUserResource()
	{
		return $this->userResource;
	}

	public function availableRoutes()
	{
		return [
			// key      =>  [method, uri, action]
			'login'		=> 	['post', 'login', LoginController::class],
			'register'	=>	['post', 'register', RegisterController::class],
			'logout'	=> 	['post', 'logout', LogoutController::class],
			'me'		=> 	['get', 'me', MeController::class],
		];
	}

	public function routes()
	{
		$exclude_routes = (array)Config::get('auth-api.exclude_routes');
		if (in_array("*", $exclude_routes)) {
			return;
		}

		$routes = array_values(Arr::except($this->availableRoutes(), $exclude_routes));
		foreach ($routes as $route) {
			Route::match($route[0], $route[1], $route[2]);
		}
	}
}
