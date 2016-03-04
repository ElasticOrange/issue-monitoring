{!! csrf_field() !!}

<ul class="nav nav-tabs">
    <li class="active"><a href="#informatii-generale" data-toggle="tab"><strong>Informatii generale</strong></a></li>
    <li><a href="#tip-abonament" data-toggle="tab"><strong>Tip abonament</strong></a></li>
    <li><a href="#access-alerts" data-toggle="tab"><strong>Restrictioneaza alerte</strong></a></li>
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

        <br/><br/>
    </div>

    <div class="tab-pane" id="tip-abonament">
        <br/>
        <div class="form-group">
            <label class="col-md-2 control-label">Abonament</label>
            <div class="col-md-8">
                <select class="form-control" name="subscription[type]">
                    <option value=" " > </option>
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
                <div class="col-sm-1">
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

        <div class="form-group">
            <div class="col-md-2 text-right">
                <label for="domain-autocomplete" class="control-label">Domenii</label>
            </div>
            <div class="col-md-8">
                <input
                        id="domain-autocomplete"
                        source-url="{{ action('NewsController@queryDomain') }}/?name={name}"
                        type="text"
                        placeholder="Nume"
                        class="form-control"
                        prevent-enter="true"
                        />
            </div>
        </div><br/>

        <div class="form-group">
            @include('auth.connected-domain')
            <div class="panel panel-success col-md-8 col-md-offset-2">
                <div class="panel-heading">Domenii conectate</div>
                <div class="list-group" id="connected-domains-container">
                    @foreach ($user->domains as $domain_connected)
                        <div class="list-group-item" domain-id="{{ $domain_connected->id }}">
                            <a class="badge" connected-domain-delete="{{ $domain_connected->id }}">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> sterge
                            </a>
                            <h4 class="list-group-item-heading">{{ $domain_connected->name }}</h4>
                            <p class="list-group-item-text"></p>
                            <input type="hidden" name="subscription[domains_connected][]" value="{{ $domain_connected->id }}" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="access-alerts">
        <br/>

        <div class="form-group">
            <div class="checkbox col-md-8 col-md-offset-2">
                <label>
                    <input  type="checkbox"
                            value="1"
                            name="admin_alert_new_issue"
                            @if($user->admin_alert_new_issue)
                            checked="checked"
                            @endif
                            />Alerta issue nou
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox col-md-8 col-md-offset-2">
                <label>
                    <input  type="checkbox"
                            value="1"
                            name="admin_alert_issue_status"
                            @if($user->admin_alert_issue_status)
                            checked="checked"
                            @endif
                            />Alerta issue status
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox col-md-8 col-md-offset-2">
                <label>
                    <input  type="checkbox"
                            value="1"
                            name="admin_alert_issue_stage"
                            @if($user->admin_alert_issue_stage)
                            checked="checked"
                            @endif
                            />Alerta issue pas
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox col-md-8 col-md-offset-2">
                <label>
                    <input  type="checkbox"
                            value="1"
                            name="admin_alert_news"
                            @if($user->admin_alert_news)
                            checked="checked"
                            @endif
                            />Alerta news
                </label>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox col-md-8 col-md-offset-2">
                <label>
                    <input  type="checkbox"
                            value="1"
                            name="admin_alert_report"
                            @if($user->admin_alert_report)
                            checked="checked"
                            @endif
                            />Alerta raport
                </label>
            </div>
        </div>
    </div>

</div>