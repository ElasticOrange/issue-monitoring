(function(){
	var tree;

	$(document).ready(function () {
		tree = $('#domainTree');
		var source = null;
		$.ajax({
			async: false,
			url: "/getTree",
			success: function (data, status, xhr) {
				source = (data);
			}
		});

		var dataAdapter = new $.jqx.dataAdapter(source);
		dataAdapter.dataBind();
		var records = dataAdapter.getRecordsHierarchy('id', 'parent_id', 'items', [{name: 'name', map: 'label'}]);
		records[0].expanded = true;

		tree.jqxTree({source: records, height: '600px', width: '100%', allowDrag: true, allowDrop: true,
			dragStart: function (item) {
				if (item.id == 1)
					return false;
			}
		});

		tree.on('dragEnd', function () {
			var item = getSelectedDomain();

			var request = $.ajax({
				async: false,
				type: "GET",
				url: "/backend/domain/" + item.id + "/change-parent",
				data: {parent_id: item.parentId}
			});
			request.done(function(data) {
				tree.jqxTree('selectItem',  getTreeItemById(tree, item.id));
				tree.jqxTree('expandItem', item);
			});
		});

		$(document).on('click', '#editDomain', function (event) {
			$('#myModal').modal('show');
			ajaxGetDomainNameForEdit();
		});

		$(document).on('click', '#addDomain', function(ev) {
			ev.preventDefault();
			setDomainFormForCreate();
		});

		$(document).on('click', '#deleteDomain', function(ev) {
			setIdForDeleteAction();
		});

        var domainAutocomplete = $('#domain-autocomplete');
		var domainsList = new Bloodhound({
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: domainAutocomplete.attr('source-url'),
				wildcard: '{name}',
				transform: function (response) {
					return _.filter(response, function(item){
						return $('[domain-id=' + item.id + ']').length === 0;
					});
				}
			}
		});

		domainAutocomplete.typeahead(
			null,
			{
				name: 'domain',
				display: 'name',
				source: domainsList
			}
		);

        typeaheadAutocomplete(domainAutocomplete);

		domainAutocomplete.bind(
			'typeahead:select',
			function(event, suggestion) {
				tree.jqxTree('selectItem', getTreeItemById(tree, suggestion.id));
				var element = tree.jqxTree('getSelectedItem');
				tree.jqxTree('expandItem', element);
		});

	});

	function setIdForDeleteAction() {
		var domain = getSelectedDomain();

		if (!domain) {
			return false;
		}

		if (domain.level === 0) {
			return false;
		}

		$.ajax({
			async: false,
			type: "GET",
			url: "/backend/domain/" + domain.id + "/delete",
			success: function (data) {
				tree.jqxTree('removeItem', domain.element);
			}
		});
	}

	function ajaxGetDomainNameForEdit() {
		var domain = getSelectedDomain();

		if (!domain) {
			alert("Nu se poate modifica");
			$('#myModal').modal('hide');
			return false;
		}

		if (domain.level === 0) {
			alert("Nu se poate modifica");
			$('#myModal').modal('hide');
			return false;
		}

		$.ajax({
			async: false,
			type: "GET",
			url: "/backend/domain/" + domain.id + "/edit",
			success: function (data) {
				$('.modal-content').html(data);
				$('input[name=parent_id]').attr("value", parseInt(domain.parentId));
                preventEnterToSubmit('form');
			}
		});
	}

	function getSelectedDomain() {
		var element = tree.jqxTree('getSelectedItem');
		return element;
	}

	function setDomainFormForCreate() {
		var domain = getSelectedDomain();
		$.ajax({
			async: false,
			type: "GET",
			url: "/backend/domain/create",
			success: function (data) {
				$('.modal-content').html(data);
				$('input[name=parent_id]').attr("value", parseInt(domain.id));
                preventEnterToSubmit('form');
			}
		});
	}

	window.getTreeItemById = function (tree, id) {
		var items = tree.jqxTree('getItems');

		var item = _.find(items, {id: id.toString()});

		return item;
	};

	window.onDomainCreated = function(domain) {
		var currentDomain = getSelectedDomain();
		tree.jqxTree('addTo', {
			label: domain['name'],
			id: parseInt(domain['id'])
		}, currentDomain);
		tree.jqxTree('selectItem',  getTreeItemById(tree, domain.id));
		tree.jqxTree('expandItem', currentDomain);

		$('#myModal').modal('hide');
	};

	window.onDomainUpdated = function(domain) {
		var currentDomain = getSelectedDomain();
		tree.jqxTree('updateItem', currentDomain.element, {label: domain['name'], id: parseInt(domain['id'])});
		tree.jqxTree('selectItem',  getTreeItemById(tree, domain.id));
		tree.jqxTree('expandItem', currentDomain);

		$('#myModal').modal('hide');
	};
})();
