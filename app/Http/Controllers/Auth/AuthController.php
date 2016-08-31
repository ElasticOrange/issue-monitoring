<?php

namespace Issue\Http\Controllers\Auth;

use DB;
use Validator;
use Issue\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Issue\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    protected $redirectTo = '/';

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    protected function trialValidator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'organization' => 'required|string',
            'function' => 'required|string',
            'telephone' => 'string',
            'domain'=> 'required',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::attempt($credentials, true)) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function createTrial(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'active' => 1,
            'type' => 'client'
        ]);

        $user->password = bcrypt($data['password']);
        $user->save();

        $user->domains()->attach(
            $data['domain'],
            [
                'can_see_issues' => 1,
                'can_see_news' => 1,
                'can_see_reports' => 1,
                'alert_for_issues' => 1,
                'alert_for_news' => 1,
                'alert_for_reports' => 1,
                'can_see_stakeholders' => 1
            ]);

        $end_date = $user->created_at;
        $end_date = $end_date->modify('+14 days');
        $end_date = $end_date->format('Y-m-d H:i:s');

        DB::table('user_subscriptions')->insert([
            'user_id'    => $user->id,
            'type'       => 'trial',
            'start_date' => $user->created_at,
            'end_date'   => $end_date
        ]);

        return $user;
    }

    /**
     * Registers a trial user
     *
     * @param Request $request
     */
    public function postRegister(Request $request)
    {
        $validator = $this->trialValidator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        Auth::login($this->createTrial($request->all()));

        return redirect($this->redirectPath());
    }
}
