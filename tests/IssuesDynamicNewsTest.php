<?php
namespace Tests;

use TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker;
use Faker\Factory;
use Config;
use Issue\News;
use Issue\Issue;

class IssuesDynamicNewsTest extends TestCase
{
	use WithoutMiddleware;
	public $faker;

	public function setUp()
	{
		parent::setUp();

		$this->faker = Faker\Factory::create();
	}

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	 public function testExample()
	 {
		 $response = $this->call(
			 'GET',
			 action('IssueController@queryNews')
		 );

		 $this->assertEquals(
			 200,
			 $response->status()
		 );
	 }
}
