(function(){
	$(document).ready(function(){

		$("input[data-action=publish-issue]").click(function(){
			var request = $.ajax({
				url: $(this).attr('update-url'),
				data: {
					published:$(this).prop('checked'),
				},
				method:'get'
			});
			request.done(function(data){
			});
		});

		CKEDITOR.replace( 'editor1',{
			toolbar:
			[
				{name: 'basicstyles', items: ['Bold','Italic']},
				{name: 'paragraph', items: ['NumberedList', 'BulletedList','-','Outdent','Indent']},
				{name: 'links', items: ['Link','Unlink']},
				{name: 'about', items: ['About']}
			]
		});

		CKEDITOR.replace( 'editor2',{
			toolbar:
			[
				{name: 'basicstyles', items: ['Bold','Italic']},
				{name: 'paragraph', items: ['NumberedList', 'BulletedList','-','Outdent','Indent']},
				{name: 'links', items: ['Link','Unlink']},
				{name: 'about', items: ['About']}
			]
		});

		CKEDITOR.replace( 'editor3',{
			toolbar:
			[
				{name: 'basicstyles', items: ['Bold','Italic']},
				{name: 'paragraph', items: ['NumberedList', 'BulletedList','-','Outdent','Indent']},
				{name: 'links', items: ['Link','Unlink']},
				{name: 'about', items: ['About']}
			]
		});

		CKEDITOR.replace( 'editor4',{
			toolbar:
			[
				{name: 'basicstyles', items: ['Bold','Italic']},
				{name: 'paragraph', items: ['NumberedList', 'BulletedList','-','Outdent','Indent']},
				{name: 'links', items: ['Link','Unlink']},
				{name: 'about', items: ['About']}
			]
		});

		CKEDITOR.replace( 'editor5',{
			toolbar:
			[
				{name: 'basicstyles', items: ['Bold','Italic']},
				{name: 'paragraph', items: ['NumberedList', 'BulletedList','-','Outdent','Indent']},
				{name: 'links', items: ['Link','Unlink']},
				{name: 'about', items: ['About']}
			]
		});

		CKEDITOR.replace( 'editor6',{
			toolbar:
			[
				{name: 'basicstyles', items: ['Bold','Italic']},
				{name: 'paragraph', items: ['NumberedList', 'BulletedList','-','Outdent','Indent']},
				{name: 'links', items: ['Link','Unlink']},
				{name: 'about', items: ['About']}
			]
		});

		var domainList = new Bloodhound({
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: $('#domain-autocomplete').attr('source-url'),
				wildcard: '{name}',
				transform: function (response) {
					return _.filter(response, function(item){
						return $('[domain-id=' + item.id + ']').length === 0;
					});
				}
			}
		});

		$('#domain-autocomplete').typeahead(
			null,
			{
				name: 'domain',
				display: 'name',
				source: domainList
			}
		);

		$('#domain-autocomplete').bind(
			'typeahead:select',
			function(event, suggestion) {
				$(this).typeahead('val', '');

				var template = _.template($('#connected-domain-template').html());
				var compiled_template = template(suggestion);

				$('#connected-domains-container').append(compiled_template);
			}
		);

		$('#connected-domains-container').on('click', '[connected-domain-delete]', function() {
			var connected_stakeholder_id = $(this).attr('connected-domain-delete');
			$('[domain-id=' + connected_stakeholder_id + ']').remove();
		});

		var stakeholdersList = new Bloodhound({
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: $('#stakeholder-autocomplete').attr('source-url'),
				wildcard: '{name}',
				transform: function (response) {
					return _.filter(response, function(item){
						return $('[stakeholder-id=' + item.id + ']').length === 0;
					});
				}
			}
		});

		$('#stakeholder-autocomplete').typeahead(
			null,
			{
				name: 'stakeholder',
				display: 'name',
				source: stakeholdersList
			}
		);

		$('#stakeholder-autocomplete').bind(
			'typeahead:select',
			function(event, suggestion) {
				$(this).typeahead('val', '');

				var template = _.template($('#connected-stakeholder-template').html());
				var compiled_template = template(suggestion);

				$('#connected-stakeholders-container').append(compiled_template);
			}
		);

		$('#connected-stakeholders-container').on('click', '[connected-stakeholder-delete]', function() {
			var connected_stakeholder_id = $(this).attr('connected-stakeholder-delete');
			$('[stakeholder-id=' + connected_stakeholder_id + ']').remove();
		});

		var newsList = new Bloodhound({
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: $('#news-autocomplete').attr('source-url'),
				wildcard: '{name}',
				transform: function (response) {
					return _.filter(response, function(item){
						return $('[news-id=' + item.id + ']').length === 0;
					});
				}
			}
		});

		$('#news-autocomplete').typeahead(
			null,
			{
				name: 'news',
				display: 'name',
				source: newsList
			}
		);

		$('#news-autocomplete').bind(
			'typeahead:select',
			function(event, suggestion) {
				$(this).typeahead('val', '');

				var template = _.template($('#connected-news-template').html());
				var compiled_template = template(suggestion);

				$('#connected-news-container').append(compiled_template);
			}
		);

		$('#connected-news-container').on('click', '[connected-news-delete]', function() {
			var connected_news_id = $(this).attr('connected-news-delete');
			$('[news-id=' + connected_news_id + ']').remove();
		});

		var issuesList = new Bloodhound({
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: $('#issue-autocomplete').attr('source-url'),
				wildcard: '{name}',
				transform: function (response) {
					return _.filter(response, function(item){
						return $('[issue-id=' + item.id + ']').length === 0;
					});
				}
			}
		});

		$('#issue-autocomplete').typeahead(
			null,
			{
				name: 'issue',
				display: 'name',
				source: issuesList
			}
		);

		$('#issue-autocomplete').bind(
			'typeahead:select',
			function(event, suggestion) {
				$(this).typeahead('val', '');

				var template = _.template($('#connected-issue-template').html());
				var compiled_template = template(suggestion);

				$('#connected-issues-container').append(compiled_template);
			}
		);

		$('#connected-issues-container').on('click', '[connected-issue-delete]', function() {
			var connected_issue_id = $(this).attr('connected-issue-delete');
			$('[issue-id=' + connected_issue_id + ']').remove();
		});

		var initiatorsList = new Bloodhound({
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: $('#initiator-autocomplete').attr('source-url'),
				wildcard: '{name}',
				transform: function (response) {
					return _.filter(response, function(item){
						return $('[initiator-id=' + item.id + ']').length === 0;
					});
				}
			}
		});

		$('#initiator-autocomplete').typeahead(
			null,
			{
				name: 'initiator',
				display: 'name',
				source: initiatorsList
			}
		);

		$('#initiator-autocomplete').bind(
			'typeahead:select',
			function(event, suggestion) {
				$(this).typeahead('val', '');

				var template = _.template($('#connected-initiator-template').html());
				var compiled_template = template(suggestion);

				$('#connected-initiators-container').append(compiled_template);
			}
		);

		$('#connected-initiators-container').on('click', '[connected-initiator-delete]', function() {
			var connected_initiator_id = $(this).attr('connected-initiator-delete');
			$('[initiator-id=' + connected_initiator_id + ']').remove();
		});


		$( '#locations-container').sortable();
		$( "#locations-container .location .step" ).sortable({
			connectWith: ".connectedSortable",
			stop: function(event, ui) {

				var strParentId = ui.item.parents('.location').attr('id');
				var parentId = strParentId.match(/\d+/g);

				var object = $(ui.item).find(':input');
				for (var i = 0; i < object.length; i++) {
					if($(object[i]).attr('name')) {
						$(object[i]).attr('name', ($(object[i]).attr('name').replace(/(\d+)/i, parentId)));
					}
				}
			}
		}).disableSelection();


		var locationsList = new Bloodhound({
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: "/backend/issue/query-location/?name={name}",
				wildcard: '{name}',
				transform: function (response) {
					return _.filter(response, function(item){
						return $('[location-id=' + item.id + ']').length === 0;
					});
				}
			}
		});

		function initEventLocation(location) {
			var locationInput = $('[save-id-to=location-id-' + location + ']');

			locationInput.typeahead(
				null,
				{
					name: 'location',
					display: 'name',
					source: locationsList
				}
			);

			locationInput.bind(
				'typeahead:select',
				function(event, suggestion) {
					$('#location-id-' + location).val(suggestion.id);
			});
		}

		$(document).on('click', '.add_location', function(){
			var locationTemplate = _.template($('#location_template').html());
			var locationId = _.uniqueId('new-');

			var populateLocationTemplate = locationTemplate({
				'id': locationId
			});

			$('#locations-container').append(populateLocationTemplate);

			initEventLocation('location-' + locationId);
		});

		$('#locations-container .location').each(function() {
			initEventLocation(this.id);
		});

		$(document).on('click', '.delete_location', function() {
			var selectedId = $(this).attr("delete-id");
			if (confirm("Sigur doriti sa stergeti locatia?")) {
				$('#' + selectedId).remove();
			}
		});


