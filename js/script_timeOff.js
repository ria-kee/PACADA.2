// Add an event listener to the department select element
$('#Department').on('change', function() {
    // Get the selected department value
    var selectedDepartment = $(this).val();

    // Update the Ajax URL with the selected department
    timeTable.ajax.url('inc.fetch_timeoff.php?department=' + selectedDepartment).load();
});

var timeTable = $('#timeTable').DataTable({
    serverSide: true,
    processing: true,
    paging: true,
    pageLength: 10,
    lengthChange: false,
    order: [],
    ajax: {
        url: 'inc.fetch_timeoff.php',
        type: 'post',
    },
    columnDefs: [{
        targets: [5],
        orderable: false,
        className: 'no-export' // Exclude the "Options" column from export
    }],

});


$(document).ready(function() {

    $('.searchField').on('keyup', function() {
        timeTable.search(this.value).draw();
    });
});
$('.dataTables_filter').hide();


// REMARKS MODAL
$(document).on('click', '.remarks-button', function() {
    var uid = $(this).data('uid');
    var empid = $(this).data('empid');
    var image = $(this).data('image');
    var name = $(this).data('empname');
    var dept = $(this).data('dept');
    var remarks = $(this).data('remarks');

    $('#preview-image').attr('src', 'data:image/jpeg;base64,' + image);
    $('#preview_emp').text(name);
    $('#preview-id').text(empid);
    $('#preview-dept').text(dept);

    $('#remarks').text(remarks);

    // Store the emp ID to be used later;
    $('#RemarksModal').data('uid', uid);

    $('#RemarksModal').modal('show'); // Show the  modal
});

$(document).on('click', '#RemarksModal #saveRemarks', function() {
    var id = $('#RemarksModal').data('uid');
    var remark = document.getElementById('remarks').value;

    // Perform the AJAX request to update
    $.ajax({
        url: 'inc.update_remarks.php',
        type: 'POST',
        data: { uID: id , remarks: remark},
        success: function(response) {
            // Show the success alert
            $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> ' + response);
            $('#timeTable').DataTable().ajax.reload();

            // Close the modal
            $('#RemarksModal').modal('hide');

            // Close the success alert after 3 seconds
            setTimeout(function() {
                $('#successAlert').removeClass('show').addClass('d-none');
            }, 3000);
        },
        error: function(xhr, status, error) {
            // Show the error alert with the custom error message
            $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> ' + xhr.responseText);

            // Close the modal
            $('#RemarksModal').modal('hide');

            // Close the error alert after 3 seconds
            setTimeout(function() {
                $('#errorAlert').removeClass('show').addClass('d-none');
            }, 5000);
        }

    });
});

// ADD TIME-OFF
$(document).on('click', '.add-credit', function() {
    var uid = $(this).data('uid');
    var empid = $(this).data('empid');
    var image = $(this).data('image');
    var name = $(this).data('empname');
    var dept = $(this).data('dept');
    var current_credits = $(this).data('credits');


    $('#credit_image').attr('src', 'data:image/jpeg;base64,' + image);
    $('#credit_emp').text(name);
    $('#credit_id').text(empid);
    $('#credit_dept').text(dept);

    // Store the emp ID to be used later;
    $('#AddTimeOffModal').data('uid', uid);
    $('#AddTimeOffModal').data('current', current_credits);

    $('#AddTimeOffModal').modal('show'); // Show the  modal
});

var hoursInput = document.getElementById('Hours');
var minsInput = document.getElementById('Minutes');
var creditFeedback = document.getElementById('hours-invalid-feedback');



function validateInput(){
    var hours = document.getElementById('Hours').value.trim();
    var mins = document.getElementById('Minutes').value.trim();


    if (hours ==='' && mins ===''){
        creditFeedback.textContent='There is no hours and minutes given.';
        return false;
    }else {
        return true;
    }
}


$('#AddTimeOffModal').on('hidden.bs.modal', function () {
    hoursInput.value = '';
    minsInput.value= '';
    creditFeedback.textContent='';
});

$(document).on('click', '#AddTimeOffModal #addCredit', function() {
    var id = $('#AddTimeOffModal').data('uid');
    var current = $('#AddTimeOffModal').data('current');
    var hours = document.getElementById('Hours').value;
    var mins = document.getElementById('Minutes').value;


    validateInput();

    var isValid = validateInput();

    if(isValid){
        // Perform the AJAX request to update
        $.ajax({
            url: 'inc.add_time_off.php',
            type: 'POST',
            data: { uID: id , current: current, hrs:hours, mins:mins},
            success: function(response) {
                // Show the success alert
                $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> ' + response);
                $('#timeTable').DataTable().ajax.reload();

                // Close the modal
                $('#AddTimeOffModal').modal('hide');

                // Close the success alert after 3 seconds
                setTimeout(function() {
                    $('#successAlert').removeClass('show').addClass('d-none');
                }, 3000);
            },
            error: function(xhr, status, error) {
                // Show the error alert with the custom error message
                $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> ' + xhr.responseText);

                // Close the modal
                $('#AddTimeOffModal').modal('hide');

                // Close the error alert after 3 seconds
                setTimeout(function() {
                    $('#errorAlert').removeClass('show').addClass('d-none');
                }, 5000);
            }

        });
    }

});



