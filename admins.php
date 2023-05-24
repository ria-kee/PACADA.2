

<!--jQuery CDN Library-->
<script src="/js/bootstrap/jquery-3.6.0.min.js"></script>

<!--JSZIP for Excel-->
<script src="/js/jszip.cs.js"></script>

<!--TYPEJS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>

<!-- Bootstrap Font Icon CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

<!--BOOTSTRAP LIBRARY-->
<link rel="stylesheet" href="/css/bootstrap/bootstrap.min.css">
<script src="/js/bootstrap/bootstrap.bundle.min.js"></script>

<!--DATATABLE LIBRARY-->
<link rel="stylesheet" href="/css/bootstrap/datatables.min.css">
<script src="/js/bootstrap/datatables.min.js"></script>

<!--CUSTOM CSS-->
<link rel="stylesheet" href="/css/style_admins.css">

<!--CUSTOM JS-->
<script src="/js/script_admins.js"></script>

<!--POPPER-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>


<?php include_once "header/active_admins.php";?>
<?php include('includes/dbh.inc.php');?>



<div class="whole-container">

    <div id="alertContainer" class="position-fixed top-0 end-0 p-3">
        <!-- Success Alert -->
        <div class="alert alert-success alert-dismissible  d-none" role="alert" id="successAlert" >
            <i class="bi-check-circle-fill me-2"></i>
            <strong>Success!</strong>
        </div>

        <!-- Error Alert -->
        <div class="alert alert-danger alert-dismissible  d-none" role="alert" id="errorAlert" >
            <i class="bi-exclamation-octagon-fill me-2"></i>
            <strong>Error!</strong>
        </div>
    </div>






    <div class="body-container">
        <div class="grid-container body-item">
            <div class="grid-item">
                <h3>What are you looking for?</h3>
            </div>


            <div class="grid-item">

            </div>

            <div class="grid-item">
                <div class="search">
                <span class="material-symbols-rounded">search</span>

                <input type="text" class="searchField" placeholder="Search for name, id, or etc.">
                </div>
            </div>



            <div class="grid-item">

            </div>
        </div>
        <div class="button-container body-item">
            <div class="grid-item actions">
                <span class="material-symbols-rounded">sprint</span> <h3>Quick Actions</h3>
            </div>

            <div class="grid-tem"></div>
            <div class="grid-tem"></div>
            <div class="grid-tem actions">
                <span class="material-symbols-rounded">download</span> <h3>Export Table</h3>
            </div>

            <div class="grid-item button1" data-bs-toggle="modal" data-bs-target="#AddAdmin">
                <span class="material-symbols-rounded">add</span>
                <button>Add Admin</button>
            </div>

            <div class="grid-item button2">
                <span class="material-symbols-rounded">visibility</span>
                <button>View Logs</button>
            </div>

            <div class="vl"></div>


            <div class="grid-item">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            File Type
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li> <a class="dropdown-item" type="button" id="excelExport">Excel</a></li>
                            <li><a class="dropdown-item"  type="button" id="">PDF</a></li>
                            <li><a class="dropdown-item"  type="button" id="">Print</a></li>
                        </ul>
                    </div>
            </div>

        </div>
    </div>
    <div class="tablead">
            <table id="adminTable" class="table table-striped" style="width:100%">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Sex</th>
                        <th>Age</th>
                        <th>Department</th>
                        <th data-orderable="false">Options</th>
                    </tr>
                </thead>
                <tbody class="table-striped">

                </tbody>
            </table>
    </div>
</div>

<script type="text/javascript">
    $('#adminTable').DataTable({
        'serverSide': true,
        'processing': true,
        'paging': true,
        'pageLength': 10,
        'lengthChange': false,
        'order': [],
        'ajax': {
            'url': 'fetch_AdminsData.php',
            'type': 'post'
        },
        'fnCreateRow': function(nRow, aData, iDataIndex) {
            $(nRow).atrr('employees_uid', aData[0]);
        },
        'columnsDefs': [{
            'target': 6,
            'orderable': false
        }],
    });
