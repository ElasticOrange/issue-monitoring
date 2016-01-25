<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

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

        return true;
    }
    
}
