<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;

use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;
use Issue\Domain;
use Auth;

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

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIssues()
    {
        $user = Auth::user();
        $publicDomainsTree = $this->getPublicDomainsTree($user);

        return view('frontend.pages.issues', ['publicDomainsTree' => $publicDomainsTree]);
    }

    private function getPublicDomainsTree($user = null) {
        $tree = [];

        if ($user) {
            $domains = $user->domains()->orderBy('parent_id')->get();
        }
        else {
            $domains = Domain::isPublic()->orderBy('parent_id')->get();
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
