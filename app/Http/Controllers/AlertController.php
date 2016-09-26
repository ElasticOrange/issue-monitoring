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

        $sentAlerts = Alert::whereSent('1')->orderBy('created_at', 'DESC')->paginate(10);
        $unsentAlerts = Alert::whereSent('0')->orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.backend.alerts.list',
            [
                'sentAlerts' => $sentAlerts,
                'unsentAlerts' => $unsentAlerts
            ]);
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
