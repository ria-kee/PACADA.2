

// FOR PERSONAL INPUT
const firstNameInput = document.getElementById('fname');
const middleNameInput = document.getElementById('mname');
const lastNameInput = document.getElementById('lname');
const birthdateInput = document.getElementById('birthdate');
const sexSelect = document.getElementById('sex');

// FOR WORK INPUT
const idInput = document.getElementById('empID');
const deptSelect = document.getElementById('dept');
const apptdateInput = document.getElementById('appptdate');
const vacationInput = document.getElementById('vacation');
const sickInput = document.getElementById('sick');
const forceInput = document.getElementById('force');
const splInput = document.getElementById('spl');

// FOR PERSONAL INPUT
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');

// // MODAL
// const reviewModal = document.getElementById('ReviewModal');

// MODAL SPANS
const reviewName = document.getElementById('review_fullname');
const reviewSex = document.getElementById('review_sex');
const reviewBirth = document.getElementById('review_birthdate');
const reviewDepartment = document.getElementById('review_department');
const reviewAppDate = document.getElementById('review_appdate');
const reviewVacation = document.getElementById('review_vacation');
const reviewSick = document.getElementById('review_sick');
const reviewForce = document.getElementById('review_force');
const reviewSpl = document.getElementById('review_spl');
const reviewEmail = document.getElementById('review_email');
const reviewPassword = document.getElementById('review_password');
const reviewID = document.getElementById('review_id');
const reviewProfile = document.getElementById('review-preview-image');


// Validation feedback elements
const firstNameFeedback = document.getElementById('fname-invalid-feedback');
const lastNameFeedback = document.getElementById('lname-invalid-feedback');
const birthdateFeedback = document.getElementById('bdate-invalid-feedback');
const sexFeedback = document.getElementById('sex-invalid-feedback');

const deptFeedback = document.getElementById('dept-invalid-feedback');
const apptdateFeedback = document.getElementById('apptdate-invalid-feedback');
const vacationFeedback = document.getElementById('vacation-invalid-feedback');
const sickFeedback = document.getElementById('sick-invalid-feedback');
const forceFeedback = document.getElementById('force-invalid-feedback');
const splFeedback = document.getElementById('spl-invalid-feedback');
const idFeedback = document.getElementById('empID-invalid-feedback');

const emailFeedback = document.getElementById('email-invalid-feedback');

//Pages
const personalSection = document.getElementById('personal');
const workSection = document.getElementById('work');
const accountSection = document.getElementById('account');

// Form File Input and Preview Image
const formFile = document.getElementById('formFile');
const previewImage = document.getElementById('preview-image');
const invalidFeedback = document.getElementById('invalid-feedback');
let currentImage = '';

// Circle
const c1Element = document.getElementById('c1');
const c2Element = document.getElementById('c2');
const c3Element = document.getElementById('c3');


// Labels
const l1Element = document.getElementById('l1');
const l2Element = document.getElementById('l2');
const l3Element = document.getElementById('l3');

const progressIndicator = document.querySelector('.progress .indicator');
var progress = 0;


// Buttons
//Personal
const nextButton = document.getElementById('next-button');
//Work
const prevButton2 = document.getElementById('prev-button2');
const nextButton2 = document.getElementById('next-button2');
//Account
const prevButton3 = document.getElementById('prev-button3');
const nextButton3 = document.getElementById('save');


// Capitalize the first letter of every word in a string
function capitalizeWords(string) {
    return string.replace(/\b\w/g, (match) => match.toUpperCase());
}

// PERSONAL


// Validate First Name Event
let isFirstNameIncreaseDone = false;
function fname_updateProgress() {
    if (firstNameInput.value.trim() !== '' && !isFirstNameIncreaseDone) {
        progress += 12.5;
        progressIndicator.style.width = progress + '%';
        isFirstNameIncreaseDone = true;
    }
    if (firstNameInput.value.trim() === '') {
        progress -= 12.5;
        progressIndicator.style.width = progress + '%';
        isFirstNameIncreaseDone = false;
    }
}
// Validate First Name Event
firstNameInput.addEventListener('input', function() {
    this.value = capitalizeWords(this.value);
    validateFirstName();
    fname_updateProgress();
});

