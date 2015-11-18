(function(){
	var tree;
	var LocationForm;

	$(document).ready(function () {
		tree = $('#locationTree');
		var source = null;
		$.ajax({
			async: false,
			url: "/getLocationTree",
			success: function (data, status, xhr) {
				source = (data);
			}
		});

		var dataAdapter = new $.jqx.dataAdapter(source);
		dataAdapter.dataBind();
		var records = dataAdapter.getRecordsHierarchy('id', 'parent_id', 'items', [{name: 'name', map: 'label'}]);
		records[0].expanded = true;

		tree.jqxTree({source: records, height: '300px', width: '100%', allowDrag: true, allowDrop: true
			, dragStart: function (item) {
				if (item.id == 1)
					return false;
			}
		});

		tree.on('dragEnd', function () {
			var item = getSelectedLocation();

			var request = $.ajax({
				async: false,
				type: "GET",
				url: "/backend/location/" + item.id + "/change-parent",
				data: {parent_id: item.parentId}
			});
			request.done(function(data) {
				tree.jqxTree('selectItem',  getTreeItemById(tree, item.id));
				tree.jqxTree('expandItem', item);
			})
		});

		$(document).on('click', '#editLocation', function (event) {
			$('#myModal').modal('show');
			ajaxGetLocationNameForEdit();
		});

		$(document).on('click', '#addLocation', function(ev) {
			ev.preventDefault();
			setLocationFormForCreate();
		});

		$(document).on('click', '#deleteLocation', function(ev) {
			setIdForDeleteAction();
		});

		var locationsList = new Bloodhound({
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: $('#location-autocomplete').attr('source-url'),
				wildcard: '{name}',
				transform: function (response) {
					return _.filter(response, function(item){
						return $('[location-id=' + item.id + ']').length === 0;
					});
				}
			}
		});

		$('#location-autocomplete').typeahead(
			null,
			{
				name: 'location',
				display: 'name',
				source: locationsList
			}
		);

		$('#location-autocomplete').bind(
			'typeahead:select',
			function(event, suggestion) {
				tree.jqxTree('selectItem', getTreeItemById(tree, suggestion.id));
				var element = tree.jqxTree('getSelectedItem');
				tree.jqxTree('expandItem', element);
		});
	});

	function setIdForDeleteAction() {
		var location = getSelectedLocation();

		if (!location) {
			return false;
		}

		if (location.level == 0) {
			return false;
		}

		$.ajax({
			async: false,
			type: "GET",
			url: "/backend/location/" + location.id + "/delete",
			success: function (data) {
				tree.jqxTree('removeItem', location.element);
			}
		});
	}

	function ajaxGetLocationNameForEdit() {
		var location = getSelectedLocation();

		if (!location) {
			alert("Nu se poate modifica");
			$('#myModal').modal('hide');
			return false;
		}

		if (location.level == 0) {
			alert("Nu se poate modifica");
			$('#myModal').modal('hide');
			return false;
		}

		$.ajax({
			async: false,
			type: "GET",
			url: "/backend/location/" + location.id + "/edit",
			success: function (data) {
				$('.modal-content').html(data);
				$('input[name=parent_id]').attr("value", parseInt(location.parentId));
			}
		});
	}

	function getSelectedLocation() {
		var element = tree.jqxTree('getSelectedItem');
		return element;
	}

	function setLocationFormForCreate() {
		var location = getSelectedLocation();
		$.ajax({
			async: false,
			type: "GET",
			url: "/backend/location/create",
			success: function (data) {
				$('.modal-content').html(data);
				$('input[name=parent_id]').attr("value", parseInt(location.id));
			}
		});
	}

	window.getTreeItemById = function (tree, id) {
		var items = tree.jqxTree('getItems');

		var item = _.find(items, {id: id.toString()});

		return item;
	};

	window.onLocationCreated = function(location) {
		var currentLocation = getSelectedLocation();
		tree.jqxTree('addTo', {
			label: location['name'],
			id: parseInt(location['id'])
		}, currentLocation);
		tree.jqxTree('selectItem',  getTreeItemById(tree, location.id));
		tree.jqxTree('expandItem', currentLocation);

		$('#myModal').modal('hide');
	};

	window.onLocationUpdated = function(location) {
		var currentLocation = getSelectedLocation();
		tree.jqxTree('updateItem', currentLocation.element, {label: location['name'], id: parseInt(location['id'])});
		tree.jqxTree('selectItem',  getTreeItemById(tree, location.id));
		tree.jqxTree('expandItem', currentLocation);

		$('#myModal').modal('hide');
	};
})();
