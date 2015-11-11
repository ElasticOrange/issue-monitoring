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
			'email' => $this->faker->email,
			'site' => $this->faker->url,
			'telephone' => $this->faker->text,
			'stakeholders_connected' => [],
			'_token' => csrf_token()
		];

		foreach (Config::get('app.all_locales') as $locale) {
			$stakeholder_data['address'][$locale] = $this->faker->text;
			$stakeholder_data['other_details'][$locale] = $this->faker->text;
			$stakeholder_data['profile'][$locale] = $this->faker->text;
			$stakeholder_data['position'][$locale] = $this->faker->text;
		}

		return $stakeholder_data;
	}

	public function newsData()
	{
		$news_data = [
			'link' => $this->faker->url,
			'published' => 1,
			'public_code' => $this->faker->url,
			'stakeholders_connected' => [],
			'_token' => csrf_token()
		];

		foreach (Config::get('app.all_locales') as $locale) {
			$news_data['title'][$locale] = $this->faker->text;
			$news_data['description'][$locale] = $this->faker->text;
		}

		return $news_data;
	}
}
