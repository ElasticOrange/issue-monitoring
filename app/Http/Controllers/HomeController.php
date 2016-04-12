<?php

namespace Issue\Http\Controllers;

use Auth;
use Issue\Issue;
use Issue\Domain;
use Issue\Http\Requests;
use Illuminate\Http\Request;
use Issue\Http\Controllers\Controller;
use Issue\News;
use Issue\Stakeholder;

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
            ->where(function($query) use ($request) {
                if ($request->viitor) {
                    $query = $query->orWhere('phase', 'viitor');
                }

                if ($request->curent) {
                    $query = $query->orWhere('phase', 'curent');
                }

                if ($request->arhivat) {
                    $query = $query->orWhere('phase', 'arhivatRespinsSauAbrogat')
                        ->orWhere('phase', 'arhivatInactiv');
                }

                if (empty($request->all())) {
                    $query = $query->orWhere('phase', 'curent');
                }
            })
            ->paginate(10);

        return view('frontend.pages.issues', [
                'issues' => $issues,
                'domainIdToHighlight' => $request->domain,
                'arhivat' => $request->arhivat,
                'curent' => $request->curent,
                'viitor' => $request->viitor,
                'issue_search' => $request->issue_search,
                'all' => $request->all()
        ]);
    }

    public function getIssueInfo($id)
    {
        $issue = Issue::findOrFail($id);

        return view('frontend.pages.info-issue', compact('issue'));
    }

    public function getNewsInfo($id)
    {
        $news = News::with('translations')->findOrFail($id);

        return view('frontend.pages.info-news', compact('news'));
    }

    public function getStakeholderInfo($id)
    {
        $stakeholder = Stakeholder::findOrFail($id);

        return view('frontend.pages.info-stakeholder', compact('stakeholder'));
    }

    public function getAllStakeholderNews($stakeholderId)
    {
        $stakeholder = Stakeholder::findOrFail($stakeholderId);
        $news = $stakeholder->connectedNews()->orderBy('id', 'desc')->paginate(10);

        return view('frontend.pages.news-list', compact('news'));
    }

    public function getAllStakeholderIssues($stakeholderId)
    {
        $stakeholder = Stakeholder::findOrFail($stakeholderId);
        $issues = $stakeholder->connectedIssues()->orderBy('id', 'desc')->paginate(10);

        return view('frontend.pages.issues-list', compact('issues'));
    }

    public function getStakeholders()
    {
        
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
