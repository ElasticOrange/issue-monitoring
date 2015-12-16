(function(){
	$(document).ready(function(){

        $( '#locations-container').sortable({
            handle:".location-handle"
        });
        $( "div.step-sort" ).sortable({
            connectWith: ".connectedSteps",
            handle: ".step-handle",
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

            typeaheadAutocomplete(locationInput);

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
            preventEnterToSubmit('[prevent-enter=true]');
		});

		$('#locations-container .location').each(function() {
			initEventLocation(this.id);
		});

		$(document).on('click', '.delete_location', function() {
			var selectedId = $(this).attr("delete-id");
			if (confirm("Doriti sa stergeti locatia ?")) {
				$('#' + selectedId).remove();
			}
		});

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

        function initEventStep(stepId) {
            var stepsAutocompleteList = new Bloodhound({
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: "/backend/issue/query-step-autocomplete/?name={name}",
                    wildcard: '{name}',
                    transform: function (response) {
                        return _.filter(response, function(item){
                            return $('#autocomplete-' + item.id).length === 0;
                        });
                    }
                }
            });

            var stepInput = $('#autocomplete-' + stepId);

            stepInput.typeahead(
                null,
                {
                    name: 'stepAutocomplete',
                    display: 'name',
                    source: stepsAutocompleteList
                }
            );

            typeaheadAutocomplete(stepInput);

            stepInput.bind(
                'typeahead:select',
                function(event, suggestion) {
                    stepInput.val(suggestion.id);
                });

            $(document).on('keypress', '#autocomplete-' + stepId, function(e) {
                if(e.which == 13) {
                    e.preventDefault();

                    var request = $.ajax({
                        url: '/backend/step-autocomplete',
                        type: 'post',
                        data: {name: stepInput.typeahead('val')}
                    });
                    request.done(function(data) {
                        stepInput.val(data.name);
                    });

                }
            });
        }

        function initDocumentsTypeahead(stepId, locationId) {
            var documentsList = new Bloodhound({
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: $('#document-autocomplete-' + stepId).attr('source-url'),
                    wildcard: '{name}',
                    transform: function (response) {
                        return _.filter(response, function(item){
                            return $('[document-id=' + item.id + ']').length === 0;
                        });
                    }
                }
            });

            $('#document-autocomplete-' + stepId).typeahead(
                null,
                {
                    name: 'document',
                    display: 'title',
                    source: documentsList
                }
            );

            $('#document-autocomplete-' + stepId).bind(
                'typeahead:select',
                function(event, suggestion) {
                    $(this).typeahead('val', '');

                    var documentsTemplate = _.template($('#connected-document-template').html());
                    var populateDocumentsTemplate = documentsTemplate(
                        {
                            'id': stepId,
                            'location_id': locationId,
                            'docId': suggestion.id,
                            'title': suggestion.title,
                            'file': suggestion.file,
                            'date': suggestion.data,
                            'fileName': suggestion.file_name
                        }
                    );
                    $('#autocomplete-document-' + stepId).append(populateDocumentsTemplate);
                }
            );
        }

		$(document).on('click', '.add_flowstep', function() {
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
			initDocumentsTypeahead(stepId, locationId);
            initEventStep(stepId);

            $("div.step-sort").sortable({
                connectWith: ".connectedSteps",
                handle: ".step-handle",
                stop: function(event, ui) {

                    var strParentId = ui.item.parents('.location').attr('id');
                    var parentId = strParentId.match(/(\d+)/g);

                    var object = $(ui.item).find(':input');
                    for (var i = 0; i < object.length; i++) {
                        if($(object[i]).attr('name')) {
                            var itemNameAttr = $(object[i]).attr('name');
                            var regexResult =  /(^location\[)([a-z0-9-]+)(\].+)/.exec(itemNameAttr);
                            var newNameAttr = regexResult[1] + parentId + regexResult[3];

                            $(object[i]).attr('name', newNameAttr);
                        }
                    }
                }
            }).disableSelection();

		});

		$('.location-step').each(function() {
			var stepId = $(this).attr('step-id');
			var edit = 1;
			initFlowStepDate(stepId, edit);
            initEventStep(stepId);
		});

		$('.documente').each(function() {
			var stepId = $(this).attr('doc-step-id');
			var locationId = $(this).attr('doc-location-id');
			initDocumentsTypeahead(stepId, locationId);
		});

		$(document).on('click', '.delete_step', function() {
			var selected_id = $(this).attr("delete-id");
			if (confirm("Doriti sa stergeti pasul ?")) {
				$('#' + selected_id).remove();
			}
		});

        $(document).on('click', '.delete_document', function() {
            var selected_id = $(this).attr("connected-document-delete");
            if (confirm("Doriti sa stergeti documentul ?")) {
                $('#' + selected_id).remove();
            }
        });

        $(document).on('click', '[data-toggle=collapse]', function() {
            $(this).find('span.glyphicon-menu-down').toggleClass('rotate-bot');
        });


	});
})();