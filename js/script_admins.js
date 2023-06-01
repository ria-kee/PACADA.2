// POPULATE ADMIN TABLE
var table = $('#adminTable').DataTable({
    serverSide: true,
    processing: true,
    paging: true,
    pageLength: 10,
    lengthChange: false,
    order: [],
    ajax: {
        url: 'fetch_AdminsData.php',
        type: 'post'
    },
    createdRow: function (row, data, dataIndex) {
        $(row).attr('employees_uid', data[0]);
    },
    columnDefs: [{
        targets: [7],
        orderable: false
    }],
    buttons: [
        {
            extend: 'excel',
            exportOptions: {
                columns: ':not(:last-child)'
            },
            filename: function() {
                var currentDate = new Date().toLocaleDateString('en-PH');
                return 'PACADA Administrators - ' + currentDate.replace(/\//g, '-');
            },
            title: 'PACADA Administrators'
        },
        {
            extend: 'pdf',
            exportOptions: {
                columns: ':not(:last-child)'
            },
            filename: function() {
                var currentDate = new Date().toLocaleDateString('en-PH');
                return 'PACADA Administrators - ' + currentDate.replace(/\//g, '-');
            },
            title: 'PACADA Administrators',
            customize: function (doc) {
                // Set the table alignment to center
                doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                doc.content[1].table.alignment = 'center';

                // Apply striped color effect to table rows
                doc.content[1].table.body.forEach(function (row, rowIndex) {
                    row.forEach(function (cell, cellIndex) {
                        if (rowIndex % 2 === 0) {
                            cell.fillColor = '#E9E9FF'; //first color for striped effect
                        } else {
                            cell.fillColor = '#FFFFFF'; //second color for striped effect
                        }
                    });
                });

                // Customize the table header color
                doc.content[1].table.headerRows = 1;
                doc.content[1].table.body[0].forEach(function (headerCell) {
                    headerCell.fillColor = '#7D7DD2'; // Specify the color for the table header
                });
                // Customize the title style
                var title = doc.content[0].text[0];
                title.bold = true; // Make the title text bold
            },
            didDrawPage: function (data) {
                // Add a striped background to the table in the exported PDF
                var pageSize = data.pageSize;
                var pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
                var table = data.content[1].table;
                var rowHeight = table.body[0].height ? table.body[0].height : table.height;
                var rowCount = table.body.length;
                var tableHeight = rowHeight * rowCount;
                var midPagePos = (pageHeight - tableHeight) / 2;

                data.content[1].table.body.forEach(function (row, rowIndex) {
                    row.forEach(function (cell) {
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
    table.button('.buttons-pdf').trigger();
    console.log('Export PDF clicked');
});

// Export Excel
$('#excelExport').click(function() {
    table.button('.buttons-excel').trigger();
    console.log('Export Excel clicked');

});


    $(document).ready(function() {


    $('.searchField').on('keyup', function() {
    table.search(this.value).draw();
});
});
    $('.dataTables_filter').hide();

<!--AJAX REQUEST FOR EMPLOYEES UNDER THE SELECTED DEPARTMENT-->

// Define an array to store the options fetched through AJAX
var ajaxOptions = [];

// Function to reset the selected option, hide the employee field, and clear the input field
function resetSelectedOption() {
    var departmentSelect = document.getElementById("Department");
    departmentSelect.value = "0";
    document.getElementById('employeeField').style.display = 'none';
    document.getElementById('Employee').value = '';
    const inputElement = document.getElementById("Employee");
    inputElement.classList.remove("is-valid");
    inputElement.classList.remove("is-invalid");
}

// Execute the reset function when the modal is closed
var modal = document.getElementById("AddAdmin");
modal.addEventListener("hidden.bs.modal", resetSelectedOption);

// Listen for changes in the Department select field
var departmentSelect = document.getElementById('Department');
departmentSelect.addEventListener('change', function () {
    var selectedDepartment = this.value;
    var employeeField = document.getElementById('employeeField');
    var employeeInput = document.getElementById('Employee');
    var datalistOptions = document.getElementById('datalistOptions');

    if (selectedDepartment !== null && selectedDepartment !== "0") {
        // Make an AJAX request to retrieve the employees for the selected department
        $.ajax({
            url: 'fetch_employees.php',
            type: 'POST',
            data: { department: selectedDepartment },
            dataType: 'json',
            success: function (response) {
                // Store the fetched options in the ajaxOptions array
                ajaxOptions = response;

                // Populate the datalist with the options
                datalistOptions.innerHTML = '';

                ajaxOptions.forEach(function(option) {
                    var optionElement = document.createElement('option');
                    optionElement.value = option.employeeID;
                    datalistOptions.appendChild(optionElement);
                });

                if (ajaxOptions.length === 0) {
                    // Disable the input field and set the placeholder
                    employeeInput.value = ''; // Clear the existing input
                    employeeInput.disabled = true;
                    employeeInput.placeholder = 'No available employees';
                } else {
                    // Enable the input field and remove the placeholder
                    employeeInput.disabled = false;
                    employeeInput.placeholder = 'Enter Employee ID';
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX Request Error:', error);
            }
        });

        // Show the Employee field
        employeeField.style.display = 'block';
    } else {
        // Hide the Employee field
        employeeField.style.display = 'none';
    }
});



<!--FOR ENTER EMPLOYEE ID-->
    function autoInputHyphen(event) {
    var input = document.getElementById('Employee');
    var value = input.value.trim();

    // Limit input to uppercase letters for the first two characters
    if (value.length === 1 || value.length === 2) {
    value = value.toUpperCase().replace(/[^A-Z]/g, '');
    input.value = value;
} else {
    // Capitalize all letters
    value = value.toUpperCase();
    input.value = value;
}


    // Check if hyphen is already present
    if (value.indexOf('-') !== -1) {
    var parts = value.split('-');
    var prefix = parts[0];
    var suffix = parts[1];

    // Limit input to 4 numbers after hyphen
    suffix = suffix.replace(/\D/g, '').slice(0, 4);
    input.value = prefix + '-' + suffix;
}

    if (value.length === 3 && event.inputType !== 'deleteContentBackward') {
    input.value = value + '-';
}

        // Add or remove "is-valid" class based on conditions
        var dataListOptions = document.getElementById('datalistOptions').options;
        var matchedOption = Array.from(dataListOptions).find(option => option.value === value);
        if (matchedOption) {
            input.classList.add('is-valid');
        } else {
            input.classList.remove('is-valid');
        }
}

    // Event listener to prevent input beyond 8 characters
    var inputField = document.getElementById('Employee');
    inputField.addEventListener('keydown', function(event) {
    var value = inputField.value;
    if (value.length >= 9 && event.key !== 'Backspace' && event.key !== 'Delete') {
    event.preventDefault();
}
});




<!--ADD ADMIN BUTTON DISABLE/ENABLE-->
    // Function to enable or disable the "Add as Admin" button and update the title
    function toggleAddAdminButton() {
    var employeeField = document.getElementById('employeeField');
    var employeeInput = document.getElementById('Employee');
    var addAdminButton = document.getElementById('addAdminButton');

    if (employeeField.style.display === 'none' || employeeInput.value.trim() === '') {
    addAdminButton.disabled = true;
    addAdminButton.title = "Employee required";
} else {
    addAdminButton.disabled = false;
    addAdminButton.title = "Assign Employee as Admin";
}
}

    // Listen for changes in the Employee input field
    var employeeInput = document.getElementById('Employee');
    employeeInput.addEventListener('input', toggleAddAdminButton);

    // Execute the toggle function initially
    toggleAddAdminButton();




<!--ADD AN ADMIN BUTTON-->
$('#addAdminButton').click(function() {
    // Get the selected department and employee ID
    var selectedDepartment = $('#Department').val();
    var employeeID = $('#Employee').val();

    // Check if the employee ID is in the ajaxOptions array
    var isValidEmployee = ajaxOptions.some(function(option) {
        return option.employeeID === employeeID;
    });

    // Function to close the alerts after a delay
    function closeAlerts() {
        $('#successAlert').removeClass('show');
        $('#errorAlert').removeClass('show');
    }

    if (isValidEmployee) {
        // Perform the AJAX request to update the employee's is_admin value
        $.ajax({
            url: 'add_admin.php',
            type: 'POST',
            data: { employeeID: employeeID, isAdmin: 1 },
            success: function(response) {
                // Show the success alert
                $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> New admin has been added.');
                $('#adminTable').DataTable().ajax.reload();
                // Close the success alert after 3 seconds
                setTimeout(function() {
                    $('#successAlert').removeClass('show').addClass('d-none');
                }, 3000);
            },
            error: function() {
                // Show the error alert
                $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> An error occurred while assigning the employee as admin.');

                // Close the error alert after 3 seconds
                setTimeout(function() {
                    $('#errorAlert').removeClass('show').addClass('d-none');
                }, 3000);
            }
        });

        // Close the modal or perform any other actions
        $('#AddAdmin').modal('hide');

    } else {
        // Display an error message
        var errorMessage = $('<div>Invalid employee selected. Please choose a valid employee.</div>');
        $('#InvalidEmployeeError').html(errorMessage);
        const inputElement = document.getElementById("Employee");
        inputElement.classList.add("is-invalid");
    }
});
$('#AddAdmin').on('hidden.bs.modal', function () {
    $('#InvalidEmployeeError').empty(); // Clear the error message
});





<!--REMOVE AN ADMIN BUTTON-->
$(document).on('click', '.remove-admin-button', function() {
    var employeeID = $(this).data('employeeid');
    var adminName = $(this).data('adminname');
    $('#adminName').text(adminName);
    $('#confirmModal').modal('show'); // Show the confirmation modal
    // Store the employee ID to be used later for removal
    $('#confirmModal').data('employeeid', employeeID);
});

$(document).on('click', '#confirmModal .btn-danger', function() {
    var employeeID = $('#confirmModal').data('employeeid');
    // Perform the AJAX request to remove the admin
    $.ajax({
        url: 'remove_admin.php',
        type: 'POST',
        data: { employees_ID: employeeID },
        success: function(response) {
            // Show the success alert
            $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> ' + response);
            $('#adminTable').DataTable().ajax.reload();

            // Close the modal
            $('#confirmModal').modal('hide');

            // Close the success alert after 3 seconds
            setTimeout(function() {
                $('#successAlert').removeClass('show').addClass('d-none');
            }, 3000);
        },
        error: function() {
            // Show the error alert
            $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> An error occurred while removing the admin.');

            // Close the modal
            $('#confirmModal').modal('hide');

            // Close the error alert after 3 seconds
            setTimeout(function() {
                $('#errorAlert').removeClass('show').addClass('d-none');
            }, 3000);
        }
    });
});
