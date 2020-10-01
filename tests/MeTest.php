<?php

namespace OutamaOthmane\AuthApi\Tests;

class MeTest extends TestCase
{
	public function test_it_fails_it_the_user_isnt_auth()
	{
		$this->json('get', '/api/auth/me')
		->assertStatus(401);
	}

	public function test_it_returns_user_resource()
	{
		$user = $this->createUser('demoMe@gmail.com', 'Otm');

		$this->jsonAs($user, 'get', '/api/auth/me')
		->assertStatus(200)
		->assertJsonFragment([
			'id'	=> $user->id,
			'email'	=> $user->email,
			'name'	=> $user->name,
			'email_verified'	=> (bool)$user->email_verified,
		]);
	}
}