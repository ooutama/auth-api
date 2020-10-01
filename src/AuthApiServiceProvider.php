<?php

namespace OutamaOthmane\AuthApi;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use OutamaOthmane\AuthApi\Facades\AuthApi;

class AuthApiServiceProvider extends ServiceProvider
{
	public function boot()
	{
		if ($this->app->runningInConsole()) {
        	$this->registerPublishing();  
        }

		$this->registerResources();
	}

	public function register()
	{
		// Use the current config file
		$this->mergeConfigFrom($this->configPath(), 'auth-api');
	}

	protected function registerResources()
	{
		$this->registerFacades();
		
		$this->registerRoutes();
	}

	protected function registerFacades()
	{
		// Register AuthApi facade
		$this->app->singleton('AuthApi', function ($app) {
			return new \OutamaOthmane\AuthApi\AuthApi;
		});
	}

	protected function registerRoutes()
	{
		Route::group($this->routeConfiguration(), function () {
			$this->loadRoutesFrom(__DIR__ . "/../routes/routes.php");
		});
	}

	protected function registerPublishing()
	{
		$this->publishes([
                __DIR__.'/../config/config.php' => config_path('auth-api.php'),
            ], 'auth-api-config');
	}

	protected function routeConfiguration()
	{
		return [
			'prefix'		=>	AuthApi::prefix(),
			'middleware'	=>	AuthApi::middleware(),
		];
	}

	protected function configPath()
    {
        return __DIR__ . '/../config/config.php';
    }
}
