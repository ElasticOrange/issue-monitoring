<?php

namespace Issue\Http\Middleware;

use App;
use Config;
use Closure;
use Session;
use Illuminate\Contracts\Auth\Guard;

class ChangeLanguage
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('applocale') && in_array(Session::get('applocale'), Config::get('app.all_locales'))) {
            App::setLocale(Session::get('applocale'));
        }

        return $next($request);
    }
}
