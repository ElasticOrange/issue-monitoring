<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
	/**
	 * The base URL to use while testing the application.
	 *
	 * @var string
	 */
	protected $baseUrl = 'http://issuemonitoring.local';

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

		return $app;
	}

	public function setUp()
	{
		parent::setUp();

		Session::start();
	}

	public function stakeholderData()
	{
		$stakeholder_data = [
			'name' => $this->faker->name,
			'type' => 'persoana',
			'site' => $this->faker->url,
			'stakeholders_connected' => [],
			'_token' => csrf_token()
		];

		foreach (Config::get('app.all_locales') as $locale) {
			$stakeholder_data['contact'][$locale] = $this->faker->text;
			$stakeholder_data['profile'][$locale] = $this->faker->text;
			$stakeholder_data['position'][$locale] = $this->faker->text;
		}

		return $stakeholder_data;
	}
}
