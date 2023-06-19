
    function togglePasswordVisibility() {
    var passwordInput = document.getElementById("new_password");
    var passwordToggle = document.getElementById("new_passwordToggle");

    if (passwordInput.type === "password") {
    passwordInput.type = "text";
    passwordToggle.innerHTML = '<i class="bi bi-eye-fill"></i>';
} else {
    passwordInput.type = "password";
    passwordToggle.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';

}
}

    function CurrentTogglePasswordVisibility() {
        var passwordInput = document.getElementById("current_password");
        var passwordToggle = document.getElementById("current_passwordToggle");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordToggle.innerHTML = '<i class="bi bi-eye-fill"></i>';
        } else {
            passwordInput.type = "password";
            passwordToggle.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';

        }
    }

    function ConfirmTogglePasswordVisibility() {
        var passwordInput = document.getElementById("confirm_password");
        var passwordToggle = document.getElementById("confirm_passwordToggle");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordToggle.innerHTML = '<i class="bi bi-eye-fill"></i>';
        } else {
            passwordInput.type = "password";
            passwordToggle.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';

        }
    }

    // Event listener for modal close event
    var changePassModal = document.getElementById("ChangePassModal");

    changePassModal.addEventListener("hidden.bs.modal", function () {
        var currentInput = document.getElementById("current_password");
        var newInput = document.getElementById("new_password");
        var confirmInput = document.getElementById("confirm_password");
        var new_passwordToggle = document.getElementById("new_passwordToggle");
        var current_passwordToggle = document.getElementById("current_passwordToggle");
        var confirm_passwordToggle = document.getElementById("confirm_passwordToggle");


        currentInput.value = "";  // Clear the value of current password input
        newInput.value = "";      // Clear the value of new password input
        confirmInput.value = "";  // Clear the value of confirm password input

        currentInput.type = "password";
        newInput.type = "password";
        confirmInput.type = "password";
        current_passwordToggle.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
        confirm_passwordToggle.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';

        confirm_passwordToggle.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
    });




    const currentPasswordInput = document.getElementById("current_password");
    const currentPassword = currentPasswordInput.value.trim();
    const currentFeedback = document.getElementById("current-invalid-feedback");


    const newPasswordInput = document.getElementById("new_password");
    const newPassword = newPasswordInput.value;
    const newFeedback = document.getElementById("new-invalid-feedback");


    const confirmPasswordInput = document.getElementById("confirm_password");
    const confirmPassword = confirmPasswordInput.value;
    const confirmFeedback = document.getElementById("confirm-invalid-feedback");


    function validateCurrent() {
        if (currentPasswordInput.value.trim() === '') {
            currentPasswordInput.classList.add('is-invalid');
            currentFeedback.textContent = 'Current Password is required.';
            return false;
        } else {
            currentPasswordInput.classList.remove('is-invalid');
            currentFeedback.textContent = '';
            return true;
        }
    }

    function validateNew() {
        var newPasswordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[-@$!%#?&])[A-Za-z\d@$!%#?&-]{8,}$/;
        var newPassword = newPasswordInput.value.trim();

        if (newPasswordInput.value.trim() === '') {
            newPasswordInput.classList.add('is-invalid');
            newFeedback.textContent = 'New Password is required.';
            return false;
        } else if (!newPasswordRegex.test(newPassword)) {
            newPasswordInput.classList.add('is-invalid');
            newFeedback.textContent = 'New Password must contain at least 8 characters, one letter, one number, and one special character (-@$!%#?&).';
            return false;
        }  else {
            newPasswordInput.classList.remove('is-invalid');
            newFeedback.textContent = '';
            return true;
        }
    }

    function validateConfirm() {
        if (confirmPasswordInput.value.trim() === '') {
            confirmPasswordInput.classList.add('is-invalid');
            confirmFeedback.textContent = 'New Password is required.';
            return false;
        } else {
            confirmPasswordInput.classList.remove('is-invalid');
            confirmFeedback.textContent = '';
            return true;
        }
    }

    function checkPasswordMatch(){
        var newPassword = newPasswordInput.value.trim();
        var confirmPassword = confirmPasswordInput.value.trim();

        if (newPassword !== confirmPassword) {
            // If passwords don't match, show an error message
            confirmPasswordInput.classList.add('is-invalid');
            confirmFeedback.textContent = 'New Password and Confirm Password must match.';
            return false;
        } else {
            // Passwords match, remove error classes and messages
            confirmPasswordInput.classList.remove('is-invalid');
            confirmFeedback.textContent = '';
            return true;
        }
    }


    const saveChanges = document.getElementById("saveChanges");

    saveChanges.addEventListener("click", function() {


        validateCurrent();
        validateNew();
        validateConfirm();

        console.error(currentPasswordInput.value);


        currentIsValid = validateCurrent();
        newIsValid = validateNew();
        confirmIsValid = validateConfirm();

        if (currentIsValid && newIsValid && confirmIsValid){
           if(checkPasswordMatch()){
               // Perform the AJAX request to remove the admin
               $.ajax({
                   url: 'inc.check_currentPassword.php',
                   type: 'POST',
                   data: { current: currentPasswordInput.value },
                   success: function(response) {
                       // Response should contain the result of the password check from the server
                       if (response === 'valid') {
                                   //Current password matches the one from the database
                                   $.ajax({
                                       url: 'inc.updatePassword.php',
                                       type: 'POST',
                                       data: { new: newPasswordInput.value},
                                       success: function(response) {
                                           // Response should contain the result of the password check from the server
                                           if (response === 'success') {
                                               // Show the success alert
                                               $('#successAlert').removeClass('d-none').addClass('show').html('<i class="bi-check-circle-fill me-2"></i><strong>Success!</strong> ' + 'Password is updated successfully.');

                                               // Close the modal
                                               $('#ChangePassModal').modal('hide');

                                               // Close the success alert after 3 seconds
                                               setTimeout(function() {
                                                   $('#successAlert').removeClass('show').addClass('d-none');
                                               }, 3000)


                                           } else {
                                               // Current password does not match the one from the database
                                               $('#errorAlert').removeClass('d-none').addClass('show').html('<i class="bi-exclamation-octagon-fill me-2"></i><strong>Error!</strong> An error occurred while updating password.');

                                               // Close the modal
                                               $('#ChangePassModal').modal('hide');

                                               // Close the error alert after 3 seconds
                                               setTimeout(function() {
                                                   $('#errorAlert').removeClass('show').addClass('d-none');
                                               }, 3000);

                                           }
                                       },
                                       error: function(xhr, status, error) {
                                           // Handle any error that occurred during the AJAX request
                                           console.error('Error:', error);
                                       }
                                   });



                       } else {
                           // Current password does not match the one from the database
                           currentPasswordInput.classList.add('is-invalid');
                           currentFeedback.textContent = 'Current Password is incorrect.';

                       }
                   },
                   error: function(xhr, status, error) {
                       // Handle any error that occurred during the AJAX request
                       console.error('Error:', error);
                   }
               });

           }
        }







    });

