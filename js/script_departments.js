
var deptTable = $('#deptTable').DataTable({
    serverSide: true,
    processing: true,
    paging: true,
    pageLength: 10,
    lengthChange: false,
    order: [],
    ajax: {
        url: 'inc.fetch_Departments.php',
        type: 'post'
    },
    createdRow: function (row, data, dataIndex) {
        $(row).attr('dept_uid', data[0]);
    },
    columnDefs: [{
        targets: [2],
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
                return 'Departments - ' + currentDate.replace(/\//g, '-');
            },
            title: 'Departments'
        },
        {
            extend: 'pdf',
            exportOptions: {
                columns: ':not(:last-child)'
            },
            filename: function() {
                var currentDate = new Date().toLocaleDateString('en-PH');
                return 'Departments - ' + currentDate.replace(/\//g, '-');
            },
            title: 'Departments',
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
    deptTable.button('.buttons-pdf').trigger();
    console.log('Export PDF clicked');
});
// Export Excel
$('#excelExport').click(function() {
    deptTable.button('.buttons-excel').trigger();
    console.log('Export Excel clicked');
});

$(document).ready(function() {

    $('.searchField').on('keyup', function() {
        deptTable.search(this.value).draw();
});
});
    $('.dataTables_filter').hide();


// ADD MODAL
// Function to enable or disable the "Add Department" button
function toggleAddDepartmentButton() {
    var acronymInput = document.getElementById('Acronym');
    var departmentInput = document.getElementById('Department');
    var addDepartmentButton = document.getElementById('addDepartmentButton');

    if (acronymInput.value.trim() === '' || departmentInput.value.trim() === '') {
        addDepartmentButton.disabled = true;
    } else {
        addDepartmentButton.disabled = false;
    }
}

// Listen for changes in the input fields
var acronymInput = document.getElementById('Acronym');
var departmentInput = document.getElementById('Department');

acronymInput.addEventListener('input', toggleAddDepartmentButton);
departmentInput.addEventListener('input', toggleAddDepartmentButton);

// Call the function initially to set the initial state of the button
toggleAddDepartmentButton();

// Clear input fields when modal is closed
var addDeptModal = document.getElementById('AddDept');
addDeptModal.addEventListener('hidden.bs.modal', function() {
    acronymInput.value = '';
    departmentInput.value = '';
    acronymInput.classList.remove('is-valid');
    toggleAddDepartmentButton();
});

function validateAcronym(acronym) {
    return $.ajax({
        url: 'inc.validate_department.php',
        type: 'POST',
        data: { acronym: acronym },
        dataType: 'json'
    });
}

var addDepartmentButton = document.getElementById('addDepartmentButton');
// Inside the event listener for the 'click' event on addDepartmentButton
addDepartmentButton.addEventListener('click', function() {
    var acronymInput = document.getElementById('Acronym');
    var departmentInput = document.getElementById('Department');

    var acronym = acronymInput.value.trim();

    if (acronym === '') {
        // Empty input, display an error message or handle as needed
        var errorMessage = $('<div>Please enter an Acronym.</div>');
        $('#invalid-feedback').html(errorMessage);
        acronymInput.classList.add('is-invalid');
        acronymInput.classList.remove('is-valid');
    } else {
        validateAcronym(acronym)
            .done(function(response) {
                if (response.exists) {
                    // Acronym already exists, display an error message or handle as needed
                    var errorMessage = $('<div>The Acronym already exists, please try another one.</div>');
                    $('#invalid-feedback').html(errorMessage);
                    acronymInput.classList.add('is-invalid');
                    acronymInput.classList.remove('is-valid');
                } else {
                    // Acronym is valid, proceed with adding the department
                    acronymInput.classList.remove('is-invalid');
                    acronymInput.classList.add('is-valid');

                    // Perform the AJAX request to add the department
                    $.ajax({
                        url: 'inc.add_department.php',
                        type: 'POST',
                        data: {
                            acronym: acronym,
                            department: departmentInput.value.trim()
                        },
                        success: function(response) {
                            // Handle the success response
                            // Show the success alert
                            $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> New department has been added.');
                            $('#AddDept').modal('hide');
                            $('#deptTable').DataTable().ajax.reload();
                            // Close the success alert after 3 seconds
                            setTimeout(function() {
                                $('#successAlert').removeClass('show').addClass('d-none');
                            }, 3000);
                        },
                        error: function() {
                            // Handle the error response
                            console.error('An error occurred while adding the department');

                            // Show the error alert
                            $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> An error occurred while adding the department.');
                            $('#AddDept').modal('hide');
                            // Close the error alert after 3 seconds
                            setTimeout(function() {
                                $('#errorAlert').removeClass('show').addClass('d-none');
                            }, 3000);
                        }
                    });
                }
            })
            .fail(function() {
                // Handle the AJAX request failure
                console.error('An error occurred during acronym validation');
            });
    }
});

// Inside the event listener for the 'input' event on the acronym input field
acronymInput.addEventListener('input', function() {
    var acronym = acronymInput.value.trim();

    if (acronym === '') {
        // Empty input
        $('#invalid-feedback').empty();
        acronymInput.classList.remove('is-invalid');
        acronymInput.classList.remove('is-valid');
    } else {
        validateAcronym(acronym)
            .done(function(response) {
                if (response.exists) {
                    // Acronym already exists, display an error message or handle as needed
                    var errorMessage = $('<div>The Acronym already exists, please try another one.</div>');
                    $('#invalid-feedback').html(errorMessage);
                    acronymInput.classList.add('is-invalid');
                    acronymInput.classList.remove('is-valid');
                } else {
                    // Acronym is valid
                    $('#invalid-feedback').empty();
                    acronymInput.classList.remove('is-invalid');
                    acronymInput.classList.add('is-valid');
                }
            })
            .fail(function() {
                // Handle the AJAX request failure
                console.error('An error occurred during acronym validation');
            });
    }
});


//EDIT DEPT

function validateUpdatingAcronym(acronym) {
    return $.ajax({
        url: 'inc.validateUpdatingAcronym.php',
        type: 'POST',
        data: { acronym: acronym },
        dataType: 'json'
    });
}

var edit_acronym = document.getElementById('editAcronym');
var edit_department = document.getElementById('editDepartment');
var updateButton = document.getElementById('EditDepartmentButton');
var current_acronym;
var current_department;
var uid;

function toggleEditDepartmentButton() {
    if (edit_acronym.value.trim() === '' || edit_department.value.trim() === '') {
        updateButton.disabled = true;
    } else {
        updateButton.disabled = false;
    }
}

// Listen for changes in the input fields
edit_acronym.addEventListener('input', toggleEditDepartmentButton);
edit_department.addEventListener('input', toggleEditDepartmentButton);

$(document).on('click', '.edit-button', function() {
    var deptId = $(this).data('deptid');

    // AJAX call to fetch department details
    $.ajax({
        url: 'inc.find_department.php',
        type: 'POST',
        data: {deptId: deptId},
        dataType: 'json',
        success: function (response) {
            // Populate the modal with the fetched department details
            if (response.error) {
                console.error(response.error);
                return;
            }
            updateButton.disabled = true;
            edit_acronym.value = response.dept_uid;
            edit_department.value = response.dept_Description;
            current_acronym = response.dept_uid;
            current_department = response.dept_Description;
            uid = response.uID;
            $('#EditDept').modal('show');
        },
        error: function () {
            console.error('An error occurred while fetching department details');
            // Display an error message
        }
    });
});

// Call the function initially to set the initial state of the button
toggleEditDepartmentButton();

var editDeptModal = document.getElementById('EditDept');
editDeptModal.addEventListener('hidden.bs.modal', function() {
    updateButton.disabled = true;
    edit_acronym.classList.remove('is-valid');
    edit_acronym.classList.remove('is-invalid');
    edit_department.classList.remove('is-valid');
    edit_department.classList.remove('is-invalid');
    $('#acronym-invalid-feedback').empty();
});
updateButton.addEventListener('click',function (){

    var acronym = edit_acronym.value.trim();

    if (acronym === '') {
        // Empty input, display an error message or handle as needed
        var errorMessage = $('<div>Please enter an Acronym.</div>');
        $('#acronym-invalid-feedback').html(errorMessage);
        edit_acronym.classList.add('is-invalid');
        edit_acronym.classList.remove('is-valid');
    }

    else {
            validateUpdatingAcronym(acronym)
                .done(function(response) {
                    if (response.exists === false) {
                        // Acronym is valid, proceed with adding the department
                        $('#acronym-invalid-feedback').empty();
                        edit_acronym.classList.remove('is-invalid');
                        edit_acronym.classList.add('is-valid');

                        $.ajax({
                            url: 'inc.update_department.php',
                            type: 'POST',
                            data: {
                                acronym: acronym,
                                department: edit_department.value.trim(),
                                uid: uid
                            },

                            success: function(response) {
                                // Handle the success response
                                // Show the success alert
                                $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong>Department has been updated successfully.');
                                $('#EditDept').modal('hide');
                                $('#deptTable').DataTable().ajax.reload();
                                // Close the success alert after 3 seconds
                                setTimeout(function() {
                                    $('#successAlert').removeClass('show').addClass('d-none');
                                }, 3000);
                            },
                            error: function() {
                                // Handle the error response
                                console.error('An error occurred while adding the department');
                                // Show the error alert
                                $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> An error occurred while updating the department.');
                                $('#EditDept').modal('hide');
                                // Close the error alert after 3 seconds
                                setTimeout(function() {
                                    $('#errorAlert').removeClass('show').addClass('d-none');
                                }, 3000);
                            }
                        });
                    }
                    else if (response.exists !== current_acronym) {
                        // Acronym already exists, display an error message or handle as needed
                        var errorMessage = $('<div>The Acronym already exists, please try another one.</div>');
                        $('#acronym-invalid-feedback').html(errorMessage);
                        edit_acronym.classList.add('is-invalid');
                        edit_acronym.classList.remove('is-valid');
                        updateButton.disabled = true;
                    }
                    else {
                        $.ajax({
                            url: 'inc.update_department.php',
                            type: 'POST',
                            data: {
                                acronym: acronym,
                                department: edit_department.value.trim(),
                                uid: uid
                            },

                            success: function(response) {
                                // Handle the success response
                                // Show the success alert
                                $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong>Department has been updated successfully.');
                                $('#EditDept').modal('hide');
                                $('#deptTable').DataTable().ajax.reload();
                                // Close the success alert after 3 seconds
                                setTimeout(function() {
                                    $('#successAlert').removeClass('show').addClass('d-none');
                                }, 3000);
                            },
                            error: function() {
                                // Handle the error response
                                console.error('An error occurred while adding the department');
                                // Show the error alert
                                $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> An error occurred while updating the department.');
                                $('#EditDept').modal('hide');
                                // Close the error alert after 3 seconds
                                setTimeout(function() {
                                    $('#errorAlert').removeClass('show').addClass('d-none');
                                }, 3000);
                            }
                        });
                    }
                 });
             }
    });
edit_department.addEventListener('input', function() {

    if (edit_department.value.trim() === ''){
        // Empty input
        var errorMessage = $('<div>Please enter Department.</div>');
        $('#department-invalid-feedback').html(errorMessage);
        edit_department.classList.add('is-invalid');
    }
    else {
        $('#department-invalid-feedback').empty();
        edit_department.classList.remove('is-invalid');
        edit_department.classList.add('is-valid');
    }

});
edit_acronym.addEventListener('input', function() {
    var acronym = edit_acronym.value.trim();



    if (edit_acronym.value.trim() === '') {
        // Empty input
        edit_acronym.classList.remove('is-valid');
        var errorMessage = $('<div>Please enter an Acronym.</div>');
        $('#acronym-invalid-feedback').html(errorMessage);
        edit_acronym.classList.add('is-invalid');
    }

    else {
        validateUpdatingAcronym(acronym)
            .done(function(response) {

                if (response.exists === false) {
                    // Acronym is valid, proceed with adding the department
                    console.log('Acronym is valid');
                    $('#acronym-invalid-feedback').empty();
                    edit_acronym.classList.remove('is-invalid');
                    edit_acronym.classList.add('is-valid');
                } else if (response.exists !== current_acronym) {
                    // Acronym already exists, display an error message or handle as needed
                    console.log('Acronym already exists');
                    var errorMessage = $('<div>The Acronym already exists, please try another one.</div>');
                    $('#acronym-invalid-feedback').html(errorMessage);
                    edit_acronym.classList.add('is-invalid');
                    edit_acronym.classList.remove('is-valid');
                    updateButton.disabled = true;
                }
            })
            .fail(function() {
                // Handle the AJAX request failure
                console.error('An error occurred during acronym validation');
            });
    }
});


//DELETE DEPT
$(document).on('click', '.remove-button', function() {
    var uID = $(this).data('id');
    var acronyms = $(this).data('acronyms');
    $('#deptName').text(acronyms);
    $('#RemoveDept').modal('show'); // Show the confirmation modal
    // Store the dept ID to be used later for archive;
    $('#RemoveDept').data('uID', uID);
});


$(document).on('click', '#RemoveDept .btn-danger', function() {
    var UID = $('#RemoveDept').data('uID');

    // Perform the AJAX request to remove the admin
    $.ajax({
        url: 'inc.remove_department.php',
        type: 'POST',
        data: { uID: UID },
        success: function(response) {
            // Show the success alert
            $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> ' + response);
            $('#deptTable').DataTable().ajax.reload();

            // Close the modal
            $('#RemoveDept').modal('hide');

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

            // Close the error alert after 3 seconds
            setTimeout(function() {
                $('#errorAlert').removeClass('show').addClass('d-none');
            }, 5000);
        }

    });
});




