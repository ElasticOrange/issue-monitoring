<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;
use Issue\Domain;
use Issue\Http\Requests\DomainRequest;

class DomainController extends Controller
{
    use \Dimsav\Translatable\Translatable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $domains = Domain::all();

        return view('admin.backend.domains.list', ['domains' => $domains]);
    }

    public function getTree()
    {
        $domain = Domain::all();
        return $domain;
    }

    private function fillDomain($domain, $request) {
        $input = $request->all();
        $domain->parent_id = $input['parent_id'];

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
        $domain = new Domain;

        return view('admin.backend.domains.create', ['domain' => $domain]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DomainRequest $request)
    {
        $domain = new Domain;
        $this->fillDomain($domain, $request);
        $domain->save();

        return $domain;
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
    public function edit($domain)
    {
        return view('admin.backend.domains.edit', ['domain' => $domain]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $domain)
    {
        $this->validate($request,
            [
                'name' => 'array',
                'name.ro' => 'required|string|unique:domain_translations,name,' . $domain->id . ',domain_id',
                'name.en' => 'required|string|unique:domain_translations,name,' . $domain->id . ',domain_id',
                'parent_id' => 'required|integer'
            ]);

        $this->fillDomain($domain, $request);
        $domain->save();

        return $domain;
    }

    public function changeParent($domain, Request $request)
    {
        $domain->parent_id = $request->input('parent_id');
        $domain->save();

        return $domain;
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

        return $domain;
    }
}
