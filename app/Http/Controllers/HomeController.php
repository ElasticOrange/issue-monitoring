<?php

namespace Issue\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Issue\Domain;
use Issue\Http\Controllers\Controller;
use Issue\Http\Requests;
use Issue\Http\Requests\ContactFormRequest;
use Issue\Issue;
use Issue\LegalNews;
use Issue\News;
use Issue\Stakeholder;
use Mail;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $legalNews = LegalNews::orderBy('created_at', 'desc')->limit(15)->get();
        $legalNews = $legalNews->chunk(5);

        return view('frontend.pages.homepage', compact('legalNews'));
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
                'domain' => $request->domain,
                'arhivat' => $request->arhivat,
                'curent' => $request->curent,
                'viitor' => $request->viitor,
                'issue_search' => $request->issue_search,
                'all' => $request->all()
        ]);
    }

    public function getIssueInfo($id, $name)
    {
        $issue = Issue::findOrFail($id);

        $domain = $issue->connectedDomains;

        if(! $domain[0]->id) {
            abort(403);
        }

        $domainsForIssues = Domain::getPublicDomains();

        foreach($domainsForIssues as $publicDomain) {
            $allowedDomains[] = $publicDomain->id;
        }

        if(! in_array($domain[0]->id, $allowedDomains)) {
            abort(403);
        }

        if ($name != Str::slug($issue->name)) {
            abort(403);
        }

        $canSeeStakeholders = \DB::table('domain_user')
                                    ->where('user_id', \Auth::user()->id)
                                    ->where('can_see_stakeholders', 1)
                                    ->get();

        return view('frontend.pages.info-issue', [
            'issue' => $issue,
            'domain' => $domain[0]->id,
            'canSeeStakeholders' => $canSeeStakeholders
        ]);
    }

    public function getNewsInfo($id, $name)
    {
        $news = News::with('translations')->findOrFail($id);

        if ($name != Str::slug($news->title)) {
            abort(403);
        }

        return view('frontend.pages.info-news', compact('news'));
    }

    public function getStakeholderInfo($id, $name)
    {
        $stakeholder = Stakeholder::findOrFail($id);

        if ($name != Str::slug($stakeholder->name)) {
            abort(403);
        }

        $canSeeStakeholders = \DB::table('domain_user')
                                    ->where('user_id', \Auth::user()->id)
                                    ->where('can_see_stakeholders', 1)
                                    ->get();

        return view('frontend.pages.info-stakeholder', compact(['stakeholder', 'canSeeStakeholders']));
    }

    public function getAllStakeholderNews($stakeholderId, $stakeholderName)
    {
        $stakeholder = Stakeholder::findOrFail($stakeholderId);

        if ($stakeholderName != Str::slug($stakeholder->name)) {
            abort(403);
        }

        $news = $stakeholder->connectedNews()->orderBy('id', 'desc')->paginate(10);

        return view('frontend.pages.news-list', compact(['news', 'stakeholder']));
    }

    public function getAllStakeholderIssues($stakeholderId, $stakeholderName)
    {
        $stakeholder = Stakeholder::findOrFail($stakeholderId);

        if ($stakeholderName != Str::slug($stakeholder->name)) {
            abort(403);
        }

        $issues = $stakeholder->connectedIssues()->orderBy('id', 'desc')->paginate(10);

        return view('frontend.pages.issues-list', compact('issues'));
    }

    public function getStakeholders()
    {
        $stakeholders = Stakeholder::paginate(10);

        $canSeeStakeholders = \DB::table('domain_user')
                                    ->where('user_id', \Auth::user()->id)
                                    ->where('can_see_stakeholders', 1)
                                    ->get();

        return view('frontend.pages.stakeholders', compact(['stakeholders', 'canSeeStakeholders']));
    }

    public function getContact()
    {
        return view('frontend.pages.contact');
    }

    private function sendContactEmail($name, $email, $body)
    {
        Mail::send(
            'emails.contact',
            [
                'name' => $name,
                'email' => $email,
                'body' =>$body
            ],
            function ($m) use ($name, $email, $body) {
                $m->to('alexandra.preda@cmpp.ro')
                    ->from($email)
                    ->subject('Mesaj primit din sectiunea de Contact');
            }
        );

        return true;
    }

    public function postContact(ContactFormRequest $request)
    {
        $name = $request->name;
        $email = $request->email;
        $body = nl2br($request->body);
        $this->sendContactEmail($name, $email, $body);

        return redirect()->back();
    }

    public function getReports()
    {

    }

    public function getAboutUs()
    {
        return view('frontend.pages.about-us');
    }

    public function getServices()
    {
        return view('frontend.pages.services');
    }

    public function getTeam()
    {
        return view('frontend.pages.team');
    }
}
