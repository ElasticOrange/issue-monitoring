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

	$("input[data-action=publish-stakeholder]").click(function(){
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

	var stakeholdersList = new Bloodhound({
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		datumTokenizer: Bloodhound.tokenizers.whitespace,
		remote: {
			url: $('#stakeholder-autocomplete').attr('source-url'),
			wildcard: '{name}',
			transform: function (response) {
				return _.filter(response, function(item){
					return $('[stakeholder-id=' + item.id + ']').length == 0;
				});
			}
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

			$('#connected-stakeholders-container').append(compiled_template);
		}
	);

	$('#connected-stakeholders-container').on('click', '[connected-stakeholder-delete]', function() {
		var connected_stakeholder_id = $(this).attr('connected-stakeholder-delete');
		$('[stakeholder-id=' + connected_stakeholder_id + ']').remove();
	});

	$('[stakeholder-type=true] select').change(function(){
		if($(this).val() == 'organizatie'){
			$('[stakeholder-cv=true]').css({'display':'none'});
			$('[stakeholder-position=true]').css({'display':'none'});
		}
		else{
			$('[stakeholder-cv=true]').css({'display':'block'});
			$('[stakeholder-position=true]').css({'display':'block'});
		}
	});

	if($('[stakeholder-type=true] select').val() == 'organizatie'){
		$('[stakeholder-cv=true]').css({'display':'none'});
		$('[stakeholder-position=true]').css({'display':'none'});
	}
});
