

    {!! csrf_field() !!}

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