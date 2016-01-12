<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;
use Issue\Http\Requests\TagRequest;
use Issue\Tag;
use Gate;

class TagController extends Controller
{
	public function store(TagRequest $request)
	{
        if (Gate::denies('store-tag')) {
            abort(403);
        }

        $tag = new Tag;

		$tag->name = $request->input('name');
		$tag->save();

		return $tag;
	}
}
