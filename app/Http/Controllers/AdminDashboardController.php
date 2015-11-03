<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
	public function getIndex()
	{
		return view('admin.backend.dashboard');
	}

	public function getLogin()
	{
		return view('admin.backend.login');
	}

}
