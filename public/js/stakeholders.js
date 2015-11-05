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
});
