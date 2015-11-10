(function(){
	$(document).ready(function(){
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
})();
