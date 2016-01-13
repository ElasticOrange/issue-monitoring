<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    protected $table = 'user_subscriptions';

    protected $guarded = ['id'];

    public $dates = ['start_date', 'end_date'];

    protected $fillable = [
        'user_id',
        'type',
        'start_date',
        'end_date'
    ];

    public function user()
    {
        return $this->belongsTo('Issue\User');
    }

    public static function isValidSubscriptionData($subscriptionData)
    {
        if (!is_array($subscriptionData)) {
            return false;
        }

        if (!array_key_exists('type', $subscriptionData)) {
            return false;
        }

        if (!in_array($subscriptionData['type'], ['limited', 'unlimited'])) {
            return false;
        }

        return true;
    }
}
