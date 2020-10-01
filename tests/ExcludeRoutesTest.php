<?php

namespace OutamaOthmane\AuthApi\Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use OutamaOthmane\AuthApi\Facades\AuthApi;

class ExcludeRoutesTest extends TestCase
{
	public function test_login_isnt_available()
	{
		$this->json('post', '/api/auth/login')
			->assertStatus(404);
	}

	public function test_register_isnt_available()
	{
		$this->json('post', '/api/auth/register')
			->assertStatus(404);
	}

	public function test_logout_isnt_available()
	{
		$this->json('post', '/api/auth/logout')
			->assertStatus(404);
	}

	public function test_me_isnt_available()
	{
		$this->json('get', '/api/auth/me')
			->assertStatus(404);
	}

	protected function getEnvironmentSetUp($app)
	{
		parent::getEnvironmentSetUp($app);

		$app['config']->set('auth-api.exclude_routes', ['me', 'login', 'register', 'logout']);
	}
}
