<?php

namespace OutamaOthmane\AuthApi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use OutamaOthmane\AuthApi\Facades\AuthApi;
use OutamaOthmane\AuthApi\Http\Resources\AuthResource;

class MeController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
	}

	public function __invoke(Request $request)
	{
		$privateUserResource = AuthApi::getPrivateUserResource();
		
		return (new $privateUserResource($request->user()));
	}
}
