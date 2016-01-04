<?php
namespace Tests;

use TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Issue\Document;
use Issue\User;

class AdminTest extends TestCase
{
	use DatabaseTransactions;
	use WithoutMiddleware;
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testAdminDashboardView()
	{
		$response = $this->call('GET', action('AdminDashboardController@getIndex'));

		$this->assertEquals(200, $response->status());
	}

	public function testLoginView()
	{
		$response = $this->call('GET', action('AdminDashboardController@getLogin'));

		$this->assertEquals(200, $response->status());
	}

	public function testDocumentsListView()
	{
		$response = $this->call('GET', action('DocumentController@index'));

		$this->assertEquals(200, $response->status());
	}

	public function testDocumentsCreateView()
	{
		$response = $this->call('GET', action('DocumentController@create'));

		$this->assertEquals(200, $response->status());
	}

	/** @test */
	public function create_a_new_admin_and_check_if_it_was_created()
	{
		$user = factory(User::class, 1)->create();
		$userCreated = User::find($user->id);

		$this->assertEquals($user->id, $userCreated->id);
	}
}
