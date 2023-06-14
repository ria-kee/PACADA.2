// IMAGE
const imageInput = document.getElementById('formFile');
const imagePreview = document.getElementById('preview-image');


const uid  = document.getElementById('edit_uid');
// FOR PERSONAL INPUT
const firstNameInput = document.getElementById('fname');
const middleNameInput = document.getElementById('mname');
const lastNameInput = document.getElementById('lname');
const birthdateInput = document.getElementById('birthdate');
const sexSelect = document.getElementById('Editsex');

// FOR WORK INPUT
const deptSelect = document.getElementById('Editdepartment');
const apptdateInput = document.getElementById('edit_appptdate');
const vacationInput = document.getElementById('edit_vacation');
const sickInput = document.getElementById('edit_sick');
const forceInput = document.getElementById('edit_force');
const splInput = document.getElementById('edit_spl');


// SPANS
const imageFeedback = document.getElementById('image-invalid-feedback');
const firstNameFeedback = document.getElementById('fname-invalid-feedback');
const lastNameFeedback = document.getElementById('lname-invalid-feedback');
const sexFeedback = document.getElementById('sex-invalid-feedback');
const birthdateFeedback = document.getElementById('bdate-invalid-feedback');
const departmentFeedback = document.getElementById('dept-invalid-feedback');
const appdateFeedback = document.getElementById('appdate-invalid-feedback');
const vacationFeedback = document.getElementById('vacation-invalid-feedback');
const sickFeedback = document.getElementById('sick-invalid-feedback');
const forceFeedback = document.getElementById('force-invalid-feedback');
const splFeedback = document.getElementById('spl-invalid-feedback');



// Add an event listener to the department select element
$('#Department').on('change', function() {
    // Get the selected department value
    var selectedDepartment = $(this).val();

    // Update the Ajax URL with the selected department
    empTable.ajax.url('fetch_All_Employees.php?department=' + selectedDepartment).load();
});

