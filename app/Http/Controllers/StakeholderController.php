<?php

namespace Issue\Http\Controllers;

use Gate;
use Storage;
use Issue\Section;
use Issue\Stakeholder;
use Issue\UploadedFile;
use Issue\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Issue\Http\Controllers\Controller;
use Issue\Http\Requests\StakeholderRequest;

class StakeholderController extends Controller
{
    use CanReturnDataForDataTables;

    private $defaultModel = 'Issue\Stakeholder';

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
        if (Gate::denies('list-stakeholder')) {
            abort(403);
        }

		return view('admin.backend.stakeholders.list');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
        if (Gate::denies('create-stakeholder')) {
            abort(403);
        }

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
        if (Gate::denies('store-stakeholder')) {
            abort(403);
        }

        $stakeholder = new Stakeholder;
		$stakeholder->setAll($request);

		$stakeholder->syncSections($request->input('section'));

		return $stakeholder;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($code)
	{
        if (Gate::denies('show-stakeholder')) {
            abort(403);
        }

        $stakeholder = Stakeholder::getByPublicCode($code);

		return $this->edit($stakeholder);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($stakeholder)
	{
        if (Gate::denies('edit-stakeholder')) {
            abort(403);
        }

        return view('admin.backend.stakeholders.edit', ['stakeholder' => $stakeholder, 'sections' => $stakeholder->sections()->get()]);
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
        if (Gate::denies('update-stakeholder')) {
            abort(403);
        }

        $stakeholder->setAll($request);
		$stakeholder->syncSections($request->input('section'));

		return $stakeholder;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($stakeholder)
	{
        if (Gate::denies('delete-stakeholder')) {
            abort(403);
        }

        $stakeholder->delete();

		return redirect()->action('StakeholderController@index');
	}

	public function setPublished($stakeholder, Request $request)
	{
		$stakeholder->published = $request->input('published') == 'true';
		$stakeholder->save();

		return ['result' => true];
	}

	/**
	 * Query the list of stakeholders for autocomplete purposes
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function queryList(Request $request)
	{
		$queryName = $request->get('name');

		$stakeholders = Stakeholder::where('name', 'like', '%'. $queryName .'%')->get();

		return response()->json($stakeholders);
	}


	public function deleteFileCv($stakeholder)
	{
		if ($stakeholder->fileCv) {
			$stakeholder->fileCv->delete();
		}

		return $stakeholder;
	}

	public function deleteFilePoza($stakeholder)
	{
		if ($stakeholder->filePoza) {
			$stakeholder->filePoza->delete();
		}

		return $stakeholder;
	}
}
