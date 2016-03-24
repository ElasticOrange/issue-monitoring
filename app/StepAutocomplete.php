<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class StepAutocomplete extends Model
{
    use HasSearchTable;
     
    private $searchTable = 'stepsautocomplete_search';

    protected $guarded = ['id'];

    protected $fillable = [
        'name'
    ];
}
