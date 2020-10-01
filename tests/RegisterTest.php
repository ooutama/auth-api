<?php

namespace OutamaOthmane\AuthApi\Tests;

class RegisterTest extends TestCase
{
	public function test_it_requires_name()
	{
		$this->json('post', '/api/auth/register')
			->assertJsonValidationErrors(["name"]);
	}

	public function test_it_requires_email()
	{
		$this->json('post', '/api/auth/register')
			->assertJsonValidationErrors(["email"]);
	}

	public function test_it_requires_a_valid_email()
	{
		$this->json('post', '/api/auth/register', ['email' => "invalid_email"])
			->assertJsonValidationErrors(["email"]);
	}

	public function test_it_requires_a_unique_email()
	{
		$user = $this->createUser('demo2@gmail.com', "Demo account");

		$this->json('post', '/api/auth/register', [
			'email' => $user->email
		])
		->assertJsonValidationErrors(["email"]);
	}

	public function test_it_requires_password()
	{
		$this->json('post', '/api/auth/register')
			->assertJsonValidationErrors(["password"]);
	}

	public function test_it_creates_the_user()
	{
		$this->json('post', '/api/auth/register', [
			'name' => $name = 'Othmane', 
			'email'	=> $email = 'demo3@gmail.com',
			'password'	=> '12345678'
		])
		->assertStatus(201);

		$this->assertDatabaseHas('users', [
			'name'	=> $name,
			'email'	=> $email,
		]);
	}
}