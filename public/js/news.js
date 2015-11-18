(function(){
	$(document).ready(function(){

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

		var tagsList = new Bloodhound({
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: $('#tag-autocomplete').attr('source-url'),
				wildcard: '{name}',
				transform: function (response) {
					return _.filter(response, function(item){
						return $('[tag-id=' + item.id + ']').length === 0;
					});
				}
			}
		});

		$('#tag-autocomplete').typeahead(
			null,
			{
				name: 'tag',
				display: 'name',
				source: tagsList
			}
		);

		$('#tag-autocomplete').bind(
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
	});
})();
