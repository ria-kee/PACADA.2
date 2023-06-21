// Get the current date
var currentDate = new Date();

// Extract the day, month, and year from the current date
var day = currentDate.getDate();
var month = currentDate.toLocaleString('default', { month: 'long' }).toUpperCase();;
var year = currentDate.getFullYear();

// Display the current date inside the "Datetitle" element
var dateTitleElement = document.querySelector(".Datetitle");
dateTitleElement.textContent = "MONTH OF " + month + "  " + year;




// Get the department select element
var departmentSelect = document.getElementById("Department");

// Get the employee select element
var employeeSelect = document.getElementById("Employee");

// Function to fetch the employee data based on the selected department
function fetchEmployeesByDepartment(departmentId) {
    $.ajax({
        url: "inc.fetch_selected_employees.php",
        type: "GET",
        data: { departmentId: departmentId },
        dataType: "json",
        success: function (employees) {
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

            var vacation  = employee.Leave_Vacation;
            var sick  = employee.Leave_Sick;
            var force  = employee.Leave_Force;
            var spl  = employee.Leave_Special;


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
            $('#image').attr('src', 'data:image/jpeg;base64,' + image);
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

$(document).ready(function() {
    var datesArray = [];
    var leave_date = document.getElementById('leave_date');
    var dateFeedback = document.getElementById('invalid-date-feedback');

    $('#addDateBtn').on('click', function() {
        var selectedDate = $('#leave_date').val();
        if (selectedDate) {

            var currentDate = new Date();
            var enteredDate = new Date(selectedDate);

            // Check if the selected date is a previous date
            if (enteredDate < currentDate) {
                dateFeedback.textContent = "Please select a future date";
                leave_date.classList.add('is-invalid');
                return; // Exit the function
            }

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
                var dateContainer = $('<div class="date-container"></div>');
                var leaveDate = $('<span class="leave-date"></span>').text(date);
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
    });
});

var leave_date = document.getElementById('leave_date');
    leave_date.addEventListener('change', function() {
    var dateFeedback = document.getElementById('invalid-date-feedback');
    dateFeedback.textContent = "";
    leave_date.classList.remove('is-invalid');
});
