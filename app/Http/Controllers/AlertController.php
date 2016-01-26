<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;
use Issue\Alert;
use Issue\Http\Controllers\Controller;
use Issue\Http\Requests;
use Issue\News;
use Issue\User;

class AlertController extends Controller
{
    public function index()
    {
        $alerts = Alert::all();

        return view('admin.backend.alerts.list', ['alerts' => $alerts]);
    }

    public function preview($id)
    {
        $alert = Alert::find($id);

        return view('admin.backend.alerts.headpreview', ['alert' => $alert]);
    }
}
