<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Alert extends Model
{
    protected $table = 'alerts';

    protected $guarded = 'id';

    protected $fillable = ['alertable_type', 'alertable_id', 'sent'];

    public function alertable()
    {
        return $this->morphTo();
    }

    public function scopeNotSent($query)
    {
        return $query->where('sent', 0);
    }

    public function scopeReportType($query)
    {
        return $query->where('report_type', '1');
    }

    public static function deleteUnsentAlertsWithoutDestination()
    {
        $date = new \DateTime;
        $date = $date->modify('-1 hour');
        $date = $date->format('Y-m-d H:i:s');

        self::where('sent', 0)
            ->where('created_at', '<=', $date)
            ->delete();

        return true;
    }

    public static function createAlert($item, $itemType)
    {
        $alert = new Alert;
        $alert->alertable_type = $itemType;
        $alert->alertable_id = $item->getKey();

        $alert->save();

        return $alert;
    }

    public static function getUnsentAlert($item, $itemType)
    {
        $currentAlertNotSent = Alert::where('alertable_id', $item->getKey())
            ->where('alertable_type', $itemType)
            ->where('sent', 0)
            ->first();
        return $currentAlertNotSent;
    }

    public static function updateAlert($item, $itemType)
    {
        $currentAlertNotSent = self::getUnsentAlert($item, $itemType);

        if ($currentAlertNotSent) {
            return $currentAlertNotSent;
        }

        $alert = Alert::createAlert($item, $itemType);

        return $alert;
    }

    public static function deleteUnsentAlert($item, $itemType)
    {
        $currentAlertNotSent = self::getUnsentAlert($item, $itemType);

        if ($currentAlertNotSent) {
            $currentAlertNotSent->delete();
        }

        return true;
    }

    public static function sendAllIssueAlerts()
    {
        $usersToSendTo = [];
        $alertType = '';

        $issueAlerts = self::whereIn('alertable_type', ['Issue\Issue', 'Issue\FlowStep'])->where('sent', 0)->with(['alertable'])->get();

        $newIssueUsers = User::where('active', true)
                            ->where('alert_new_issue', true)
                            ->with(['domains' => function($query) {
                                $query->where('alert_for_issues', true);
                            }])
                            ->get();

        $newStatusUsers = User::where('active', true)
                            ->where('alert_issue_status', true)
                            ->with(['domains' => function($query) {
                                $query->where('alert_for_issues', true);
                            }])
                            ->get();

        $newFlowStepUsers = User::where('active', true)
                            ->where('alert_issue_stage', true)
                            ->with(['domains' => function($query) {
                                $query->where('alert_for_issues', true);
                            }])
                            ->get();

        foreach ($issueAlerts as $alert) {
            if ($alert->alertable_type == 'Issue\Issue') {
                if (! $alert->alertable->hasSentAlerts()->isEmpty()) {
                    $alertType = 'alert_issue_status';
                    $usersToSendTo = self::getUsersToSendIssueAlertTo($alert, $newStatusUsers);
                }
                else {
                    $alertType = 'alert_new_issue';
                    $usersToSendTo = self::getUsersToSendIssueAlertTo($alert, $newIssueUsers);
                }
            }

            if ($alert->alertable_type == 'Issue\FlowStep') {
                $alertType = 'alert_issue_stage';
                $usersToSendTo = self::getUsersToSendIssueAlertTo($alert, $newFlowStepUsers);
            }

            foreach ($usersToSendTo as $mailUser) {
                self::sendMail($mailUser, $alert, $alertType);
            }
        }

        return true;
    }

    public static function getUsersToSendIssueAlertTo($alert, $users) {
        $usersToSendTo = [];

        foreach ($users as $user) {
            if ($alert->alertable->flowstepsInLocation == null
                && ! $user->domains->intersect($alert->alertable->connectedDomains)->isEmpty()
                && ! $user->issues()->where('issue_id', $alert->alertable_id)->first()) {

                $usersToSendTo[] = $user;
            }

            if ($alert->alertable->flowstepsInLocation != null
                && ! $user->domains->intersect($alert->alertable->flowstepsInLocation->issue->connectedDomains)->isEmpty()
                && ! $user->issues()->where('issue_id', $alert->alertable->flowstepsInLocation->issue->id)->first()) {

                $usersToSendTo[] = $user;
            }
        }
        return $usersToSendTo;
    }

    public static function sendMail($user, $alert, $alertType)
    {
        $alert_type = '';
        if ($alertType == 'alert_new_issue') {
            $alert_type = 'Initiativa recent adaugata';
        } elseif ($alertType == 'alert_issue_status') {
            $alert_type = 'Modificare initiativa '.$alert->alertable->name;
        } elseif ($alertType == 'alert_issue_stage') {
            $alert_type = 'Modificare initiativa '.$alert->alertable->flowstepsInLocation->issue->name;
        }

        Mail::send('emails.'.$alertType,
            [
                'user' => $user,
                'alert' => $alert,
                'alert_type' => $alert_type
            ],
            function ($m) use ($user, $alert_type) {
                $m->to($user->email)->subject($alert_type);
            }
        );

        $alert->sent = 1;
        $alert->save();

        return true;
    }

    public static function getNewsForUser($user, $newsAlerts) {
        $issues = [];
        foreach ($newsAlerts as $newsAlert) {
            if ($newsAlert->alertable == null) {
                continue;
            }

            foreach ($newsAlert->alertable->connectedIssues as $issue) {
                if (!$issue->connectedDomains->intersect($user->domains)->isEmpty()) {
                    if (! array_key_exists($issue->id, $issues)) {
                        $issues[$issue->id] = [];
                    }
                    $issues[$issue->id][] = $newsAlert->alertable;
                }
            }
        }
        return $issues;
    }

    public static function sendNewsMail($user, $alertsToSendByIssue, $alertType)
    {
        $alert_type = '';
        if ($alertType == 'alert_news') {
            $alert_type = 'stire noua';
        }

        Mail::send('emails.'.$alertType,
            [
                'user' => $user,
                'alertsToSendByIssue' => $alertsToSendByIssue,
                'alert_type' => $alert_type
            ],
            function ($m) use ($user, $alertType) {
                $m->to($user->email)->subject('Stiri recent adaugate');
            }
        );

        for ($i = 0; $i < count($alertsToSendByIssue); $i++) {
            $alert = self::where('alertable_type', 'Issue\News')
                         ->where('alertable_id', $alertsToSendByIssue[$i]->id)
                         ->update(['sent' => 1]);
        }

        return $alert;
    }

    public static function sendAllNewsAlerts()
    {
        $alertsToSendByIssue = [];
        $alertType = 'alert_news';

        $newsAlerts = self::where('alertable_type', 'Issue\News')->where('sent', 0)->with(['alertable'])->get();
        $users = User::where('active', true)
                    ->where('alert_news', true)
                    ->with(['domains' => function($query) {
                                $query->where('alert_for_news', true);
                            }])
                    ->get();

        foreach ($users as $user) {
            $alertsToSendByIssue = self::getNewsForUser($user, $newsAlerts);
            foreach (array_keys($alertsToSendByIssue) as $value) {
                if ($user->issues()->where('issue_id', $value)->first()) {
                    unset($alertsToSendByIssue[$value]);
                }
            }
            foreach ($alertsToSendByIssue as $alertToSendByIssue) {
                self::sendNewsMail($user, $alertToSendByIssue, $alertType);
            }
        }

        return true;
    }

    public static function sendReportMail($user, $alert)
    {
        $alert_template = 'report_alert';
        $alert_type = 'Rapoarte recent adaugate';

        Mail::send('emails.'.$alert_template,
            [
                'user' => $user,
                'alert' => $alert,
                'alert_type' => $alert_type
            ],
            function ($m) use ($user, $alert_type) {
                $m->to($user->email)->subject($alert_type);
            }
        );

        $alert->sent = 1;
        $alert->save();

        return true;
    }

    public static function getUsersToSendReportAlertTo($alert, $users)
    {
        $usersToSendTo = [];

        foreach ($users as $user) {
            if ($alert->alertable->report_type == 1 ||
                $alert->alertable->report_type == 2) {
                $usersToSendTo[] = $user;
            } elseif (!$user->domains->intersect($alert->alertable->domains)->isEmpty()) {
                $usersToSendTo[] = $user;
            }
        }

        foreach ($usersToSendTo as $mailUser) {
            self::sendReportMail($mailUser, $alert);
        }

        return $usersToSendTo;
    }

    public static function sendReportAlerts()
    {
        $alertType = 'report_alert';

        $reportAlerts = self::where('alertable_type', 'Issue\Report')->where('sent', 0)->with(['alertable'])->get();
        $usersToSendReportsTo = User::where('active', true)
                                    ->where('alert_report', true)
                                    ->with(['domains' => function($query) {
                                        $query->where('alert_for_reports', true);
                                    }])
                                    ->get();

        foreach ($reportAlerts as $alert) {
            self::getUsersToSendReportAlertTo($alert, $usersToSendReportsTo);
        }

        return true;
    }
}
