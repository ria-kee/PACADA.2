<?php
ob_start(); // Start output buffering

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
        $mail->isSMTP();                                            // Send using SMTP
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        $mail->Host = 'smtp.office365.com';                       // Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = 'techsupport@region1.dost.gov.ph';               // SMTP username
        $mail->Password = 'Ma!n@@c!tsm';                       // SMTP password (Use an App Password if 2-Step Verification is enabled)
        $mail->SMTPSecure = 'STARTTLS';                             // Enable TLS encryption
        $mail->Port = 587;                                    // TCP port to connect to

        // Recipients
        $mail->setFrom('techsupport@region1.dost.gov.ph', 'PACADA Tech Support');
        $mail->addAddress($get_email);                              // Add a recipient

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = 'Reset Password Notification';

        $mail_template = '
        <h2>Greetings!</h2>
        <h5 style="font-weight: unset">You are receiving this email because we received a password reset request for your account with the email ' . $get_email . '.</h5>
        <br/>
        <a href="http://192.168.0.138/PACADA.2/change_password.php?token=' . $token . '&email=' . $get_email . '" style="color:#5555a5"><b>Reset Password</b></a>
        ';

        $mail->Body = $mail_template;

        $mail->send();
        // Return the success response
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

ob_end_clean(); // Clean the output buffer

header('Content-Type: application/json');
echo json_encode($response);
