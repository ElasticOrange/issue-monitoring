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
}