// Update progress indicator on focus out
firstNameInput.addEventListener('focusout', function() {
    fname_updateProgress();
});
// Capitalize Middle Name Event
middleNameInput.addEventListener('keyup', function() {
    this.value = capitalizeWords(this.value);
});


let isLastNameIncreaseDone = false;

// Function to update the progress indicator
function lname_updateProgress() {
    if (lastNameInput.value.trim() !== '' && !isLastNameIncreaseDone) {
        progress += 12.5;
        progressIndicator.style.width = progress + '%';
        isLastNameIncreaseDone = true;
    }
    if (lastNameInput.value.trim() === '') {
        progress -= 12.5;
        progressIndicator.style.width = progress + '%';
        isLastNameIncreaseDone = false;
    }
}

// Validate Last Name Event
lastNameInput.addEventListener('input', function() {
    this.value = capitalizeWords(this.value);
    validateLastName();
    lname_updateProgress();
});

// Update progress indicator on focus out
lastNameInput.addEventListener('focusout', function() {
    lname_updateProgress();
});


let isBirthdateIncreaseDone = false;
// Validate Date of Birth Event
birthdateInput.addEventListener('change', function() {
    validateBirthdate();

    if(this.value !== '' && !isBirthdateIncreaseDone){
        progress += 12.5;
        progressIndicator.style.width = progress + '%';
        isBirthdateIncreaseDone = true;
    }

    if(this.value === ''){
        progress -= 12.5;
        progressIndicator.style.width = progress + '%';
        isBirthdateIncreaseDone = false;
    }


    // CREATE PASSWORD
    var DOB = new Date(this.value);
    var year = DOB.getFullYear();

    passwordInput.value = 'DOST-' + year;

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

let isSexIncreaseDone = false;
// Validate Sex Selection Event
sexSelect.addEventListener('change', function() {
    validateSex();

    if (this.value !== '0' && !isSexIncreaseDone) {
        progress += 12.5;
        progressIndicator.style.width = progress + '%';
        isSexIncreaseDone = true;
    }
    if (this.value === '0') {
        progress -= 12.5;
        progressIndicator.style.width = progress + '%';
        isSexIncreaseDone = false;
    }
});

// WORK

// Validate Department Event
let isDeptIncreaseDone = false;
deptSelect.addEventListener('change',function (){
    validateDept();

    if(this.value !== '0' && !isDeptIncreaseDone){
        progress += 8;
        progressIndicator.style.width = progress + '%';
        isDeptIncreaseDone = true;
    }

    if (sickInput.value.trim() !== '' && !isSickIncreaseDone) {
        progress += 8;
        progressIndicator.style.width = progress + '%';
        isSickIncreaseDone = true;
    }

    if (splInput.value.trim() !== '' && !isSplIncreaseDone) {
        progress += 5;
        progressIndicator.style.width = progress + '%';
        isSplIncreaseDone = true;
    }

    if(this.value === '0'){
        progress -= 8;
        progressIndicator.style.width = progress + '%';
        isDeptIncreaseDone = false;
    }


});

let isApptdateIncreaseDone = false;
// Validate Appointment Event
apptdateInput.addEventListener('change',function (){
    validateAppDate();

    if(this.value !== '' && !isApptdateIncreaseDone){
        progress += 5.5;
        progressIndicator.style.width = progress + '%';
        isApptdateIncreaseDone = true;
    }

    if (vacationInput.value.trim() !== '' && !isVacationIncreaseDone) {
        progress += 5.5;
        progressIndicator.style.width = progress + '%';
        isVacationIncreaseDone = true;
    }


    if (forceInput.value.trim() !== '' && !isForceIncreaseDone) {
        progress += 5.5;
        progressIndicator.style.width = progress + '%';
        isForceIncreaseDone = true;
    }

    if(this.value === ''){
        progress -= 5.5;
        progressIndicator.style.width = progress + '%';
        isApptdateIncreaseDone = false;
    }
});

// Validate Vacation Event
let isVacationIncreaseDone = false;
vacationInput.addEventListener('change',function (){
    validateVacation();

    if (this.value.trim() !== '' && !isVacationIncreaseDone) {
        progress += 5.5;
        progressIndicator.style.width = progress + '%';
        isVacationIncreaseDone = true;
    }
    if (this.value.trim() === '') {
        progress -= 5.5;
        progressIndicator.style.width = progress + '%';
        isVacationIncreaseDone = false;
    }
});

// Validate Sick Event
let isSickIncreaseDone = false;
sickInput.addEventListener('change',function (){
    validateSick();
    if (this.value.trim() !== '' && !isSickIncreaseDone) {
        progress += 5.5;
        progressIndicator.style.width = progress + '%';
        isSickIncreaseDone = true;
    }
    if (this.value.trim() === '') {
        progress -= 5.5;
        progressIndicator.style.width = progress + '%';
        isSickIncreaseDone = false;
    }
});

// Validate ID Event
let isIdIncreaseDone = false;
idInput.addEventListener('change', function (){

    validateId();

    if (this.value.trim() !== '' && !isIdIncreaseDone) {
        progress += 5.5;
        progressIndicator.style.width = progress + '%';
        isIdIncreaseDone = true;
    }
    if (this.value.trim() === '') {
        progress -= 5.5;
        progressIndicator.style.width = progress + '%';
        isIdIncreaseDone = false;
    }

});

// Validate Force Event
let isForceIncreaseDone = false;
forceInput.addEventListener('change',function (){
    validateForce();
    if (this.value.trim() !== '' && !isForceIncreaseDone) {
        progress += 5.5;
        progressIndicator.style.width = progress + '%';
        isForceIncreaseDone = true;
    }
    if (this.value.trim() === '') {
        progress -= 5.5;
        progressIndicator.style.width = progress + '%';
        isForceIncreaseDone = false;
    }
});

let isSplIncreaseDone = false;
// Validate SPL Event
splInput.addEventListener('change',function (){
    validateSpl();
    if (this.value.trim() !== '' && !isSplIncreaseDone) {
        progress += 5.5;
        progressIndicator.style.width = progress + '%';
        isSplIncreaseDone = true;
    }
    if (this.value.trim() === '') {
        progress -= 5.5;
        progressIndicator.style.width = progress + '%';
        isSplIncreaseDone = false;
    }

});

// ACCOUNT

emailInput.addEventListener('change',function () {
    validateEmail();
});

// Validate Email
function validateEmail(){
    return new Promise((resolve, reject) => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var email = emailInput.value.trim();

        if (emailInput.value.trim() === '') {
            emailInput.classList.add('is-invalid');
            emailFeedback.textContent = 'Email is required.';
            return false;
        } else if (!emailRegex.test(emailInput.value.trim())) {
            emailInput.classList.add('is-invalid');
            emailFeedback.textContent = 'Invalid email format.';
            return false;
        }
        else {
            // Make an AJAX request to check if the ID exists in the database
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Request successful, process the response
                        var response = JSON.parse(xhr.responseText);
                        if (response.exists) {
                            emailInput.classList.add('is-invalid');
                            emailFeedback.textContent = 'Email is already registered with another account.';
                            resolve(false);
                        } else {
                            // validID = true;
                            emailInput.classList.remove('is-invalid');
                            emailInput.classList.add('is-valid');
                            emailFeedback.textContent = '';
                            resolve(true);
                        }
                    } else {
                        // Request failed, handle the error
                        console.error('Request failed with status ' + xhr.status);
                    }
                }
            };

            xhr.open('GET', 'query_email.php?email=' + email, true);
            xhr.send();

        }
        // else {
        //     emailInput.classList.remove('is-invalid');
        //     emailFeedback.textContent = '';
        //     return true;
        // }

    });
}


