<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAdminDashboardView()
	{
	    $response = $this->call('GET', '/admin');

	    $this->assertEquals(200, $response->status());
	}

	public function testLoginView()
	{
		$response = $this->call('GET', '/admin/login');

		$this->assertEquals(200, $response->status());
	}

	public function testDocumentsView()
	{
		$response = $this->call('GET', '/backend/document');

		$this->assertEquals(200, $response->status());
	}

	public function testDocumentsCreate()
	{
		$response = $this->call('GET', '/backend/document/create');

		$this->assertEquals(200, $response->status());
	}
}