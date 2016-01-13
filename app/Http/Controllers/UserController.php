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
//dd($request->all());
        $user->fill($request->all());
        $user->save();
        $user->syncSubscription($request->input('subscription'));

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

        $user->save($request->all());
        $user->syncSubscription($request->input('subscription'));

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
}
