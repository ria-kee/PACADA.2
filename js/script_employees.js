// IMAGE
const imageInput = document.getElementById('formFile');
const imagePreview = document.getElementById('preview-image');
const remove = document.getElementById('RemoveImage');

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
const remarksInput = document.getElementById('remarks');

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
    empTable.ajax.url('inc.fetch_All_Employees.php?department=' + selectedDepartment).load();
});

var empTable = $('#empTable').DataTable({
    serverSide: true,
    processing: true,
    paging: true,
    pageLength: 10,
    lengthChange: false,
    order: [],
    ajax: {
        url: 'inc.fetch_All_Employees.php',
        type: 'post',

    },
    columnDefs: [{
        targets: [8],
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
});
// Export Excel
$('#excelExport').click(function() {
    empTable.button('.buttons-excel').trigger();
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
    var id =  $(this).data('emp');

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

    $('#history').data('name', name);
    $('#history').data('emp', id);
    $('#ViewModal').modal('show'); // Show the  modal
});

$('#history').on('click', function() {
    // Retrieve the 'emp' data associated with the button
    var empID = $(this).data('emp');
    var empName = $(this).data('name');

    // Encrypt the employee ID using a secret key
    var secretKey = 'd0$tP@c@da';
    var encryptedEmpID = CryptoJS.AES.encrypt(empID.toString(), secretKey).toString();

    // Create the URL with the encrypted employee ID and empName as query parameters
    var url = 'history.php?employee=' + encodeURIComponent(encryptedEmpID) + '&Name=' + encodeURIComponent(empName);

    // Redirect to the generated URL
    window.location.href = url;
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
    var remarks = $(this).data('remarks');

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
    $('#remarks').val(remarks);

    var empUID = $(this).data('uid');
    // Set the empUID value in the modal
    $('#edit_uid').val(empUID);

    $('#UpdateEmployee').data('emp', emp);

    if( image === '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')
    {
        remove.style.display = 'none';
    }
    else{
        remove.style.display = 'block';
    }
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
let imageData;
let blob;
let thereisFile = false;
let uploaded;
let currentImage;
let isImageValid = true;
const fallbackImage = 'assets/img/no-profile.png';

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
            imageData = uploaded;

        } else {
            // Display error message for invalid file type, size, or extension
            isImageValid = false;
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
remove.addEventListener("click", function() {
    fetch(fallbackImage)
        .then(response => response.blob())
        .then(blob => {
            const fileData = new File([blob], 'no-profile.png', { type: 'image/png' });
            imageData = fileData;
        })
        .catch(error => {
            console.error('Error fetching fallback image:', error);
        });

    imagePreview.src = 'assets/img/no-profile.png'; // Display default image
    thereisFile =true;
    isImageValid = true;
    $('#UpdateEmployee').prop('disabled', false);
    remove.style.display = 'none';
});

$(document).ready(function() {

    $('#UpdateEmployee').click(function () {
        console.error(imageData);
        console.error(thereisFile);
        console.error(isImageValid);
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
                formData.append('employees_remarks', remarksInput.value);

                // Send the employee data to the PHP file using an AJAX request
                $.ajax({
                    url: 'inc.update_employee_with_image.php',
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
            formData.append('employees_remarks', remarksInput.value);

            // Send the employee data to the PHP file using an AJAX request
            $.ajax({
                url: 'inc.update_employee.php',
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


//DEACT MODAL
$(document).on('click', '.archive-button', function() {
    var uID = $(this).data('uid');
    var empname = $(this).data('empname');
    $('#empname').text(empname);
    $('#EmployeeArchiveModal').modal('show'); // Show the  modal
    // Store the emp ID to be used later for archive;
    $('#EmployeeArchiveModal').data('uID', uID);
});

$(document).on('click', '#EmployeeArchiveModal #yes', function() {
    var UID = $('#EmployeeArchiveModal').data('uID');
    console.error(UID)

    // Perform the AJAX request to remove the admin
    $.ajax({
        url: 'inc.remove_employee.php',
        type: 'POST',
        data: { uID: UID },
        success: function(response) {
            // Show the success alert
            $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> ' + response);
            $('#empTable').DataTable().ajax.reload();

            // Close the modal
            $('#EmployeeArchiveModal').modal('hide');

            // Close the success alert after 3 seconds
            setTimeout(function() {
                $('#successAlert').removeClass('show').addClass('d-none');
            }, 3000);
        },
        error: function(xhr, status, error) {
            // Show the error alert with the custom error message
            $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> ' + xhr.responseText);

            // Close the modal
            $('#EmployeeArchiveModal').modal('hide');

            // Close the error alert after 3 seconds
            setTimeout(function() {
                $('#errorAlert').removeClass('show').addClass('d-none');
            }, 5000);
        }

    });
});