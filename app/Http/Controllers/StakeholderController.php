<?php

namespace Issue\Http\Controllers;
use Issue\Stakeholder;
use Issue\StakeholderTranslation;
use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Requests\StakeholderRequest;
use Issue\Http\Controllers\Controller;


class StakeholderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stakeholders = Stakeholder::all();
// dd($stakeholders);
        return view('admin.backend.stakeholders.list', ['stakeholders' => $stakeholders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stakeholder = new Stakeholder;
        return view('admin.backend.stakeholders.create', ['stakeholder' => $stakeholder]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StakeholderRequest $request)
    {
        $stakeholder = new Stakeholder;
        $stakeholder->setAll($request);

        return redirect()->action('StakeholderController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($stakeholder)
    {
        return view('admin.backend.stakeholders.edit', ['stakeholder' => $stakeholder]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StakeholderRequest $request, $stakeholder)
    {
        $stakeholder->setAll($request);

        return redirect()->action('StakeholderController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($stakeholder)
    {
        $stakeholder -> delete();

        return redirect()->action('StakeholderController@index');
    }

    public function setPublished($stakeholder, Request $request)
    {
        $stakeholder->published = $request->input('published') == 'true';
        $stakeholder->save();
        return ['result' => true];
    }
}
