
// Get the current date
var currentDate = new Date();

// Extract the day, month, and year from the current date
var day = currentDate.getDate();
var month = currentDate.toLocaleString('default', { month: 'long' }).toUpperCase();;
var year = currentDate.getFullYear();

// Display the current date inside the "Datetitle" element
var dateTitleElement = document.querySelector(".Datetitle");
dateTitleElement.textContent =  month + " "+ year;


// Add an event listener to the department select element
$('#Department').on('change', function() {
    // Get the selected department value
    var selectedDepartment = $(this).val();

    // Update the Ajax URL with the selected department
    pendingTable.ajax.url('inc.fetch_pending_credits.php?department=' + selectedDepartment).load();

    updatedTable.ajax.url('inc.fetch_updated_credits.php?department=' + selectedDepartment).load();
});

var pendingTable = $('#creditTable').DataTable({
    serverSide: true,
    processing: true,
    paging: true,
    pageLength: 10,
    lengthChange: false,
    order: [],
    ajax: {
        url: 'inc.fetch_pending_credits.php',
        type: 'post',
    },
    columnDefs: [{
        targets: [8],
        orderable: false,
        className: 'no-export' // Exclude the "Options" column from export
    }]
});


$(document).ready(function() {

    $('.searchField').on('keyup', function() {
        pendingTable.search(this.value).draw();
    });
});
$('.dataTables_filter').hide();


var updatedTable = $('#updatedcreditTable').DataTable({
    serverSide: true,
    processing: true,
    paging: true,
    pageLength: 10,
    lengthChange: false,
    order: [],
    ajax: {
        url: 'inc.fetch_updated_credits.php',
        type: 'post',
    },
    columnDefs: [{
        targets: [7],
        orderable: false,
        className: 'no-export' // Exclude the "Options" column from export
    }]
});


$(document).ready(function() {

    $('.searchField').on('keyup', function() {
        updatedTable.search(this.value).draw();
    });
});
$('.dataTables_filter').hide();




//EDIT MODAL
$(document).on('click', '.add-credit', function() {
    var emp_uid = $(this).data('uid');
    var emp_dept = $(this).data('dept');
    var emp_name = $(this).data('empname');
    var image = $(this).data('image');

    $('#empname').text(emp_name);
    $('#dept').text(emp_dept);
    $('#image').attr('src', 'data:image/jpeg;base64,' + image);

    $('#AddCreditModal').modal('show'); // Show the  modal


});






