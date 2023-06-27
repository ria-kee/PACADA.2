const inputs = document.querySelectorAll(".input-field");
const toggle_btn = document.querySelectorAll(".toggle");
const main = document.querySelector("main");
const bullets = document.querySelectorAll(".bullets span");
const images = document.querySelectorAll(".image");

inputs.forEach((inp) => {
    inp.addEventListener("focus", () => {
        inp.classList.add("active");
    });
    inp.addEventListener("blur", () => {
        if (inp.value != "") return;
        inp.classList.remove("active");
    });
});

toggle_btn.forEach((btn) => {
    btn.addEventListener("click", () => {
        main.classList.toggle("sign-up-mode");
    });
});


const passwordInput = document.getElementById('new_password');
const confirmInput = document.getElementById('new_confirm_password');

passwordInput.addEventListener('input', function(event) {
    $('#change-success').removeClass('show').addClass('d-none');
    $('#change-error').removeClass('show').addClass('d-none');
});

confirmInput.addEventListener('input', function(event) {
    $('#change-success').removeClass('show').addClass('d-none');
    $('#change-error').removeClass('show').addClass('d-none');
});


$(document).ready(function() {


    const form = $('#change-password-form');

    // Handle form submission
    form.submit(function(event){
        event.preventDefault(); // Prevent the default form submission
        // Create a new FormData object and append the form data
        const formData = new FormData(this);


        // Perform an AJAX request
        $.ajax({
            url: 'inc.password-change.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Handle the response here
                if (response.success) {
                    // Display success message
                    $('#change-error').removeClass('show').addClass('d-none');
                    $('#change-success').removeClass('d-none').addClass('show');
                    // Redirect to a login page
                    setTimeout(function() {
                        window.location.href = 'employee-login.php';
                        exit();
                    }, 2000);

                } else {
                    // Display error message
                    $('#change-success').removeClass('show').addClass('d-none');
                    $('#change-error').removeClass('d-none').addClass('show');
                    $('#change-error-text').html(response.error.replace(/\n/g, '<br>'));
                }
            },
            error: function(xhr, status, error) {
                // Display error message
                $('#change-success').removeClass('show').addClass('d-none');
                $('#change-error').removeClass('d-none').addClass('show');
                $('#change-error-text').text('Password could not be changed. Error: ' + error);
            }

        });
    });
});