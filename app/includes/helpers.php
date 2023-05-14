<?php

use PHPMailer\PHPMailer\PHPMailer;

/**
 *Sends an email to a specified email address using PHPMailer.
 *@param string $email The email address to send the email to.
 *@param string $code The verification code to include in the email.
 *@return void
 *@throws Exception Throws an exception if an error occurs while sending the email.
 */
function send_email($email, $code)
{
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    // create object of PHPMailer class with boolean parameter which sets/unsets exception.
    $mail = new PHPMailer(true);

    $mail->isSMTP(); // using SMTP protocol
    $mail->Host = 'smtp.gmail.com'; // SMTP host as gmail
    $mail->SMTPAuth = true; // enable smtp authentication
    $mail->Username = 'bennacermohilyes@gmail.com'; // sender gmail host
    $mail->Password = 'ecdsazimxecybpxz'; // sender gmail host password
    $mail->SMTPSecure = 'tls'; // for encrypted connection
    $mail->Port = 587; // port for SMTP

    $mail->isHTML(true);
    $mail->setFrom('bennacermohilyes@gmail.com', "InternEase"); // sender's email and name
    $mail->addAddress($email, 'Dear User'); // receiver's email and name
    $mail->Subject = 'Email verification';
    $mail->Body = 'Please verify your account by entering the following code:' . $code;

    if (!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        // Email sent successfully
        header('Location: ../student/verification.php');
        exit();
    }
}


function redirect_unauthorized_user(string $user): void
{
    if (isset($_SESSION['id'])) {
        $URL = "../{$user}/dashboard.php";
        header("Location: $URL");
        exit;
    }else {
        $URL = "../{$user}/login.php";
        header("Location: $URL");
        exit;
    }
}






/**
 *Validates an email address and retrieves login info for the specified user.
 *@param string $email The email address to validate.
 *@param string $email_err A variable to hold any error message related to the email address validation.
 *@param object $login_info A variable to hold the retrieved login info.
 *@param object $user An instance of a model class.
 *@return bool Returns true if the email address is valid and login info was retrieved successfully, false otherwise.
 */
function validateEmail(String $email, String &$email_err, &$login_info, $user): bool
{
    if (empty(trim($email))) {
        $email_err = "Please enter your email address.";
        return false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
        return false;
    }

    $login_info = $user->getLoginInfo($email);
    if ($login_info === false) {
        $email_err = "Account does not exist.";
        return false;
    }

    return true;
}
