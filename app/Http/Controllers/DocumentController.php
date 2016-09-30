<?php
namespace Issue\Http\Controllers;

use Gate;
use Storage;
use Carbon\Carbon;
use Issue\Document;
use Issue\UploadedFile;
use Issue\Http\Requests;
use Illuminate\Http\Request;
use Issue\Http\Controllers\Controller;
use Issue\Http\Requests\DocumentRequest;

const DOCUMENTS_LOCATION = '/documents/';
class DocumentController extends Controller
{

    use CanReturnDataForDataTables;

    private $defaultModel = 'Issue\Document';
    private $searchTable = 'documents_search';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('list-document')) {
            abort(403);
        }

        return view('admin.backend.documents.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('create-document')) {
        abort(403);
        }

        return view('admin.backend.documents.create');
    }

    /**
     * Store a newly created resource in `.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentRequest $request)
    {
        if (Gate::denies('store-document')) {
            abort(403);
        }

        $document = new Document;
        $document->fillDocument($request);

        return $document;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        if (Gate::denies('show-document')) {
            abort(403);
        }

        $document = Document::getByPublicCode($code);

        return $this->edit($document);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($document)
    {
        if (Gate::denies('edit-document')) {
            abort(403);
        }

        return view('admin.backend.documents.edit', ['document' => $document]);
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
        if (Gate::denies('update-document')) {
            abort(403);
        }

        $document->fillDocument($request);

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
        if (Gate::denies('delete-document')) {
            abort(403);
        }

        $document->delete();

        return redirect()->action('DocumentController@index');
    }
}
