<?php

namespace Issue\Http\Controllers;

use Gate;
use Illuminate\Http\Request;
use Issue\Alert;
use Issue\Http\Controllers\Controller;
use Issue\Http\Requests;
use Issue\Http\Requests\ReportRequest;
use Issue\Report;

class ReportController extends Controller
{
    use CanReturnDataForDataTables;

    private $defaultModel = 'Issue\Report';
    private $searchTable = 'reports_search';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('list-reports')) {
            abort(403);
        }

        return view('admin.backend.reports.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('create-reports')) {
            abort(403);
        }

        $report = new Report;

        return view('admin.backend.reports.create', ['report' => $report]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReportRequest $request)
    {
        if (Gate::denies('store-reports')) {
            abort(403);
        }

        $report = new Report;
        $report->setAll($request);

        if ($request->published) {
            Alert::createAlert($report, 'Issue\Report');
        }

        return $report;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        if (Gate::denies('show-reports')) {
            abort(403);
        }

        $report = Report::getByPublicCode($code);

        return $this->edit($report);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($report)
    {
        if (Gate::denies('edit-reports')) {
            abort(403);
        }

        return view('admin.backend.reports.edit', ['report'=> $report]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReportRequest $request, $report)
    {
        if (Gate::denies('update-reports')) {
            abort(403);
        }

        $report->setAll($request);

        if ($request->published) {
            Alert::updateAlert($report, 'Issue\Report');
        } else {
            Alert::deleteUnsentAlert($report, 'Issue\Report');
        }

        return $report;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($report)
    {
        if (Gate::denies('delete-reports')) {
            abort(403);
        }

        $report->delete();

        return redirect()->action('ReportController@index');
    }

    public function deleteFile($report)
    {
        if ($report->file) {
            $report->file->delete();
        }

        return $report;
    }
}
