<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;
use Issue\StepAutocomplete;
use Issue\Http\Requests\StepAutocompleteRequest;

class StepAutocompleteController extends Controller
{
    public function store(StepAutocompleteRequest $request)
    {
        $step = new StepAutocomplete;

        $step->name = $request->input('name');
        $step->save();

        return $step;
    }
}
