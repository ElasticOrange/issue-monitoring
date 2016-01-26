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

    public static function createAlert($item, $itemType)
    {
        $alert = new Alert;
        $alert->alertable_type = $itemType;
        $alert->alertable_id = $item->getKey();

        $alert->save();

        return $alert;
    }

    /**
     * @param $news
     * @return mixed
     */
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
        $newIssueUsers = User::where('active', true)->where('alert_new_issue', true)->with('domains')->get();
        $newStatusUsers = User::where('active', true)->where('alert_issue_status', true)->with('domains')->get();
        $newFlowStepUsers = User::where('active', true)->where('alert_issue_stage', true)->with('domains')->get();
       
        foreach ($issueAlerts as $alert) {
            if ($alert->alertable_type == 'Issue\Issue') {
                if ($alert->alertable->hasSentAlerts() == null) {
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

        return $usersToSendTo;
    }

    public static function getUsersToSendIssueAlertTo($alert, $users) {
        $usersToSendTo = [];

        foreach ($users as $user) {
            if ($alert->alertable->flowstepsInLocation == null
                && !$user->domains->intersect($alert->alertable->connectedDomains)->isEmpty()) {
                $usersToSendTo[] = $user;
            }

            if ($alert->alertable->flowstepsInLocation != null
                && !$user->domains->intersect($alert->alertable->flowstepsInLocation->issue->connectedDomains)->isEmpty()) {
                $usersToSendTo[] = $user;
            }
        }
        return $usersToSendTo;
    }
    
    public static function sendMail($user, $alert, $alertType)
    {
        $alert_type = '';
        if ($alertType == 'alert_new_issue') {
            $alert_type = 'initiativa noua';
        } elseif ($alertType == 'alert_issue_status') {
            $alert_type = 'update de status';
        } elseif ($alertType == 'alert_issue_stage') {
            $alert_type = 'stadiu nou';
        }

        Mail::send('emails.'.$alertType,
            [
                'user' => $user,
                'alert' => $alert,
                'alert_type' => $alert_type
            ],
            function ($m) use ($user, $alertType) {
                $m->to($user->email)->subject($alertType);
            }
        );

        $alert->sent = 1;
        $alert->save();

        return $user;
    }

    public static function getNewsForUser($user, $newsAlerts) {
        $issues = [];
        foreach ($newsAlerts as $newsAlert) {
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
                $m->to($user->email)->subject($alertType);
            }
        );

        for ($i = 0; $i < count($alertsToSendByIssue); $i++) { 
            $alert = self::where('alertable_type', 'Issue\News')
                         ->where('alertable_id', $alertsToSendByIssue[$i]->id)
                         ->update(['sent' => 1]);
        }

        return $user;
    }

    public static function sendAllNewsAlerts()
    {
        $alertsToSendByIssue = [];
        $alertType = 'alert_news';
        
        $newsAlerts = self::where('alertable_type', 'Issue\News')->where('sent', 0)->with(['alertable'])->get();
        $users = User::where('active', true)->where('alert_news', true)->with('domains')->get();

        foreach ($users as $user) {
            $alertsToSendByIssue = self::getNewsForUser($user, $newsAlerts);
            foreach ($alertsToSendByIssue as $alertToSendByIssue) {
                self::sendNewsMail($user, $alertToSendByIssue, $alertType);
            }
        }

        return $alertsToSendByIssue;
    }
    
}
