<?php
include('includes/dbh.inc.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$response = array();

function send_password_reset($get_name, $get_email, $token)
{
    $mail = new PHPMailer(true);

    try {
        // ... (your code for sending email)

        return array(
            'success' => true,
            'message' => 'Email sent successfully!'
        );
    } catch (Exception $e) {
        return array(
            'success' => false,
            'error' => 'Exception: Email could not be sent. Error: ' . $mail->ErrorInfo
        );
    }
}

if (isset($_POST['email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $token = md5(rand());

    $check_email = "SELECT * FROM employees WHERE employees_Email='$email' AND (is_admin=1 OR is_superadmin=1) LIMIT 1 ";
    $check_email_run = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($check_email_run) > 0) {
        $row = mysqli_fetch_array($check_email_run);
        $get_name = $row['employees_FirstName'];
        $get_email = $row['employees_Email'];

        $update_token = "UPDATE employees SET token='$token' WHERE employees_Email='$email' LIMIT 1 ";
        $update_token_run = mysqli_query($conn, $update_token);

        if ($update_token_run) {
            $result = send_password_reset($get_name, $get_email, $token);
            if ($result['success']) {
                $response = array(
                    'success' => true,
                    'message' => 'Email sent successfully!'
                );
            } else {
                $response = array(
                    'success' => false,
                    'error' => $result['error']
                );
            }
        } else {
            $response = array(
                'success' => false,
                'error' => 'Error updating token.'
            );
        }
    } else {
        $response = array(
            'success' => false,
            'error' => 'No account found with that email address.'
        );
    }
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
