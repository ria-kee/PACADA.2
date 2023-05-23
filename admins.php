

<!--jQuery CDN Library-->
<script src="/js/bootstrap/jquery-3.6.0.min.js"></script>



<!--BOOTSTRAP LIBRARY-->
<link rel="stylesheet" href="/css/bootstrap/bootstrap.min.css">
<script src="/js/bootstrap/bootstrap.bundle.min.js"></script>

<!--DATATABLE LIBRARY-->
<link rel="stylesheet" href="/css/bootstrap/datatables.min.css">
<script src="/js/bootstrap/datatables.min.js"></script>

<!--CUSTOM CSS-->
<link rel="stylesheet" href="/css/style_admins.css">

<!--DROPDOWN ARROW-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<!--CUSTOM JS-->
<script src="/js/script_admins.js"></script>


<!--POPPER-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>


<?php include_once "header/active_admins.php";?>
<?php include('includes/dbh.inc.php');?>

<div class="whole-container">
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
                <button>Search</button>
            </div>
        </div>
        <div class="button-container body-item">
            <div class="grid-item">
                <h3>Actions</h3>
            </div>

            <div class="grid-tem"></div>

            <div class="grid-item button1" data-bs-toggle="modal" data-bs-target="#AddAdmin">
                <span class="material-symbols-rounded">add</span>
                <button>Add Admin</button>
            </div>

            <div class="grid-item button2">
                <span class="material-symbols-rounded">visibility</span>
                <button>View Logs</button>
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
            'url': 'fetchData.php',
            'type': 'post'
        },
        'fnCreateRow': function(nRow, aData, iDataIndex) {
            $(nRow).atrr('adminsUid', aData[0]);
        },
        'columnsDefs': [{
            'target': 6,
            'orderable': false
        }]

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




<!--ADD ADMIN MODAL-->
<div class="modal fade" id="AddAdmin" tabindex="-1">
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
                                <option selected disabled>Select Department</option>
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
                            <input class="form-control" list="datalistOptions" id="Employee" placeholder="Enter Employee Name" autocomplete="off">
                            <datalist id="datalistOptions">
                            </datalist>
                        </div>


                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Define an array to store the options fetched through AJAX
    var ajaxOptions = [];

    // Function to reset the selected option, hide the employee field, and clear the input field
    function resetSelectedOption() {
        var departmentSelect = document.getElementById("Department");
        departmentSelect.value = "";
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
                        optionElement.value = option.employeeName;
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
                        employeeInput.placeholder = 'Enter Employee Name';
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


<!--ADD ADMIN MODAL END-->






