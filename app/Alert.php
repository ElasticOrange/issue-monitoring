<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $table = 'alerts';

    protected $guarded = 'id';

    protected $fillable = ['alertable_type', 'alertable_id', 'sent'];


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

    public function alertable()
    {
        return $this->morphTo();
    }

    public static function getUsersToSendIssueAlertTo($issueAlert, $users) {
        $usersToSendTo = [];
        foreach ($users as $user)
            if (array_intersect($user->domains, $issueAlert->issue->domains)) {
                $usersToSendTo[] = $user;
            }

        return $usersToSendTo;
    }

    public static function sendIssueAlerts()
    {
        $usersToSendTo = [];
        $alertType = '';

        $issueAlerts = self::whereIn('alertable_type', ['Issue\Issue', 'Issue\FlowStep'])->where('sent', 0)->with(['alertable'])->get();
        $newIssueUsers = User::where('alert_new_issue', true)->with('domains')->get();
        $newStatusUsers = User::where('alert_issue_status', true)->with('domains')->get();
        $newFlowStepUsers = User::where('alert_issue_stage', true)->with('domains')->get();

        foreach ($issueAlerts as $alert) {
            if ($alert->alertable_type == 'Issue\Issue') {
                if ($alert->alertable->hasSentAlerts) {
                    $alertType = 'alert_issue_status';
                    $usersToSendTo = getUsersToSendIssueAlertTo($alert, $newStatusUsers);
                }
                else {
                    $alertType = 'alert_new_issue';
                    $usersToSendTo = getUsersToSendIssueAlertTo($alert, $newIssueUsers);
                }
            }

            if ($alert->alertable_type == 'Issue\FlowStep') {
                $alertType = 'alert_issue_stage';
                $usersToSendTo = getUsersToSendIssueAlertTo($alert, $newFlowStepUsers);
            }
        }
        return $usersToSendTo;
        //make email
        //send alert to $usersToSendTo

    }
}
