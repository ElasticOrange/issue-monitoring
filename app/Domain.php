<?php

namespace Issue;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
	use \Dimsav\Translatable\Translatable;

	public $translatedAttributes = ['name'];

	protected $guarded = ['id'];
	protected $fillable = ['parent_id', 'name', 'public'];
	protected $with = 'translations';

	public function connectedNews()
	{
		return $this->belongsToMany('Issue\News');
	}

	public function parent()
	{
		return $this->belongsTo('Issue\Domain', 'parent_id');
	}

	public function connectedIssues()
	{
		return $this->belongsToMany('Issue\Issue');
	}

	public function scopeIsPublic($query)
	{
		return $query->where('public', 1);
	}

	public static function getPublicDomains()
	{
		$publicDomains = null;
		$user = \Auth::user();
		if($user) {
			$publicDomains = $user->domains()->orderBy('parent_id')->get();
		}

		if(!$publicDomains or $publicDomains->isEmpty()) {
			$publicDomains = self::isPublic()->orderBy('parent_id')->get();
		}

		$subdomains = self::whereIn('parent_id', $publicDomains->lists('id'))->get();

		$publicDomains = $publicDomains->merge($subdomains);

		return $publicDomains;
	}

	public static function getDomainsForTree($domains) {
			$visibleDomainIds = [];
			$parentDomainIds = [];
			foreach ($domains as $domain) {
					$visibleDomainIds[$domain->getKey()] = true;
					$visibleDomainIds[$domain->parent_id] = true;
					$parentDomainIds[$domain->getKey()] = true;
			}
			$domainIds = array_keys($visibleDomainIds);
			$parentIds = array_keys($parentDomainIds);

			return self::whereIn('id', $domainIds)->orWhereIn('parent_id', $parentIds)->get();
	}

	public static function getTree($domains) {
			$tree = [];

			if (! $domains or $domains->isEmpty()) {
					return [];
			}

			foreach($domains as $domain) {
					if (! array_key_exists($domain->id, $tree)) {
							$tree[$domain->id] = [
									'domain' => null,
									'subdomains' => [],
									'hasParent' => false
									];
							}

					if (! array_key_exists($domain->parent_id, $tree)) {
							$tree[$domain->parent_id] = [
									'domain' => null,
									'subdomains' => [],
									'hasParent' => false
							];
					}

					$tree[$domain->id]['domain'] = $domain;
					$tree[$domain->parent_id]['subdomains'][] = $domain;
					if ($domain->parent_id) {

							$tree[$domain->id]['hasParent'] = true;
					}
			}
			return $tree;
	}

}
