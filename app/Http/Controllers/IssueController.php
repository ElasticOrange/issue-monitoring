<?php

namespace Issue\Http\Controllers;

use Issue\Issue;
use Issue\IssueTranslation;
use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;
use Issue\Http\Requests\IssueRequest;
use Storage;
use Issue\News;
use Issue\NewsTranslation;
use Issue\Domain;
use Issue\DomainTranslation;
use Issue\Stakeholder;

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

	public function queryDomain(Request $request)
	{
		$queryDomainName = $request->input('name');

		$domainIds = DomainTranslation::where('name', 'like', '%'.$queryDomainName.'%')
										->where('locale', \App::getLocale())
										->lists('domain_id');
		$domains = Domain::whereIn('id', $domainIds)
							->where('parent_id', '>', 0)
							->with(['translations', 'parent'])
							->get();

		$result = [];

		foreach ($domains as $domain) {
			$result[] = [
				'id' => $domain->id,
				'name' => (($domain->parent->id > 1) ? $domain->parent->name." - " : "").$domain->name,
			];
		}

		return $result;
	}

	public function queryStakeholder(Request $request)
	{
		$queryStakeholderName = $request->input('name');

		$stakeholders = Stakeholder::where('name', 'like', '%'.$queryStakeholderName.'%')->get();

		return $stakeholders;
	}

	public function queryInitiator(Request $request)
	{
		$queryInitiatorName = $request->input('name');

		$initiators = Stakeholder::where('name', 'like', '%'.$queryInitiatorName.'%')->get();

		return $initiators;
	}

	public function queryNews(Request $request)
	{
		$queryNewsName = $request->input('name');

		$newsIds = NewsTranslation::where('title', 'like', '%'.$queryNewsName.'%')
										->where('locale', \App::getLocale())
										->lists('news_id');
		$news = News::whereIn('id', $newsIds)
							->with(['translations'])
							->get();

		$result = [];

		foreach ($news as $n) {
			$result[] = [
				'id' => $n->id,
				'name' => $n->title,
			];
		}

		return $result;
	}

	public function queryIssue(Request $request)
	{
		$queryIssueName = $request->input('name');

		$issueIds = IssueTranslation::where('name', 'like', '%'.$queryIssueName.'%')
										->where('locale', \App::getLocale())
										->lists('issue_id');
		$issues = Issue::whereIn('id', $issueIds)
							->with(['translations'])
							->get();

		$result = [];

		foreach ($issues as $issue) {
			$result[] = [
				'id' => $issue->id,
				'name' => $issue->name,
			];
		}

		return $result;
	}
}