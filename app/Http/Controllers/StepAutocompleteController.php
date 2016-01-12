<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;
use Issue\StepAutocomplete;
use Issue\Http\Requests\StepAutocompleteRequest;
use Gate;

class StepAutocompleteController extends Controller
{
    public function index()
    {
        if (Gate::denies('list-step-autocomplete')) {
            abort(403);
        }

        $steps = StepAutocomplete::all();

        return view('admin.backend.step-autocomplete.list', ['steps' => $steps]);
    }

    public function store(StepAutocompleteRequest $request)
    {
        if (Gate::denies('store-step-autocomplete')) {
            abort(403);
        }

        $step = new StepAutocomplete;

        $step->name = $request->input('name');
        $step->save();

        return $step;
    }

    public function destroy($stepautocomplete)
    {
        if (Gate::denies('delete-step-autocomplete')) {
            abort(403);
        }

        $stepautocomplete->delete();

        return redirect()->action('StepAutocompleteController@index');
    }
}