// Validate ID
function validateId() {
    return new Promise((resolve, reject) => {
        var id = idInput.value.trim();

        if (id === '') {
            idInput.classList.add('is-invalid');
            idFeedback.textContent = 'ID is required.';
            resolve(false);
        }
        else if (id.length !== 8 && id.length !== 9) {
            idInput.classList.add('is-invalid');
            idFeedback.textContent = 'ID must have 8 or 9 characters.';
            resolve(false);
        }

        else {
            // Make an AJAX request to check if the ID exists in the database
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Request successful, process the response
                        var response = JSON.parse(xhr.responseText);
                        if (response.exists) {
                            idInput.classList.add('is-invalid');
                            idFeedback.textContent = 'ID already exists.';
                            resolve(false);
                        } else {
                            // validID = true;
                            idInput.classList.remove('is-invalid');
                            idInput.classList.add('is-valid');
                            idFeedback.textContent = '';
                            resolve(true);
                        }
                    } else {
                        // Request failed, handle the error
                        console.error('Request failed with status ' + xhr.status);
                    }
                }
            };

            xhr.open('GET', 'query_id.php?id=' + id, true);
            xhr.send();

        }
    });
}

// Validate SPL
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

// Validate Force
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


// Validate Sick
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

// Validate Vacation
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



