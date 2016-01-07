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

class MailTest extends TestCase
{
//    use DatabaseTransactions;

    protected $mailcatcher;

    function __construct()
    {
        $this->mailcatcher = new Client(['base_url' => 'http://127.0.0.1:1080']);
    }

    public function getAllEmails()
    {
        $emails = $this->mailcatcher->get('/messages')->json();

        if(empty($emails))
        {
            $this->fail('No messages returned');
        }
        return $emails;
    }

    public function getLastEmail()
    {
        $emails = $this->getAllEmails();
        $emailId = count($emails);
        return $this->mailcatcher->get("/messages/{$emailId}.html");
    }

    /** @test */
    function reset_password_and_login_with_new_password()
    {

        $user = factory(User::class, 1)->create();

        $params = [
            '_token' => csrf_token(),
            'email' => $user->email,
        ];

        $this->call('POST', action('Auth\PasswordController@postEmail'), $params);

        $email = $this->getLastEmail();
        $reset_token = DB::table('password_resets')->select('token')->where('email', '=', $user->email)->get();

        $this->assertContains($reset_token[0]->token, (string) $email->getBody());

        $this->visit('/password/reset/'.$reset_token[0]->token)
            ->seePageIs('/password/reset/'.$reset_token[0]->token)
            ->type($user->email, 'email')
            ->type('qwerty', 'password')
            ->type('qwerty', 'password_confirmation')
            ->press('Reset password')
            ->seePageIs('/');

        $this->visit('/admin')->seePageIs('/admin');

        $user->delete();
    }
}
