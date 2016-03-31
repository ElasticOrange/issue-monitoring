(function(){
	$(document).ready(function(){

		var actionButtonsTemplate = _.template($("#action_buttons").html(),
                {
                    interpolate: /__([\s\S]+?)__/g
                }
            );

        $('#news-table').DataTable({
            "language":{
                "sInfo": "Arata de la _START_ la _END_ din _TOTAL_ intrari",
                "sInfoEmpty": "Arata de la 0 la 0 din 0 intrari",
                "sLengthMenu": "Arata _MENU_ intrari",
                "sSearch": "Cauta",
                "paginate":{
                    "next": "Inainte",
                    "previous": "Inapoi",
                    "first": "Primul",
                    "last": "Ultimul"
                },
                "sEmptyTable": "Nu exista nicio inregistrare"
            },
            "columns": [
                {
                    data: "id",
                    title: "id"
                },
                {
                    data: "title",
                    title: "Titlu",
                    orderable: false
                },
                {
                    data: "date",
                    title: "Data",
					render: function (data, type, rowData, meta) {
                        var date = new Date(data);
                        var dd = date.getDate();
                        var mm = date.getMonth() + 1;
                        var yyyy = date.getFullYear();

                        if(dd < 10) {
                            dd = '0' + dd;
                        }

                        if(mm < 10) {
                            mm = '0' + mm;
                        }
                        
                        date = dd + '-' + mm + '-' + yyyy;
                        return date;
                    }
                },
                {
                    data: "link",
                    title: "Sursa"
                },
                {
                    data: "id",
                    title: "Actiuni",
                    render: function(data, type, rowData, meta) {
                        return actionButtonsTemplate({id: data});
                    },
					orderable: false
                }
            ],
            responsive: true,
            stateSave: true,
            serverSide: true,
            ajax: {
            "url": window.location.href + '/query',
            }
        });

		CKEDITOR.replace( 'editor1',{
			toolbar:
			[
				{name: 'basicstyles', items: ['Bold','Italic']},
				{name: 'paragraph', items: ['NumberedList', 'BulletedList','-','Outdent','Indent']},
				{name: 'links', items: ['Link','Unlink']},
                {name: 'styles', items: ['Styles', 'Format']},
                {name: 'document', items: ['Source']},
                {name: 'about', items: ['About']}
            ]
		});

		CKEDITOR.replace( 'editor2',{
			toolbar:
			[
				{name: 'basicstyles', items: ['Bold','Italic']},
				{name: 'paragraph', items: ['NumberedList', 'BulletedList','-','Outdent','Indent']},
				{name: 'links', items: ['Link','Unlink']},
                {name: 'styles', items: ['Styles', 'Format']},
                {name: 'document', items: ['Source']},
                {name: 'about', items: ['About']}
			]
		});

    var stakeholderAutocomplete = $('#stakeholder-autocomplete');
		var stakeholdersList = new Bloodhound({
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: stakeholderAutocomplete.attr('source-url'),
				wildcard: '{name}',
				transform: function (response) {
					return _.filter(response, function(item){
						return $('[stakeholder-id=' + item.id + ']').length === 0;
					});
				}
			}
		});

		stakeholderAutocomplete.typeahead(
			null,
			{
				name: 'stakeholder',
				display: 'name',
				source: stakeholdersList
			}
		);

        typeaheadAutocomplete(stakeholderAutocomplete);

		stakeholderAutocomplete.bind(
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

    var domainAutocomplete = $('#domain-autocomplete');
		var domainList = new Bloodhound({
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
				source: domainList
			}
		);

        typeaheadAutocomplete(domainAutocomplete);

		domainAutocomplete.bind(
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

    var tagAutocomplete = $('#tag-autocomplete');
		var tagsList = new Bloodhound({
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: tagAutocomplete.attr('source-url'),
				wildcard: '{name}',
				transform: function (response) {
					return _.filter(response, function(item){
						return $('[tag-id=' + item.id + ']').length === 0;
					});
				}
			}
		});

		tagAutocomplete.typeahead(
			null,
			{
				name: 'tag',
				display: 'name',
				source: tagsList
			}
		);

        typeaheadAutocomplete(tagAutocomplete);

		tagAutocomplete.bind(
			'typeahead:select',
			function(event, suggestion) {
				$(this).typeahead('val', '');

				var template = _.template($('#connected-tag-template').html());
				var compiled_template = template(suggestion);

				$('#connected-tags-container').append(compiled_template);
			}
		);

		$('#connected-tags-container').on('click', '[connected-tag-delete]', function() {
			var connected_tag_id = $(this).attr('connected-tag-delete');
			$('[tag-id=' + connected_tag_id + ']').remove();
		});

		$(document).on('keypress', '#tag-autocomplete', function(e) {
			if(e.which == 13) {
				e.preventDefault();
				var templateData;

				var template = _.template($('#connected-tag-template').html());

				var request = $.ajax({
					url: '/backend/tag',
					type: 'post',
					data: {name: $('#tag-autocomplete').typeahead('val')},
				});
				request.done(function(data) {
					templateData = {
						'id': data.id,
						'name': data.name
					};
					$('#connected-tags-container').append(template(templateData));
					$('#tag-autocomplete').typeahead('val', '');
				});

			}
		});

        var issueAutocomplete = $('#issue-autocomplete');
        var issuesList = new Bloodhound({
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: issueAutocomplete.attr('source-url'),
                wildcard: '{name}',
                transform: function (response) {
                    return _.filter(response, function(item){
                        return $('[issue-id=' + item.id + ']').length === 0;
                    });
                }
            }
        });

        issueAutocomplete.typeahead(
            null,
            {
                name: 'issue',
                display: 'name',
                source: issuesList
            }
        );

        typeaheadAutocomplete(issueAutocomplete);

        issueAutocomplete.bind(
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

		$(document).on('click', '[delete-file=true]', function(ev) {
			ev.preventDefault();
			var request = $.ajax({
				url: $(this).attr('href'),
				method: 'GET'
			});
			request.done(function() {
				$('[file-show=true]').text('');
				$('[delete-file=true]').hide();
			});
		});

        var dateWidgets = $('[date-widget=true]').datetimepicker({
            locale: 'ro',
            format: 'L'
        });

        $('[name=date]').val(($('[date-widget=true]').val()).split(".").reverse().join("-"));

        dateWidgets.on('dp.change', function () {
            var d = $(this).data("DateTimePicker").date();
            var e = d.format("YYYY-MM-DD");
            $('[name=date]').val(e);
        });
	});
})();
