<?php

namespace Issue\Http\Controllers;

use Gate;
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
        if (Gate::denies('list-alerts')) {
            abort(403);
        }

        $alerts = Alert::all();

        return view('admin.backend.alerts.list', ['alerts' => $alerts]);
    }

    public function preview($id)
    {
        if (Gate::denies('preview-alerts')) {
            abort(403);
        }

        $alert = Alert::find($id);

        return view('admin.backend.alerts.headpreview', ['alert' => $alert]);
    }
}
