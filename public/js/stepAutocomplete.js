(function(){
	$(document).ready(function() {

		var deleteButtonTemplate = _.template($("#delete-button").html(),
                {
                    interpolate: /__([\s\S]+?)__/g
                }
            );

        $('#step-autocomplete-table').DataTable({
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
                    title: "id",
                    orderable: true
                },
                {
                    data: "name",
                    title: "Titlu",
                    orderable: true
                },
                {
                    data: "id",
                    title: "Actiuni",
                    render: function(data, type, rowData, meta) {
                        return deleteButtonTemplate({id: data});
                    }
                }
            ],
            responsive: true,
            stateSave: true,
            serverSide: true,
            ajax: {
            "url": window.location.href + '/query',
            }
        });
	});
})()