// CLAIM TIME-OFF
var claimhoursInput = document.getElementById('claim_Hours');
var claimminsInput = document.getElementById('claim_Minutes');
var claimMinFeedback = document.getElementById('claim-min-invalid-feedback');
var claimHrFeedback = document.getElementById('claim-hr-invalid-feedback');

var claimRemarks = document.getElementById('claim_remarks');

$(document).on('click', '.claim-button', function() {
    var uid = $(this).data('uid');
    var empid = $(this).data('empid');
    var image = $(this).data('image');
    var name = $(this).data('empname');
    var dept = $(this).data('dept');
    var current_credits = $(this).data('credits');

    $('#claim_image').attr('src', 'data:image/jpeg;base64,' + image);
    $('#claim_emp').text(name);
    $('#claim_id').text(empid);
    $('#claim_dept').text(dept);

    // Store the emp ID to be used later;
    $('#ClaimTimeOffModal').data('uid', uid);
    $('#ClaimTimeOffModal').data('current', current_credits);
    $('#useCredit').prop('disabled', true); // Disable the submit button
    $('#ClaimTimeOffModal').modal('show'); // Show the  modal
});

$('#ClaimTimeOffModal').on('hidden.bs.modal', function () {
    claimhoursInput.value = '';
    claimminsInput.value= '';
    claimHrFeedback.textContent='';
    claimRemarks.value= '';

});


function parseTimeToMinutes(time) {
    var parts = time.split(':');
    var hours = parseInt(parts[0]) || 0;
    var minutes = parseInt(parts[1]) || 0;
    return hours * 60 + minutes;
}



$(document).on('change', '#ClaimTimeOffModal #claim_Hours, #ClaimTimeOffModal #claim_Minutes', function() {
    var current = $('#ClaimTimeOffModal').data('current');
    var maxMinutes = parseTimeToMinutes(current);

    var hours = parseInt($('#claim_Hours').val()) || 0;
    var minutes = parseInt($('#claim_Minutes').val()) || 0;
    var selectedMinutes = hours * 60 + minutes;

    if (selectedMinutes > maxMinutes) {
        claimHrFeedback.textContent = 'Exceeds the maximum duration credit.';
        $('#useCredit').prop('disabled', true); // Disable the submit button
    } else {
        claimHrFeedback.textContent = '';
        if (hours === 0 && minutes === 0) {
            $('#useCredit').prop('disabled', true); // Disable the submit button
        } else {
            $('#useCredit').prop('disabled', false); // Enable the submit button
        }
    }
});

$(document).on('click', '#ClaimTimeOffModal #useCredit', function() {
    var hours = parseInt($('#claim_Hours').val()) || 0;
    var minutes = parseInt($('#claim_Minutes').val()) || 0;

    var id = $('#ClaimTimeOffModal').data('uid');
    var remarks = $('#claim_remarks').val();
    var current_credits =  $('#ClaimTimeOffModal').data('current');
    // Combine hours, minutes, and default seconds into a single time representation
    var time = hours.toString().padStart(2, '0') + ':' +
        minutes.toString().padStart(2, '0') + ':00';


    // Perform the AJAX request to update
    $.ajax({
        url: 'inc.claim_time_off.php',
        type: 'POST',
        data: { uID: id , current: current_credits, claim:time, remarks:remarks},
        success: function(response) {
            // Show the success alert
            $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> ' + response);
            $('#timeTable').DataTable().ajax.reload();

            // Close the modal
            $('#ClaimTimeOffModal').modal('hide');

            // Close the success alert after 3 seconds
            setTimeout(function() {
                $('#successAlert').removeClass('show').addClass('d-none');
            }, 3000);
        },
        error: function(xhr, status, error) {
            // Show the error alert with the custom error message
            $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> ' + xhr.responseText);

            // Close the modal
            $('#ClaimTimeOffModal').modal('hide');

            // Close the error alert after 3 seconds
            setTimeout(function() {
                $('#errorAlert').removeClass('show').addClass('d-none');
            }, 5000);
        }

    });



});

