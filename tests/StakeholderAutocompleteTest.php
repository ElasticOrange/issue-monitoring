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
		$stakeholder_data = [
			'name' => $this->faker->name,
			'type' => 'persoana',
			'site' => $this->faker->url,
			'_token' => csrf_token()
		];

		foreach (Config::get('app.all_locales') as $locale) {
			$stakeholder_data['contact'][$locale] = $this->faker->text;
			$stakeholder_data['profile'][$locale] = $this->faker->text;
			$stakeholder_data['position'][$locale] = $this->faker->text;
		}

		$response = $this->call(
			'POST',
			action('StakeholderController@store'),
			$stakeholder_data
		);

		// We need to test the connected stakeholders and remove this stakeholder
		echo $response->getContent();
	}
}
