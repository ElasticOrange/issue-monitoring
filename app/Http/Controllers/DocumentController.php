<?php

namespace Issue\Http\Controllers;
use Issue\Document;
use Issue\DocumentTranslation;
use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;
use Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $document = Document::all();
        $documentTranslation = DocumentTranslation::all();

        return view('admin.backend.documents', ['document' => $document, 'documentTranslation' => $documentTranslation]);
    }

    public function getDocument($filespath)
    {
        $entry = Document::where('filespath', $filespath)->firstOrFail();
        $doc_name = $entry->filespath;
        $documentsLocation = storage_path() . '/documents/';
        return response()->download($documentsLocation . $doc_name);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.backend.documents-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $document = new Document;
        $document->proposalid = $input['proposalid'];
        $document->stageid = $input['stageid'];
        $document->initat = $input['initat'];
        $document->link = $input['link'];
        $document->online = true;

        $documentsLocation = storage_path() . '/documents/';
        Storage::makeDirectory($documentsLocation);
        $fileMove = $input['filespath'];
        $fileName = $input['filespath']->getClientOriginalName();
        $fileMove->move($documentsLocation, $fileName);
        $document->filespath = $fileName;

        foreach (['ro', 'en'] as $locale)
        {
            $document->translateOrNew($locale)->description = $input['description'][$locale];
        }

        $document->save();
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
    public function destroy($id)
    {
        //
    }
}
