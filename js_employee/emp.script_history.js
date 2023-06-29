$('#leaveTable').DataTable({
    serverSide: true,
    processing: true,
    paging: true,
    pageLength: 10,
    lengthChange: false,
    order: [],
    ajax: {
        url: 'inc.employee_fetch_leave_history.php',
        type: 'post',
    },
    columnDefs: [{
        targets: '_all', // Target all columns
        orderable: true, // enable sorting for all columns
    }],
});


$('#timeTable').DataTable({
    serverSide: true,
    processing: true,
    paging: true,
    pageLength: 10,
    lengthChange: false,
    order: [],
    ajax: {
        url: 'inc.employee_fetch_timeoff_history.php',
        type: 'post',
    },
    columnDefs: [{
        targets: '_all', // Target all columns
        orderable: true, // enable sorting for all columns
    }],
});
