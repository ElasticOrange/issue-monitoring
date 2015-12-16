<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Requests\FlowTemplateRequest;
use Issue\Http\Controllers\Controller;
use Issue\FlowTemplate;

class FlowTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($flowTemplate)
    {
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
        $flowTemplate->delete();

        return redirect()->action('FlowTemplateController@index');
    }

    public function getFullTemplate($flowTemplate)
    {
        $templateLocationStep = $flowTemplate->locationStep()
                                            ->with('flowsteps')
                                            ->orderBy('step_order', 'asc')
                                            ->get();

        return $templateLocationStep;
    }
}
