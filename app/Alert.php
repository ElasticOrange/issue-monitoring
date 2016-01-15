<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $table = 'alerts';

    protected $guarded = 'id';

    protected $fillable = ['type', 'item_id', 'sent'];

    public static function createIssueAlert($issue)
    {
        $alert = new Alert;
        $alert->type = 'issue';
        $alert->item_id = $issue->getKey();

        $alert->save();

        return $alert;
    }

    public static function createStatusAlert($issueId)
    {
        return true;
    }

    public static function createFlowStepAlert($flowStepId)
    {
        return true;
    }

    public static function createNewsAlert($newsId)
    {
        return true;
    }
}
