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

    public function fillStakeholder($stakeholder, $request)
    {
        $stakeholder->name = $request->get('name');
        $stakeholder->type = $request->get('type');
        $stakeholder->site = $request->get('site');
        $stakeholder->download_code = $request->get('download_code');
        if(is_null($request->get('published'))){
            $stakeholder->published = 0;
        }
        else{
        $stakeholder->published = $request->get('published');
        }
        foreach (['ro', 'en'] as $locale)
        {
            $stakeholder->translateOrNew($locale)->contact = $request->get('contact')[$locale];
            $stakeholder->translateOrNew($locale)->profile = $request->get('profile')[$locale];
            $stakeholder->translateOrNew($locale)->position = $request->get('position')[$locale];
        }
        return $stakeholder;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stakeholder = new Stakeholder;
        $this->fillStakeholder($stakeholder, $request);
        $stakeholder->save();

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
    public function update(Request $request, $stakeholder)
    {
        $this->fillStakeholder($stakeholder, $request);
        $stakeholder->save();

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
}
