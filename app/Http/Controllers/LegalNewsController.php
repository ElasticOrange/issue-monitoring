<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;

use Gate;
use Issue\LegalNews;
use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;

class LegalNewsController extends Controller
{
    use CanReturnDataForDataTables;

    private $defaultModel = 'Issue\LegalNews';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('list-legal-news')) {
            abort(403);
        }

        return view('admin.backend.legal-news.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($legalnews)
    {
        if (Gate::denies('edit-legal-news')) {
            abort(403);
        }

        return view('admin.backend.legal-news.edit', ['legalNews'=> $legalnews]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $legalnews)
    {
        if (Gate::denies('update-legal-news')) {
            abort(403);
        }

        foreach (\Config::get('app.all_locales') as $locale) {
            $legalnews->translateOrNew($locale)->title = $request->title[$locale];
            $legalnews->translateOrNew($locale)->content = $request->content[$locale];
        }

        $legalnews->save();

        return $legalnews;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($legalnews)
    {
        if (Gate::denies('delete-legal-news')) {
            abort(403);
        }

        $legalnews->delete();

        return redirect()->action('LegalNewsController@index');
    }
}
