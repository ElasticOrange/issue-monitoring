<?php

namespace Issue\Http\Controllers;

use Gate;
use Storage;
use Issue\News;
use Issue\Alert;
use Issue\Issue;
use Issue\Domain;
use Issue\Document;
use Issue\Location;
use Issue\LegalNews;
use Issue\Stakeholder;
use Issue\FlowTemplate;
use Issue\LocationStep;
use Issue\Http\Requests;
use Issue\NewsTranslation;
use Issue\IssueTranslation;
use Issue\StepAutocomplete;
use Illuminate\Http\Request;
use Issue\DomainTranslation;
use Issue\DocumentTranslation;
use Issue\LocationTranslation;
use Issue\Http\Requests\IssueRequest;
use Issue\Http\Controllers\Controller;

class IssueController extends Controller
{
	use CanReturnDataForDataTables;

	private $defaultModel = 'Issue\Issue';

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
        if (Gate::denies('list-issue')) {
            abort(403);
        }

		return view('admin.backend.issues.list');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
        if (Gate::denies('create-issue')) {
            abort(403);
        }

        $flowTemplates = FlowTemplate::all();
		$issue = new Issue;

		return view('admin.backend.issues.create', ['issue' => $issue, 'flowTemplates' => $flowTemplates]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(IssueRequest $request)
	{
        if (Gate::denies('store-issue')) {
            abort(403);
        }

        $issue = new Issue;
		$issue->setAll($request);
		$issue->syncLocations($request->input('location'));

        if ($request->published) {
            Alert::createAlert($issue, 'Issue\Issue');
        }

        if ($request->addToLegalNews) {
            $this->addToLegalNews($issue);
        }

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
        if (Gate::denies('show-issue')) {
            abort(403);
        }

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
        if (Gate::denies('edit-issue')) {
            abort(403);
        }

        $flowTemplates = FlowTemplate::all();
		$locationSteps = $issue->locationsteps()->orderBy('step_order', 'asc')->get();

		return view(
			'admin.backend.issues.edit',
			[
				'issue' => $issue,
				'locationSteps' => $locationSteps,
                'flowTemplates' => $flowTemplates
			 ]
		);
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
        if (Gate::denies('update-issue')) {
            abort(403);
        }

        $locationsData = $request->input('location');
		$issue->setAll($request);
		$issue->syncLocations($locationsData);

        if ($request->published) {
            Alert::updateAlert($issue, 'Issue\Issue');
        } else {
            Alert::deleteUnsentAlert($issue, 'Issue\Issue');
        }

        if ($request->addToLegalNews) {
            $this->addToLegalNews($issue);
        }

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
        if (Gate::denies('delete-issue')) {
            abort(403);
        }

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

	public function setPublished($issue, Request $request)
	{
		$issue->published = $request->input('published') == 'true';
		$issue->save();

		return ['result' => true];
	}

	public function queryLocation(Request $request)
	{
		$queryLocationName = $request->input('name');

		$locationIds = LocationTranslation::where('name', 'like', '%'.$queryLocationName.'%')
										->where('locale', \App::getLocale())
										->lists('location_id');
		$locations = Location::whereIn('id', $locationIds)
							->where('parent_id', '>', 0)
							->with(['translations', 'parent'])
							->get();

		$result = [];

		foreach ($locations as $location) {
			$result[] = [
				'id' => $location->id,
				'name' => (($location->parent->id > 1) ? $location->parent->name." - " : "").$location->name,
			];
		}

		return $result;
	}

	public function queryDocument(Request $request)
	{
		$queryDocumentName = $request->input('name');

		$documentIds = DocumentTranslation::where('title', 'like', '%'.$queryDocumentName.'%')
										->where('locale', \App::getLocale())
										->lists('document_id');
		$documents = Document::whereIn('id', $documentIds)
							->get();

		$result = [];
		foreach ($documents as $document) {
			$result[] = [
				'id' => $document->id,
				'title' => $document->title,
				'file' => $document->file->original_file_name,
				'data' => $document->init_at->format('d-m-Y'),
				'file_name' => $document->file->file_name
			];
		}

		return $result;
	}

    public function queryStepAutocomplete(Request $request)
    {
        $queryStepAutocompleteName = $request->input('name');

        $step = StepAutocomplete::where('name', 'like', '%'. $queryStepAutocompleteName .'%')->get();

        return $step;
    }

    protected function addToLegalNews($issue)
    {
        $legalNews = new LegalNews;

        foreach (\Config::get('app.all_locales') as $locale) {
            $legalNews->translateOrNew($locale)->title = $issue->getAttribute('name:'.$locale);
            $legalNews->translateOrNew($locale)->content = $issue->getAttribute('status:'.$locale);
        }

        $legalNews->issue_id = $issue->id;
        $legalNews->save();

        return $legalNews;
    }
}
