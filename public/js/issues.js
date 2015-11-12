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

		CKEDITOR.replace( 'editor5',{
			toolbar:
			[
				{name: 'basicstyles', items: ['Bold','Italic']},
				{name: 'paragraph', items: ['NumberedList', 'BulletedList','-','Outdent','Indent']},
				{name: 'links', items: ['Link','Unlink']},
				{name: 'about', items: ['About']}
			]
		});

		CKEDITOR.replace( 'editor6',{
			toolbar:
			[
				{name: 'basicstyles', items: ['Bold','Italic']},
				{name: 'paragraph', items: ['NumberedList', 'BulletedList','-','Outdent','Indent']},
				{name: 'links', items: ['Link','Unlink']},
				{name: 'about', items: ['About']}
			]
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

		var newsList = new Bloodhound({
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: $('#news-autocomplete').attr('source-url'),
				wildcard: '{name}',
				transform: function (response) {
					return _.filter(response, function(item){
						return $('[news-id=' + item.id + ']').length === 0;
					});
				}
			}
		});

		$('#news-autocomplete').typeahead(
			null,
			{
				name: 'news',
				display: 'name',
				source: newsList
			}
		);

		$('#news-autocomplete').bind(
			'typeahead:select',
			function(event, suggestion) {
				$(this).typeahead('val', '');

				var template = _.template($('#connected-news-template').html());
				var compiled_template = template(suggestion);

				$('#connected-news-container').append(compiled_template);
			}
		);

		$('#connected-news-container').on('click', '[connected-news-delete]', function() {
			var connected_news_id = $(this).attr('connected-news-delete');
			$('[news-id=' + connected_news_id + ']').remove();
		});
	});
})();
