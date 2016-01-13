<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    protected $table = 'user_subscriptions';

    protected $guarded = ['id'];

    public $dates = ['start_date', 'end_date'];

    protected $fillable = ['type'];

    
}
