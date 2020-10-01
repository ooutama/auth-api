<?php

namespace OutamaOthmane\AuthApi\Facades;

use Illuminate\Support\Facades\Facade;

class AuthApi extends Facade
{
	protected static function getFacadeAccessor()
	{
		return \OutamaOthmane\AuthApi\AuthApi::class;
	}
}