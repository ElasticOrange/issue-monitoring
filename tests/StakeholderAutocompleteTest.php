<?php
namespace Tests;

use TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Issue\Stakeholder;

class StakeholderAutocompleteTest extends TestCase
{
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testExample()
	{
		$stakeholder = Stakeholder::create([
			'name' => 'Gigel Turbinca'
		]);

		$response = $this->call(
			'GET',
			action('StakeholderController@queryList'),
			[
				'name' => 'Gigel'
			]
		);

		$this->assertEquals(
			200,
			$response->status()
		);

		$firstStakeholder = json_decode($response->getContent())[0];
		$this->assertEquals(
			'Gigel Turbinca',
			$firstStakeholder->name
		);

		$stakeholder->delete();
	}
}
