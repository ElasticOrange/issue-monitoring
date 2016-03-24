<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;

trait CanReturnDataForDataTables {

	public function query(Request $request)
	{
		$searched = false;
		$modelInstance = new $this->defaultModel;

		$queryBuilder = $modelInstance->bySearchTerm($request->search['value']);

		$itemsCount = $modelInstance->searchTermItemsCount();
		if (empty($itemsCount)) {
			$itemsCount = $modelInstance->count();
		}

		$items = $queryBuilder->take($request->input('length'))
					   ->skip($request->input('start'))
					   ->get();

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
}
