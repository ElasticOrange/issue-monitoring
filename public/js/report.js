(function(){
    $(document).ready(function(){

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
        
        var dateWidget = $('#date-init').datetimepicker({
            locale: 'ro',
            format: 'L',
            defaultDate: moment()
        });

        $('#date-result').val(($('#date-init').val()).split(".").reverse().join("-"));

        dateWidget.on('dp.change', function () {
            var d = $(this).data("DateTimePicker").date();
            var e = d.format("YYYY-MM-DD");
            $('#date-result').val(e);
        });

    });
})();