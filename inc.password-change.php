<?php
ob_start(); // Start output buffering
include('includes/dbh.inc.php');

if (isset($_POST['email']) && isset($_POST['password_token'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['new_confirm_password']);
    $token = mysqli_real_escape_string($conn, $_POST['password_token']);

    if (!empty($token)) {
        if (!empty($email) && !empty($new_password) && !empty($confirm_password)) {
            $check_token = "SELECT token FROM employees WHERE token='$token' LIMIT 1";
            $check_token_run = mysqli_query($conn, $check_token);

            if (mysqli_num_rows($check_token_run) > 0) {
                if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[-@$!%#?&])[A-Za-z\d@$!%#?&-]{8,}$/', $new_password)){
                    if ($new_password === $confirm_password) {
                        $sql = "UPDATE employees SET employees_Password = ? WHERE token = ? LIMIT 1";
                        // Prepare the statement and bind the parameters
                        $stmt = $conn->prepare($sql);
                        // Hash the password
                        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

                        // Bind the values to the placeholders
                        $stmt->bind_param('ss', $hashedPassword, $token);

                        // Execute the query and check for errors
                        if ($stmt->execute()) {
                            // Check if any rows were affected
                            if ($stmt->affected_rows > 0) {

//                                // Password updated successfully
//                                $response = array(
//                                    'success' => true,
//                                    'error' => 'Password updated successfully.'
//                                );

                                // Update the token column to clear its value
                                $clearTokenSql = "UPDATE employees SET token = 'NULL' WHERE employees_Email = '$email' LIMIT 1";
                                $clearTokenQuery = mysqli_query($conn, $clearTokenSql);

                                if ($clearTokenQuery) {
                                    // Token cleared successfully
                                    $response = array(
                                        'success' => true,
                                        'error' => 'Password updated successfully.'
                                    );
                                } else {
                                    // Failed to clear token
                                    $response = array(
                                        'success' => false,
                                        'error' => 'Failed to clear token.'
                                    );
                                }


                            } else {
                                // No changes made
                                $response = array(
                                    'success' => false,
                                    'error' => 'Password is not updated. Something went wrong.'
                                );
                            }
                        } else {
                            // Failed to execute the query
                            $response = array(
                                'success' => false,
                                'error' => $conn->error
                            );
                        }
                        // Close the statement
                        $stmt->close();
                    } else {
                        $response = array(
                            'success' => false,
                            'error' => 'Passwords do not match.'
                        );
                    }
                }
                else{
                    $response = array(
                        'success' => false,
                        'error' => 'Invalid password format. Password must be minimum eight characters, at least one letter, one number, and one special character.'
                    );
                }


            } else {
                $response = array(
                    'success' => false,
                    'error' => 'Invalid token.'. "\n" .' Please request a new reset link.'
                );
            }
        }
    } else {
        $response = array(
            'success' => false,
            'error' => 'Error updating password.'
        );
    }
}
else {
    $response = array(
        'success' => false,
        'error' => 'No token available. Please request a new reset link'
    );
}
ob_end_clean(); // Clean the output buffer

header('Content-Type: application/json');
echo json_encode($response);
