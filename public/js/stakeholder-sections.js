$(document).ready(function(){
	var compiled = _.template($('#section_template').html());

	$('.add_section').on('click', function(){
	    var template_populated= compiled({ 'sectionid': _.random(100000, 1000000),
											'id': _.uniqueId('new-')});
	    $('.sections').append(template_populated);
	});

	$(document).on('click', '.delete_section', function() {
	    var selected_id = $(this).attr("id");
	    $('#section'+selected_id).remove();
	});
});