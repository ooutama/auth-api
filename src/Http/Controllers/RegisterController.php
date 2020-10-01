<?php

namespace OutamaOthmane\AuthApi\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use OutamaOthmane\AuthApi\Facades\AuthApi;
use OutamaOthmane\AuthApi\Http\Requests\RegisterRequest;
use OutamaOthmane\AuthApi\Repositories\UserRepository;

class RegisterController extends Controller
{
	public function __invoke(RegisterRequest $request, UserRepository $userRepository)
	{
		$userRepository->save(
			$request->only('name', 'email', 'password')
		);

		return response()->json(null, 201);
	}
}
