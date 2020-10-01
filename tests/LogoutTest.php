<?php

namespace OutamaOthmane\AuthApi\Tests;

class LogoutTest extends TestCase
{
	public function test_it_deletes_the_auth_token()
	{
		$user = $this->createUser('demo4@gmail.com', 'Demo');
		$user->tokens()->delete();
		
		$this->jsonAs($user, 'post', '/api/auth/logout')
		->assertStatus(200);

        $this->assertEquals($user->tokens()->count(), 0);
	}
}