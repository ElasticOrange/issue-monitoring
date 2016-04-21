<?php

namespace Issue\Http\Controllers;

use Gate;
use Issue\Http\Requests;
use Illuminate\Http\Request;
use Issue\Http\Controllers\Controller;

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
