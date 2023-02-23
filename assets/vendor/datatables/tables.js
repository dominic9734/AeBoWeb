$(document).ready(function () {

    // Get the IDs of all elements with the class "table" in an array
    var tableIds = $(".table").map(function () {
        return this.id;
    }).get();

    // Call the function "test" with each ID from "tableIds"
    $.each(tableIds, function (index, tabelID) {
        setDatatable(tabelID);
    });

    // Initialize DataTables for all tables
    function setDatatable(tabelID) {
        console.log(tabelID)
        $('#' + tabelID).DataTable({
            drawCallback: function (settings) {
                // Get paging information
                var pagingInfo = $(this).DataTable().page.info();
                // If there is only one page, hide the next and previous buttons
                if (pagingInfo.pages <= 0) {
                    $('#' + tabelID + '_next, #' + tabelID + '_previous').hide();
                }

                // Set the height of the table and its rows
                var table = $(settings.nTable);
                var rows = table.find('tr');
                var rowHeight = 75; // set the height of each row here
                var height = rowHeight * rows.length; // add 50 pixels for the table header
                table.css('height', height + 'px');
                rows.css('height', rowHeight + 'px');
                // Add invisible rows to fill the table if there are less than 11 rows
                if (rows.length < 11) {
                    var numExtraRows = 11 - rows.length;
                    for (var i = 0; i < numExtraRows; i++) {
                        $('<tr>').append($('<td>').css({ 'border-top': 'none', 'border-bottom': 'none', 'visibility': 'hidden' })).appendTo(table);
                    }
                }
            },
            "bLengthChange": false,
            "info": false,
            "language": {
                zeroRecords: "Es wurden keine Einträge gefunden...",
                "paginate": {
                    "previous": "Zurück",
                    "next": "Weiter"
                }
            }
        });
        // Hide search input and bind keyup event
        $('#' + tabelID + '_filter').hide();
    }
    $('.nav_search').on('keyup', function () {
        $('.table')
            .DataTable()
            .search($('#txtSearch').val(), false, true)
            .draw()
    });
});
