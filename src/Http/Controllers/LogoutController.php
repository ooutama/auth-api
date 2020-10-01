<?php

namespace OutamaOthmane\AuthApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use OutamaOthmane\AuthApi\Facades\AuthApi;

class LogoutController extends Controller
{
	public function __invoke(Request $request)
	{
		// Check if the user is authenticated
		if (Auth::check()) {
			// Get the current access token
			// In other words, get the id of the token that the user uses in authorization header
			$currentToken = $request->user()->currentAccessToken()->id;
			
			// Delete the token
			// => Logged out
    		$request->user()->tokens()->where('id', $currentToken)->delete();
		}

		return response()->json(null, 200);
	}
}
