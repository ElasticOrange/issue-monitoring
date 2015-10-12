				<input type="hidden" name="_token" value="{{ csrf_token() }}">
	            <div class="form-group">
	            	<label class="col-md-3 control-label">Descriere succinta</label>
	            	<div class="col-md-7">
						<textarea id="content" name="description[ro]" class="form-control" rows="3">{{ $document->translateOrNew('ro')->description }}</textarea>
	            	</div>
	        	</div>
	            <div class="form-group">
	                <label class="col-md-3 control-label">Short description</label>
	                <div class="col-md-7">
	                    <textarea id="encontent" name="description[en]" class="form-control" rows="3">{{ $document->translateOrNew('en')->description }}</textarea>
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="col-md-3 control-label">Incarca document</label>
	                <div class="col-md-7">
						<input type="file" id="file" name="file" />
                    	{{ $document->original_file_name }}
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="col-md-3 control-label">Data</label>
	                <div class="col-md-7">
	                    <input type="date" name="init_at" value="{{ $document->init_at->format('Y-m-d') }}" class="form-control" />
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="col-md-3 control-label">Link</label>
	                <div class="col-md-7">
	                    <input type="text" id="link" name="link" placeholder="www.server.com/test/document.doc" class="form-control" value="{{ $document->link }}" size="105" />
	                </div>
	            </div>
	            <div class="form-actions">
	                <div class="row">
	                    <div class="col-md-offset-3 col-md-7">
	                    	<input type="submit" value="Salveaza" class="btn btn-primary btn-lg btn-block" />
	                 	</div>
	                </div>
	            </div>
