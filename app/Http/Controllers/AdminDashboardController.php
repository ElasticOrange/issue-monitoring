<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;
use Gate;

class AdminDashboardController extends Controller
{
	public function getIndex()
	{
        if (Gate::denies('list-dashboard')) {
        abort(403);
    }

        return view('admin.backend.dashboard');
	}

	public function getLogin()
	{
        if (Gate::denies('list-login')) {
            abort(403);
        }

        return view('admin.backend.login');
	}
}
