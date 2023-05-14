<?php
$email = $password = $user_type = $email_err = $password_err = "";
$HiddenInputMessage = NULL;
$login_info = NULL;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $HiddenInputMessage = NULL;
    $user_type = trim(filter_input(INPUT_POST, 'identity', FILTER_SANITIZE_SPECIAL_CHARS));
    switch ($user_type) {
        case 'student':
            require_once BASE_DIR . 'app/Models/Student.php';

            $student = new Student();
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
                            include '../student/loading.html';
                            header('Location: ../student/dashboard.php');
                            exit;
                        } else {
                            $_SESSION["verification_code"] = $student->getStudentVerificationCode($_SESSION['id']);
                            header("location:../student/verification.php");
                            exit;
                        }
                    }
                }
            } else {
                $email = NULL;
            }
            break;
        case 'DepartmentHead':
            require_once BASE_DIR . 'app/Models/DepartmentHead.php';
            $DepartmentHead = new DepartmentHead();
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
            }
            break;
        case 'internshipsupervisor':
            require_once BASE_DIR . 'app/Models/InternshipSupervisor.php';
            require_once BASE_DIR . 'app/Models/Company.php';
            $InternshipSupervisor = new InternshipSupervisor();
            $company= new Company();
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
                            $_SESSION["supervisor"] = $InternshipSupervisor->getInternshipSupervisor($email);
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
            }
            break;
        default:
            $HiddenInputMessage = "Something went wrong, Please try again.";
            break;
    }
}
