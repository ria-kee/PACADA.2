
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

    $('#AddCreditModal').data('uID', emp_uid);
    $('#AddCreditModal').modal('show'); // Show the  modal
});


const lateInput = document.getElementById('late');
const sick = document.getElementById('sick');
const vacation = document.getElementById('vacation');
const lateInvalidFeedback = document.getElementById('late-invalid-feedback');

var lateisValid =true;

// RECORD LATE MODAL
lateInput.addEventListener('change', function() {
    // Retrieve the entered value
    const enteredValue = lateInput.value;

    if(enteredValue < 1){
        var VacationBalance = 1.25;
        var SickBalance = 1.25;
        var accumulatedVacation = VacationBalance - enteredValue;
        sick.value = SickBalance;
        vacation.value = accumulatedVacation;
        lateInvalidFeedback.textContent = '';
        lateisValid=true;
    }else {
        sick.value = '';
        vacation.value = '';
        lateInvalidFeedback.textContent = 'the value should be less than 1.';
        lateisValid =false;
    }

});

$(document).on('click', '#AddCreditModal #AddCredits', function() {
    var UID = $('#AddCreditModal').data('uID');
    var vacationValue = vacation.value;
    var sickValue = sick.value;

   if (lateisValid){
       //Perform the AJAX request to update credits
       $.ajax({
           url: 'inc.add_credits.php',
           type: 'POST',
           data: { uID: UID, vacation: vacationValue, sick:sickValue },
           success: function(response) {
               // Show the success alert
               $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> ' + 'Credits is updated successfully');
               $('#updatedcreditTable').DataTable().ajax.reload();
               $('#creditTable').DataTable().ajax.reload();
               // Close the modal
               $('#AddCreditModal').modal('hide');

               // Close the success alert after 3 seconds
               setTimeout(function() {
                   $('#successAlert').removeClass('show').addClass('d-none');
               }, 3000);
           },
           error: function(xhr, status, error) {
               // Show the error alert with the custom error message
               $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> ' + xhr.responseText);

               // Close the modal
               $('#AddCreditModal').modal('hide');

               // Close the error alert after 3 seconds
               setTimeout(function() {
                   $('#errorAlert').removeClass('show').addClass('d-none');
               }, 5000);
           }

       });
   }
});




