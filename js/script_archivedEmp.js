$(document).ready(function() {
    var empTable = $('#empTable').DataTable({
        serverSide: true,
        processing: true,
        paging: true,
        pageLength: 10,
        lengthChange: false,
        order: [],
        ajax: {
            url: 'fetch_ArchivedEmp.php',
            type: 'post'
        },
        createdRow: function(row, data, dataIndex) {
            $(row).attr('uID', data[0]);
        },
        columnDefs: [{
            targets: [0], // Target the first column (checkbox column)
            className: 'text-right',
            orderable: false,
        }, {
            targets: [1-7], // Adjust the target indices for the "Acronym" and "Department" columns
            orderable: true // Enable column ordering for these columns
        }, {
            targets: [8], // Adjust the target index for the "Options" column
            orderable: false
        }]
    });

    $('.searchField').on('keyup', function() {
        empTable.search(this.value).draw();
    });
    $('.dataTables_filter').hide();

    var deleteAllButton = $('#deleteAllButton');
    var activateAllButton = $('#activateAllButton');
    var selectedData = []; // Array to store the selected data

    // Function to check the checkbox state and enable/disable the button
    function checkCheckboxState() {
        var checkboxes = $('#empTable').find('.form-check-input');
        var checkedCount = checkboxes.filter(':checked').length;

        if (checkedCount === 0) {
            deleteAllButton.prop('disabled', true); // Disable the button
            activateAllButton.prop('disabled', true); // Disable the button
        } else {
            deleteAllButton.prop('disabled', false); // Enable the button
            activateAllButton.prop('disabled', false); // Enable the button
        }
    }

    // Function to get the values of the selected checkboxes
    function getSelectedValues() {
        var checkboxes = $('#empTable').find('.form-check-input:checked');
        selectedData = checkboxes.map(function() {
            var ID = $(this).val();
            var empID = $(this).closest('tr').find('td:nth-child(1)').text();

            // Create an object with the collected data
            return {
                ID: ID,
                empID: empID
            };
        }).get();

        return selectedData;
    }

    // Call the function on page load
    checkCheckboxState();

    // Call the function whenever a checkbox is clicked
    $(document).on('change', '.form-check-input', function() {
        checkCheckboxState();
        selectedData = getSelectedValues(); // Update the selectedData array
    });


    // DELETE ALL
    deleteAllButton.on('click', function() {
        // Clear any previous values
        $('#selectedValues').empty();

        // Display the selected values
        if (selectedData.length > 0) {
            for (var i = 0; i < selectedData.length; i++) {
                var value = selectedData[i];
                var row = $('<div>').text('Employee ID: ' + value.ID);
                $('#selectedValues').append(row);
            }

            // Show the modal
            $('#DeleteAll').modal('show');
        }
    });

    $('#yes').on('click', function() {
        // Array to store the department IDs to be deleted
        var empIdsToDelete = [];

        // Extract the employee IDs from selectedData, ignoring the value 0
        for (var i = 0; i < selectedData.length; i++) {
            var ID = selectedData[i].ID;
            if (ID !== '0') {
                empIdsToDelete.push(ID);
            }
        }


        // Perform the deletion action using the empIdsToDelete array
        $.ajax({
            url: 'delete_employees.php',
            type: 'POST',
            data: { empIds: empIdsToDelete },
            success: function(response) {
                // Show the success alert
                $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> ' + response);
                $('#empTable').DataTable().ajax.reload();

                // Close the modal
                $('#DeleteEmp').modal('hide');
                // Uncheck the selectAllCheckbox
                $('#selectAllCheckbox').prop('checked', false);

                // Close the success alert after 3 seconds
                setTimeout(function() {
                    $('#successAlert').removeClass('show').addClass('d-none');
                }, 3000);
            },
            error: function(xhr, status, error) {
                // Show the error alert with the custom error message
                $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> ' + xhr.responseText);

                // Close the modal
                $('#DeleteAll').modal('hide');
                // Uncheck the selectAllCheckbox
                $('#selectAllCheckbox').prop('checked', false);

                // Close the error alert after 5 seconds
                setTimeout(function() {
                    $('#errorAlert').removeClass('show').addClass('d-none');
                }, 5000);
            }
        });

        // Close the modal or perform any other necessary actions
        $('#DeleteAll').modal('hide');
        // Uncheck the selectAllCheckbox
        $('#selectAllCheckbox').prop('checked', false);

    });

    $('#selectAllCheckbox').on('change', function() {
        var checkboxes = $('#empTable').find('.form-check-input');
        checkboxes.prop('checked', this.checked);
    });



    // ACTIVATE ALL

    activateAllButton.on('click', function() {
        // Clear any previous values
        $('#selectedValues').empty();

        // Display the selected values
        if (selectedData.length > 0) {
            for (var i = 0; i < selectedData.length; i++) {
                var value = selectedData[i];
                var row = $('<div>').text('Employee ID: ' + value.ID);
                $('#selectedValues').append(row);
            }

            // Show the modal
            $('#ActivateAll').modal('show');
        }
    });

$('#activate-all-yes').on('click', function() {
    // Array to store the department IDs to be deleted
    var EmpIdsToActivate = [];

    // Extract the department IDs from selectedData, ignoring the value 0
    for (var i = 0; i < selectedData.length; i++) {
        var ID = selectedData[i].ID;
        if (ID !== '0') {
            EmpIdsToActivate.push(ID);
        }
    }
    console.error('EmpIdsToActivate',EmpIdsToActivate);


    // Perform the activation action using the deptIdsToActivate array
    $.ajax({
        url: 'activate_employees.php',
        type: 'POST',
        data: { empIds: EmpIdsToActivate },
        success: function(response) {
            // Show the success alert
            $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> ' + response);
            $('#empTable').DataTable().ajax.reload();

            // Close the modal
            $('#ActivateAll').modal('hide');
            // Uncheck the selectAllCheckbox
            $('#selectAllCheckbox').prop('checked', false);

            // Close the success alert after 3 seconds
            setTimeout(function() {
                $('#successAlert').removeClass('show').addClass('d-none');
            }, 3000);
        },
        error: function(xhr, status, error) {
            // Show the error alert with the custom error message
            $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> ' + xhr.responseText);

            // Close the modal
            $('#ActivateAll').modal('hide');
            // Uncheck the selectAllCheckbox
            $('#selectAllCheckbox').prop('checked', false);

            // Close the error alert after 5 seconds
            setTimeout(function() {
                $('#errorAlert').removeClass('show').addClass('d-none');
            }, 5000);
        }
    });

    // Close the modal or perform any other necessary actions
    $('#ActivateAll').modal('hide');
    // Uncheck the selectAllCheckbox
    $('#selectAllCheckbox').prop('checked', false);

});








    var id;
    var empid;
    var empname;


    //DELETE AN EMPLOYEE
    $(document).on('click', '.remove-button', function() {
        id = $(this).data('id');
        empid = $(this).data('empid');
        empname = $(this).data('empname');


        $('#empName').text(empid + " : " + empname);
        $('#DeleteEmp').modal('show');
    });
    $('#yess').on('click', function() {
        $.ajax({
            url: 'delete_employee.php',
            type: 'POST',
            data: { id: id, empid: empid, empname: empname },
            success: function(response) {
                // Show the success alert
                $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> ' + response);
                $('#empTable').DataTable().ajax.reload();

                // Close the modal
                $('#DeleteEmp').modal('hide');
                // Uncheck the selectAllCheckbox
                $('#selectAllCheckbox').prop('checked', false);

                // Close the success alert after 3 seconds
                setTimeout(function() {
                    $('#successAlert').removeClass('show').addClass('d-none');
                }, 3000);
            },
            error: function(xhr, status, error) {
                // Show the error alert with the custom error message
                $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> ' + xhr.responseText);

                // Close the modal
                $('#DeleteEmp').modal('hide');
                // Uncheck the selectAllCheckbox
                $('#selectAllCheckbox').prop('checked', false);

                // Close the error alert after 5 seconds
                setTimeout(function() {
                    $('#errorAlert').removeClass('show').addClass('d-none');
                }, 5000);
            }
        });

        // Close the modal
        $('#DeleteEmp').modal('hide');
    });


    // ACTIVATE AN EMPLOYEE
    $(document).on('click', '.activate-button', function() {
        id = $(this).data('id');
        empid = $(this).data('empid');
        empname = $(this).data('empname');

        $('#act_empName').text(empid + ": " + empname);
        $('#ActivateEmp').modal('show');
    });


    $('#activate-yes').on('click', function() {
        $.ajax({
            url: 'activate_employee.php',
            type: 'POST',
            data: { uID: id, empname: empname },
            success: function(response) {
                // Show the success alert
                $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> ' + response);
                $('#empTable').DataTable().ajax.reload();

                // Close the modal
                $('#ActivateEmp').modal('hide');
                // Uncheck the selectAllCheckbox
                $('#selectAllCheckbox').prop('checked', false);

                // Close the success alert after 3 seconds
                setTimeout(function() {
                    $('#successAlert').removeClass('show').addClass('d-none');
                }, 3000);
            },
            error: function(xhr, status, error) {
                // Show the error alert with the custom error message
                $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> ' + xhr.responseText);

                // Close the modal
                $('#ActivateEmp').modal('hide');
                // Uncheck the selectAllCheckbox
                $('#selectAllCheckbox').prop('checked', false);

                // Close the error alert after 5 seconds
                setTimeout(function() {
                    $('#errorAlert').removeClass('show').addClass('d-none');
                }, 5000);
            }
        });

        // Close the modal
        $('#ActivateEmp').modal('hide');
    });




});





