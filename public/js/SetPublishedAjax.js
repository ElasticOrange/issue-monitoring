$(document).ready(function(){
	$("input[data-action='publish-stakeholder'").click(function(){
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
});