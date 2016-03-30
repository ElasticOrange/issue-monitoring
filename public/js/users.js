$(document).ready(function(){

    var actionButtonsTemplate = _.template($("#action_buttons").html(),
            {
                interpolate: /__([\s\S]+?)__/g
            }
        );

    $('#users-table').DataTable({
        "language":{
            "sInfo": "Arata de la _START_ la _END_ din _TOTAL_ intrari",
            "sInfoEmpty": "Arata de la 0 la 0 din 0 intrari",
            "sLengthMenu": "Arata _MENU_ intrari",
            "sSearch": "Cauta",
            "paginate":{
                "next": "Inainte",
                "previous": "Inapoi",
                "first": "Primul",
                "last": "Ultimul"
            },
            "sEmptyTable": "Nu exista nicio inregistrare"
        },
        "columns": [
            {
                data: "id",
                title: "id"
            },
            {
                data: "name",
                title: "Nume"
            },
            {
                data: "email",
                title: "E-mail"
            },
            {
                data: "type",
                title: "Acces"
            },
            {
                data: "active",
                title: "Activ",
                render: function (data, type, rowData, meta) {
                    return (data != 0 ? '<span class="glyphicon glyphicon-ok"></span>' : '');
                }
            },
            {
                data: "id",
                title: "Actiuni",
                render: function (data, type, rowData, meta) {
                    return actionButtonsTemplate({id: data});
                },
                orderable: false
            }
        ],
        responsive: true,
        stateSave: true,
        serverSide: true,
        ajax: {
        "url": window.location.href + '/query'
        }
    });

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
            format: 'L'
        });

        $('#startdate-result').val(($('#startdate-subscription').val()).split(".").reverse().join("-"));

        startDateWidgets.on('dp.change', function () {
            var d = $(this).data("DateTimePicker").date();
            var e = d.format("YYYY-MM-DD");
            $('#startdate-result').val(e);
        });

        var endDateWidgets = $('#enddate-subscription').datetimepicker({
            locale: 'ro',
            format: 'L'
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
        if(confirm('Vrei sa stergi acest domeniu ?'))
        {
            $('[domain-id=' + connected_domain_id + ']').remove();
        }
    });
});
