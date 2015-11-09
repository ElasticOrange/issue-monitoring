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
		$document->delete();

		return redirect()->action('DocumentController@index');
	}
}
