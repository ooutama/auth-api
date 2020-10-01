<?php

namespace OutamaOthmane\AuthApi\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use OutamaOthmane\AuthApi\Exceptions\UserModelDoesntUseHasApiTokensException;
use OutamaOthmane\AuthApi\Facades\AuthApi;
use OutamaOthmane\AuthApi\Http\Requests\LoginRequest;

class LoginController extends Controller
{
	/**
     * Token used by device name
     *
     * @var string
     */
    protected const DEVICE_NAME = 'web_api';

    /**
     * 
     * Login the user
     *
     * @param \OutamaOthmane\AuthApi\Http\Requests\LoginRequest $request
     * @return mixed
     */
	public function __invoke(LoginRequest $request)
	{
		$user = AuthApi::userModelClass()::firstWhere($request->only(AuthApi::username()));

		if ( ! $user || ! Hash::check($request->password, $user->password)) {
			$this->failedResponse();
		}

		$token = $this->createToken($user);
		return $this->successResponse($token);
	}

	protected function createToken($user)
	{
		// Check if the model user has createToken method.
		// In other words, the user model has to use HasApiTokens trait provided by laravel/sanctum.
		if ( ! method_exists($user, "createToken")) {
			throw new UserModelDoesntUseHasApiTokensException(
				sprintf("'%s'  does not use the 'Laravel\Sanctum\HasApiTokens' trait.", AuthApi::userModelClass())
			);
		}

		$token = $user->createToken(self::DEVICE_NAME)->plainTextToken;

		/*-------------------------------------------------------------
		// Check if the id is provided within the token
		if (Str::contains($token, "|")) {
			// Skip the id
			return Str::afterLast($token, "|");
		}
		-------------------------------------------------------------*/

		return $token;
	}

	protected function failedResponse()
	{
		throw ValidationException::withMessages([
            'email' => [
            	Lang::get('auth.failed')
            ],
        ]);
	}

	protected function successResponse($token)
	{
		// Json format of the token with 200 as status code
		return response()->json(['token'	=>  $token], 200);
	}
}