var empTable = $('#empTable').DataTable({
    serverSide: true,
    processing: true,
    paging: true,
    pageLength: 10,
    lengthChange: false,
    order: [],
    ajax: {
        url: 'fetch_All_Employees.php',
        type: 'post',
    },
    columnDefs: [{
        targets: [7],
        orderable: false,
        className: 'no-export' // Exclude the "Options" column from export
    }],
    buttons: [
        {
            extend: 'excel',
            exportOptions: {
                columns: ':not(.no-export)',
                header: function(data, columnIdx, columnNode) {
                    return $(columnNode).text();
                }
            },
            filename: function() {
                var currentDate = new Date().toLocaleDateString('en-PH');
                return 'Employees - ' + currentDate.replace(/\//g, '-');
            },
            title: 'Employees'
        },
        {
            extend: 'pdf',
            exportOptions: {
                columns: ':not(.no-export)',
                header: function(data, columnIdx, columnNode) {
                    return $(columnNode).text();
                }
            },
            filename: function() {
                var currentDate = new Date().toLocaleDateString('en-PH');
                return 'Employees - ' + currentDate.replace(/\//g, '-');
            },
            title: 'Employees',
            customize: function(doc) {
                // Set the table alignment to center
                doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                doc.content[1].table.alignment = 'center';

                // Apply striped color effect to table rows
                doc.content[1].table.body.forEach(function(row, rowIndex) {
                    row.forEach(function(cell, cellIndex) {
                        if (rowIndex % 2 === 0) {
                            cell.fillColor = '#E9E9FF'; //first color for striped effect
                        } else {
                            cell.fillColor = '#FFFFFF'; //second color for striped effect
                        }
                    });
                });

                // Customize the table header color
                doc.content[1].table.headerRows = 1;
                doc.content[1].table.body[0].forEach(function(headerCell) {
                    headerCell.fillColor = '#7D7DD2'; // Specify the color for the table header
                });
                // Customize the title style
                var title = doc.content[0].text[0];
                title.bold = true; // Make the title text bold
            },
            didDrawPage: function(data) {
                // Add a striped background to the table in the exported PDF
                var pageSize = data.pageSize;
                var pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
                var table = data.content[1].table;
                var rowHeight = table.body[0].height ? table.body[0].height : table.height;
                var rowCount = table.body.length;
                var tableHeight = rowHeight * rowCount;
                var midPagePos = (pageHeight - tableHeight) / 2;

                data.content[1].table.body.forEach(function(row, rowIndex) {
                    row.forEach(function(cell) {
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
    empTable.button('.buttons-pdf').trigger();
    console.log('Export PDF clicked');
});
// Export Excel
$('#excelExport').click(function() {
    empTable.button('.buttons-excel').trigger();
    console.log('Export Excel clicked');
});
$(document).ready(function() {

    $('.searchField').on('keyup', function() {
        empTable.search(this.value).draw();
    });
});
$('.dataTables_filter').hide();

//VIEW MODAL
$(document).on('click', '.view-button', function() {
    var image = $(this).data('image');
    var name = $(this).data('name');
    var department = $(this).data('department');
    var uid = $(this).data('uid');
    var email = $(this).data('email');
    var sex = $(this).data('sex');
    var age = $(this).data('age');
    var appdate = $(this).data('appdate');
    var vacation = $(this).data('vacation');
    var sick = $(this).data('sick');
    var force = $(this).data('force');
    var spl = $(this).data('spl');

    $('#image').attr('src', 'data:image/jpeg;base64,' + image);
    $('#name').text(name);
    $('#department').text(department);
    $('#uid').text(uid);
    $('#email').text(email);
    if(sex ==='F'){$('#sex').text('Female');}else {$('#sex').text('Male');}
    $('#age').text(age);
    $('#appdate').text(appdate);
    $('#vacation').text(vacation);
    $('#sick').text(sick);
    $('#force').text(force);
    $('#spl').text(spl);

    $('#ViewModal').modal('show'); // Show the confirmation modal
});



var defaultImage;
//EDIT MODAL
$(document).on('click', '.edit-button', function() {
    var image = $(this).data('image');
    defaultImage = image;
    // PERSONAL
    var fname = $(this).data('fname');
    var mname = $(this).data('mname');
    var lname = $(this).data('lname');
    var sex = $(this).data('sex');
    var birthdate = $(this).data('birthdate');
    //WORK
    var department = $(this).data('department');
    var appdate = $(this).data('appdate');
    var vacation = $(this).data('vacation');
    var sick = $(this).data('sick');
    var force = $(this).data('force');
    var spl = $(this).data('spl');

    var emp = $(this).data('empid');

    $('#preview-image').attr('src', 'data:image/jpeg;base64,' + image);
    $('#fname').val(fname);
    $('#mname').val(mname);
    $('#lname').val(lname);
    $('#Editsex').val(sex);
    $('#birthdate').val(birthdate);

    $('#Editdepartment').val(department);
    $('#edit_appptdate').val(appdate);

    $('#edit_vacation').val(vacation);
    $('#edit_sick').val(sick);
    $('#edit_force').val(force);
    $('#edit_spl').val(spl);

    var empUID = $(this).data('uid');
    // Set the empUID value in the modal
    $('#edit_uid').val(empUID);

    $('#UpdateEmployee').data('emp', emp);

    $('#EditEmployee').modal('show'); // Show the  modal
});


$('#UpdateEmployee').prop('disabled', true);

// Event listener for input fields in Edit Modal
$('.edit-input').on('input', function() {
    // Check if any input field value has changed
    var anyChanges = $('.edit-input').toArray().some(function(input) {
        return input.defaultValue !== input.value;
    });

    // Disable or enable the UpdateEmployee button based on changes
    if (anyChanges) {
        $('#UpdateEmployee').prop('disabled', false);
    } else {
        $('#UpdateEmployee').prop('disabled', true);
    }
});


// EDIT MODAL VALIDATION


// Capitalize the first letter of every word in a string
        function capitalizeWords(string) {
            return string.replace(/\b\w/g, (match) => match.toUpperCase());
        }

// VALIDATION EVENT LISTENERS
        firstNameInput.addEventListener('keyup', function() {
            this.value = capitalizeWords(this.value);
            validateFirstName();
        });

        middleNameInput.addEventListener('keyup', function() {
            this.value = capitalizeWords(this.value);
        });

        lastNameInput.addEventListener('keyup', function() {
            this.value = capitalizeWords(this.value);
            validateLastName();
        });

        birthdateInput.addEventListener('change', function() {
            validateBirthdate();
        });

        function calculateAge(dob) {
            var today = new Date();
            var birthdate = birthdateInput.value;
            var birthdateArray = birthdate.split('-');
            var birthYear = parseInt(birthdateArray[0]);
            var birthMonth = parseInt(birthdateArray[1]) - 1;
            var birthDay = parseInt(birthdateArray[2]);
            var age = today.getFullYear() - birthYear;

            if (
                today.getMonth() < birthMonth ||
                (today.getMonth() === birthMonth && today.getDate() < birthDay)
            ) {
                age--;
            }

            return age;
        }

        sexSelect.addEventListener('change', function() {
            validateSex();
        });

        deptSelect.addEventListener('change',function (){
            validateDept();
        });

        apptdateInput.addEventListener('change',function (){
            validateAppDate();
        });

        vacationInput.addEventListener('change',function (){
            validateVacation();
        });

        sickInput.addEventListener('change',function (){
            validateSick();
        });

        forceInput.addEventListener('change',function (){
            validateForce();
        });

        splInput.addEventListener('change',function (){
            validateSpl();
        });


// VALIDATION FUNCTIONS
        function validateFirstName() {
            if (firstNameInput.value.trim() === '') {
                firstNameInput.classList.add('is-invalid');
                firstNameFeedback.textContent = 'First Name is required.';
                return false;
            } else {
                firstNameInput.classList.remove('is-invalid');
                firstNameFeedback.textContent = '';
                return true;
            }
        }

        function validateLastName() {
            if (lastNameInput.value.trim() === '') {
                lastNameInput.classList.add('is-invalid');
                lastNameFeedback.textContent = 'Last Name is required.';
                return false;
            } else {
                lastNameInput.classList.remove('is-invalid');
                lastNameFeedback.textContent = '';
                return true;
            }
        }

        function validateBirthdate() {
    const birthdate = birthdateInput.value;

    // Create a Date object from the input value
    const inputDate = new Date(birthdate);

    // Check if the input value is a valid date
    if (isNaN(inputDate.getTime())) {
        birthdateInput.classList.add('is-invalid');
        birthdateFeedback.textContent = 'Please enter a valid date.';
        return false;
    }
    // Check if birthdate is not empty
    if (birthdateInput.value.trim() === '') {
        birthdateInput.classList.add('is-invalid');
        birthdateFeedback.textContent = 'Date of Birth is required.';
        return false;
    }

    // Check if the input year is valid
    const inputYear = inputDate.getFullYear();
    const currentYear = new Date().getFullYear();
    if (inputYear < 1900 || inputYear > currentYear) {
        birthdateInput.classList.add('is-invalid');
        birthdateFeedback.textContent = 'Please enter a valid year.';
        return false;
    }

    // Calculate the age
    const age = calculateAge(inputDate);

    // Check if age is less than 18
    if (age < 18) {
        birthdateInput.classList.add('is-invalid');
        birthdateFeedback.textContent = 'Employee must be at least 18 years old.';
        return false;
    }

    // Check if the input value is a future date
    if (inputDate > new Date()) {
        birthdateInput.classList.add('is-invalid');
        birthdateFeedback.textContent = 'Please enter a date in the past.';
        return false;
    }

    // Clear validation feedback and mark as valid
    birthdateInput.classList.remove('is-invalid');
    birthdateFeedback.textContent = '';
    return true;
}

        function validateSex() {
            if (sexSelect.value === '0') {
                sexSelect.classList.add('is-invalid');
                sexFeedback.textContent = 'Please select your sex.';
                return false;
            } else {
                sexSelect.classList.remove('is-invalid');
                sexFeedback.textContent = '';
                return true;
            }
        }

        function validateDept(){
            if (deptSelect.value === '0'){
                deptSelect.classList.add('is-invalid');
                departmentFeedback.textContent = 'Please assign department.';
                return false;
            } else {
                deptSelect.classList.remove('is-invalid');
                departmentFeedback.textContent = '';
                return true;
            }
        }

        function validateAppDate(){
            const appdate = apptdateInput.value;
            const inputDate = new Date(appdate);
        // Check if birthdate is not empty


            // Check if the input value is a valid date
            if (isNaN(inputDate.getTime())) {
                apptdateInput.classList.add('is-invalid');
                appdateFeedback.textContent = 'Please enter a valid date.';
                return false;
            }

            if (appdate === '') {
                apptdateInput.classList.add('is-invalid');
                apptdateFeedback.textContent = 'Appointment Date is required.';
                return false;
            }

            // Check if the input value is a future date
            const currentDate = new Date();
            if (inputDate > currentDate) {
                apptdateInput.classList.add('is-invalid');
                appdateFeedback.textContent = 'Please enter a date in the past.';
                return false;
            }

            // Check if the input year is valid
            const inputYear = inputDate.getFullYear();
            const currentYear = currentDate.getFullYear();
            if (inputYear < 1900 || inputYear > currentYear) {
                apptdateInput.classList.add('is-invalid');
                appdateFeedback.textContent = 'Please enter a valid year.';
                return false;
            }

            // Clear validation feedback and mark as valid
            apptdateInput.classList.remove('is-invalid');
            appdateFeedback.textContent = '';
            return true;
        }

        function validateVacation(){
            if (vacationInput.value.trim() === '') {
                vacationInput.classList.add('is-invalid');
                vacationFeedback.textContent = 'Vacation Leave Credit Balance is required.';
                return false;
            } else {
                vacationInput.classList.remove('is-invalid');
                vacationFeedback.textContent = '';
                return true;
            }
        }

        function validateSick() {
    if (sickInput.value.trim() === '') {
        sickInput.classList.add('is-invalid');
        sickFeedback.textContent = 'Sick Leave Credit Balance is required.';

        return false;
    } else {
        sickInput.classList.remove('is-invalid');
        sickFeedback.textContent = '';
        return true;
    }
}

        function validateForce() {
    if (forceInput.value.trim() === '') {
        forceInput.classList.add('is-invalid');
        forceFeedback.textContent = 'Force Leave Credit Balance is required.';
        return false;
    } else {
        forceInput.classList.remove('is-invalid');
        forceFeedback.textContent = '';
        return true;
    }
}

        function validateSpl() {
    if (splInput.value.trim() === '') {
        splInput.classList.add('is-invalid');
        splFeedback.textContent = 'Sick Leave Credit Balance is required.';
        return false;
    } else {
        splInput.classList.remove('is-invalid');
        splFeedback.textContent = '';
        return true;
    }
}



// defaultImage
let blob;
let thereisFile = false;
let uploaded;
let currentImage;
let isImageValid = false;

// Form File Input Change Event
imageInput.addEventListener('change', function() {

    const file = this.files[0];
    const fallbackImage = 'assets/img/no-profile.png';

    if (file) {
        const fileSize = file.size / (1024 * 1024); // Convert file size to MB
        const fileExtension = file.name.split('.').pop().toLowerCase();

        // Check if file is an image, within size limit, and has a valid extension
        if (
            file.type.startsWith('image/') &&
            fileSize <= 5 &&
            (fileExtension === 'jpg' ||
                fileExtension === 'jpeg' ||
                fileExtension === 'png' ||
                fileExtension === 'gif')
        ) {
            const reader = new FileReader();

            reader.addEventListener('load', function () {
                imagePreview.src = this.result;
                imageFeedback.textContent = ''; // Clear any previous error message
                currentImage = this.result; // Update the current image variable
            });

            reader.readAsDataURL(file);

            thereisFile =true;
            uploaded=file;
            isImageValid = true;

        } else {
            // Display error message for invalid file type, size, or extension
            imageFeedback.textContent = 'Please select a valid image file (up to 5MB).';
            formFile.value = ''; // Reset the file input
            if (currentImage) {
                imagePreview.src = currentImage; // Restore the previous image
            } else {
                imagePreview.src = 'assets/img/no-profile.png'; // Display default image
            }
        }
    }
    else {
        // If no file selected, reset the preview image and clear any previous error message
        imagePreview.src = 'data:image/jpeg;base64,' + defaultImage;
        imageFeedback.textContent = '';
        currentImage = ''; // Reset the current image variable
        thereisFile =false;
    }


});







$(document).ready(function() {

    $('#UpdateEmployee').click(function () {
        let imageData = uploaded;
        const emp = $(this).data('emp');

        // Validate Inputs
        const isImageChanged = thereisFile;
        const isUploadedImageValid = isImageValid;
        const isFirstNameValid = validateFirstName();
        const isLastNameValid = validateLastName();
        const isBirthdateValid = validateBirthdate();
        const isSexValid = validateSex();
        const isDepartmentValid = validateDept();
        const isAppDateValid = validateAppDate();
        const isVacationValid = validateVacation();
        const isSickValid = validateSick();
        const isForceValid = validateForce();
        const isSplValid = validateSpl();



        if (isUploadedImageValid && isImageChanged && isFirstNameValid && isLastNameValid && isBirthdateValid && isSexValid && isDepartmentValid && isAppDateValid && isVacationValid && isSickValid && isForceValid && isSplValid) {
            const reader = new FileReader();


            reader.onload = function(event) {
                const arrayBuffer = event.target.result;

                // Convert the ArrayBuffer to a Blob
                const imageBlob = new Blob([arrayBuffer], { type: imageData.type });

                // Retrieve the file name from the File object
                const fileName = imageData.name;
                console.error('blob:', imageBlob);
                // Create a File object with the Blob and set the name
                const files = new File([imageBlob], fileName, { type: imageData.type });

                console.error('employees_image:', files);
                // Create a new FormData object
                const formData = new FormData();
                formData.append('uid', uid.value);
                formData.append('employees_image', files);
                formData.append('employees_FirstName', firstNameInput.value);
                formData.append('employees_MiddleName', middleNameInput.value);
                formData.append('employees_LastName', lastNameInput.value);
                formData.append('employees_sex', sexSelect.value);
                formData.append('employees_birthdate', birthdateInput.value);
                formData.append('employees_Department', deptSelect.value);
                formData.append('employees_appointmentDate', apptdateInput.value);
                formData.append('Leave_Vacation', vacationInput.value);
                formData.append('Leave_Sick', sickInput.value);
                formData.append('Leave_Force', forceInput.value);
                formData.append('Leave_Special', splInput.value);

                // Send the employee data to the PHP file using an AJAX request
                $.ajax({
                    url: 'update_employee_with_image.php',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        // Show the success alert
                        $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> Employee <strong>' + emp + '</strong> has been updated successfully.');
                        $('#EditEmployee').modal('hide');
                        $('#empTable').DataTable().ajax.reload();
                        // Close the success alert after 3 seconds
                        setTimeout(function () {
                            $('#successAlert').removeClass('show').addClass('d-none');
                        }, 3000);

                    },
                    error: function () {
                        // Handle the error response
                        console.error('An error occurred while updating the employee');
                        // Show the error alert
                        $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> An error occurred while updating the employee <strong>' + emp + '</strong>.');
                        $('#EditEmployee').modal('hide');
                        // Close the error alert after 3 seconds
                        setTimeout(function () {
                            $('#errorAlert').removeClass('show').addClass('d-none');
                        }, 3000);
                    }
                });
            };
            // Start reading the image file as ArrayBuffer
            reader.readAsArrayBuffer(imageData);
        }
        else if (isUploadedImageValid && isFirstNameValid && isLastNameValid && isBirthdateValid && isSexValid && isDepartmentValid && isAppDateValid && isVacationValid && isSickValid && isForceValid && isSplValid) {

            const formData = new FormData();
            formData.append('uid', uid.value);
            formData.append('employees_FirstName', firstNameInput.value);
            formData.append('employees_MiddleName', middleNameInput.value);
            formData.append('employees_LastName', lastNameInput.value);
            formData.append('employees_sex', sexSelect.value);
            formData.append('employees_birthdate', birthdateInput.value);
            formData.append('employees_Department', deptSelect.value);
            formData.append('employees_appointmentDate', apptdateInput.value);
            formData.append('Leave_Vacation', vacationInput.value);
            formData.append('Leave_Sick', sickInput.value);
            formData.append('Leave_Force', forceInput.value);
            formData.append('Leave_Special', splInput.value);

            // Send the employee data to the PHP file using an AJAX request
            $.ajax({
                url: 'update_employee.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    // Show the success alert
                    $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> Employee <strong>' + emp + '</strong> has been updated successfully.');
                    $('#EditEmployee').modal('hide');
                    $('#empTable').DataTable().ajax.reload();
                    // Close the success alert after 3 seconds
                    setTimeout(function () {
                        $('#successAlert').removeClass('show').addClass('d-none');
                    }, 3000);

                },
                error: function () {
                    // Handle the error response
                    console.error('An error occurred while updating the employee');
                    // Show the error alert
                    $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> An error occurred while updating the employee <strong>' + emp + '</strong>.');
                    $('#EditEmployee').modal('hide');
                    // Close the error alert after 3 seconds
                    setTimeout(function () {
                        $('#errorAlert').removeClass('show').addClass('d-none');
                    }, 3000);
                }
            });

        }

    });

});
// Listen for the EditModal's hidden.bs.modal event
$('#EditEmployee').on('hidden.bs.modal', function() {
    // Clear the text inside the class text-danger
    $('.text-danger').text('');
    // Remove the 'is-invalid' class from all elements
    $('.is-invalid').removeClass('is-invalid');

    $('#UpdateEmployee').prop('disabled', true);
});