// Validate Appointment
function validateAppDate(){
    const appdate = apptdateInput.value;
    const inputDate = new Date(appdate);
// Check if birthdate is not empty


    // Check if the input value is a valid date
    if (isNaN(inputDate.getTime())) {
        apptdateInput.classList.add('is-invalid');
        apptdateFeedback.textContent = 'Please enter a valid date.';
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
        apptdateFeedback.textContent = 'Please enter a date in the past.';
        return false;
    }

    // Check if the input year is valid
    const inputYear = inputDate.getFullYear();
    const currentYear = currentDate.getFullYear();
    if (inputYear < 1900 || inputYear > currentYear) {
        apptdateInput.classList.add('is-invalid');
        apptdateFeedback.textContent = 'Please enter a valid year.';
        return false;
    }

    // Clear validation feedback and mark as valid
    apptdateInput.classList.remove('is-invalid');
    apptdateFeedback.textContent = '';
    return true;
}




// Validate Department Selection
function validateDept(){
    if (deptSelect.value === '0'){
        deptSelect.classList.add('is-invalid');
        deptFeedback.textContent = 'Please assign department.';
        return false;
    } else {
        deptSelect.classList.remove('is-invalid');
        deptFeedback.textContent = '';
        return true;
    }
}

// Validate Sex Selection
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

// Validate First Name
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

// Validate Last Name
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

// Validate Date of Birth
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




let blob;
let thereisFile = false;
let uploaded ='assets/img/no-profile.png';
// Form File Input Change Event
formFile.addEventListener('change', function() {

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
                previewImage.src = this.result;
                invalidFeedback.textContent = ''; // Clear any previous error message
                currentImage = this.result; // Update the current image variable
            });

            reader.readAsDataURL(file);

            thereisFile =true;
            uploaded=file;

        } else {
            // Display error message for invalid file type, size, or extension
            invalidFeedback.textContent = 'Please select a valid image file (up to 5MB).';
            formFile.value = ''; // Reset the file input
            if (currentImage) {
                previewImage.src = currentImage; // Restore the previous image
            } else {
                previewImage.src = 'assets/img/no-profile.png'; // Display default image
            }
        }
    } else {
        // If no file selected, reset the preview image and clear any previous error message
        previewImage.src = 'assets/img/no-profile.png';
        invalidFeedback.textContent = '';
        currentImage = ''; // Reset the current image variable
        thereisFile =false;
    }
});

