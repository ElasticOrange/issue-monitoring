<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $table = 'alerts';

    protected $guarded = 'id';

    protected $fillable = ['type', 'item_id', 'sent'];


    public static function createAlert($item, $itemType)
    {
        $alert = new Alert;
        $alert->type = $itemType;
        $alert->item_id = $item->getKey();

        $alert->save();

        return $alert;
    }

    /**
     * @param $news
     * @return mixed
     */
    public static function getUnsentAlert($item, $itemType)
    {
        $currentAlertNotSent = Alert::where('item_id', $item->getKey())
            ->where('type', $itemType)
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
}
