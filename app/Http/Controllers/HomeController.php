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

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function getIssues(Request $request)
    {
        $user = Auth::user();

        $domainsForIssues = Domain::getPublicDomains();

        if ($request->domain) {
            $domain = $domainsForIssues->find($request->domain);
            if ($domain) {
                $domainsForIssues = collect([$domain]);
            }
        }

        $issues = Issue::bySearchTerm($request->issue_search)
                         ->byDomainIds($domainsForIssues->lists('id')->toArray())
                        ->orderBy('id', 'desc')
                        ->paginate(8);

        if ($request->viitor) {
            $issues = $issues->where('phase', 'viitor');
        }

        if ($request->curent) {
            $issues = $issues->where('phase', 'curent');
        }

        if ($request->arhivat) {
            $arhivatRespins = $issues->where('phase', 'arhivatRespinsSauAbrogat');
            $arhivatInactiv = $issues->where('phase', 'arhivatInactiv');
            $issues = $arhivatInactiv->merge($arhivatRespins);
        }

        return view('frontend.pages.issues', [
                'issues' => $issues,
                'domainIdToHighlight' => $request->domain
            ]);
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
