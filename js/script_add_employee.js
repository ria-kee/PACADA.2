

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
var isFirstNameIncreaseDone = false;
firstNameInput.addEventListener('keyup', function() {
    this.value = capitalizeWords(this.value);
    validateFirstName();

     if (this.value.trim() !== '' && !isFirstNameIncreaseDone) {
        progress += 12.5;
        progressIndicator.style.width = progress + '%';
        isFirstNameIncreaseDone = true;
    }
         if (this.value.trim() === '') {
             progress -= 12.5;
             progressIndicator.style.width = progress + '%';
             isFirstNameIncreaseDone = false;
         }



});

// Capitalize Middle Name Event
middleNameInput.addEventListener('keyup', function() {
    this.value = capitalizeWords(this.value);
});


var isLastNameIncreaseDone = false;
// Validate Last Name Event
lastNameInput.addEventListener('keyup', function() {
    this.value = capitalizeWords(this.value);
    validateLastName();

    if (this.value.trim() !== '' && !isLastNameIncreaseDone) {
        progress += 12.5;
        progressIndicator.style.width = progress + '%';
        isLastNameIncreaseDone = true;
    }
    if (this.value.trim() === '') {
        progress -= 12.5;
        progressIndicator.style.width = progress + '%';
        isLastNameIncreaseDone = false;
    }
});

var isBirthdateIncreaseDone = false;
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








var isSexIncreaseDone = false;
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
var isDeptIncreaseDone = false;
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

var isApptdateIncreaseDone = false;
// Validate Appointment Event
apptdateInput.addEventListener('change',function (){
    validateAppDate();

    if(this.value !== '' && !isApptdateIncreaseDone){
        progress += 8;
        progressIndicator.style.width = progress + '%';
        isApptdateIncreaseDone = true;
    }

    if (vacationInput.value.trim() !== '' && !isVacationIncreaseDone) {
        progress += 8;
        progressIndicator.style.width = progress + '%';
        isVacationIncreaseDone = true;
    }


    if (forceInput.value.trim() !== '' && !isForceIncreaseDone) {
        progress += 5;
        progressIndicator.style.width = progress + '%';
        isForceIncreaseDone = true;
    }

    if(this.value === ''){
        progress -= 8;
        progressIndicator.style.width = progress + '%';
        isApptdateIncreaseDone = false;
    }
});

// Validate Vacation Event
var isVacationIncreaseDone = false;
vacationInput.addEventListener('change',function (){
    validateVacation();

    if (this.value.trim() !== '' && !isVacationIncreaseDone) {
        progress += 8;
        progressIndicator.style.width = progress + '%';
        isVacationIncreaseDone = true;
    }
    if (this.value.trim() === '') {
        progress -= 8;
        progressIndicator.style.width = progress + '%';
        isVacationIncreaseDone = false;
    }
});

// Validate Sick Event
var isSickIncreaseDone = false;
sickInput.addEventListener('change',function (){
    validateSick();
    if (this.value.trim() !== '' && !isSickIncreaseDone) {
        progress += 8;
        progressIndicator.style.width = progress + '%';
        isSickIncreaseDone = true;
    }
    if (this.value.trim() === '') {
        progress -= 8;
        progressIndicator.style.width = progress + '%';
        isSickIncreaseDone = false;
    }
});





// Validate ID Event
var isIdIncreaseDone = false;
idInput.addEventListener('change', function (){

    validateId();

    if (this.value.trim() !== '' && !isIdIncreaseDone) {
        progress += 8;
        progressIndicator.style.width = progress + '%';
        isIdIncreaseDone = true;
    }
    if (this.value.trim() === '') {
        progress -= 8;
        progressIndicator.style.width = progress + '%';
        isIdIncreaseDone = false;
    }

});






// Validate Force Event
var isForceIncreaseDone = false;
forceInput.addEventListener('change',function (){
    validateForce();
    if (this.value.trim() !== '' && !isForceIncreaseDone) {
        progress += 5;
        progressIndicator.style.width = progress + '%';
        isForceIncreaseDone = true;
    }
    if (this.value.trim() === '') {
        progress -= 5;
        progressIndicator.style.width = progress + '%';
        isForceIncreaseDone = false;
    }
});

