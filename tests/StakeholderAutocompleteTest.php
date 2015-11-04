<?php
namespace Tests;

use TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Issue\Stakeholder;
use Faker;
use Faker\Factory;
use Config;

class StakeholderAutocompleteTest extends TestCase
{
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

	public function testStakeholderSave()
	{
		$stakeholder_data = $this->stakeholderData();

		// Create a few stakeholders to connect the main one with
		$stakeholders_connected = [];
		for ($i = 0; $i < rand(3, 5); $i++) {
			$stakeholder_response_aux = $this->call(
				'POST',
				action('StakeholderController@store'),
				$this->stakeholderData()
			);

			$this->assertEquals(
				200,
				$stakeholder_response_aux->status()
			);
			$stakeholder_response_data = json_decode($stakeholder_response_aux->getContent());
			$stakeholder_aux = Stakeholder::find($stakeholder_response_data->id);
			$stakeholders_connected[] = $stakeholder_aux;
		}

		$stakeholder_data['stakeholders_connected'] = [];
		foreach ($stakeholders_connected as $sc) {
			$stakeholder_data['stakeholders_connected'][] = $sc->id;
		}

		$response = $this->call(
			'POST',
			action('StakeholderController@store'),
			$stakeholder_data
		);

		print_r($stakeholder_data);

		// We need to test the connected stakeholders and remove this stakeholder
		$stakeholder_generated_data = json_decode($response->getContent());
		$stakeholder = Stakeholder::find($stakeholder_generated_data->id);

		// Check if the main stakeholder is connected to the other stakeholders
		$connected_stakeholders = $stakeholder_data['stakeholders_connected'];
		$stakeholders_connected_found = [];
		foreach ($stakeholder->stakeholders_connected as $sc) {
			$stakeholders_connected_found[] = $sc->id;
		}
		$this->assertEquals(
			0,
			count(array_diff($stakeholders_connected_found, $stakeholder_data['stakeholders_connected']))
		);
		$this->assertEquals(
			0,
			count(array_diff($stakeholder_data['stakeholders_connected'], $stakeholders_connected_found))
		);

		// Cleanup
		$stakeholder->delete();
		foreach ($stakeholders_connected as $sc) {
			$sc->delete();
		}
	}
}
