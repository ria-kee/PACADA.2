// Add an event listener to the department select element
$('#Department').on('change', function() {
    // Get the selected department value
    var selectedDepartment = $(this).val();

    // Update the Ajax URL with the selected department
    leaveTable.ajax.url('inc.fetch_Leaves.php?department=' + selectedDepartment).load();
});

var leaveTable = $('#leaveTable').DataTable({
    serverSide: true,
    processing: true,
    paging: true,
    pageLength: 10,
    lengthChange: false,
    order: [],
    ajax: {
        url: 'inc.fetch_Leaves.php',
        type: 'post',
        data: function (d) {
            // Add the from-date and to-date values to the AJAX request
            d.fromDate = document.getElementById('from-date').value;
            d.toDate = document.getElementById('to-date').value;
        }
    },
    columnDefs: [{
        targets: [6],
        orderable: false,
        className: 'no-export' // Exclude the "Options" column from export
    }],
    buttons: [
        {
            extend: 'excel',
            exportOptions: {
                columns: ':not(.no-export)',
                header: function(data, columnIdx, columnNode) {
                    return $(columnNode).text();
                }
            },
            filename: function() {
                var currentDate = new Date().toLocaleDateString('en-PH');
                return 'Filed Leaves - ' + currentDate.replace(/\//g, '-');
            },
            title: 'Filed Leaves'
        },
        {
            extend: 'pdf',
            exportOptions: {
                columns: ':not(.no-export)',
                header: function(data, columnIdx, columnNode) {
                    return $(columnNode).text();
                }
            },
            filename: function() {
                var currentDate = new Date().toLocaleDateString('en-PH');
                return 'Filed Leaves - ' + currentDate.replace(/\//g, '-');
            },
            title: 'Filed Leaves',
            customize: function(doc) {
                // Set the table alignment to center
                doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                doc.content[1].table.alignment = 'center';

                // Apply striped color effect to table rows
                doc.content[1].table.body.forEach(function(row, rowIndex) {
                    row.forEach(function(cell, cellIndex) {
                        if (rowIndex % 2 === 0) {
                            cell.fillColor = '#E9E9FF'; //first color for striped effect
                        } else {
                            cell.fillColor = '#FFFFFF'; //second color for striped effect
                        }
                    });
                });

                // Customize the table header color
                doc.content[1].table.headerRows = 1;
                doc.content[1].table.body[0].forEach(function(headerCell) {
                    headerCell.fillColor = '#7D7DD2'; // Specify the color for the table header
                });
                // Customize the title style
                var title = doc.content[0].text[0];
                title.bold = true; // Make the title text bold
            },
            didDrawPage: function(data) {
                // Add a striped background to the table in the exported PDF
                var pageSize = data.pageSize;
                var pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
                var table = data.content[1].table;
                var rowHeight = table.body[0].height ? table.body[0].height : table.height;
                var rowCount = table.body.length;
                var tableHeight = rowHeight * rowCount;
                var midPagePos = (pageHeight - tableHeight) / 2;

                data.content[1].table.body.forEach(function(row, rowIndex) {
                    row.forEach(function(cell) {
                        cell.textPos.y += midPagePos;
                        cell.height = rowHeight;
                    });
                });
            }
        }
    ]
});




// Export PDF
$('#pdfExport').click(function() {
    leaveTable.button('.buttons-pdf').trigger();
    console.log('Export PDF clicked');
});
// Export Excel
$('#excelExport').click(function() {
    leaveTable.button('.buttons-excel').trigger();
    console.log('Export Excel clicked');
});
$(document).ready(function() {

    $('.searchField').on('keyup', function() {
        leaveTable.search(this.value).draw();
    });
});
$('.dataTables_filter').hide();




$(document).ready(function() {
    // Get the "from-date" and "to-date" input elements
    var fromDate = document.getElementById("from-date");
    var toDate = document.getElementById("to-date");

    // Set the minimum selectable date for "to-date" based on "from-date"
    fromDate.addEventListener("change", function() {
        toDate.min = fromDate.value;
    });

    // Handle the case where "from-date" is null but "to-date" has a value
    toDate.addEventListener("change", function() {
        if (fromDate.value === "" && toDate.value !== "") {
            fromDate.value = toDate.value;
        }
    });
});


var fromDateInput = document.getElementById('from-date');
var toDateInput = document.getElementById('to-date');

// Add event listeners to the date inputs
fromDateInput.addEventListener('change', handleDateRangeChange);
toDateInput.addEventListener('change', handleDateRangeChange);

function handleDateRangeChange() {
    var fromDate = fromDateInput.value;
    var toDate = toDateInput.value;

    // Trigger DataTable search with the date range values
    leaveTable.column(0).search(fromDate + ' - ' + toDate).draw();
}