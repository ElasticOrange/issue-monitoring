<?php

namespace Issue\Http\Controllers;

use Issue\Alert;
use Issue\News;
use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Requests\NewsRequest;
use Issue\Http\Controllers\Controller;
use Storage;
use Issue\Tag;
use Issue\Domain;
use Issue\DomainTranslation;
use Issue\Stakeholder;
use Issue\Issue;
use Issue\IssueTranslation;
use Gate;

class NewsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
        if (Gate::denies('list-news')) {
            abort(403);
        }

        $news = News::all();

		return view('admin.backend.news.list', ['news' => $news]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
        if (Gate::denies('create-news')) {
            abort(403);
        }

        $news = new News;

		return view('admin.backend.news.create', ['news' => $news]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(NewsRequest $request)
	{
        if (Gate::denies('store-news')) {
            abort(403);
        }

        $news = new News;
		$news->setAll($request);

        if ($request->published) {
            Alert::createAlert($news, 'news');
        }

		return $news;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($code)
	{
        if (Gate::denies('show-news')) {
            abort(403);
        }

        $news = News::getByPublicCode($code);

		return $this->edit($news);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($news)
	{
        if (Gate::denies('edit-news')) {
            abort(403);
        }

        return view('admin.backend.news.edit', ['news'=> $news]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(NewsRequest $request, $news)
	{
        if (Gate::denies('update-news')) {
            abort(403);
        }

        $news->setAll($request);

        if ($request->published) {
            Alert::updateAlert($news, 'news');
        } else {
            Alert::deleteUnsentAlert($news, 'news');
        }

		return $news;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($news)
	{
        if (Gate::denies('delete-news')) {
            abort(403);
        }

        $news->delete();

		return redirect()->action('NewsController@index');
	}

	public function queryStakeholder(Request $request)
	{
		$queryStakeholderName = $request->input('name');
		$stakeholders = Stakeholder::where('name', 'like', '%'. $queryStakeholderName .'%')->get();

		return $stakeholders;
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

	public function queryTag(Request $request)
	{
		$queryTagName = $request->input('name');

		$tags = Tag::where('name', 'like', '%'. $queryTagName .'%')->get();

		return $tags;
	}

	public function deleteFile($news)
	{
		if ($news->fileDocument) {
			$news->fileDocument->delete();
		}

		return $news;
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
