<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;
// use Issue\Issue;

trait CanReturnDataForDataTables {

	public function query(Request $request)
	{
		$searched = false;
		$modelInstance = new $this->defaultModel;
		if ( $request->search['value']) {

			$itemIds = \DB::select('
					SELECT distinct id 
					FROM `'.$this->searchTable.'` 
					WHERE '.$this->generateSearchQueryPart($request->search['value'])
				);
			$itemIds = collect($itemIds)->lists('id');
			$itemsCount = count($itemIds);
			$searched = true;
		}

		if (empty($itemsCount)) {
			$itemsCount = $modelInstance->count();
		}

		$items = $modelInstance->take($request->input('length'))
					   ->skip($request->input('start'));

		if ($searched) {
			$items->whereIn('id', $itemIds);
		}

		$items = $items->get();

		$tableData = [];
		$index = $request->input('start');

		$result = [
			'draw' => 0 + $request->input('draw'),
			'recordsTotal' => $itemsCount,
			'recordsFiltered' => $itemsCount,
			'data' => $items->toArray()
		];
		return $result;
	}

	private function generateSearchQueryPart($string)
	{
		$words = explode(',', $string);

		foreach ($words as $key => $word) {
			$words[$key] = 'content LIKE "%'.trim($word).'%"';
		}
		
		return implode(' AND ', $words);
	}
}