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
use Issue\News;

class NewsDynamicStakeholderTest extends TestCase
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
		$response = $this->call(
			'GET',
			action('NewsController@queryStakeholder')
		);

		$this->assertEquals(
			200,
			$response->status()
		);
	}

	public function testExistingStakeholder()
	{
		$stakeholder = Stakeholder::create([
			'name' => 'Gigel Turbinca'
		]);

		$response = $this->call(
			'GET',
			action('NewsController@queryStakeholder'),
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

	public function testStakeholdersConnected_RemovesOne_TheOthersAreStillThere()
	{
		// Initial state
		// a-->b
		// a-->c
		// d-->e
		// Remove a-->c, result should be
		// a-->b
		// d-->e

		$a_news = $this->newsData();
		$a = News::create($a_news);

		$b_stakeholder = $this->stakeholderData();
		$b = Stakeholder::create($b_stakeholder);

		$c_stakeholder = $this->stakeholderData();
		$c = Stakeholder::create($c_stakeholder);

		$d_news = $this->newsData();
		$d = News::create($d_news);

		$e_stakeholder = $this->stakeholderData();
		$d = Stakeholder::create($e_stakeholder);

		// Connect a-->b, a-->c
		$a_news['stakeholders_connected'] = [$b->id, $c->id];
		$response = $this->call(
			'PUT',
			action('NewsController@update', [$a]),
			$a_news
		);
		$this->assertEquals(
			200,
			$response->status()
		);

		// Connect d-->e
		$d_news['stakeholders_connected'] = [$e->id];
		$response = $this->call(
			'PUT',
			action('NewsController@update', [$d]),
			$d_news
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
