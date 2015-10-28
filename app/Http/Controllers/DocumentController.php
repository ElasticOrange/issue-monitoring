<?php

namespace Issue\Http\Controllers;
use Issue\Document;
use Issue\UploadedFile;
use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Requests\DocumentRequest;
use Issue\Http\Controllers\Controller;
use Storage;
use Carbon\Carbon;

const DOCUMENTS_LOCATION = '/documents/';
class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Document::all();

        return view('admin.backend.documents.list', ['documents' => $documents]);
    }

    public function downloadDocument($file_name)
    {

        $entry = Document::where('file_name', $file_name)->firstOrFail();

        return response()->download(storage_path().DOCUMENTS_LOCATION . $file_name, $entry->original_file_name);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $document = new Document(['init_at' => date('Y-m-d')]);
        return view('admin.backend.documents.create', ['document' => $document]);
    }

    /**
     * Store a newly created resource in `.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentRequest $request)
    {
        $document = new Document;
        $this->fillDocument($document, $request);
        $document->save();

        return $document;
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
    public function edit($document)
    {
        return view('admin.backend.documents.edit', ['document' => $document]);
    }

    private function fillDocument($document, $request) {
        $input = $request->all();
        Storage::makeDirectory(DOCUMENTS_LOCATION);

        $document->init_at = $input['date'];
        $document->link = $input['link'];
        $document->public = true;

        $file = new UploadedFile;
        $file->storeFile(DOCUMENTS_LOCATION, $request->file('file'));
        $file->document()->save($document);

        foreach (['ro', 'en'] as $locale)
        {
            $document->translateOrNew($locale)->description = $input['description'][$locale];
        }

        return $document;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $document)
    {
        $this->fillDocument($document, $request);
        $document->save();

        return $document;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($document)
    {
        $document->delete();

        return redirect()->action('DocumentController@index');
    }
}
