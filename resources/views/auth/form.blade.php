{!! csrf_field() !!}

<ul class="nav nav-tabs">
    <li class="active"><a href="#informatii-generale" data-toggle="tab"><strong>Informatii generale</strong></a></li>
    <li><a href="#tip-abonament" data-toggle="tab"><strong>Tip abonament</strong></a></li>
    <li><a href="#access-alerts" data-toggle="tab"><strong>Acces si alerte</strong></a></li>
</ul>

<div class="tab-content">
    <br/>
    <div class="tab-pane active" id="informatii-generale">
        <br/>

        <div class="form-group">
            <label class="col-md-2 control-label">Name</label>
            <div class="col-sm-8">
                <input  type="text"
                        name="name"
                        class="form-control"
                        value="{{ $user->name }}"
                        />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label">E-mail</label>
            <div class="col-sm-8">
                <input  type="email"
                        name="email"
                        class="form-control"
                        value="{{ $user->email }}"
                        />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label">Acces user</label>
            <div class="col-md-8">
                <select class="form-control" name="type">
                    <option value="client">client</option>
                    <option value="editor" @if($user->type === 'editor') selected="selected" @endif>editor</option>
                    <option value="admin" @if($user->type === 'admin') selected="selected" @endif>admin</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label">Inregistrat la</label>
            <div class="col-md-8">
                <input  type="text"
                        disabled
                        class="form-control"
                        value="{{ $user->created_at }}"
                />
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-2 control-label">Limba</label>
            <div class="col-md-8">
                <select class="form-control" name="language">
                    <option value="ro" @if($user->language === 'ro') selected="selected" @endif>Romana</option>
                    <option value="en" @if($user->language === 'en') selected="selected" @endif>Engleza</option>
                </select>
            </div>
        </div>

        <br/><hr/>
        <div class="checkbox col-md-8 col-md-offset-2">
            <label>
                <input type="hidden" value="0" name="active">
                <input type="checkbox"
                       value="1"
                       name="active"
                       @if($user->active)checked="checked" @endif>Activ
            </label>
        </div>
        <br/><hr/><br/>
    </div>

    <div class="tab-pane" id="tip-abonament">
        <br/>
        <div class="form-group">
            <label class="col-md-2 control-label">Abonament</label>
            <div class="col-md-8">
                <select class="form-control" name="subscription[type]">
                    <option value=" " > </option>
                    <option value="trial" @if(is_object($user->subscription) && $user->subscription->type === 'trial') selected="selected" @endif>trial</option>
                    <option value="limited" @if(is_object($user->subscription) && $user->subscription->type === 'limited') selected="selected" @endif>limitat</option>
                    <option value="unlimited" @if(is_object($user->subscription) && $user->subscription->type === 'unlimited') selected="selected" @endif>nelimitat</option>
                </select>
            </div>
        </div><br/><br/>

        <div class="form-group">
            <label class="col-md-2 control-label">Valabilitate</label>
            <div class="row col-sm-offset-2">
                <div class="col-sm-2">
                    <label>Activ de la</label>
                </div>
                <div class="col-sm-2">
                    <label>Expira la</label>
                </div>
            </div>

            <div class="row col-sm-offset-2">
                <div class="col-sm-2">
                    <input class="form-control"
                           type="text"
                           id="startdate-subscription"
                           placeholder="Activ de la"
                           @if(is_object($user->subscription))
                           value="{{ $user->subscription->start_date->format('d-m-Y') }}"
                           @endif
                    />
                    <input type="hidden" id="startdate-result" name="subscription[start_date]" />
                </div>
                <div class="col-sm-2">
                    <input class="form-control"
                            type="text"
                            id="enddate-subscription"
                            placeholder="Expira la"
                            @if(is_object($user->subscription))
                            value="{{ $user->subscription->end_date->format('d-m-Y') }}"
                            @endif
                    />
                    <input type="hidden" id="enddate-result" name="subscription[end_date]" />
                </div>
            </div>
        </div>

        <br/><hr/><br/>
    </div>

    <div class="tab-pane" id="access-alerts">
        <br/>

        <div class="form-group">
            <div class="col-md-2 text-right">
                <label for="domain-autocomplete" class="control-label">Domenii</label>
            </div>
            <div class="col-md-8">
                <input
                        id="domain-autocomplete"
                        source-url="{{ action('UserController@queryDomain') }}/?name={name}"
                        type="text"
                        placeholder="Nume"
                        class="form-control"
                        prevent-enter="true"
                        />
            </div>
        </div><br/>

        <div class="checkbox col-md-8 col-md-offset-2">
            <label>
                <input type="hidden" value="0" name="can_see_stakeholders" />
                <input type="checkbox"
                        value="1"
                        name="can_see_stakeholders"
                        @if ($user->can_see_stakeholders == true)
                            checked="checked"
                        @endif
                /> Access Stakeholderi
            </label>
        </div>

        <br/><hr/><br/>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Domeniu</th>
                        <th>Initiative</th>
                        <th>Rapoarte</th>
                        <th>Stiri</th>
                        <th>Actiuni</th>
                    </tr>
                </thead>
                <tbody id="connected-domains-container">
                @include('auth.connected-domain')
                @foreach ($user->domains as $domain_connected)
                    <tr domain-id="{{ $domain_connected->id }}">
                        <th scope="row">
                            {{ $domain_connected->name }}
                        </th>
                        <td>
                            <label>
                                <input name="rights[{{ $domain_connected->id }}][can_see_issues]"
                                        type="hidden"
                                        value="0"
                                />
                                <input name="rights[{{ $domain_connected->id }}][can_see_issues]"
                                        type="checkbox"
                                        value="1"
                                        @if($domain_connected->pivot->can_see_issues == true)
                                            checked="checked"
                                        @endif
                                />Acces
                            </label>
                            <label style="margin-left: 20px;">
                                <input name="rights[{{ $domain_connected->id }}][alert_for_issues]"
                                        type="hidden"
                                        value="0"
                                />
                                <input name="rights[{{ $domain_connected->id }}][alert_for_issues]"
                                        type="checkbox"
                                        value="1"
                                        @if($domain_connected->pivot->alert_for_issues == true)
                                            checked="checked"
                                        @endif
                                />Alerte
                            </label>
                        </td>
                        <td>
                            <label>
                                <input name="rights[{{ $domain_connected->id }}][can_see_reports]"
                                        type="hidden"
                                        value="0"
                                />
                                <input name="rights[{{ $domain_connected->id }}][can_see_reports]"
                                        type="checkbox"
                                        value="1"
                                        @if($domain_connected->pivot->can_see_reports == true)
                                            checked="checked"
                                        @endif
                                />Acces
                            </label>
                            <label style="margin-left: 20px;">
                                <input name="rights[{{ $domain_connected->id }}][alert_for_reports]"
                                        type="hidden"
                                        value="0"
                                />
                                <input name="rights[{{ $domain_connected->id }}][alert_for_reports]"
                                        type="checkbox"
                                        value="1"
                                        @if($domain_connected->pivot->alert_for_reports == true)
                                            checked="checked"
                                        @endif
                                />Alerte
                            </label>
                        </td>
                        <td>
                            <label>
                                <input name="rights[{{ $domain_connected->id }}][can_see_news]"
                                        type="hidden"
                                        value="0"
                                />
                                <input name="rights[{{ $domain_connected->id }}][can_see_news]"
                                        type="checkbox"
                                        value="1"
                                        @if($domain_connected->pivot->can_see_news == true)
                                            checked="checked"
                                        @endif
                                />Acces
                            </label>
                            <label style="margin-left: 20px;">
                                <input name="rights[{{ $domain_connected->id }}][alert_for_news]"
                                        type="hidden"
                                        value="0"
                                />
                                <input name="rights[{{ $domain_connected->id }}][alert_for_news]"
                                        type="checkbox"
                                        value="1"
                                        @if($domain_connected->pivot->alert_for_news == true)
                                            checked="checked"
                                        @endif
                                />Alerte
                            </label>
                        </td>
                        <td>
                            <a class="btn btn-danger" connected-domain-delete="{{ $domain_connected->id }}">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        </td>
                        <input type="hidden" name="domains_connected[]" value="{{ $domain_connected->id }}" />
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
