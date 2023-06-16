$(document).ready(function() {


    const form = $('#password-reset-form');
    // Get the email input element
    const emailInput = document.getElementById('reset-email');

// Add an event listener for the 'input' event
    emailInput.addEventListener('input', function(event) {
        $('#phpmailer-success').removeClass('show').addClass('d-none');
        $('#phpmailer-error').removeClass('show').addClass('d-none');
    });
    // Handle form submission
    form.submit(function(event){
        event.preventDefault(); // Prevent the default form submission

        // Create a new FormData object and append the form data
        const formData = new FormData(this);


        // Perform an AJAX request
        $.ajax({
            url: 'inc.password-reset-link.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Handle the response here
                if (response.success) {
                    // Display success message
                    $('#phpmailer-success').removeClass('d-none').addClass('show');
                } else {
                    // Display error message
                    $('#phpmailer-error').removeClass('d-none').addClass('show');
                    $('#phpmailer-error-text').text( response.error);
                }
            },
            error: function(xhr, status, error) {
                // Display error message
                $('#phpmailer-error').removeClass('d-none').addClass('show');
                $('#phpmailer-error-text').text('Email could not be sent. Error: ' + error);
                console.error($(this).serialize());
                console.error(xhr.responseText);
            }

        });
    });
});