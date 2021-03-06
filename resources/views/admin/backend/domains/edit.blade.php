<form
        action="{{ action('DomainController@update', [$domain]) }}"
        method="post"
        data-ajax="true"
        success-message="Domeniu salvat cu succes"
        error-message="Eroare"
        success-function="onDomainUpdated"
        id="domain-form"
        >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Editeaza Domeniu</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" id="hiddtoken" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" data-parent="true" name="parent_id">
        <div class="form-group">
            <label class="col-md-3 control-label">Nume domeniu</label>
            <div class="col-md-7">
                <input type="text" id="content" name="name[ro]" nume-ro="true" class="form-control" value="{{ $domain->translateOrNew('ro')->name }}" />
            </div>
        </div>
        <br /><br />
        <div class="form-group">
            <label class="col-md-3 control-label">Domain name</label>
            <div class="col-md-7">
                <input type="text" id="encontent" name="name[en]" nume-en="true" class="form-control" value="{{ $domain->translateOrNew('en')->name }}" />
            </div>
        </div>
        <br />
        <br />
        <br />
        <div class="form-group">
            <label class="col-md-7 col-md-offset-3">
                <input type="checkbox"
                       value="1"
                       name="public"
                       @if ($domain->public)
                           checked="checked"
                       @endif
                /><span> </span>Domeniu vizibil in demo</label>
            </div>
            <div class="form-group">
                <label class="col-md-7 col-md-offset-3">
                    <input type="checkbox"
                           value="1"
                           name="visible_in_demo"
                           @if ($domain->visible_in_demo)
                               checked="checked"
                           @endif
                    />
                     Vizibil in Trial/inregistrare
                </label>
            </div>
        </div>
        <br /><br />
    </div>
    <div class="modal-footer">
        <button type="submit" id="updateDomain" class="btn btn-primary">Salveaza</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Inchide</button>
    </div>
</form>
