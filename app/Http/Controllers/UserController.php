<?php

namespace Issue\Http\Controllers;

use Illuminate\Http\Request;
use Issue\Http\Requests;
use Issue\Http\Controllers\Controller;
use Issue\User;
use Hash;
use Issue\Http\Requests\UserRequest;
use Gate;
use Auth;
use Mail;
use Guard;
use Issue\Domain;
use Issue\DomainTranslation;

class UserController extends Controller
{
    use CanReturnDataForDataTables;

    private $defaultModel = 'Issue\User';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('list-users')) {
            abort(403);
        }

        return view('auth.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('create-users')) {
            abort(403);
        }

        $user = new User;

        return view('auth.create', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if (Gate::denies('store-users')) {
            abort(403);
        }

        $user = new User;

        $password = str_random(10);
        $user->fill($request->all());
        $user->password = Hash::make($password);

        $user->save();

        $user->syncSubscription($request->input('subscription'));
        $this->endDateGtStartDate($request, $user->subscription);
        $this->sendNewUserEmail($user, $password);

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        if (Gate::denies('show-users')) {
            abort(403);
        }

        return $this->edit($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        if (Gate::denies('edit-users')) {
            abort(403);
        }

        return view('auth.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {
        $input = $request->all();

        if (Gate::denies('update-users')) {
            abort(403);
        }

        $this->validate(
            $request,
            [
                'name' => 'string|min:3',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'password' => 'string|min:5',
                'password_confirmation' => 'same:password',
            ]
        );

        $user->fill($request->all());

        if (isset($input['password']) && $input['password']) {
            $user->password = Hash::make($input['password']);
        }

        $user->setDomains($request);

        $user->save();

        $user->syncSubscription($request->input('subscription'));
        $this->endDateGtStartDate($request, $user->subscription);

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        if (Gate::denies('delete-users')) {
            abort(403);
        }

        $user->delete();

        return redirect()->action('UserController@index');
    }

    public function setActive($user, Request $request)
    {
        $user->active = $request->input('active') == 'true';
        $user->save();

        return ['result' => true];
    }

    /**
     * @param $request
     * @param $data
     */
    public function endDateGtStartDate($request, $data)
    {
        if (is_object($data)) {
            $this->validate(
                $request,
                [
                    'subscription.start_date' => 'date|after:yesterday',
                    'subscription.end_date' => 'date|after:subscription.start_date'
                ]
            );
        }
    }

    private function sendNewUserEmail($user, $password)
    {
        Mail::send(
            'emails.usernew',
            [
                'user' => $user,
                'password' => $password
            ],
            function ($m) use ($user) {
                $m->to($user->email, $user->name)->subject('Your IssueMonitoring account!');
            }
        );
    }


    public function profile()
    {
        $user = Auth::user();

        return view('auth.show', ['user' => $user]);
    }

    public function updateProfile(Request $request)
    {
        $input = $request->all();

        $user = User::where('email', $input['email'])->firstOrFail();

        $this->validate(
            $request,
            [
                'name' => 'string|min:3',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'password' => 'string|min:5',
                'password_confirmation' => 'same:password',
            ]
        );

        $user->fill($request->all());

        $user->alert_new_issue = $request->alert_new_issue == true;
        $user->alert_issue_status = $request->alert_issue_status == true;
        $user->alert_news = $request->alert_news == true;
        $user->alert_report = $request->alert_report == true;
        $user->alert_issue_stage = $request->alert_issue_stage == true;

        if (isset($input['password']) && $input['password']) {
            $user->password = Hash::make($input['password']);
        }

        $user->save();

        return $user;
    }

    public function queryDomain(Request $request)
    {
        $queryDomainName = $request->input('name');

        $domainIds = DomainTranslation::where('name', 'like', '%'.$queryDomainName.'%')
                                        ->where('locale', \App::getLocale())
                                        ->lists('domain_id');
        $domains = Domain::whereIn('id', $domainIds)
                            ->where('parent_id', '>', 0)
                            ->with(['translations', 'parent'])
                            ->get();

        $result = [];

        foreach ($domains as $domain) {
            $result[] = [
                'id' => $domain->id,
                // 'can_see_issues' => $domain->can_see_issues,
                // 'can_see_news' => $domain->can_see_news,
                // 'can_see_reports' => $domain->can_see_reports,
                // 'alert_for_issues' => $domain->alert_for_issues,
                // 'alert_for_news' => $domain->alert_for_news,
                // 'alert_for_reports' => $domain->alert_for_reports,
                'name' => (($domain->parent->id > 1) ? $domain->parent->name." - " : "").$domain->name,
            ];
        }

        return $result;
    }
}
