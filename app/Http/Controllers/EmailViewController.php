<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;

use Issue\Location;
use Issue\News;
use Issue\Issue;
use Issue\Report;
use Illuminate\Support\Str;
use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;

class EmailViewController extends Controller
{
    public function getExternalIssueInfo($id, $name)
    {
        $issue = Issue::findOrFail($id);

        if ($name != Str::slug($issue->name)) {
            abort(403);
        }

        $newsList = $issue->connectedNews()->paginate(10);

        $stakeholdersList = $issue->connectedStakeholders->chunk(10);
        $initiatorsList = $issue->connectedInitiatorsStakeholders->chunk(10);

        $dateNow = (new \DateTime)->format('Y-m-d H:i:s');

        return view('frontend.external.issue', [
            'issue' => $issue,
            'locations' => Location::all(),
            'newsList' => $newsList,
            'stakeholdersList' => $stakeholdersList,
            'initiatorsList' => $initiatorsList,
            'dateNow' => $dateNow
        ]);
    }

    public function getExternalNewsInfo($id, $name)
    {
        $news = News::with('translations')->findOrFail($id);

        if ($name != Str::slug($news->title)) {
            abort(403);
        }

        return view('frontend.external.news', compact('news'));
    }

    public function getExternalReportInfo($id, $name)
    {
        $report = Report::with('translations')->findOrFail($id);

        if ($name != Str::slug($report->title)) {
            abort(403);
        }

        return view('frontend.external.report', compact('report'));
    }
}
