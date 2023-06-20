// Add an event listener to the department select element
$('#Department').on('change', function() {
    // Get the selected department value
    var selectedDepartment = $(this).val();

    // Update the Ajax URL with the selected department
    leaveTable.ajax.url('inc.fetch_All_Employees.php?department=' + selectedDepartment).load();
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
    },
    columnDefs: [{
        targets: [5],
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
                return 'Employees - ' + currentDate.replace(/\//g, '-');
            },
            title: 'Employees'
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
                return 'Employees - ' + currentDate.replace(/\//g, '-');
            },
            title: 'Employees',
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
    empTable.button('.buttons-pdf').trigger();
    console.log('Export PDF clicked');
});
// Export Excel
$('#excelExport').click(function() {
    empTable.button('.buttons-excel').trigger();
    console.log('Export Excel clicked');
});
$(document).ready(function() {

    $('.searchField').on('keyup', function() {
        empTable.search(this.value).draw();
    });
});
$('.dataTables_filter').hide();
