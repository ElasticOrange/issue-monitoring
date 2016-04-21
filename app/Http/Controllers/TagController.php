<?php

namespace Issue\Http\Controllers;

use Gate;
use Issue\Tag;
use Issue\Http\Requests;
use Illuminate\Http\Request;
use Issue\Http\Requests\TagRequest;
use Issue\Http\Controllers\Controller;

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
