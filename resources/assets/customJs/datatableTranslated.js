$(document).ready(function() {
    $('.dataTables-example').DataTable({
        responsive: true,
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
            "sEmptyTable": "Nu exista nici o inregistrare in tabel"
        }
    });
});
