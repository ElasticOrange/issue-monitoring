(function(){
    $(document).ready(function(){

        var actionButtonsTemplate = _.template($("#action_buttons").html(),
                {
                    interpolate: /__([\s\S]+?)__/g
                }
            );

        var link = _.template($("#external_link").html(),
            {
                interpolate: /__([\s\S]+?)__/g
            });

        $('#news-table').DataTable({
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
                    data: "title",
                    title: "Titlu",
                    orderable: false
                },
                {
                    data: "title",
                    title: "Title",
                    render: function (data, type, rowData) {
                        if (_.isArray(rowData['translations'])) {
                            var obj = _.find(rowData['translations'], function(obj) {
                                return obj.locale === 'en';
                            });
                            return obj.title;
                        }
                    },
                    orderable: false
                },
                {
                    data: "date",
                    title: "Data",
                    render: function (data, type, rowData, meta) {
                        var date = new Date(data);
                        var dd = date.getDate();
                        var mm = date.getMonth() + 1;
                        var yyyy = date.getFullYear();

                        if(dd < 10) {
                            dd = '0' + dd;
                        }

                        if(mm < 10) {
                            mm = '0' + mm;
                        }

                        date = dd + '-' + mm + '-' + yyyy;
                        return date;
                    }
                },
                {
                    data: "link",
                    title: "Sursa",
                    render: function(data, type, rowData, meta) {
                        return link({link: data});
                    }
                },
                {
                    data: "id",
                    title: "Actiuni",
                    render: function(data, type, rowData, meta) {
                        return actionButtonsTemplate({id: data});
                    },
                    orderable: false
                }
            ],
            responsive: true,
            stateSave: true,
            serverSide: true,
            ajax: {
            "url": window.location.href + '/query',
            }
        });

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

        initAutocomplete(
            $('#stakeholder-autocomplete'), //autocomplete selector
            '[stakeholder-id=', //filter duplicate
            '#connected-stakeholder-template',
            '#connected-stakeholders-container',
            '[connected-stakeholder-delete]', //delete selector
            'connected-stakeholder-delete', //delete attr
            '[stakeholder-id=' //remove selector
        );

        initAutocomplete(
            $('#domain-autocomplete'), //autocomplete selector
            '[domain-id=', //filter duplicate
            '#connected-domain-template',
            '#connected-domains-container',
            '[connected-domain-delete]', //delete selector
            'connected-domain-delete', //delete attr
            '[domain-id=' //remove selector
        );

        initAutocomplete(
            $('#issue-autocomplete'), //autocomplete selector
            '[issue-id=', //filter duplicate
            '#connected-issue-template',
            '#connected-issues-container',
            '[connected-issue-delete]', //delete selector
            'connected-issue-delete', //delete attr
            '[issue-id=' //remove selector
        );

        initAutocomplete(
            $('#tag-autocomplete'), //autocomplete selector
            '[tag-id=', //filter duplicate
            '#connected-tag-template',
            '#connected-tags-container',
            '[connected-tag-delete]', //delete selector
            'connected-tag-delete', //delete attr
            '[tag-id=' //remove selector
        );

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

        var dateWidgets = $('[date-widget=true]').datetimepicker({
            locale: 'ro',
            format: 'L'
        });

        if ($('[date-widget=true]').length > 0) {
            $('[name=date]').val(($('[date-widget=true]').val()).split(".").reverse().join("-"));
        }

        dateWidgets.on('dp.change', function () {
            var d = $(this).data("DateTimePicker").date();
            var e = d.format("YYYY-MM-DD");
            $('[name=date]').val(e);
        });
    });
})();
