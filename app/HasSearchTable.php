<?php
namespace Issue;

use Illuminate\Database\Eloquent\Builder;

trait HasSearchTable {
    protected $searchTermItemsCount = 0;

    private function getSearchTable() {
        if (property_exists($this, 'searchTable')) {
            return $this->searchTable;
        }

        return new \Exception('No $searchTable defined in model!');
    }

    private function getSearchTableKeyName() {
        if (property_exists($this, 'getSearchTableKeyName')) {
            return $this->searchTableKeyName;
        }

        return 'id';        
    }

    public function searchTermItemsCount() {
        return $this->searchTermItemsCount;
    }

    private function generateSearchQueryPart($string)
    {
        $words = explode(' ', $string);

        foreach ($words as $key => $word) {
            $words[$key] = 'content LIKE "%'.trim($word).'%"';
        }
        
        return implode(' AND ', $words);
    }    

    public function scopeBySearchTerm(Builder $query, $searchTerm) {
        if (! is_string($searchTerm) or empty($searchTerm)) {
            return $query;
        }

        $itemIds = \DB::select('
                SELECT distinct '.$this->getSearchTableKeyName().' 
                FROM `'.$this->getSearchTable().'` 
                WHERE '.$this->generateSearchQueryPart($searchTerm)
            );
        $itemIds = collect($itemIds)->lists($this->getSearchTableKeyName());
        $this->searchTermItemsCount = count($itemIds);
        return $query->whereIn($this->getKeyName(), $itemIds);
    }
}