//FlowSteps
		function initFlowStepDate(flowStepId, edit) {
			var startDateWidgets = $('#startdate-widget-' + flowStepId).datetimepicker({
				locale: 'ro',
				format: 'L',
				defaultDate: moment()
			});

			if(edit == 0) {
				$('#startdate-result-' + flowStepId).val(moment().format("YYYY-MM-DD"));
			}
			else {
				$('#startdate-result-' + flowStepId).val(($('#startdate-widget-' + flowStepId).val()).split(".").reverse().join("-"));
			}

			startDateWidgets.on('dp.change', function () {
				var d = $(this).data("DateTimePicker").date();
				var e = d.format("YYYY-MM-DD");
				$('#startdate-result-' + flowStepId).val(e);
			});

			var endDateWidgets = $('#enddate-widget-' + flowStepId).datetimepicker({
				locale: 'ro',
				format: 'L',
				defaultDate: moment()
			});

			if(edit == 0) {
				$('#enddate-result-' + flowStepId).val(moment().format("YYYY-MM-DD"));
			}
			else {
				$('#enddate-result-' + flowStepId).val(($('#enddate-widget-' + flowStepId).val()).split(".").reverse().join("-"));
			}
			endDateWidgets.on('dp.change', function () {
				var d = $(this).data("DateTimePicker").date();
				var e = d.format("YYYY-MM-DD");
				$('#enddate-result-' + flowStepId).val(e);
			});
		}

		$(document).on('click', '.add_flowstep', function(){
			var stepTemplate = _.template($('#flowstep_template').html());
			var stepId = _.uniqueId('new-');

			var locationId = $(this).attr('location-id');

			var populateStepTemplate = stepTemplate({
				'id': stepId,
				'location_id': locationId
			});

			$('#flow-container-' + locationId).append(populateStepTemplate);

			var edit = 0;
			initFlowStepDate(stepId, edit);
		});

		$('.location-step').each(function() {
			var stepId = $(this).attr('step-id');
			var edit = 1;
			initFlowStepDate(stepId, edit);
		});

		$(document).on('click', '.delete_step', function() {
			var selected_id = $(this).attr("delete-id");
			var result = confirm("Sigur doriti sa stergeti locatia?");
			if (result) {
				$('#' + selected_id).remove();
			}
		});

