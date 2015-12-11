<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class StepAutocomplete extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'name'
    ];
}
