<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;
use Issue\Domain;
use Issue\DomainTranslation;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $domain = Domain::all();

        return view('admin.backend.domains.list', ['domain' => $domain]);
    }

    public function getTree()
    {
        $domain = Domain::all();

        return $domain;
    }

    private function fillDomain($domain, $request) {
        $input = $request->all();

        foreach (['ro', 'en'] as $locale)
        {
            $domain->translateOrNew($locale)->name = $input['name'][$locale];
        }

        return $domain;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $domain = new Domain();

        return view('admin.backend.domains.list', ['domain' => $domain]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $domain = new Domain();
        $this->fillDomain($domain, $request);
        $domain->save();

        return response()->json(['status' => 'OK', 'message' => 'Formul a fost completat']);
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($domain)
    {
        $domain->delete();

        return redirect()->action('DomainController@index');
    }
}