function autoInputHyphen(event) {
    var value = idInput.value.trim();

    // Limit input to uppercase letters for the first two characters
    if (value.length === 1 || value.length === 2) {
        value = value.toUpperCase().replace(/[^A-Z]/g, '');
        idInput.value = value;
    } else {
        // Capitalize all letters
        value = value.toUpperCase();
        idInput.value = value;
    }
    // Check if hyphen is already present
    if (value.indexOf('-') !== -1) {
        var parts = value.split('-');
        var prefix = parts[0];
        var suffix = parts[1];

        // Limit input to 4 numbers after hyphen
        suffix = suffix.replace(/\D/g, '').slice(0, 4);
        idInput.value = prefix + '-' + suffix;
    }

    if (value.length === 3 && event.inputType !== 'deleteContentBackward') {
        idInput.value = value + '-';
    }
}

// Event listener to prevent input beyond 8 characters
idInput.addEventListener('keydown', function(event) {
    var value = idInput.value;
    if (value.length >= 9 && event.key !== 'Backspace' && event.key !== 'Delete') {
        event.preventDefault();
    }
});

var profile = '';
let imageData;

// WHEN NEXT BUTTON IS CLICKED



// Retrieve the personalDetails object from localStorage
const personalDetailsJSON = localStorage.getItem('personalDetails');
const personalDetails = JSON.parse(personalDetailsJSON);

var fullName_per = '' ;
var fname_per='';
var mname_per='';
var lname_per='';
var sex_per = '';
var birthdate_per = '';

nextButton.addEventListener('click', function() {
    // Validate First Name, Last Name, and Date of Birth
    const isFirstNameValid = validateFirstName();
    const isLastNameValid = validateLastName();
    const isBirthdateValid = validateBirthdate();
    const isSexValid = validateSex();

    console.error('is there a file', thereisFile);

    // Check if all required fields are valid
    if (isFirstNameValid && isLastNameValid && isBirthdateValid && isSexValid) {
        // Save the entered values to localStorage
        const personalDetails = {
            firstName: firstNameInput.value,
            middleName: middleNameInput.value,
            lastName: lastNameInput.value,
            sex: sexSelect.value,
            birthdate: birthdateInput.value
        };

        localStorage.setItem('personalDetails', JSON.stringify(personalDetails));
        // Retrieve  personal
         fullName_per = personalDetails.firstName + ' ' + personalDetails.middleName + ' ' + personalDetails.lastName;
         fname_per=personalDetails.firstName;
        mname_per=personalDetails.middleName;
         lname_per=personalDetails.lastName;
         sex_per = personalDetails.sex;
         birthdate_per = personalDetails.birthdate;



        // Retrieve the currentImage from localStorage
        profile = currentImage || 'assets/img/no-profile.png';

        const fallbackImage = 'assets/img/no-profile.png';
        if (!thereisFile){
            fetch(fallbackImage)
                .then(response => response.blob())
                .then(blob => {
                    const fileData = new File([blob], 'no-profile.png', { type: 'image/png' });
                    console.error(fileData);
                    imageData = fileData;
                })
                .catch(error => {
                    console.error('Error fetching fallback image:', error);
                });
        }
        else {
            imageData = uploaded;
        }



        // Show the next section (Work Information)
        personalSection.style.display = 'none';
        workSection.style.display = 'block';

        // Update the progress indicator width to 50%
        c1Element.innerHTML = '<span class="material-symbols-rounded">done</span>';
        l1Element.style.fontWeight = 'normal';
        l1Element.style.color = '#999';


        // Apply styles to element with ID #c2
        c2Element.style.borderColor = 'var(--color-p1)';
        c2Element.style.backgroundColor = 'var(--color-p1)';
        c2Element.style.color = '#ffffff';
        l2Element.style.fontWeight = 'bold';
        l2Element.style.color = 'var(--color-p1)';

    }
});

