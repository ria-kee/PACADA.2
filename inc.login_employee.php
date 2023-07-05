
<?php
include('includes/dbh.inc.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $is_superadmin = 0;
    $is_active = 1;


// Prepare the SQL statement to retrieve the user's credentials from the database
    $stmt = $conn->prepare('SELECT * FROM employees WHERE employees_Email = ?  AND is_superadmin = ? AND is_active = ?');
    $stmt->bind_param('sii', $email,  $is_superadmin,$is_active );
    $stmt->execute();

// Get the result of the query
    $result = $stmt->get_result();

// Check if a user with the provided email exists
    if ($result->num_rows === 1) {
        // Fetch the user's data
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['employees_Password'])) {
            // Password is correct
            //Start a session and store user information
            session_start();
            $_SESSION['employee_uID'] = $row['uID'];
            $_SESSION['employee_id'] = $row['employees_uid'];
            $_SESSION['employee_FirstName'] = $row['employees_FirstName'];
            $_SESSION['employee_MiddleName'] = $row['employees_MiddleName'];
            $_SESSION['employee_LastName'] = $row['employees_LastName'];
            $_SESSION['employee_email'] = $row['employees_Email'];
            $_SESSION['employee_Profile'] = $row['employees_image'];
        } else {
            // Password is incorrect
            // Send an error response
            http_response_code(401); // Set the HTTP response code to indicate authentication failure
            echo json_encode(['success' => false, 'error' => 'password incorrect']);

        }
    } else {
        // User with the provided email does not exist
        // Send an error response
        http_response_code(401); // Set the HTTP response code to indicate authentication failure
        echo json_encode(['success' => false, 'error' => 'email does not exist']);

    }


// Close the database connection
    $stmt->close();
    $conn->close();

}

