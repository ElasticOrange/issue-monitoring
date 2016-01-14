$(document).ready(function(){

    $("input[data-action=active-user]").click(function(){
        var request = $.ajax({
            url: $(this).attr('update-url'),
            data: {
                active: $(this).prop('checked')
            },
            method:'get'
        });
        request.done(function(data){
        });
    });

    function initDate() {
        var startDateWidgets = $('#startdate-subscription').datetimepicker({
            locale: 'ro',
            format: 'L',
            defaultDate: moment()
        });

        $('#startdate-result').val(($('#startdate-subscription').val()).split(".").reverse().join("-"));

        startDateWidgets.on('dp.change', function () {
            var d = $(this).data("DateTimePicker").date();
            var e = d.format("YYYY-MM-DD");
            $('#startdate-result').val(e);
        });

        var endDateWidgets = $('#enddate-subscription').datetimepicker({
            locale: 'ro',
            format: 'L',
            defaultDate: moment()
        });

        $('#enddate-result').val(($('#enddate-subscription').val()).split(".").reverse().join("-"));

        endDateWidgets.on('dp.change', function () {
            var d = $(this).data("DateTimePicker").date();
            var e = d.format("YYYY-MM-DD");
            $('#enddate-result').val(e);
        });
    }

    initDate();

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
        var connected_domain_id = $(this).attr('connected-domain-delete');
        $('[domain-id=' + connected_domain_id + ']').remove();
    });
});
