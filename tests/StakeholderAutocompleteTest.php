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

	public function testStakeholdersConnectedSave()
	{
		$stakeholder_data = $this->stakeholderData();

		// Create a few stakeholders to connect the main one with
		$stakeholders_connected = [];
		for ($i = 0; $i < rand(3, 5); $i++) {
			$sc_data = $this->stakeholderData();
			$stakeholder_response_aux = $this->call(
				'POST',
				action('StakeholderController@store'),
				$sc_data
			);

			$this->assertEquals(
				200,
				$stakeholder_response_aux->status()
			);
			$stakeholder_response_data = json_decode($stakeholder_response_aux->getContent());
			$stakeholder_aux = Stakeholder::find($stakeholder_response_data->id);
			$stakeholders_connected[] = $stakeholder_aux;
		}

		foreach ($stakeholders_connected as $sc) {
			$stakeholder_data['stakeholders_connected'][] = $sc->id;
		}

		$response = $this->call(
			'POST',
			action('StakeholderController@store'),
			$stakeholder_data
		);

		// We need to test the connected stakeholders and remove this stakeholder
		$stakeholder_generated_data = json_decode($response->getContent());
		$stakeholder = Stakeholder::find($stakeholder_generated_data->id);

		// Check if the main stakeholder is connected to the other stakeholders
		$connected_stakeholders = $stakeholder_data['stakeholders_connected'];
		$stakeholders_connected_found = [];
		foreach ($stakeholder->stakeholdersConnectedOfMine as $sc) {
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

	public function testStakeholdersConnectedSaved_AreVisible_OnTheOtherSide()
	{
		$stakeholder_data = $this->stakeholderData();

		// Create a few stakeholders to connect the main one with
		$stakeholders_connected = [];
		for ($i = 0; $i < rand(3, 5); $i++) {
			$sc_data = $this->stakeholderData();

			$stakeholder_response_aux = $this->call(
				'POST',
				action('StakeholderController@store'),
				$sc_data
			);

			$this->assertEquals(
				200,
				$stakeholder_response_aux->status()
			);
			$stakeholder_response_data = json_decode($stakeholder_response_aux->getContent());
			$stakeholder_aux = Stakeholder::find($stakeholder_response_data->id);
			$stakeholders_connected[] = $stakeholder_aux;
		}

		foreach ($stakeholders_connected as $sc) {
			$stakeholder_data['stakeholders_connected'][] = $sc->id;
		}

		$response = $this->call(
			'POST',
			action('StakeholderController@store'),
			$stakeholder_data
		);

		// We need to test the connected stakeholders and remove this stakeholder
		$stakeholder_generated_data = json_decode($response->getContent());
		$stakeholder = Stakeholder::find($stakeholder_generated_data->id);

		// Check if the main stakeholder is connected to the other stakeholders
		$connected_stakeholders = $stakeholder_data['stakeholders_connected'];
		$stakeholders_connected_found = [];
		foreach ($stakeholder->stakeholdersConnected as $sc) {
			$found_stakeholder = $sc->stakeholdersConnected->where('id', $stakeholder->id)->count();
			$this->assertEquals(1, $found_stakeholder);
		}

		// Cleanup
		$stakeholder->delete();
		foreach ($stakeholders_connected as $sc) {
			$sc->delete();
		}
	}

	public function testStakeholdersConnected_RemovesOne_TheOthersAreStillThere()
	{
		// Initial state
		// a-->b
		// a-->c
		// b-->d
		// Remove a-->c, result should be
		// a-->b
		// b-->d

		$a_data = $this->stakeholderData();
		$a = Stakeholder::create($a_data);

		$b_data = $this->stakeholderData();
		$b = Stakeholder::create($b_data);

		$c_data = $this->stakeholderData();
		$c = Stakeholder::create($c_data);

		$d_data = $this->stakeholderData();
		$d = Stakeholder::create($d_data);

		// Connect a-->b, a-->c
		$a_data['stakeholders_connected'] = [$b->id, $c->id];
		$response = $this->call(
			'PUT',
			action('StakeholderController@update', [$a]),
			$a_data
		);
		$this->assertEquals(
			200,
			$response->status()
		);

		// Connect b-->d
		$b_data['stakeholders_connected'] = [$d->id];
		$response = $this->call(
			'PUT',
			action('StakeholderController@update', [$b]),
			$b_data
		);

		// Check a-x->b
		$b_found = false;
		foreach ($a->stakeholdersConnected as $sc) {
			if ($sc->id == $b->id) {
				$b_found = true;
			}
		}
		$this->assertFalse($b_found);

		// Check a-->c
		$c_found = false;
		foreach ($a->stakeholdersConnected as $sc) {
			if ($sc->id == $c->id) {
				$c_found = true;
			}
		}
		$this->assertTrue($c_found);

		// Check b-->d
		$d_found = false;
		foreach ($b->stakeholdersConnected as $sc) {
			if ($sc->id == $d->id) {
				$d_found = true;
			}
		}
		$this->assertTrue($d_found);

		$a->delete();
		$b->delete();
		$c->delete();
		$d->delete();
	}
}
