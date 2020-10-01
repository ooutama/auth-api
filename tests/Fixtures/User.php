<?php

namespace OutamaOthmane\AuthApi\Tests\Fixtures;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
	use HasApiTokens;

	protected $table = 'users';

	protected $guarded = [];
}
