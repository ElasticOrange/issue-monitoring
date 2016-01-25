<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;
use Issue\Alert;
use Issue\Http\Controllers\Controller;
use Issue\Http\Requests;
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

    public function userii()
    {
        $usersToSendTo = [];
        $alertType = '';

        $issueAlerts = Alert::whereIn('alertable_type', ['Issue\Issue', 'Issue\FlowStep'])->where('sent', 0)->with(['alertable'])->get();
        $newIssueUsers = User::where('active', true)->where('alert_new_issue', true)->with('domains')->get();
        $newStatusUsers = User::where('active', true)->where('alert_issue_status', true)->with('domains')->get();
        $newFlowStepUsers = User::where('active', true)->where('alert_issue_stage', true)->with('domains')->get();
        foreach ($issueAlerts as $alert) {
            if ($alert->alertable_type == 'Issue\Issue') {
                if ($alert->alertable->hasSentAlerts() == null) {
                    $alertType = 'alert_issue_status';
                    $usersToSendTo = Alert::getUsersToSendIssueAlertTo($alert, $newStatusUsers);
                }
                else {
                    $alertType = 'alert_new_issue';
                    $usersToSendTo = Alert::getUsersToSendIssueAlertTo($alert, $newIssueUsers);
                }
            }

            if ($alert->alertable_type == 'Issue\FlowStep') {
                $alertType = 'alert_issue_stage';
                $usersToSendTo = Alert::getUsersToSendIssueAlertTo($alert, $newFlowStepUsers);
            }

            foreach ($usersToSendTo as $mailUser) {
                Alert::sendMail($mailUser, $alert, $alertType);
            }
        }

        return $usersToSendTo;
    }
}
