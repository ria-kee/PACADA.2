$(document).ready(function() {
    $('#loginForm').submit(function(event) {
        event.preventDefault(); // Prevent form submission

        // Get form values
        const input_email = $('#signIn_email').val();
        const input_password = $('#signIn_password').val();


        function displayErrorMessage(errorMessage) {
            $('#error')
                .removeClass('d-none')
                .addClass('show')
                .css({
                    display: 'flex',
                    alignItems: 'center',
                    // justifyContent: 'center', /* Center vertically */
                    flexDirection: 'row'
                });

            // Show the error message in the error div
            $('#error').removeClass('d-none').addClass('show');
        }

        // Send an AJAX request to the server
        $.ajax({
            url: 'inc.login_employee.php',
            type: 'POST',
            data:{ email: input_email, password: input_password },
            success: function(response) {

                // Successful login, redirect or perform desired action
                window.location.href = 'employee_dashboard.php';
            },
            error: function(xhr, status, error) {
                displayErrorMessage();

            }

        });

    });
});
