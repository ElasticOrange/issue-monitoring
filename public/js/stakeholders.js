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

	$('.stakeholder-type select').change(function(){
		if($(this).val() == 'organizatie'){
			$('.stakeholder-cv').css({'display':'none'});
		}
		else{
			$('.stakeholder-cv').css({'display':'block'});
		}
	});
});