// WHEN PREV BUTTON2 IS CLICKED
prevButton2.addEventListener('click', function() {
    // Show the prev section (Personal Information)
    personalSection.style.display = 'block';
    workSection.style.display = 'none';

    // Update the progress indicator width to 0%
    c1Element.innerHTML = '1';
    l1Element.style.fontWeight = 'bold';
    l1Element.style.color = 'var(--color-p1)';


    // Apply styles to element with ID #c2
    c2Element.style.borderColor = '#e0e0e0';
    c2Element.style.backgroundColor = '#fff';
    c2Element.style.color = '#999';
    c2Element.innerHTML = '2';

    l2Element.style.fontWeight = 'normal';
    l2Element.style.color = '#999';

});


// Retrieve the workDetails object from localStorage
const workDetailsJSON = localStorage.getItem('workDetails');
const workDetails = JSON.parse(workDetailsJSON);

// Retrieve  workDetails
var department_work = '';
var appdate_work = '';
var vacation_work = '';
var sick_work = '';
var force_work = '';
var spl_work = '';

// WHEN NEXT BUTTON2 IS CLICKED
nextButton2.addEventListener('click', function() {
    // Validate Department, Appointment Date, Credit Balance (V,S,F,SPL)
    (async function() {
        const isIDValid = await validateId();
        const isDepartmentValid = validateDept();
        const isAppDateValid = validateAppDate();
        const isVacationValid = validateVacation();
        const isSickValid = validateSick();
        const isForceValid = validateForce();
        const isSplValid = validateSpl();

        // Check if all required fields are valid
        if (isIDValid && isDepartmentValid && isAppDateValid && isVacationValid && isSickValid && isForceValid && isSplValid) {


            // Save the entered values to localStorage
            const workDetails = {
                id: idInput.value,
                department: deptSelect.value,
                appdate: apptdateInput.value,
                vacation: vacationInput.value,
                sick: sickInput.value,
                force: forceInput.value,
                spl: splInput.value
            };

            localStorage.setItem('workDetails', JSON.stringify(workDetails));

            // Retrieve  workDetails
             department_work = workDetails.department;
             appdate_work = workDetails.appdate;
             vacation_work = workDetails.vacation;
             sick_work = workDetails.sick;
             force_work =workDetails.force;
             spl_work = workDetails.spl;


            // Show the prev section (Personal Information)
            accountSection.style.display = 'block';
            workSection.style.display = 'none';

            // Update num to check
            c2Element.innerHTML = '<span class="material-symbols-rounded">done</span>';

            // Apply styles to element with ID #c3
            c3Element.style.borderColor = 'var(--color-p1)';
            c3Element.style.backgroundColor = 'var(--color-p1)';
            c3Element.style.color = '#ffffff';
            l3Element.style.fontWeight = 'bold';
            l3Element.style.color = 'var(--color-p1)';


            l2Element.style.fontWeight = 'normal';
            l2Element.style.color = '#999';


        }

    })();
});

// WHEN PREV BUTTON3 IS CLICKED
prevButton3.addEventListener('click', function() {
    // Show the prev section (Personal Information)
    workSection.style.display = 'block';
    accountSection.style.display = 'none';

    // Update the progress indicator width to 0%
    c2Element.innerHTML = '2';
    l2Element.style.fontWeight = 'bold';
    l2Element.style.color = 'var(--color-p1)';


    // Apply styles to element with ID #c2
    c3Element.style.borderColor = '#e0e0e0';
    c3Element.style.backgroundColor = '#fff';
    c3Element.style.color = '#999';
    c3Element.innerHTML = '3';

    l3Element.style.fontWeight = 'normal';
    l3Element.style.color = '#999';

});




// Retrieve the accountDetails object from localStorage
const accountDetailsJSON = localStorage.getItem('personalDetails');
const accountDetails = JSON.parse(accountDetailsJSON);


var email_acc = '';
var password_acc = '';

