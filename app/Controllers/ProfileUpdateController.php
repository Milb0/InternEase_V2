<?php
$name_err = $birthdate = $birthplace_err = $phonenumber_err = $department_err = $grade_err = $old_password_err = $new_password_err = $confirm_password_err = "";

$name = $birthdate_err = $birthplace = $phonenumber = $department = $grade = $old_password = $confirm_password = $new_password = "";

$form_error_message = "";

$student = new Student($db_conn);
$department_obj = new Department($db_conn);
switch ($safetype) {
    case 'persona':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $expected_input_names = array(
                "name",
                "birthdate",
                "birthplace",
                "phonenumber",
            );
            try {
                foreach ($expected_input_names as $input_name) {
                    if (!isset($_POST[$input_name])) {
                        throw new Exception("Something Went Wrong Try again please");
                    }
                }
                if (trim(($_POST["name"]))) {
                    if (!preg_match('/^[A-Za-z\s\'\-]+$/u', $_POST["name"])) {
                        $name_err = "Please enter a valid name.";
                    } else {
                        $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    }
                }

                // Validate Student's birthdate
                if (trim($_POST["birthdate"])) {
                    $birthdate = trim($_POST["birthdate"]);
                    if (!isValidDate($birthdate)) {
                        $birthdate_err = "Invalid Start Date format.";
                    }
                }


                // Validate Student's birthplace
                if (trim($_POST["birthplace"])) {
                    if (!preg_match('/^[\p{L}\p{N}\s\'\-.,]+$/u', $_POST["birthplace"])) {
                        $birthplace_err = "Please enter a valid birthplace.";
                    } else {
                        $birthplace = trim(filter_input(INPUT_POST, 'birthplace', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    }
                }


                // Validate Student's Phone Number
                if (trim($_POST["phonenumber"])) {
                    $safe_phone = trim(filter_input(INPUT_POST, 'phonenumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    if (!preg_match("/^\+?\d+$/", $safe_phone)) {
                        $phonenumber_err = "Invalid phone format.";
                    } else {
                        $phonenumber = $safe_phone;
                    }
                }


                if (!empty($name) || !empty($birthdate) || !empty($birthdate) || !empty($phonenumber)) {
                    if (empty($name_err) && empty($birthdate_err) && empty($birthplace_err) && empty($phonenumber_err)) {
                        if ($student->updateStudent($_SESSION['id'], $name, $birthdate, $birthplace, "", "", "", $phonenumber)) {
                            include '../loading.html';
                            header('Location: ../student/profile.php?Type=2');
                            exit();
                        }
                    }
                } else {
                    $name_err = "You didn't perform any changes.";
                }
            } catch (Exception $e) {
                $form_error_message = $e->getMessage();
            }
        }

        break;

    case 'academia':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $expected_input_names = array(
                "department",
                "grade",
            );
            try {
                foreach ($expected_input_names as $input_name) {
                    if (!isset($_POST[$input_name])) {
                        throw new Exception("Something Went Wrong Try again please");
                    }
                }
                if (trim($_POST['department'])) {
                    $department = trim(filter_input(INPUT_POST, 'department', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $department_names = $department_obj->getDepartmentNames();
                    $allowedDepartments = [];
                    foreach ($department_names as $department_name) {
                        $allowedDepartments[] = $department_name['name'];
                    }

                    if (in_array($department, $allowedDepartments, true)) {
                        try {
                            $department_id = $department_obj->getDepartmentId($department);
                        } catch (Exception $e) {
                            $department_err = 'Something went wrong, please try again later.';
                        }
                        if (trim($_POST['grade'])) {
                            $grade = trim(filter_input(INPUT_POST, 'grade', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                            $allowedGrades = ["L3 TI", "L3 SCI", "M2 STIC", "M2 RSD", "L3 GL", "L3 SI", "M2 SITW", "M2 GL"];
                            if (!in_array($grade, $allowedGrades, true)) {
                                $department_err = "Something went wrong with the grade you choose. Please try again.";
                            }
                        } else {
                            $department = null;
                            $department_err = "Please select a department.";
                        }
                    } else {
                        $department_err = 'Select a valid department.';
                    }
                    if (!empty($department) && isset($grade)) {
                        if (empty($department_err) && isset($grade)) {
                            if ($student->updateStudent($_SESSION['id'], "", "", "", $department_id, "", $grade, "")) {
                                include '../loading.html';
                                header('Location: ../student/profile.php?Type=3');
                                exit();
                            }
                        }
                    } else {
                        $department_err = "You didn't perform any changes.";
                    }
                }
            } catch (Exception $e) {
                $form_error_message = $e->getMessage();
            }
        }

        break;

    case 'auth':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty(trim($_POST['old-password']))) {
                $old_password_err = "Please enter your current password";
            } else {
                $safe_password = trim(filter_input(INPUT_POST, 'old-password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                $current_password = $student->getLoginInfo($_SESSION['id'], false)['password_hashed'];
                if (!password_verify($safe_password, $current_password)) {
                    $old_password_err = "Incorrect password";
                } else {
                    if (empty(trim($_POST["new-password"]))) {
                        $new_password_err = "Please enter a password.";
                    } else {
                        $safe_new_password = trim(filter_input(INPUT_POST, 'new-password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                        if (strlen($safe_new_password) < 8 || strlen($safe_new_password) > 64) {
                            $new_password_err = "Password must be between 8 and 64 characters.";
                        } else {
                            $new_password = $safe_new_password;
                            if (empty(trim($_POST["confirm-password"]))) {
                                $confirm_password_err = "Please confirm the new password.";
                            } else {
                                $confirm_password = trim(filter_input(INPUT_POST, 'confirm-password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                                if ($new_password != $confirm_password) {
                                    $confirm_password_err = "Passwords did not match.";
                                }
                            }
                        }
                    }
                }
                if (empty($old_password_err) && empty($new_password_err) && empty($confirm_password_err)) {
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    if ($student->updateStudent($_SESSION['id'], "", "", "", "", $password_hash, "", "")) {
                        include '../loading.html';
                        header('Location: ../student/profile.php?Type=4');
                        exit();
                    }
                }
            }
        }
        break;
}
