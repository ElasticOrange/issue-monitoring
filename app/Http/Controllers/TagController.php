<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;
use Issue\Http\Requests\TagRequest;
use Issue\Tag;

class TagController extends Controller
{
	public function store(TagRequest $request)
	{
		$tag = new Tag;

		$tag->name = $request->input('name');
		$tag->save();

		return $tag;
	}
}
