<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class FlowTemplate extends Model
{
    protected $fillable = [
        'name'
    ];

    public function locationStep()
    {
        return $this->hasMany('Issue\LocationStep');
    }
}
