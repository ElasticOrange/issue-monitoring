@extends('admin.layouts.master')

@section('content')
<!-- BEGIN PAGE CONTENT-->
<div class="col-sm-12 text-center">
	<h1>Editeaza Document</h1>
	<br /><br /><br />
	<div class="row">
		<div class="col-md-12">
	        <form action="/backend/document/{{ $document->id }}" class="form-horizontal" method="PUT" enctype="multipart/form-data">
	        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	        	<div class="form-group">
	            	<label class="col-md-3 control-label">Propunere legislativa</label>
	            	<div class="col-md-7">
	                    <select id="propid" name="proposalid" value="{{ $document->proposalid }}" class="form-control">
							<option value="">Selecteaza</option>
							<option value="121">Propunere legislativă pentru modificarea şi completarea Ordonanţei de urgenţă a Guvernului nr.96/2002 privind acordarea de produse lactate şi de panificaţie pentru elevii din învăţământul primar şi gimnazial de stat şi privat, precum şi pentru copiii preşcolari din grădiniţele de stat şi private cu program normal de 4 ore</option>
							<option value="122">Propunere legislativă privind modificarea şi completarea articolului 1. din Ordonanţa de Urgenţă a Guvernului nr. 96 din 2002, privind acordarea de produse lactate şi de panificaţie pentru elevii din clasele I-IV din învăţământul de stat, modificat şi completat</option>
							<option value="127">Proiect de lege Cod de procedură fiscală</option>
							<option value="130">Propunere legislativă pentru modificarea şi completarea Ordonanţei de urgenţă a Guvernului nr.96/2002 privind acordarea de produse lactate şi de panificaţie pentru elevii din învăţământul primar şi gimnazial de stat şi privat, precum şi pentru copiii preşcolari din grădiniţele de stat şi private cu program normal de 4 ore</option>
						</select>
					</div>
	        	</div>
	            <div class="form-group">
	                <label class="col-md-3 control-label">Stadiu procedural</label>
	                <div class="col-md-7">
	                    <select id="stepid" name="stageid" class="form-control">
	                        <option value="">Selecteaza o propunere de mai sus</option>
	                        <option value="204">Inregistrare la prima camera sesizata pentru dezbatere</option>
							<option value="205">Prezentat in Biroul Permanent al primei camere sesizate</option>
							<option value="206">Dezbatere in comisiile de specialitate ale primei camere sesizate</option>
							<option value="207">Dezbatere  in plenul primei camere sesizate</option>
							<option value="208">Transmis spre dezbatere catre camera decizionala</option>
							<option value="209">Solicitare aviz Consiliul Legislativ</option>
	                    </select>
	                </div>
	            </div>
	            <div class="form-group">
	            	<label class="col-md-3 control-label">Descriere succinta</label>
	            	<div class="col-md-7">
                		<textarea id="content" name="description[ro]" class="form-control" rows="3">{{ $descRo->description }}</textarea>
	            	</div>
	        	</div>
	            <div class="form-group">
	                <label class="col-md-3 control-label">Short description</label>
	                <div class="col-md-7">
	                    <textarea id="encontent" name="description[en]" class="form-control" rows="3">{{ $document->description }}</textarea>
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="col-md-3 control-label">Incarca document</label>
	                <div class="col-md-7">
	                	@if (count($document->filespath) < 1)
	                    	<input type="file" id="filespath" title="{{ $document->filespath }}" name="filespath" />
	                    @else
	                    	{{ $document->filespath }}
	                    @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="col-md-3 control-label">Data</label>
	                <div class="col-md-7">
	                    <input type="text" id="initat" name="initat" value="{{ $document->initat }}" class="form-control" />
	                </div>
	            </div>
	            <div class="form-group">
	                <label class="col-md-3 control-label">Link</label>
	                <div class="col-md-7">
	                    <input type="text" id="link" name="link" class="form-control" value="{{ $document->link }}" size="105" />
	                </div>
	            </div>
	            <div class="form-actions">
	                <div class="row">
	                    <div class="col-md-offset-3 col-md-7">
	                    	<input type="submit" value="Salveaza" class="btn btn-primary btn-lg btn-block" />
	                 	</div>
	                </div>
	            </div>
	        </form>
	    </div>
	</div>
</div>
<!-- END PAGE CONTENT-->
@endsection