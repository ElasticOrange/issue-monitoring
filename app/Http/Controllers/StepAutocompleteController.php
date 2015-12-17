<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;
use Issue\StepAutocomplete;
use Issue\Http\Requests\StepAutocompleteRequest;

class StepAutocompleteController extends Controller
{
    public function index()
    {
        $steps = StepAutocomplete::all();

        return view('admin.backend.step-autocomplete.list', ['steps' => $steps]);
    }

    public function store(StepAutocompleteRequest $request)
    {
        $step = new StepAutocomplete;

        $step->name = $request->input('name');
        $step->save();

        return $step;
    }

    public function destroy($stepautocomplete)
    {
        $stepautocomplete->delete();

        return redirect()->action('StepAutocompleteController@index');
    }
}
