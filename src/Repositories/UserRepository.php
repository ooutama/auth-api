<?php

namespace OutamaOthmane\AuthApi\Repositories;

use Illuminate\Support\Facades\Hash;
use OutamaOthmane\AuthApi\Facades\AuthApi;

class UserRepository
{
	public function save(array $user)
	{
		AuthApi::userModelClass()::updateOrCreate([
			'email'    			=>  $user['email']
		], $this->user($user));
	}

	protected function user(array $user): array
	{
		$data = [];
		$data['name'] = $user['name'];

		if (array_key_exists("password", $user)) {
			$data['password'] = Hash::make($user['password']);
		}

		return $data;
	}
}
