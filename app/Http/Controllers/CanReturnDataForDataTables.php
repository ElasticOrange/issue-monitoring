<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;

trait CanReturnDataForDataTables {

	public function query(Request $request)
	{
		$modelInstance = new $this->defaultModel;

		$queryBuilder = $modelInstance->bySearchTerm($request->search['value']);

		$itemsCount = $modelInstance->searchTermItemsCount();
		if (empty($itemsCount)) {
			$itemsCount = $modelInstance->count();
		}

		$orders = [[
			'column' => $modelInstance->getKeyName(),
			'order' => 'desc'
		]];

		if ($request->order) {
			$orders = [];
			foreach($request->order as $columnOrder) {
				$orders[] = [
					'column' => $request->columns[$columnOrder['column']]['data'],
					'order' => $columnOrder['dir']
				];
			}
		}

		$queryBuilder = $queryBuilder->take($request->input('length'))
					   ->skip($request->input('start'));

		foreach ($orders as $order) {
			$queryBuilder = $queryBuilder->orderBy($order['column'], $order['order']);
		}

		$items = $queryBuilder->get();

		$result = [
			'draw' => 0 + $request->input('draw'),
			'recordsTotal' => $itemsCount,
			'recordsFiltered' => $itemsCount,
			'data' => $items->toArray()
		];
		return $result;
	}
}
