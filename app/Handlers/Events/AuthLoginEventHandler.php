<?php

namespace Issue\Handlers\Events;

use Issue\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AuthLoginEventHandler
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle the event.
     *
     * @param  User $user
     * @param  $remember
     * @return void
     */
    public function handle(User $user)
    {
        if ($user->subscriptionExpired()) {

            $this->auth->logout();

            if ($user->subscription->type == 'trial') {
                return redirect()->guest('/auth/login')->withErrors('Perioada de testare de 14 zile a expirat.');
            }

            return redirect()->guest('/auth/login')->withErrors('Abonamentul tau a expirat.');
        }

        if ($user->active == 0) {

            $this->auth->logout();

            return redirect()->guest('/auth/login')->withErrors('Contul tau nu este activat.');
        }
    }
}
