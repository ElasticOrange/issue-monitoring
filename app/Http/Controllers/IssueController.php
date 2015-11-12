<?php

namespace Issue\Http\Controllers;

use Issue\Issue;
use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;
use Issue\Http\Requests\IssueRequest;
use Storage;

class IssueController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$issues=Issue::all();

		return view('admin.backend.issues.list', ['issues' => $issues]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$issue = new Issue;

		return view('admin.backend.issues.create', ['issue' => $issue]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(IssueRequest $request)
	{
		$issue = new Issue;
		$issue->setAll($request);

		return $issue;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($code)
	{
		$issue = Issue::getByPublicCode($code);

		return $this->edit($issue);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($issue)
	{
		return view('admin.backend.issues.edit', ['issue' => $issue]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $issue)
	{
		$issue->setAll($request);

		return $issue;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($issue)
	{
		$issue -> delete();

		return redirect()->action('IssueController@index');
	}
}
