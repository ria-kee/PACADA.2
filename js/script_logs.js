
var logsTable = $('#logsTable').DataTable({
    serverSide: true,
    processing: true,
    paging: true,
    pageLength: 10,
    lengthChange: false,
    order: [],
    ajax: {
        url: 'inc.fetch_logs.php',
        type: 'post',
    },
    columnDefs: [{
        targets: [5]
    }]
});


$(document).ready(function() {

    $('.searchField').on('keyup', function() {
        logsTable.search(this.value).draw();
    });
});
$('.dataTables_filter').hide();
