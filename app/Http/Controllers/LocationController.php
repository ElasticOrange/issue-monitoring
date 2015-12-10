<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;
use Issue\Location;
use Issue\LocationTranslation;
use Issue\Http\Requests\LocationRequest;

class LocationController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$locations = Location::all();

		return view('admin.backend.location.list', ['locations' => $locations]);
	}

	public function getTree()
	{
		$locations = Location::all();
		return $locations;
	}

	private function fillLocation($location, $request) {
		$input = $request->all();
		$location->parent_id = $input['parent_id'];

		foreach (['ro', 'en'] as $locale)
		{
			$location->translateOrNew($locale)->name = $input['name'][$locale];
		}

		return $location;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$location = new Location;

		return view('admin.backend.location.create', ['location' => $location]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(LocationRequest $request)
	{
		$location = new Location;
		$this->fillLocation($location, $request);
		$location->save();

		return $location;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($location)
	{
		return view('admin.backend.location.edit', ['location' => $location]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $location)
	{
		$this->validate($request,
			[
				'name' => 'array',
				'name.ro' => 'required|string|unique:location_translations,name,' . $location->id . ',location_id',
				'name.en' => 'string|unique:location_translations,name,' . $location->id . ',location_id',
				'parent_id' => 'required|integer'
			]);

		$this->fillLocation($location, $request);
		$location->save();

		return $location;
	}

	public function changeParent($location, Request $request)
	{
		$location->parent_id = $request->input('parent_id');
		$location->save();

		return $location;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($location)
	{
		$location->delete();

		return $location;
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
}
