// Get the current date
var currentDate = new Date();

// Extract the day, month, and year from the current date
var day = currentDate.getDate();
var month = currentDate.toLocaleString('default', { month: 'long' }).toUpperCase();;
var year = currentDate.getFullYear();

// Display the current date inside the "Datetitle" element
var dateTitleElement = document.getElementById("Datetitle");
dateTitleElement.textContent = "MONTH OF " + month + "  " + year;

// Get the department select element
var departmentSelect = document.getElementById("Department");
// Get the employee select element
var employeeSelect = document.getElementById("Employee");

function fetchEmployeesByDepartment(departmentId) {
    $.ajax({
        url: "inc.fetch_selected_employees.php",
        type: "GET",
        data: { departmentId: departmentId },
        dataType: "json",
        success: function (employees) {
            // Sort the employees by name in ascending order
            employees.sort(function (a, b) {
                return a.name.localeCompare(b.name);
            });

            // Clear previous options
            employeeSelect.innerHTML = "";

            // Add the selected option based on the number of employees
            var selectedOption = document.createElement("option");
            if (employees.length === 0) {
                selectedOption.value = "";
                selectedOption.textContent = "No Employees";
                selectedOption.disabled = true;
            } else {
                selectedOption.value = "";
                selectedOption.textContent = "Select Employee";
                selectedOption.disabled = true;
            }
            employeeSelect.appendChild(selectedOption);

            // Add the employees as options to the employee select
            employees.forEach(function (employee) {
                var option = document.createElement("option");
                option.value = employee.id;
                option.textContent = employee.name;
                employeeSelect.appendChild(option);
            });

            // Set the selected option to the first option
            employeeSelect.selectedIndex = 0;

        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}


// Add event listener to the department select
departmentSelect.addEventListener("change", function () {
    var selectedDepartment = departmentSelect.value;
    fetchEmployeesByDepartment(selectedDepartment);
    $("#employee-profile").removeClass('show').addClass('d-none');
    $("#leave-form").removeClass('show').addClass('d-none');
});

// Initial population of the employee select
var initialDepartment = departmentSelect.value;
fetchEmployeesByDepartment(initialDepartment);


var current_vacation;
var current_sick;
var current_spl;
var current_force;
var emp_uid;
var emp_dept;

function fetchSelectedEmployee(employeeId) {
    $.ajax({
        url: "inc.fetch_selected_employee.php",
        type: "GET",
        data: { employeeId: employeeId},
        dataType: "json",
        success: function (employee) {
            // Access the retrieved employee information here
            var firstName = employee.employees_FirstName;
            var middleName = employee.employees_MiddleName;
            var lastName = employee.employees_LastName;
            var image = employee.employees_image;
            var dept = employee.employees_Department;

            var vacation  = employee.Leave_Vacation;
            var sick  = employee.Leave_Sick;
            var force  = employee.Leave_Force;
            var spl  = employee.Leave_Special;
            var uid = employee.uID;

            emp_uid=uid;
            current_vacation=vacation;
            current_sick = sick;
            current_force = force;
            current_spl = spl;
            emp_dept =dept;

            // Process the name components to generate the formatted name
            var empName = firstName + ' ';
            if (middleName) {
                empName += middleName.charAt(0) + '. ';
            }
            empName += lastName;

            // Capitalize the first letter of each word
            empName = empName.toLowerCase().replace(/(^|\s)\S/g, function (char) {
                return char.toUpperCase();
            });

            // Use the formatted name to update the HTML element or perform any other operations
            $("#selected_emp").text(empName);
            $("#preview_emp").text(empName);
            $("#empUID").val(uid);
            $("#empDept").val(dept);

            $('#image').attr('src', 'data:image/jpeg;base64,' + image);
            $('#preview_image').attr('src', 'data:image/jpeg;base64,' + image);
            $("#vacation-value").text(vacation);
            $("#sick-value").text(sick);
            $("#force-value").text(force);
            $("#spl-value").text(spl);
            $("#employee-profile").removeClass('d-none').addClass('show');
            $("#leave-form").removeClass('d-none').addClass('show');
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}


// Add event listener to the employee select
employeeSelect.addEventListener("change", function () {
    var selectedEmployee = employeeSelect.value;
    fetchSelectedEmployee(selectedEmployee);
});

var leaveDatesArray = [];

var leave_date = document.getElementById('leave_date');
var dateFeedback = document.getElementById('invalid-date-feedback');

$(document).ready(function() {
    var datesArray = [];

    $('#addDateBtn').on('click', function() {
        var selectedDate = $('#leave_date').val();
        if (selectedDate) {




            // Check if the selected date already exists in the array
            if (datesArray.includes(selectedDate)) {
                dateFeedback.textContent = "Date already exists";
                leave_date.classList.add('is-invalid');
                return; // Exit the function
            }

            datesArray.push(selectedDate);
            $('#leave_date').val(''); // Clear the input field

            // Clear any existing dates
            $('.date-container').remove();

            // Add dates from the array to the container
            datesArray.forEach(function(date) {
                var formattedDate = new Date(date);
                var options = { year: 'numeric', month: 'long', day: 'numeric' };
                var formattedDateString = formattedDate.toLocaleDateString('en-PH', options);

                var dateContainer = $('<div class="date-container"></div>');
                var leaveDate = $('<span class="leave-date"></span>').text(formattedDateString);
                var closeButton = $('<button type="button" class="btn-close" aria-label="Close"></button>');

                closeButton.on('click', function() {
                    var index = datesArray.indexOf(date);
                    if (index !== -1) {
                        datesArray.splice(index, 1);
                        dateContainer.remove();
                    }
                });

                dateContainer.append(leaveDate, closeButton);
                $('.dates').append(dateContainer);
            });


        } else {
            dateFeedback.textContent = "Please enter a date";
            leave_date.classList.add('is-invalid');
        }
        leaveDatesArray = datesArray;

    });
});

leave_date.addEventListener('change', function() {
        dateFeedback.textContent = "";
        leave_date.classList.remove('is-invalid');
});


var leave_type = document.getElementById('leave-type');
var typeFeedback = document.getElementById('invalid-type-feedback');

function validateType() {
    if (leave_type.value === '0') {
        leave_type.classList.add('is-invalid');
        typeFeedback.textContent = 'Leave Type is required.';
        return false;
    } else {
        leave_type.classList.remove('is-invalid');
        typeFeedback.textContent = '';
        return true;
    }
}
leave_type.addEventListener('click',function() {
    leave_type.classList.remove('is-invalid');
    typeFeedback.textContent = '';
});


function validateDate (){
    if (leaveDatesArray.length === 0)  {
        leave_date.classList.add('is-invalid');
        dateFeedback.textContent = 'Leave Date is required.';
        return false;
    } else {
        leave_date.classList.remove('is-invalid');
        dateFeedback.textContent = '';
        return true;
    }
}

var file_submit = document.getElementById("file_submit");

var remarks = document.getElementById('remarks');

var currentFeedback = document.getElementById('current-invalid-feedback');


var leaveType;
var remarks_value;

file_submit.addEventListener('click',function(){
    validateType();
    validateDate();
    leaveType = leave_type.value;
    $("#preview_type").val(leaveType);

    var formattedDates = leaveDatesArray.map(function(date) {
        var formattedDate = new Date(date).toLocaleDateString('en-PH', { month: 'long', day: 'numeric', year: 'numeric' });
        return formattedDate;
    });

    formattedDates.sort(function(a, b) {
        return new Date(a) - new Date(b);
    });

    $("#preview_date").val(formattedDates.join("\n"));
    $("#preview_date").prop("rows", formattedDates.length);


    var remarks_value = remarks.value;
    $("#preview_remarks").val(remarks_value);




    var current;
    var updated;
    var days = leaveDatesArray.length;
    var current_leave;

   if (leaveType === 'Vacation') {
        current_leave = current_vacation;
       $("#credits-prev").removeClass('d-none').addClass('show');
    } else if (leaveType === 'Sick') {
        current_leave = current_sick;
       $("#credits-prev").removeClass('d-none').addClass('show');
    } else if (leaveType === 'Force') {
        current_leave = current_force;
       $("#credits-prev").removeClass('d-none').addClass('show');
    } else if (leaveType === 'Special') {
        current_leave = current_spl;
       $("#credits-prev").removeClass('d-none').addClass('show');
    }

    $("#whatCredit").text("Current " + leaveType + " Credits");
    $("#whatCredit2").text("Updated " + leaveType + " Credits");








    if (current_leave >= days) {
        $("#whatCredit").text("Current " + leaveType + " Credits");
        $("#whatCredit2").text("Updated " + leaveType + " Credits");
        $("#preview_current").removeClass("is-invalid");

        if (leaveType === 'Vacation') {
            current = current_vacation;
            updated = (current - days).toFixed(3);

            $("#preview_current").val(current);
            $("#preview_updated").val(updated);
        }
        else if (leaveType === 'Sick') {
            current = current_sick;
            updated = (current - days).toFixed(3);
            $("#preview_current").val(current);
            $("#preview_updated").val(updated);
        }
        else if (leaveType === 'Force') {
            current = current_force;
            updated = (current - days).toFixed(3);
            $("#preview_current").val(current);
            $("#preview_updated").val(updated);
        }
        else if (leaveType === 'Special') {
            current = current_spl;
            updated = (current - days).toFixed(3);
            $("#preview_current").val(current);
            $("#preview_updated").val(updated);
        }
        currentFeedback.textContent = '';
    }
    else if (leaveType === "Others") {
        $("#preview_current").removeClass("is-invalid");
        $("#credits-prev").addClass('d-none');
    }
    else {
        if (leaveType === 'Vacation') {
            current = current_vacation;
        }
        else if (leaveType === 'Sick') {
            current = current_sick;
        }
        else if (leaveType === 'Force') {
            current = current_force;
        }
        else if (leaveType === 'Special') {
            current = current_spl;
        }
        $("#preview_current").addClass("is-invalid");
        $("#preview_current").val(current);
        $("#preview_updated").val('');
        currentFeedback.textContent = 'Sorry, Insufficient Balance.';
    }







    typeisValid = validateType();
    dateisValid = validateDate();


    if (typeisValid && dateisValid){
        $('#LeavePreview').data('emp_uid', emp_uid);
        $('#LeavePreview').data('emp_dept', emp_dept);
        $('#LeavePreview').data('current_vacation', current_vacation);
        $('#LeavePreview').data('current_sick', current_sick);
        $('#LeavePreview').data('current_force', current_force);
        $('#LeavePreview').data('current_spl', current_spl);
        $('#LeavePreview').data('leaveType', leaveType);
        $('#LeavePreview').data('remarks_value', remarks_value);
        console.error(leaveDatesArray);
        $('#LeavePreview').modal('show');
    }
});

$(document).on('click', '#LeavePreview #FileLeaveSubmit', function() {
    var UID = $('#LeavePreview').data('emp_uid');
    var emp_dept = $('#LeavePreview').data('emp_dept');
    var current_vacation = $('#LeavePreview').data('current_vacation');
    var current_sick = $('#LeavePreview').data('current_sick');
    var current_force = $('#LeavePreview').data('current_force');
    var current_spl = $('#LeavePreview').data('current_spl');
    var LeaveDays = leaveDatesArray.length;
    var LeaveDates = leaveDatesArray;
    var LeaveType =leave_type.value;
    var remarks = $('#LeavePreview').data('remarks_value');
    var current_value;


    if (LeaveType === 'Vacation') {
        current_value = current_vacation;
    } else if (LeaveType === 'Sick') {
        current_value = current_sick;
    } else if (LeaveType === 'Force') {
        current_value = current_force;
    } else if (LeaveType === 'Special') {
        current_value = current_spl;
    } else {
        current_value = 0;
    }



    if (LeaveType === 'Others' || current_value >= LeaveDays) {
        $.ajax({
            url: 'inc.file_leave.php',
            type: 'POST',
            data: {
                LeaveDates: LeaveDates,
                LeaveDays: LeaveDays,
                uID: UID,
                dept: emp_dept,
                type: LeaveType,
                current_vacation: current_vacation,
                current_sick: current_sick,
                current_force: current_force,
                current_spl: current_spl,
                remarks: remarks
            },
            success: function(response) {
                // Show the success alert
                $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> ' + 'Leave is filed successfully!');
                // Close the modal
                $('#LeavePreview').modal('hide');
                // Close the success alert after 3 seconds
                setTimeout(function() {
                    $('#successAlert').removeClass('show').addClass('d-none');
                }, 3000);

                // Go to leave.php after a short delay
                setTimeout(function() {
                    window.location.href = 'leave.php';
                }, 2000);

            },
            error: function(xhr, status, error) {
                // Show the error alert with the custom error message
                $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> ' + xhr.responseText);
                // Close the modal
                $('#LeavePreview').modal('hide');
                // Close the error alert after 3 seconds
                setTimeout(function() {
                    $('#errorAlert').removeClass('show').addClass('d-none');
                }, 5000);
            }
        });
    }
});




