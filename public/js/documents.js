(function(){
	$(document).ready(function(){

        var actionButtonsTemplate = _.template($("#action_buttons").html(),
                {
                    interpolate: /__([\s\S]+?)__/g
                }
            );

        var downloadUploadedFile = _.template($("#download_file").html(),
                {
                    interpolate: /__([\s\S]+?)__/g
                });

        var externalLink = _.template($("#external_link").html(),
                {
                    interpolate: /__([\s\S]+?)__/g
                });

        $('#documents-table').DataTable({
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
                    data: "file",
                    title: "Document",
                    orderable: false,
                    render: function(data, type, rowData, meta) {
                        return downloadUploadedFile({fileName: data.file_name, originalFileName: data.original_file_name});
                    }
                },
                {
                    data: "public_code",
                    title: "Link",
                    render: function(data, type, rowData, meta) {
                        return externalLink({publicCode: data});
                    },
                    orderable: false
                },
                {
                    data: "init_at",
                    title: "Data"
                },
                {
                    data: "id",
                    title: "Actiuni",
                    render: function(data, type, rowData, meta) {
                        return actionButtonsTemplate({id: data});
                    },
                    orderable:false
                }
            ],
            responsive: true,
            stateSave: true,
            serverSide: true,
            ajax: {
            "url": window.location.href + '/query',
            }
        });

		$('[data-confirm=true]').click(function(e)
		{
			if(confirm('Vrei sa stergi acest document ?'))
			{
				return true;
			}
			e.preventDefault();
			return false;
		});


		var dateWidgets = $('[date-widget=true]').datetimepicker({
			locale: 'ro',
			format: 'L'
		});

		$('[name=date]').val(($('[date-widget=true]').val()).split(".").reverse().join("-"));

		dateWidgets.on('dp.change', function () {
			var d = $(this).data("DateTimePicker").date();
			var e = d.format("YYYY-MM-DD");
			$('[name=date]').val(e);
		});
	});
})();
