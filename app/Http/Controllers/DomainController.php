<?php
namespace Issue\Http\Controllers;

use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;
use Issue\Domain;
use Issue\DomainTranslation;
use Issue\Http\Requests\DomainRequest;
use Gate;

class DomainController extends Controller
{
	use \Dimsav\Translatable\Translatable;
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
        if (Gate::denies('list-domain')) {
            abort(403);
        }

		$domain = Domain::all();

		return view('admin.backend.domains.list', ['domain' => $domain]);
	}

	public function getTree()
	{
        $domain = Domain::all();
		return $domain;
	}

	private function fillDomain($domain, $request)
	{
		$input = $request->all();
		$domain->parent_id = $input['parent_id'];
		$domain->public = $request->public == true;

		foreach (['ro', 'en'] as $locale) {
			$domain->translateOrNew($locale)->name = $input['name'][$locale];
		}

		return $domain;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
        if (Gate::denies('create-domain')) {
            abort(403);
        }

        $domain = new Domain;

		return view('admin.backend.domains.create', ['domain' => $domain]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(DomainRequest $request)
	{
        if (Gate::denies('store-domain')) {
            abort(403);
        }

        $domain = new Domain;
		$this->fillDomain($domain, $request);
		$domain->save();

		return $domain;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
        if (Gate::denies('show-domain')) {
            abort(403);
        }

    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($domain)
	{
        if (Gate::denies('edit-domain')) {
            abort(403);
        }

        return view('admin.backend.domains.edit', ['domain' => $domain]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $domain)
	{
        if (Gate::denies('update-domain')) {
            abort(403);
        }

        $this->validate(
			$request,
			[
				'name' => 'array',
				'name.ro' => 'required|string',
				'name.en' => 'string',
				'parent_id' => 'required|integer'
			]
		);

			$this->fillDomain($domain, $request);
			$domain->save();

		return $domain;
	}

	public function changeParent($domain, Request $request)
	{
		$domain->parent_id = $request->input('parent_id');
		$domain->save();

		return $domain;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($domain)
	{
        if (Gate::denies('delete-domain')) {
            abort(403);
        }

        $domain->delete();

		return $domain;
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
}
