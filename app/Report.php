<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function alerts()
    {
        return $this->morphMany(Alert::class, 'alertable');
    }
}
