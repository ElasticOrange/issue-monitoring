<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;
use Issue\User;
use Hash;
use Issue\Http\Requests\UserRequest;
use Gate;
use Auth;
use Mail;
use Guard;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('list-users')) {
            abort(403);
        }

        $users = User::all();

        return view('auth.list', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('create-users')) {
            abort(403);
        }

        $user = new User;

        return view('auth.create', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if (Gate::denies('store-users')) {
            abort(403);
        }

        $user = new User;

        $password = str_random(10);
        $user->fill($request->all());
        $user->password = Hash::make($password);

        $user->save();

        $user->syncSubscription($request->input('subscription'));
        $this->endDateGtStartDate($request, $user->subscription);
        $this->sendNewUserEmail($user, $password);

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        if (Gate::denies('show-users')) {
            abort(403);
        }

        return $this->edit($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        if (Gate::denies('edit-users')) {
            abort(403);
        }

        return view('auth.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {
        $input = $request->all();

        if (Gate::denies('update-users')) {
            abort(403);
        }

        $this->validate(
            $request,
            [
                'name' => 'string|min:3',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'password' => 'string|min:5',
                'password_confirmation' => 'same:password',
            ]
        );

        $user->fill($request->all());

        if (isset($input['password']) && $input['password']) {
            $user->password = Hash::make($input['password']);
        }

        $user->save();

        $user->syncSubscription($request->input('subscription'));
        $this->endDateGtStartDate($request, $user->subscription);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        if (Gate::denies('delete-users')) {
            abort(403);
        }

        $user->delete();

        return redirect()->action('UserController@index');
    }

    public function setActive($user, Request $request)
    {
        $user->active = $request->input('active') == 'true';
        $user->save();

        return ['result' => true];
    }

    /**
     * @param $request
     * @param $data
     */
    public function endDateGtStartDate($request, $data)
    {
        if (is_object($data)) {
            $this->validate(
                $request,
                [
                    'subscription.start_date' => 'date|after:yesterday',
                    'subscription.end_date' => 'date|after:subscription.start_date'
                ]
            );
        }
    }

    private function sendNewUserEmail($user, $password)
    {
        Mail::send(
            'emails.usernew',
            [
                'user' => $user,
                'password' => $password
            ],
            function ($m) use ($user) {
                $m->to($user->email, $user->name)->subject('Your IssueMonitoring account!');
            }
        );
    }


    public function profile()
    {
        $user = Auth::user();

        return view('auth.show', ['user' => $user]);
    }

    public function updateProfile(Request $request)
    {
        $input = $request->all();

        $user = User::where('email', $input['email'])->firstOrFail();

        $this->validate(
            $request,
            [
                'name' => 'string|min:3',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'password' => 'string|min:5',
                'password_confirmation' => 'same:password',
            ]
        );

        $user->fill($input);

        if (isset($input['password']) && $input['password']) {
            $user->password = Hash::make($input['password']);
        }

        $user->save();

        return $user;
    }
}
