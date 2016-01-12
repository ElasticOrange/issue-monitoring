<?php
namespace Tests;

use Illuminate\Support\Facades\DB;
use TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Hash;
use GuzzleHttp\Client;

use Issue\User;

class UserRightsTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create_a_new_editor_login_with_it_and_access_user_functions()
    {
        $user = factory(User::class, 1)->create(['type' => 'editor']);

        $params = [
            '_token' => csrf_token(),
            'email' => $user->email,
            'password' => $user->remember_token
        ];

        $this->call('POST', action('Auth\AuthController@postLogin'), $params);

        $this->assertResponseStatus(302);

        $response = $this->call('GET', action('UserController@index'));

        $this->assertEquals(403, $response->status());


        $backendIssue = $this->call('GET', action('IssueController@index'));

        $this->assertEquals(200, $backendIssue->status());
    }

    /** @test */
    public function create_a_new_user_of_type_client_and_login_with_it_and_access_backend_functions()
    {
        $user = factory(User::class, 1)->create(['type' => 'client']);

        $params = [
            '_token' => csrf_token(),
            'email' => $user->email,
            'password' => $user->remember_token
        ];

        $this->call('POST', action('Auth\AuthController@postLogin'), $params);

        $this->assertResponseStatus(302);

        $backendUsers = $this->call('GET', action('UserController@index'));

        $this->assertEquals(403, $backendUsers->status());


        $backendIssue = $this->call('GET', action('IssueController@index'));

        $this->assertEquals(403, $backendIssue->status());


        $backendDocuments = $this->call('GET', action('DocumentController@index'));

        $this->assertEquals(403, $backendDocuments->status());
    }
}