$(document).ready(function(){
	var compiled = _.template($('#section_template').html());

	$('.add_section').on('click', function(){
		var template_populated= compiled({ 'sectionid': _.random(100000, 1000000),
											'id': _.uniqueId('new-')});
		$('.sections').append(template_populated);
	});

	$(document).on('click', '.delete_section', function() {
		var selected_id = $(this).attr("id");
		var result = confirm("Sigur doriti sa stergeti sectiunea?")
		if (result) {
			$('#section'+selected_id).remove();
		}
	});

	$("input[data-action=publish-stakeholder").click(function(){
		var request = $.ajax({
			url: $(this).attr('update-url'),
			data: {
				published:$(this).prop('checked'),
			},
			method:'get'
		});
		request.done(function(data){
			console.error("ajaxresult",data);
		});
	});

	var stakeholdersList = new Bloodhound({
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		datumTokenizer: Bloodhound.tokenizers.whitespace,
		remote: {
			url: $('#stakeholder-autocomplete').attr('source-url'),
			wildcard: '{name}'
		}
	});

	// Autocomplete for stakeholders
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

			console.log(compiled_template);

			$('#connected-stakeholders-container').append(compiled_template);
		}
	);
});
