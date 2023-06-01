$(document).ready(function() {
    var deptTable = $('#deptTable').DataTable({
        serverSide: true,
        processing: true,
        paging: true,
        pageLength: 10,
        lengthChange: false,
        order: [],
        ajax: {
            url: 'fetch_ArchivedDept.php',
            type: 'post'
        },
        createdRow: function(row, data, dataIndex) {
            $(row).attr('dept_uid', data[0]);
        },
        columnDefs: [{
            targets: [0], // Target the first column (checkbox column)
            className: 'text-right',
            orderable: false,
        }, {
            targets: [1, 2], // Adjust the target indices for the "Acronym" and "Department" columns
            orderable: true // Enable column ordering for these columns
        }, {
            targets: [3], // Adjust the target index for the "Options" column
            orderable: false
        }]
    });

    $('.searchField').on('keyup', function() {
        deptTable.search(this.value).draw();
    });

    $('.dataTables_filter').hide();

    var deleteAllButton = $('#deleteAllButton');
    var selectedData = []; // Array to store the selected data

    // Function to check the checkbox state and enable/disable the button
    function checkCheckboxState() {
        var checkboxes = $('#deptTable').find('.form-check-input');
        var checkedCount = checkboxes.filter(':checked').length;

        if (checkedCount === 0) {
            deleteAllButton.prop('disabled', true); // Disable the button
        } else {
            deleteAllButton.prop('disabled', false); // Enable the button
        }
    }

    // Function to get the values of the selected checkboxes
    function getSelectedValues() {
        var checkboxes = $('#deptTable').find('.form-check-input:checked');
        selectedData = checkboxes.map(function() {
            var deptUid = $(this).val();
            var acronyms = $(this).closest('tr').find('td:nth-child(1)').text();
            var department = $(this).closest('tr').find('td:nth-child(2)').text();

            // Create an object with the collected data
            return {
                deptUid: deptUid,
                acronyms: acronyms,
                department: department
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

    deleteAllButton.on('click', function() {
        // Clear any previous values
        $('#selectedValues').empty();

        // Display the selected values
        if (selectedData.length > 0) {
            for (var i = 0; i < selectedData.length; i++) {
                var value = selectedData[i];
                var row = $('<div>').text('Dept UID: ' + value.deptUid);
                $('#selectedValues').append(row);
            }

            // Show the modal
            $('#DeleteAll').modal('show');
        }
    });

    $('#yes').on('click', function() {
        // Array to store the department IDs to be deleted
        var deptIdsToDelete = [];

        // Extract the department IDs from selectedData, ignoring the value 0
        for (var i = 0; i < selectedData.length; i++) {
            var deptUid = selectedData[i].deptUid;
            if (deptUid !== '0') {
                deptIdsToDelete.push(deptUid);
            }
        }


        // Perform the deletion action using the deptIdsToDelete array
        $.ajax({
            url: 'delete_departments.php',
            type: 'POST',
            data: { deptIds: deptIdsToDelete },
            success: function(response) {
                // Show the success alert
                $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> ' + response);
                $('#deptTable').DataTable().ajax.reload();

                // Close the modal
                $('#RemoveDept').modal('hide');
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
                $('#RemoveDept').modal('hide');
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
        var checkboxes = $('#deptTable').find('.form-check-input');
        checkboxes.prop('checked', this.checked);
    });



    var deptUid ='';
    var acronyms = '';
    var department = '';

    //DELETE A DEPARTMENT
    $(document).on('click', '.remove-button', function() {
         deptUid = $(this).data('id');
         acronyms = $(this).data('acronyms');
         department = $(this).data('department');


        $('#deptName').text(acronyms + " - " + department);
        $('#DeleteDept').modal('show');
    });



    $('#yess').on('click', function() {
        $.ajax({
            url: 'delete_department.php',
            type: 'POST',
            data: { uID: deptUid, acronym: acronyms },
            success: function(response) {
                // Show the success alert
                $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> ' + response);
                $('#deptTable').DataTable().ajax.reload();

                // Close the modal
                $('#RemoveDept').modal('hide');
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
                $('#RemoveDept').modal('hide');
                // Uncheck the selectAllCheckbox
                $('#selectAllCheckbox').prop('checked', false);

                // Close the error alert after 5 seconds
                setTimeout(function() {
                    $('#errorAlert').removeClass('show').addClass('d-none');
                }, 5000);
            }
        });

        // Close the modal
        $('#DeleteDept').modal('hide');
    });








    // Function to check the checkbox state and enable/disable the button
    function checkCheckboxState() {
        var checkboxes = $('#deptTable').find('.form-check-input');
        var checkedCount = checkboxes.filter(':checked').length;
        var rowCount = deptTable.rows().count(); // Get the number of rows in the DataTable

        if (checkedCount === 0 || rowCount === 0) {
            deleteAllButton.prop('disabled', true); // Disable the button
        } else {
            deleteAllButton.prop('disabled', false); // Enable the button
        }
    }

});