var isSplIncreaseDone = false;
// Validate SPL Event
splInput.addEventListener('change',function (){
    validateSpl();
    if (this.value.trim() !== '' && !isSplIncreaseDone) {
        progress += 5;
        progressIndicator.style.width = progress + '%';
        isSplIncreaseDone = true;
    }
    if (this.value.trim() === '') {
        progress -= 5;
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

// var validID = false;
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




// Form File Input Change Event
formFile.addEventListener('change', function() {
    const file = this.files[0];

    if (file) {
        const fileSize = file.size / (1024 * 1024); // Convert file size to MB
        const fileExtension = file.name.split('.').pop().toLowerCase();

        // Check if file is an image, within size limit, and has a valid extension
        if (file.type.startsWith('image/') && fileSize <= 5 && (fileExtension === 'jpg' || fileExtension === 'jpeg' || fileExtension === 'png' || fileExtension === 'gif')) {
            const reader = new FileReader();

            reader.addEventListener('load', function() {
                previewImage.src = this.result;
                invalidFeedback.textContent = ''; // Clear any previous error message
                currentImage = this.result; // Update the current image variable
            });

            reader.readAsDataURL(file);
        } else {
            // Display error message for invalid file type, size, or extension
            invalidFeedback.textContent = 'Please select a valid image file (up to 5MB).';
            this.value = ''; // Reset the file input
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










// WHEN NEXT BUTTON IS CLICKED
nextButton.addEventListener('click', function() {
    // Validate First Name, Last Name, and Date of Birth
    const isFirstNameValid = validateFirstName();
    const isLastNameValid = validateLastName();
    const isBirthdateValid = validateBirthdate();
    const isSexValid = validateSex();



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

        // Save the uploaded image if available
        if (currentImage) {
            localStorage.setItem('currentImage', currentImage);
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

// Retrieve the personalDetails object from localStorage
const personalDetailsJSON = localStorage.getItem('personalDetails');
const personalDetails = JSON.parse(personalDetailsJSON);

// Retrieve  personalDetails
const fullName = personalDetails.firstName + ' ' + personalDetails.middleName + ' ' + personalDetails.lastName ;
const sex = personalDetails.sex;
const birthdate = personalDetails.birthdate;

// Retrieve the workDetails object from localStorage
const workDetailsJSON = localStorage.getItem('workDetails');
const workDetails = JSON.parse(workDetailsJSON);


// Retrieve  workDetails
const department = workDetails.department;
const appdate = workDetails.appdate;
const vacation = workDetails.vacation;
const sick = workDetails.sick;
const force =workDetails.force;
const spl = workDetails.spl;



// Retrieve the accountDetails object from localStorage
const accountDetailsJSON = localStorage.getItem('personalDetails');
const accountDetails = JSON.parse(accountDetailsJSON);


// Retrieve the currentImage from localStorage
const profile = localStorage.getItem('currentImage');


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
        const email_acc = accountDetails.email;
        const password_acc = accountDetails.password;

        reviewID.innerHTML = idInput.value;
        reviewName.innerHTML =  fullName;

    if (sex==='F'){
        reviewSex.innerHTML = 'Female';
        }else{
        reviewSex.innerHTML = 'Male';
        }

        reviewBirth.innerHTML = birthdate;



        // Make an AJAX request to execute the MySQL query
        var xhr = new XMLHttpRequest();
        var departmentId = department;

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



        reviewAppDate.innerHTML = appdate;

        reviewVacation.innerHTML = vacation;

        reviewSick.innerHTML = sick;

        reviewForce.innerHTML = force;

        reviewSpl.innerHTML = spl;

        reviewEmail.innerHTML = email_acc;

        reviewPassword.innerHTML = password_acc;

        $('#ReviewModal').modal('show');

    }
    })();
});

$('#ReviewModal').on('hidden.bs.modal', function () {
    c3Element.innerHTML = '3';
});