// WHEN NEXT BUTTON3 IS CLICKED
nextButton3.addEventListener('click',function(){
    // ValidateEmail
    (async function() {
        const isEmailValid = await validateEmail();

        if (isEmailValid){
            const accountDetails = {
                email: emailInput.value,
                password: passwordInput.value
            };

            localStorage.setItem('accountDetails', JSON.stringify(accountDetails));
            // Update num to check
            c3Element.innerHTML = '<span class="material-symbols-rounded">done</span>';
            // Retrieve  accountDetails
            email_acc = accountDetails.email;
            password_acc = accountDetails.password;

            reviewID.innerHTML = idInput.value;
            reviewName.innerHTML =  fullName_per;

            if (sex_per==='F'){
                reviewSex.innerHTML = 'Female';
            }else{
                reviewSex.innerHTML = 'Male';
            }

            reviewBirth.innerHTML = birthdate_per;



            // Make an AJAX request to execute the MySQL query
            var xhr = new XMLHttpRequest();
            var departmentId = department_work;

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Request successful, process the response
                        var response = xhr.responseText;
                        // Set the innerHTML of the element
                        reviewDepartment.innerHTML = response;
                    } else {
                        // Request failed, handle the error
                        console.error('Request failed with status ' + xhr.status);
                    }
                }
            };

            xhr.open('GET', 'query.php?department=' + departmentId, true);
            xhr.send();


            reviewProfile.src = profile;
            reviewAppDate.innerHTML = appdate_work;

            reviewVacation.innerHTML = vacation_work;

            reviewSick.innerHTML = sick_work;

            reviewForce.innerHTML = force_work;

            reviewSpl.innerHTML = spl_work;

            reviewEmail.innerHTML = email_acc;

            reviewPassword.innerHTML = password_acc;

            $('#ReviewModal').modal('show');

        }
    })();
});

$('#ReviewModal').on('hidden.bs.modal', function () {
    c3Element.innerHTML = '3';
});



//ADD EMPLOYEE (SERVER-SIDE)
$('#addDepartmentButton').click(function() {
    const reader = new FileReader();

    reader.onload = function(event) {
        const arrayBuffer = event.target.result;

        // Convert the ArrayBuffer to a Blob
        const imageBlob = new Blob([arrayBuffer], { type: imageData.type });

        // Retrieve the file name from the File object
        const fileName = imageData.name;
        console.error('blob:', imageBlob);
        // Create a File object with the Blob and set the name
        const file = new File([imageBlob], fileName, { type: imageData.type });

        console.error('employees_image:', file);
        // Create a new FormData object
        const formData = new FormData();
        formData.append('employees_image', file);
        formData.append('employees_uid', idInput.value);
        formData.append('employees_FirstName', fname_per);
        formData.append('employees_MiddleName', mname_per);
        formData.append('employees_LastName', lname_per);
        formData.append('employees_sex', sex_per);
        formData.append('employees_birthdate', birthdate_per);
        formData.append('employees_Department', department_work);
        formData.append('employees_appointmentDate', appdate_work);
        formData.append('Leave_Vacation', vacation_work);
        formData.append('Leave_Sick', sick_work);
        formData.append('Leave_Force', force_work);
        formData.append('Leave_Special', spl_work);
        formData.append('employees_Email', email_acc);
        formData.append('employees_Password', password_acc);

        // Send the employee data to the PHP file using an AJAX request
        $.ajax({
            url: 'add_employee.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Show the success alert
                $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> New employee has been added.');

                // Close the modal
                $('#ReviewModal').modal('hide');
                //
                // Close the error alert after 3 seconds
                setTimeout(function() {
                    $('#successAlert').removeClass('show').addClass('d-none');
                }, 2000);

                // // Go to employees.php after a short delay
                // setTimeout(function() {
                //     window.location.href = 'employees.php';
                // }, 2000);
            },
            error: function() {
                // Show the error alert
                $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> An error occurred while assigning the employee as admin.');

                // Close the error alert after 3 seconds
                setTimeout(function() {
                    $('#errorAlert').removeClass('show').addClass('d-none');
                }, 3000);

                // Go to employees.php after a short delay
                setTimeout(function() {
                    window.location.href = 'employees.php';
                }, 2000);
            }
        });
    };

    // Start reading the image file as ArrayBuffer
    reader.readAsArrayBuffer(imageData);
});