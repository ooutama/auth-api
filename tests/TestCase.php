<?php

namespace OutamaOthmane\AuthApi\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\SanctumServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use OutamaOthmane\AuthApi\AuthApiServiceProvider;
use OutamaOthmane\AuthApi\Tests\Fixtures\User;

abstract class TestCase extends BaseTestCase
{
	use RefreshDatabase;

	protected function setUp(): void
	{
		parent::setUp();

		$this->loadLaravelMigrations(['--database' => 'testing']);
		$this->setUpDatabase();
	}

	protected function getPackageProviders($app)
	{
		return [
			AuthApiServiceProvider::class,
			SanctumServiceProvider::class,
		];
	}

	protected function getEnvironmentSetUp($app)
	{
		// You can use sqlite drive or testing driver provided by orchestra
		// $app['config']->set('database.default', 'testing');
		
		// Because sqlite does not work well on my windows, I use mysql instead.
		$app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' 	=> 'mysql',
            'url' 		=> null,
            'host'		=> 'localhost',
            'database'	=> 'mm',
			'username'	=> 'root',
			'password'	=> '',
            'port' 		=> 3306,
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ]);

		$app['config']->set('auth.defaults.guard', 'api');
		$app['config']->set('auth.guards.api.driver', 'sanctum');
	}

	protected function setUpDatabase()
	{
		$this->app['db']->connection()->getSchemaBuilder()->dropIfExists('personal_access_tokens');
		$this->app['db']->connection()->getSchemaBuilder()->create('personal_access_tokens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
        });
	}

	protected function createUser($email = '', $name = '', $password = 'password')
	{
		$user = User::forceCreate([
			'name'	=> $name,
			'email'	=> $email,
			'password'	=> Hash::make($password),
		]);

		return $user;
	}

	public function jsonAs(User $user, $method, $url, $data = [], $headers = [])
    {
    	$headers = array_merge([
    		'Authorization' => "Bearer " . $user->createToken('web_api')->plainTextToken,
    	], $headers);
    	
    	return $this->json($method, $url, $data, $headers);
    }
}
