<?php

namespace OutamaOthmane\AuthApi\Tests;

use Illuminate\Support\Facades\Hash;
use OutamaOthmane\AuthApi\Facades\AuthApi;

class LoginTest extends TestCase
{
	public function test_it_requires_username()
	{
		$this->json('post', '/api/auth/login')
			->assertJsonValidationErrors(['email']);
	}

	public function test_it_requires_password()
	{
		$this->json('post', '/api/auth/login')
			->assertJsonValidationErrors(['password']);
	}

	public function test_it_fails_it_user_does_not_exist()
	{
		$this->json('post', '/api/auth/login', [
			'email'	=> 'nope@email.com',
			'password'	=> 'password'
		])
			->assertJsonValidationErrors(['email']);
	}

	public function test_it_returns_auth_token()
	{
		$user = $this->createUser('myemail@domain.com', 'Othmane');

		$this->json('post', '/api/auth/login', [
			'email'	=> 'myemail@domain.com',
			'password'	=> 'password'
		])
		->assertJsonStructure(['token']);
	}
}