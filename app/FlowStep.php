<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class FlowStep extends Model
{
	protected $guarded = ['id'];

	public $dates = ['start_date', 'end_date'];

	protected $fillable = ['name'];
}
