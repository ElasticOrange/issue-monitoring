<?php

namespace Issue\Http\Controllers;

use Gate;
use Issue\FlowTemplate;
use Issue\Http\Requests;
use Illuminate\Http\Request;
use Issue\Http\Controllers\Controller;
use Issue\Http\Requests\FlowTemplateRequest;

class FlowTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('list-template')) {
            abort(403);
        }

        $flowTemplates = FlowTemplate::all();

        return view('admin.backend.flow-template.list', ['flowTemplates' => $flowTemplates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('create-template')) {
            abort(403);
        }

        $flowTemplate = new FlowTemplate;

        return view('admin.backend.flow-template.create', ['flowTemplate' => $flowTemplate]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FlowTemplateRequest $request)
    {
        if (Gate::denies('store-template')) {
            abort(403);
        }

        $flowTemplate = new FlowTemplate;
        $flowTemplate->setAll($request);
        $flowTemplate->syncLocations($request->input('location'));

        return $flowTemplate;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($flowTemplate)
    {
        if (Gate::denies('show-template')) {
            abort(403);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($flowTemplate)
    {
        if (Gate::denies('edit-template')) {
            abort(403);
        }

        $locationSteps = $flowTemplate->locationStep()->orderBy('step_order', 'asc')->get();

        return view(
            'admin.backend.flow-template.edit',
            [
                'flowTemplate' => $flowTemplate,
                'locationSteps' => $locationSteps,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $flowTemplate)
    {
        if (Gate::denies('update-template')) {
            abort(403);
        }

        $flowTemplate->setAll($request);
        $flowTemplate->syncLocations($request->input('location'));

        return $flowTemplate;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($flowTemplate)
    {
        if (Gate::denies('delete-template')) {
            abort(403);
        }

        $flowTemplate->delete();

        return redirect()->action('FlowTemplateController@index');
    }

    public function getFullTemplate($flowTemplate)
    {
        $templateLocationStep = $flowTemplate->locationStep()
            ->orderBy('step_order', 'asc')
            ->with(['flowsteps', 'location'])
            ->get();

        return $templateLocationStep;
    }
}
