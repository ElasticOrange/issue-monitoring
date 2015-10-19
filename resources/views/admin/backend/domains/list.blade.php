@extends('admin.layouts.master')

@section('content')
<div class="row">
	<div class="col-lg-12 text-center">
		<h1 class="page-header">Domenii</h1>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<input type="search" class="form-control" placeholder="Search here">
					</div>
					<div class="col-lg-1 col-lg-offset-4">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
							+ Adauga
						</button>
						<!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<form action="/backend/domain" method="post" data-form="true">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="myModalLabel">Adauga Domeniu</h4>
										</div>
										<div class="modal-body">
											@include('admin.backend.domains.form')
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Inchide</button>
											<button type="submit" data-adauga="true" class="btn btn-primary">+ Adauga</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-1">
						<form method="POST" action="{{ action('DomainController@destroy') }}" style="display: inline-block;">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input name="_method" type="hidden" value="DELETE">
							<input class="btn btn-danger" data-confirm="true" type="submit" value="Delete" style="width: 81px;">
						</form>
					</div>
				</div>
				<br /><br />
				<div class="row">
					<div class="col-lg-4">
						<div id="jqxTree"></div>
						<input type="button" style="margin: 10px;" id="jqxbutton" value="Get item" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
	$(document).ready(function () {

		$('#jqxbutton').click(function () {
			var item = tree.jqxTree('getSelectedItem');
//			var id = $(item).attr('parentElement');
			console.log("item id: ", item);
		});

		$('[data-adauga=true]').click(function () {
			submitGenericAjaxForm($('[data-form=true]'));
		});

		function submitGenericAjaxForm(form) {
			var $form = $(form);
			var item = tree.jqxTree('getSelectedItem');
			var id = $(item).attr('id');
			var formdata = $form.serialize();
			formdata.push({name: 'parent_id', value: id});
			var action = $form.attr('action') || window.document.location;
			var method = $form.attr('method') || 'POST';

			showLoader();
			var request = $.ajax({
				url: action,
				method: method,
				data: formdata,
				dataType: 'json'
			});

			request.done(function(data) {
				console.log('Ajax success: ', data);
			});

			request.fail(function(error) {
				console.error('Ajax error: ', error.responseJSON);
			});

			request.always(function() {
				hideLoader();
			});

			return request;
		}


		var tree = $('#jqxTree');
		var source = null;
		$.ajax({
			async: false,
			url: "/getTree",
			success: function (data) {
				var data = data;
				source = builddata(data);
			}
		});

		function builddata(data) {
			var object = [];
			var items = [];

			for (i = 0; i < data.length; i++) {
				var item = data[i];
				var label = item["name"];
				var parentid = item["parent_id"];
				var id = item["id"];

				if (items[parentid]) {
					item = {parentid: parentid, label: label, item: item};
					if (!items[parentid].items) {
						items[parentid].items = [];
					}
					items[parentid].items[items[parentid].items.length] = item;
					items[id] = item;
				}
				else {
					items[id] = {parentid: parentid, label: label, item: item};
					object[id] = items[id];
				}
			}
			console.log(object);
			return object;
		}

		var height = tree.jqxTree('height');
		tree.jqxTree({source: source, height: 300, width: 300});

		function singleClick(event) {
			var _item = event.target;
			if (_item.tagName != "LI") {
				_item = $(_item).parents("li:first");
			}
			var item = tree.jqxTree('getItem', _item[0]);
			if (item.isExpanded == true) {
				$('#jqxTree').jqxTree('collapseItem', _item[0]);
			} else {
				$('#jqxTree').jqxTree('expandItem', _item[0]);
			}
		}
		function doubleClick(event) {
			var text = event.target.textContent;
			var text2 = text.replace(/\s+/g, ' ');
			alert(text2+' e pregatit pentru edit :)');
		}
		$("#jqxTree .jqx-tree-item").click(function (event) {
			var that = this;
			setTimeout(function () {
				var dblclick = parseInt($(that).data('double'), 10);
				if (dblclick > 0) {
					$(that).data('double', dblclick - 1);
				} else {
					singleClick.call(that, event);
				}
			}, 300);
		}).dblclick(function (event) {
			$(this).data('double', 2);
			doubleClick.call(this, event);
		});
	});

</script>
@endsection