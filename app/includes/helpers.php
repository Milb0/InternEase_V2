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
        include '../loading.html';
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

    $login_info = $user->getLoginInfo($email,true);
    if ($login_info === false) {
        $email_err = "Account does not exist.";
        return false;
    }

    return true;
}


// Function to validate date format (YYYY-MM-DD)
function isValidDate($date)
{
    $datePattern = "/^\d{4}-\d{2}-\d{2}$/"; // Update the pattern to match "yyyy-mm-dd"
    $date = str_replace('/', '-', $date); // Replace "/" with "-"
    return preg_match($datePattern, $date);
}



function displayAlert($type) {
    $type = trim(filter_input(INPUT_GET, 'Type', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    switch ($type) {
        case '0':
            echo '<div id="alert-additional-content-3" class="p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
                    <div class="flex items-center">
                        <i class="fa-solid fa-circle-info w-4 h-4 mr-2"></i>
                        <h3 class="text-lg font-medium">Your request has been successfully created</h3>
                    </div>
                    <div class="mt-2 mb-4 text-sm">
                        The Information about Your Internship supervisor and the company he works for has been edited by the system since he&#39s saved in our system, check the details of your internship below and if you want any change contact us.
                    </div>
                    <div class="flex">
                    <a href="contactus.php" class="inline-flex items-center">
                    <button type="button" class="text-white bg-green-800 hover:bg-green-900 font-medium rounded-lg text-xs px-3 py-1.5 mr-2 text-center inline-flex items-center dark:bg-green-600 dark:hover:bg-green-700">
                      Contact Us
                    </button>
                  </a>
                  <button type="button" id="alert-close-button" onclick="closeAlertDialogue()" class="text-green-800 bg-transparent border border-green-800 hover:bg-green-900 hover:text-white font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-green-700 dark:border-green-600 dark:text-green-400 dark:hover:text-white" data-dismiss-target="#alert-additional-content-3" aria-label="Close">
                    Dismiss
                  </button>
                    </div>
                </div>';
            break;
        case '1':
            echo '<div id="alert-additional-content-3" class="p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800 relative" role="alert">
                    <div class="flex items-center">
                        <i class="fa-solid fa-circle-info w-4 h-4 mr-2"></i>
                        <h3 class="text-lg font-medium">Your request has been successfully created</h3>
                    </div>
                    <button id="alert-close-button" onclick="closeAlertDialogue()" type="button" class="absolute top-1 right-1 -mt-1 -mr-1 text-green-800 rounded-lg p-1.5 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-blue-400" aria-label="Close">
                    <i class="fa-solid fa-circle-xmark w-5 h-5 text-green-800 dark:text-green-800"></i>
                    </button>
                </div>';
            break;
        case '2':
            echo '<div id="alert-additional-content-3" class="p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800 relative" role="alert">
                    <div class="flex items-center">
                        <i class="fa-solid fa-circle-info w-4 h-4 mr-2"></i>
                        <h3 class="text-lg font-medium">Your Personal Information have been updated Successfully</h3>
                    </div>
                    <button id="alert-close-button" onclick="closeAlertDialogue()" type="button" class="absolute top-1 right-1 -mt-1 -mr-1 text-green-800 rounded-lg p-1.5 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-blue-400" aria-label="Close">
                    <i class="fa-solid fa-circle-xmark w-5 h-5 text-green-800 dark:text-green-800"></i>
                    </button>
                </div>';
            break;
        case '3':
            break;
        case '4':
            echo '<div id="alert-additional-content-3" class="p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800 relative" role="alert">
            <div class="flex items-center">
                <i class="fa-solid fa-circle-info w-4 h-4 mr-2"></i>
                <h3 class="text-lg font-medium">Your Login Credentials have been updated Successfully</h3>
            </div>
            <button id="alert-close-button" onclick="closeAlertDialogue()" type="button" class="absolute top-1 right-1 -mt-1 -mr-1 text-green-800 rounded-lg p-1.5 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-blue-400" aria-label="Close">
            <i class="fa-solid fa-circle-xmark w-5 h-5 text-green-800 dark:text-green-800"></i>
            </button>
        </div>';
            break;
            case '5':
                echo '<div id="alert-additional-content-3" class="p-4 mb-4 text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800 relative" role="alert">
                <div class="flex items-center">
                    <i class="fa-solid fa-circle-info w-4 h-4 mr-2"></i>
                    <h3 class="text-lg font-medium">You are not eligible for requesting a new Internship</h3>
                </div>
                <button id="alert-close-button" onclick="closeAlertDialogue()" type="button" class="absolute top-1 right-1 -mt-1 -mr-1 text-blue-800 rounded-lg p-1.5 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-blue-400" aria-label="Close">
                <i class="fa-solid fa-circle-xmark w-5 h-5 text-blue-800 dark:text-blue-800"></i>
                </button>
            </div>';
                break;
    }
}



function singOutModal (){
    echo '
    <div id="modal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75 transition-opacity"></div>
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all w-full max-w-lg dark:bg-gray-800" @click.away="closeModal()">
            <div class="p-4 sm:p-10 text-center overflow-y-auto">
                <span class="mb-4 inline-flex justify-center items-center w-[62px] h-[62px] rounded-full border-4 border-yellow-50 bg-yellow-100 text-yellow-500">
                    <i class="fa-sharp fa-solid fa-circle-exclamation w-4 h-4" style="color: #f0bf4c;"></i>
                </span>
                <h3 class="mb-2 text-2xl font-bold text-gray-800 dark:text-white">Sign out</h3>
                <p class="text-gray-500">Are you sure you would like to sign out of your account?</p>
                <div class="mt-6 flex justify-center gap-x-4">
                    <a class="py-2.5 px-4 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-200 text-sm" href="../logout.php">Sign out</a>
                    <button class="py-2.5 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm" onclick="closeSignOutModal()">
                    Cancel
                </button>
                </div>
            </div>
        </div>
    </div>
';
}

function Eligibility($id,$internship){
    if (!$internship->requestingEligibility($id)){
        header('location:dashboard.php?Type=5');
    }
}
