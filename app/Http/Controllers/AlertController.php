<?php

namespace Issue\Http\Controllers;

use Gate;
use Issue\News;
use Issue\User;
use Issue\Alert;
use Issue\Http\Requests;
use Illuminate\Http\Request;
use Issue\Http\Controllers\Controller;

class AlertController extends Controller
{
    public function index()
    {
        if (Gate::denies('list-alerts')) {
            abort(403);
        }

        $alerts = Alert::limit(100)->get();

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
