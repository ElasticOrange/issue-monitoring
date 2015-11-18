<?php

namespace Issue\Http\Controllers;

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

class NewsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
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
		$news = new News;
		$news->setAll($request);

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
		$news->setAll($request);

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
}
