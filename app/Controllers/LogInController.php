<?php
$email = $password = $user_type = $email_err = $password_err = $form_error_message = "";
$HiddenInputMessage = NULL;
$login_info = NULL;
$expected_input_names = array(
    'email',
    'password',
    'identity',
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $HiddenInputMessage = NULL;
    $user_type = trim(filter_input(INPUT_POST, 'identity', FILTER_SANITIZE_SPECIAL_CHARS));
    switch ($user_type) {
        case 'student':
            try {
                foreach ($expected_input_names as $input_name) {
                    if (!isset($_POST[$input_name])) {
                        throw new Exception("Something Went Wrong Try again please");
                    }
                }
            $student = new Student($db_conn);
            $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $email = trim($_POST['email']);
            if (validateEmail($email, $email_err, $login_info, $student)) {
                if (empty($password)) {
                    $password_err = "Please enter a password.";
                    $errors["password_err"] = $password_err;
                } else {
                    if (!password_verify($password, $login_info['password_hashed'])) {
                        $password_err = "Incorrect password.";
                    } else {
                        $_SESSION['id'] =$student->getStudentID($email);
                        if ($student->isVerified($_SESSION['id'])) {
                            $_SESSION['user_type'] = 'student';
                            include '../loading.html';
                            header('Location: ../student/dashboard.php');
                            exit;
                        } else {
                            $_SESSION["verification_code"] = $student->getStudentVerificationCode($_SESSION['id']);
                            include '../loading.html';
                            header("location:../student/verification.php");
                            exit;
                        }
                    }
                }
            } else {
                $email = NULL;
            }} catch (Exception $e) {
                $form_error_message = $e->getMessage();
            }
            break;
        case 'DepartmentHead':
            try {
                foreach ($expected_input_names as $input_name) {
                    if (!isset($_POST[$input_name])) {
                        throw new Exception("Something Went Wrong Try again please");
                    }
                }
                $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $email = trim($_POST['email']);
            if (validateEmail($email, $email_err, $login_info, $DepartmentHead)) {
                if (empty($password)) {
                    $password_err = "Please enter a password.";
                    $errors["password_err"] = $password_err;
                } else {
                    if (!password_verify($password, $login_info['password_hashed'])) {
                        $password_err = "Incorrect password.";
                    } else {
                        $_SESSION["email"] = $email;
                        $_SESSION['user_type'] = 'DepartmentHead';
                        header('Location: ../DepartmentHead/dashboard.php');
                        exit;
                    }
                }
            } else {
                $email = NULL;
            }} catch (Exception $e) {
                $form_error_message = $e->getMessage();
            }
            break;
        case 'internshipsupervisor':
            try {
                foreach ($expected_input_names as $input_name) {
                    if (!isset($_POST[$input_name])) {
                        throw new Exception("Something Went Wrong Try again please");
                    }
                }
            $InternshipSupervisor = new InternshipSupervisor($db_conn);
            $company= new Company($db_conn);
            $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $email = trim($_POST['email']);
            if (validateEmail($email, $email_err, $login_info, $InternshipSupervisor)) {
                if (empty($password)) {
                    $password_err = "Please enter a password.";
                    $errors["password_err"] = $password_err;
                } else {
                    if (!password_verify($password, $login_info['password_hashed'])) {
                        $password_err = "Incorrect password.";
                    } else {
                        $_SESSION['user_type'] = 'internship-supervisor';
                        $_SESSION["email"] = $email;
                        if ($InternshipSupervisor->isFirstLogin($email)) {
                            $_SESSION["supervisor"] = $InternshipSupervisor->getInternshipSupervisor($email,true);
                            ;
                            $_SESSION["sup_company"] = $company->getCompany($_SESSION['supervisor']['company_id'],true);
                            header("location:../internship-supervisor/complete-account.php");
                            exit;
                        } else {
                            $_SESSION['id'] = $InternshipSupervisor->getInternshipSupervisorID($email);
                            $_SESSION['account_completed']=true;
                            header('Location: ../internship-supervisor/dashboard.php');
                            exit;
                        }
                    }
                }
            } else {
                $email = NULL;
            }} catch (Exception $e) {
                $form_error_message = $e->getMessage();
            }
            break;
        default:
            $HiddenInputMessage = "Something went wrong, Please try again.";
            break;
    }
}
