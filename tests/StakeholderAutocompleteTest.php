<?php
namespace Tests;

use TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StakeholderAutocompleteTest extends TestCase
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
			action('StakeholderController@queryList')
		);

		$this->assertEquals(
			200,
			$response->status()
		);
	}
}
