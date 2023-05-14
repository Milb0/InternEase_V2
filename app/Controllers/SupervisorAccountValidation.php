<?php
TODO: // Session User Authentication // the email might not get changed and I must allow it.

require_once BASE_DIR . 'app/Models/InternshipSupervisor.php';
require_once BASE_DIR . 'app/Models/Company.php';
$InternshipSupervisor = new InternshipSupervisor();
$Company = new Company();
// define variables and set to empty values
$name = $email = $password = $confirm_password = $phone = $address = "";
$name_err = $email_err = $password_err = $confirm_password_err = $phone_err = $address_err = "";

// Processing form form's data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    }
    
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email address.";
    } else {
        $safe_email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    
        if (!filter_var($safe_email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format.";
        } elseif ($safe_email !== $_SESSION['supervisor']['email'] && $InternshipSupervisor->isEmailTaken($safe_email)) {
            $email_err = "This email is already taken.";
        } else {
            $email = $safe_email;
        }
    }
    
    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } else {
        $safe_password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        if (strlen($safe_password) < 8 || strlen($safe_password) > 64) {
            $password_err = "Password must be between 8 and 64 characters.";
        } else {
            $password = $safe_password;
        }
    }    

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim(filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Validate phone
    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Please enter your phone number.";
        $errors["phone_err"] = $phone_err;
    } else {
        $safe_phone=trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        if (!preg_match("/^\+?\d+$/", $safe_phone)) {
            $phone_err = "Invalid phone format.";
        } else {
            $phone = $safe_phone;
        }
    }

    // Validate company's address 
    if (empty(trim($_POST["address"]))) {
        $address_err = "Please enter an address.";
    } else {
        $address = trim(filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    }


    if (empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($phone_err) && empty($address_err)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        if($InternshipSupervisor->updateInternshipSupervisor($_SESSION['supervisor']['id'], $name,$email,$password_hash,$phone)){
            if ($Company->updateCompany($_SESSION['supervisor']['company_id'],'',$address)){
                $InternshipSupervisor->accountCompleted($_SESSION['supervisor']['id']);
                $_SESSION['ID']=$_SESSION['supervisor']['id'];
                unset($_SESSION['supervisor']);
                $_SESSION['account_completed']=true;
                header('Location: ../internship-supervisor/dashboard.php');
            }
        }
    } else {
        $HiddenInputMessage = "Something went wrong, Please try again.";
    }
}