</script>
<script>
    $(document).ready(function() {
        var table = $('#adminTable').DataTable();

        $('.searchField').on('keyup', function() {
            table.search(this.value).draw();
        });
    });
    $('.dataTables_filter').hide();



</script>

<!--EDIT AN ADMIN BUTTON-->
<script>
    $(document).on('click','')
</script>






<!--ADD ADMIN MODAL-->
<div class="modal fade " id="AddAdmin" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <span class="material-symbols-rounded">add_circle</span>
                <h1 class="modal-title" id="exampleModalLabel">Add an Admin</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <fieldset>
                        <div class="mb-3">
                            <label for="Department" class="form-label">From what department?</label>
                            <select id="Department" class="form-select">
                                <option value="1" selected disabled>Select Department</option>
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM departments ORDER BY dept_uid");
                                $departments = array();

                                while ($row = mysqli_fetch_assoc($query)) {
                                    $departmentName = $row['dept_uid'];
                                    $departments[] = $departmentName;
                                }

                                sort($departments);

                                foreach ($departments as $department) {
                                    echo '<option value="' . $department . '">' . $department . '</option>';
                                }
                                ?>

                            </select>
                        </div>

                        <div class="mb-3" id="employeeField" style="display: none;">
                            <label for="Employee" class="form-label">Which Employee?</label>
                            <input class="form-control" list="datalistOptions" id="Employee" placeholder="Enter Employee ID" autocomplete="off" oninput="autoInputHyphen(event)"/>
                            <datalist id="datalistOptions">
                            </datalist>
                        </div>
                        <div id="InvalidEmployeeError"></div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary"  id="addAdminButton">Add as Admin</button>
            </div>
        </div>
    </div>
</div>

<!--FOR ENTER EMPLOYEE ID-->
<script>
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
    }

    // Event listener to prevent input beyond 8 characters
    var inputField = document.getElementById('Employee');
    inputField.addEventListener('keydown', function(event) {
        var value = inputField.value;
        if (value.length >= 8 && event.key !== 'Backspace' && event.key !== 'Delete') {
            event.preventDefault();
        }
    });
</script>
<!--AJAX REQUEST FOR EMPLOYEES UNDER THE SELECTED DEPARTMENT-->
<script>
    // Define an array to store the options fetched through AJAX
    var ajaxOptions = [];

    // Function to reset the selected option, hide the employee field, and clear the input field
    function resetSelectedOption() {
        var departmentSelect = document.getElementById("Department");
        departmentSelect.value = "1";
        document.getElementById('employeeField').style.display = 'none';
        document.getElementById('Employee').value = '';
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
                error: function () {
                    console.log('Error occurred while retrieving employee data.');
                }
            });

            // Show the Employee field
            employeeField.style.display = 'block';
        } else {
            // Hide the Employee field
            employeeField.style.display = 'none';
        }
    });

</script>
<!--ADD ADMIN BUTTON DISABLE/ENABLE-->
<script>
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
</script>
<!--ADD AN ADMIN-->
<script>
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
                    $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> New admin has been added');
                    $('#adminTable').DataTable().ajax.reload();
                    // Close the success alert after 3 seconds
                    setTimeout(function() {
                        $('#successAlert').removeClass('show').addClass('d-none');
                    }, 3000);
                },
                error: function() {
                    // Show the error alert
                    $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> An error occurred while updating the employee is_admin value.');

                    // Close the error alert after 3 seconds
                    setTimeout(function() {
                        $('#errorAlert').removeClass('show').addClass('d-none');
                    }, 3000);
                }
            });

            // Close the modal or perform any other actions
            $('#AddAdmin').modal('hide');
        } else {
            // Display an error message or take appropriate action
            var errorMessage = $('<div class="alert alert-danger">Invalid employee selected. Please choose a valid employee.</div>');
            $('#InvalidEmployeeError').html(errorMessage);
        }
    });
    $('#AddAdmin').on('hidden.bs.modal', function () {
        $('#InvalidEmployeeError').empty(); // Clear the error message
    });
</script>

<!--ADD ADMIN MODAL END-->