//Documents
		var documentsList = new Bloodhound({
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: $('#document-autocomplete').attr('source-url'),
				wildcard: '{name}',
				transform: function (response) {
					return _.filter(response, function(item){
						return $('[document-id=' + item.id + ']').length === 0;
					});
				}
			}
		});

		$('#document-autocomplete').typeahead(
			null,
			{
				name: 'document',
				display: 'title',
				source: documentsList
			}
		);

		$('#document-autocomplete').bind(
			'typeahead:select',
			function(event, suggestion) {
				$(this).typeahead('val', '');

				var documentsTemplate = _.template($('#connected-document-template').html());
				var populateDocumentsTemplate = documentsTemplate(
					{
						'id': _.uniqueId('new-'),
						'location_id': _.uniqueId('new-'),
						'docId': suggestion.id,
						'title': suggestion.title,
						'file': suggestion.file,
						'date': suggestion.data,
						'fileName': suggestion.file_name,
					}
				);

				$('#autocomplete-document').append(populateDocumentsTemplate);
			}
		);

		$('#autocomplete-document').on('click', '[connected-document-delete]', function() {
			var connectedDocumentId = $(this).attr('connected-document-delete');
			$('#' + connectedDocumentId).remove();
		});

		$(document).on('click', '[data-toggle=collapse]', function() {
			$(this).find('span.glyphicon-menu-down').toggleClass('rotate-bot');
		});
	});
})();
