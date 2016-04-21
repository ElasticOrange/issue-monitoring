<?php

namespace Issue\Http\Controllers;

use Gate;
use Storage;
use Issue\Tag;
use Issue\News;
use Issue\Alert;
use Issue\Issue;
use Issue\Domain;
use Issue\Stakeholder;
use Issue\Http\Requests;
use Issue\IssueTranslation;
use Illuminate\Http\Request;
use Issue\DomainTranslation;
use Issue\Http\Requests\NewsRequest;
use Issue\Http\Controllers\Controller;

class NewsController extends Controller
{
    use CanReturnDataForDataTables;

    private $defaultModel = 'Issue\News';

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

        return view('admin.backend.news.list');
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
            Alert::createAlert($news, 'Issue\News');
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
            Alert::updateAlert($news, 'Issue\News');
        } else {
            Alert::deleteUnsentAlert($news, 'Issue\News');
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
                'can_see_issues' => $domain->can_see_issues,
                'can_see_news' => $domain->can_see_news,
                'can_see_reports' => $domain->can_see_reports,
                'alert_for_issues' => $domain->alert_for_issues,
                'alert_for_news' => $domain->alert_for_news,
                'alert_for_reports' => $domain->alert_for_reports,
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
