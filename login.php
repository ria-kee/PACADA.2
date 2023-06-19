
<?php
include('includes/dbh.inc.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $is_admin = 1;


// Prepare the SQL statement to retrieve the user's credentials from the database
    $stmt = $conn->prepare('SELECT * FROM employees WHERE employees_Email = ? AND is_admin = ?');
    $stmt->bind_param('si', $email, $is_admin);
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
                $_SESSION['admin_uID'] = $row['uID'];
                $_SESSION['admin_FirstName'] = $row['employees_FirstName'];
                $_SESSION['admin_MiddleName'] = $row['employees_MiddleName'];
                $_SESSION['admin_LastName'] = $row['employees_LastName'];
                $_SESSION['admin_email'] = $row['employees_Email'];
                $_SESSION['admin_Profile'] = $row['employees_image'];
                $_SESSION['is_superadmin'] = $row['is_superadmin'];
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

