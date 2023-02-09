$(document).ready(function () {

    $('#datatable').DataTable({
        fixedColumns: {
            heightMatch: 'none'
        },
        "bLengthChange": false,
        "info": false,
        "scrollY": "100vh",
        "scrollCollapse": true,
        "language": {
            zeroRecords: "Es wurden keine Einträge gefunden...",
            "paginate": {
                "previous": "Zurück",
                "next": "Weiter"
            }
        }

    });
    $('#datatable_filter').hide();
    $('#txtSearch').on('keyup', function () {
        $('#datatable')
            .DataTable()
            .search($('#txtSearch').val(), false, true)
            .draw()
    });
});


