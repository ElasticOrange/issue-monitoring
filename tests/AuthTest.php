<?php
namespace Tests;

use Illuminate\Support\Facades\DB;
use TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Hash;

use Issue\Document;
use Issue\User;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */


    /** @test */
    public function create_a_new_admin_and_check_if_it_was_created()
    {
        $user = factory(User::class, 1)->create();
        $userCreated = User::find($user->id);

        $this->assertEquals($user->name, $userCreated->name);
    }

    /** @test */
    public function create_a_new_admin_and_login_with_it()
    {
        $user = factory(User::class, 1)->create();

        $params = [
            '_token' => csrf_token(),
            'email' => $user->email,
            'password' => $user->remember_token
        ];

        $this->call('POST', action('Auth\AuthController@postLogin'), $params);

        $this->assertResponseStatus(302);
        $this->assertRedirectedToAction('AdminDashboardController@getIndex');
    }

    /** @test */
    public function create_a_new_admin_and_login_with_wrong_email()
    {
        $user = factory(User::class, 1)->create();

        $params = [
            '_token' => csrf_token(),
            'email' => '12345'.$user->email,
            'password' => $user->remember_token
        ];

        $this->call('POST', action('Auth\AuthController@postLogin'), $params);

        $this->assertRedirectedTo('/auth/login');
        $this->visit(action('AdminDashboardController@getIndex'))
            ->seePageIs(action('Auth\AuthController@getLogin'));
    }

    /** @test */
    public function create_a_new_admin_and_login_with_wrong_password()
    {
        $user = factory(User::class, 1)->create();

        $params = [
            '_token' => csrf_token(),
            'email' => $user->email,
            'password' => 'sadf'.$user->remember_token
        ];

        $this->call('POST', action('Auth\AuthController@postLogin'), $params);

        $this->assertRedirectedTo('/auth/login');
        $this->visit(action('AdminDashboardController@getIndex'))
            ->seePageIs(action('Auth\AuthController@getLogin'));
    }

    /** @test */
    public function create_a_new_admin_and_login_with_it_then_logout()
    {
        $user = factory(User::class, 1)->create();

        $params = [
            '_token' => csrf_token(),
            'email' => $user->email,
            'password' => $user->remember_token
        ];

        $this->call('POST', action('Auth\AuthController@postLogin'), $params);

        $this->visit('/users')->seePageIs('users');

        $response = $this->call('GET', action('Auth\AuthController@getLogout'));

        $this->assertEquals(
            302,
            $response->status()
        );

        $this->visit('/users')->seePageIs('/auth/login');
    }

    /** @test */
    public function check_if_a_page_is_available_to_guest()
    {
        $this->visit('/users')->seePageIs('/auth/login');
    }

    /** @test */
    public function reset_password_and_login_with_new_password()
    {

        $params = [
            '_token' => csrf_token(),
            'email' => 'xwave21@gmail.com',
        ];

        $response = $this->call('POST', action('Auth\PasswordController@postEmail'), $params);

        $this->assertEquals(302, $response->status());
    }
}