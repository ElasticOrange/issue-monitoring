<?php
namespace Tests;

use TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker;
use Faker\Factory;
use Config;
use Issue\Issue;
use Issue\Domain;

class IssuesDynamicDomainTest extends TestCase
{
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	 public function testExample()
	 {
		 $response = $this->call(
			 'GET',
			 action('IssueController@queryDomain')
		 );

		 $this->assertEquals(
			 200,
			 $response->status()
		 );
	 }
}
