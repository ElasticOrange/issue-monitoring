<?php

namespace Issue\Http\Controllers;

use Auth;
use Issue\Issue;
use Issue\Domain;
use Issue\Http\Requests;
use Illuminate\Http\Request;
use Issue\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {

        return view('frontend.pages.homepage');
    }

    private function getIssuesFromDomainIds(array $domainIds, $searchTerm = null)
    {
        $issueIds = \DB::table('domain_issue')
                        ->whereIn('domain_id', $domainIds)
                        ->get(['issue_id']);

        $issues = Issue::bySearchTerm($searchTerm)
                        ->whereIn('id', collect($issueIds)->lists('issue_id'))
                        ->orderBy('id', 'desc')
                        ->limit(10)
                        ->get();

        return $issues;
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function getIssues(Request $request)
    {
        $user = Auth::user();

        $publicDomains = $this->getVisibleDomains($user);
        if(!$publicDomains or  $publicDomains->isEmpty()) {
            $publicDomains = $this->getVisibleDomains();
        }

        $domainsForIssues = $publicDomains;

        if ($request->domain) {
            $domain = $publicDomains->find($request->domain);            
            if ($domain) {
                $domainsForIssues = collect([$domain]);
            }
        }

        $domainsForTree = $this->getDomainsForTree($publicDomains);

        $tree = $this->getPublicDomainsTree($domainsForTree);
        $issues = $this->getIssuesFromDomainIds($domainsForIssues->lists('id')->toArray(), $request->issue_search);

        return view('frontend.pages.issues', ['publicDomainsTree' => $tree, 'issues' => $issues]);
    }

    private function getDomainsForTree($domains) {
        $visibleDomainIds = [];
        $parentDomainIds = [];
        foreach ($domains as $domain) {
            $visibleDomainIds[$domain->getKey()] = true;
            $visibleDomainIds[$domain->parent_id] = true;
            $parentDomainIds[$domain->getKey()] = true;
        }
        $domainIds = array_keys($visibleDomainIds);
        $parentIds = array_keys($parentDomainIds);

        return Domain::whereIn('id', $domainIds)->orWhereIn('parent_id', $parentIds)->get();
    }

    private function getVisibleDomains($user = null)  {
        if ($user) {
            $domains = $user->domains()->orderBy('parent_id')->with('translations')->get();
        }
        else {
            $domains = Domain::isPublic()->orderBy('parent_id')->with('translations')->get();
        }



        return $domains;
    }



    private function getPublicDomainsTree($domains) {
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

    public function getContact()
    {
        
    }

    public function getReports()
    {
        
    }

    public function getAboutUs()
    {
        
    }

    public function getServices()
    {
        
    }

    public function getTeam()
    {
        
    }
}
