<input type="hidden" name="_token" value="{{ csrf_token() }}">
<ul class="nav nav-tabs">
    <li class="active"><a href="#legal_ro" data-toggle="tab">RO</a></li>
    <li><a href="#legal_en" data-toggle="tab">EN</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="legal_ro">
        <div class="form-group">
            <br/>
            <label class="col-md-2 control-label">Titlu</label>
            <div class="col-md-8">
                <textarea type="text"
                       rows="3"
                       prevent-enter="true"
                       name="title[ro]"
                       class="form-control">{{ $legalNews->translateOrNew('ro')->title }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">Continut</label>
            <div class="col-md-8">
                <textarea name="content[ro]" id="editor1" class="form-control" rows="3">{{ $legalNews->translateOrNew('ro')->content }}</textarea>
            </div>
        </div>
    </div>

    <div class="tab-pane" id="legal_en">
        <div class="form-group">
            <br/>
            <label class="col-md-2 control-label">Title</label>
            <div class="col-md-8">
                <textarea type="text"
                       prevent-enter="true"
                       rows="3"
                       name="title[en]"
                       class="form-control">{{ $legalNews->translateOrNew('en')->title }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">Continut</label>
            <div class="col-md-8">
                <textarea name="content[en]" id="editor2" class="form-control" rows="3">{{ $legalNews->translateOrNew('en')->content }}</textarea>
            </div>
        </div>
    </div>
</div>

<hr/>
