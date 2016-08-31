<?php

namespace Issue\Http\Controllers;

use Auth;
use Mail;
use Issue\News;
use Issue\Issue;
use Issue\Domain;
use Issue\Report;
use Issue\Location;
use Issue\LegalNews;
use Issue\Stakeholder;
use Issue\Http\Requests;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Issue\Http\Controllers\Controller;
use Issue\Http\Requests\ContactFormRequest;
use Illuminate\Pagination\LengthAwarePaginator;

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

        $reports = Report::orderBy('created_at', 'desc')->where('public', '1')->limit(6)->get();
        $reports = $reports->chunk(2);

        return view('frontend.pages.homepage', compact(['legalNews', 'reports']));
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function getIssues(Request $request)
    {
        $domainsForIssues = Domain::getCurrentDomains();

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
                if ($request->type) {
                    $query = $query->where('type', $request->type);
                }

                if ($request->phase) {
                    $query = $query->where('phase', $request->phase);
                }

                if (empty($request->all())) {
                    $query = $query->orWhere('phase', 'curent');
                }
            })
            ->paginate(10);

        return view('frontend.pages.issues', [
                'issues' => $issues,
                'domain' => $request->domain,
                'issue_search' => $request->issue_search,
                'type' => $request->type,
                'phase' => $request->phase,
                'all' => $request->all()
        ]);
    }

    public function getIssueInfo($id, $name)
    {
        $issue = Issue::findOrFail($id);

        $issueDomains = $issue->connectedDomains;
        if(! $issueDomains || $issueDomains->isEmpty()) {
            abort(403);
        }

        $allowedDomains = Domain::getUserAndPublicDomains();
        $intersection = $allowedDomains->intersect($issueDomains);
        if(! $intersection || $intersection->isEmpty()) {
            abort(403);
        }

        if ($name != Str::slug($issue->name)) {
            abort(403);
        }

        $newsList = $issue->connectedNews()->orderBy('created_at', 'desc')->paginate(10);

        $stakeholdersList = $issue->connectedStakeholders->chunk(10);
        $initiatorsList = $issue->connectedInitiatorsStakeholders->chunk(10);

        $dateNow = (new \DateTime)->format('Y-m-d H:i:s');

        return view('frontend.pages.info-issue', [
            'issue' => $issue,
            'domain' => $issueDomains[0]->id,
            'locations' => Location::all(),
            'newsList' => $newsList,
            'stakeholdersList' => $stakeholdersList,
            'initiatorsList' => $initiatorsList,
            'dateNow' => $dateNow
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

        if (\Auth::user()->can_see_stakeholders == false) {
            return view('frontend.pages.contact');
        }

        return view('frontend.pages.info-stakeholder', compact(['stakeholder']));
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

    public function getAllStakeholdersConnected($stakeholderId, $stakeholderName)
    {
        $stakeholder = Stakeholder::findOrFail($stakeholderId);

        if ($stakeholderName != Str::slug($stakeholder->name)) {
            abort(403);
        }

        $stakeholders = $stakeholder->stakeholdersConnectedOfMine()->orderBy('id', 'desc')->paginate(10);

        return view('frontend.pages.stakeholders-list', compact(['stakeholders', 'stakeholder']));
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

    public function getStakeholders(Request $request)
    {
        $user = \Auth::user();

        if (! $user or ! $user->can_see_stakeholders) {
            abort(403);
        }

        $stakeholders = Stakeholder::paginate(10);

        if ($request->search) {
            $modelInstance = new Stakeholder;

            $stakeholders = $modelInstance->bySearchTerm($request->search)->paginate(10);
        }

        return view('frontend.pages.stakeholders', [
            'stakeholders' => $stakeholders,
            'search' => $request->search ? $request->search : ''
        ]);
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

    public function getReports(Request $request)
    {
        $domainsForReports = Domain::getCurrentDomains();
        if ($request->domain) {
            $domain = $domainsForReports->find($request->domain);
            if ($domain) {
                $domainsForReports = collect([$domain]);
            }
        }

        $reports = Report::bySearchTerm($request->report_search)
            ->byDomainIds($domainsForReports->lists('id')->toArray())
            ->orderBy('id', 'desc')
            ->where(function($query) use ($request) {
                if ($request->report_type) {
                    $query = $query->orWhere('report_type', $request->report_type);
                }
            })
            ->paginate(5);

        return view('frontend.pages.reports', [
            'reports' => $reports,
            'report_type' => $request->report_type,
            'report_search' => $request->report_search,
            'domain' => $request->domain
        ]);
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

    public function howWorks()
    {
        return view('frontend.pages.howWorks');
    }

    private function hyperlinkUrls($text)
    {
        $regexUrl = "/\[([^\]]+)\]\((((http|https):\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)\)/";
        $newText = $text;

        if (preg_match($regexUrl, $text, $url)) {
               $newText = preg_replace($regexUrl, '<a href="' . $url[2] . '" target="_blank">' . $url[1] . '</a>', $text);
        }

        return $newText;
    }
}
