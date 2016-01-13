{!! csrf_field() !!}

<ul class="nav nav-tabs">
    <li class="active"><a href="#informatii-generale" data-toggle="tab"><strong>Informatii generale</strong></a></li>
    <li><a href="#tip-abonament" data-toggle="tab"><strong>Tip abonament</strong></a></li>
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

        {{--<div class="form-group">--}}
            {{--<label class="col-md-2 control-label">Password</label>--}}
            {{--<div class="col-sm-8">--}}
                {{--<input  type="password"--}}
                        {{--name="password"--}}
                        {{--class="form-control"--}}
                        {{--/>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="form-group">--}}
            {{--<label class="col-md-2 control-label">Password confirmation</label>--}}
            {{--<div class="col-sm-8">--}}
                {{--<input  type="password"--}}
                        {{--name="password_confirmation"--}}
                        {{--class="form-control"--}}
                        {{--/>--}}
            {{--</div>--}}
        {{--</div>--}}
        <br/><br/>
    </div>

    <div class="tab-pane" id="tip-abonament">
        <div class="form-group">
            <label class="col-md-2 control-label">Abonament</label>
            <div class="col-md-8">
                <select class="form-control" name="subscription[type]">
                    <option value=" " > </option>
                    <option value="limited" @if(is_object($user->subscription) && $user->subscription->type === 'limited') selected="selected" @endif>limitat</option>
                    <option value="unlimited" @if(is_object($user->subscription) && $user->subscription->type === 'unlimited') selected="selected" @endif>nelimitat</option>
                </select>
            </div>
        </div><br/>

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
    </div>

</div>