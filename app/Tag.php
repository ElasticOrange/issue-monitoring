<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $guarded = ['id'];

	protected $fillable = [
		'name'
	];

	public function connectedIssues()
	{
		return $this->belognsToMany('Issue\Issue');
	}
}
