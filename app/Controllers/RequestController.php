<?php
$supervisor = new InternshipSupervisor($db_conn);
$internship = new InternshipRequest($db_conn);
$company = new Company($db_conn);

$theme = $description = $startDate = $endDate = $period = $fullName = $email = $confirmEmail = $phoneNumber = $faxNumber = $companyName = $companyAddress = "";
$theme_err = $description_err = $startDate_err = $endDate_err = $period_err = $fullName_err = $email_err = $confirmEmail_err = $phoneNumber_err = $faxNumber_err = $company_err = $company_address_err = "";
$supervisor_exists = $company_exists = false;
$expected_input_names = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expected_input_names = array(
        'theme',
        'description',
        'start_date',
        'end_date',
        'period',
        'full_name',
        'email',
        'confirm_email',
        'phonenumber',
        'fax',
        'company_name',
        'company_address'
    );
    try {
        foreach ($expected_input_names as $input_name) {
            if (!isset($_POST[$input_name])) {
                throw new Exception("Something Went Wrong Try again please");
            }
        }
        if (empty(trim($_POST["theme"]))) {
            $theme_err = "Please enter the internship's theme.";
        } else {
            $theme = trim(filter_input(INPUT_POST, 'theme', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        }

        if (empty(trim($_POST["description"]))) {
            $description_err = "Please enter the internship's description.";
        } else {
            $description = trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            if (strlen($description) > 1000) {
                $description_err = "Description should not exceed 1000 characters.";
            }
        }

        if (empty(trim($_POST["start_date"]))) {
            $startDate_err = "Please enter the internship's Start Date.";
        } else {
            $startDate = trim($_POST["start_date"]);
            if (!isValidDate($startDate)) {
                $startDate_err = "Invalid Start Date format.";
            }
        }

        if (empty(trim($_POST["end_date"]))) {
            $endDate_err = "Please enter the internship's End Date.";
        } else {
            $endDate = trim($_POST["end_date"]);
            if (!isValidDate($endDate)) {
                $endDate_err = "Invalid End Date format.";
            } else {
                if (strtotime($endDate) < strtotime($startDate)) {
                    $endDate_err = "End Date must not be less than Start Date.";
                }
            }
        }

        if (empty(trim($_POST["period"]))) {
            $period_err = "Please enter the internship's period.";
        } else {
            $period = trim($_POST["period"]);
            if (!is_numeric($period) || $period <= 0) {
                $period_err = "Invalid period value.";
            } elseif (empty($startDate) || empty($endDate)) {
                $period_err = "Validate the dates.";
            } else {
                $diff = strtotime($endDate) - strtotime($startDate);
                $days = round($diff / (60 * 60 * 24));
                if ($period > $days) {
                    $period_err = "Validate the period.";
                    $period = $days;
                }
            }
        }

        if (empty(trim($_POST["full_name"]))) {
            $fullName_err = "Please enter the supervisor's name.";
        } else {
            $fullName = trim(filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        }

        if (empty(trim($_POST["email"]))) {
            $email_err = "Please enter the supervisor's email address.";
        } else {
            $safe_email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
            if (!filter_var($safe_email, FILTER_VALIDATE_EMAIL)) {
                $email_err = "Invalid email format.";
            } else {
                if (empty(trim($_POST["confirm_email"]))) {
                    $confirmEmail_err = "Please confirm the email.";
                } elseif ($safe_email == trim($_POST["confirm_email"])) {
                    $email = $safe_email;
                    $confirmEmail = $safe_email;
                    switch ($supervisor->isEmailTaken($safe_email)) {
                        case true:
                            $data = $supervisor->getInternshipSupervisor($email, true);
                            if ($data) {
                                $fullName = $data['name'];
                                $phoneNumber = $data['phonenumber'];
                                $faxNumber = $data['faxnumber'];
                                $companyData = $data['company_id'];
                                // Getting the company details
                                $companyDetails = $company->getCompany($companyData, true);
                                if ($companyDetails) {
                                    $companyName = $companyDetails['name'];
                                    $companyAddress = $companyDetails['address'];
                                    $supervisor_exists = $company_exists = true;
                                }
                            }
                            break;

                        case false:

                            if (empty(trim($_POST["phonenumber"]))) {
                                $phoneNumber_err = "Please enter the supervisor's phone number.";
                            } else {
                                $safe_phone = trim(filter_input(INPUT_POST, 'phonenumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                                if (!preg_match("/^(?:\+213|0)(5|6|7)\d{8}$/", $safe_phone)) {
                                    $phoneNumber_err = "Invalid phone format.";
                                } else {
                                    $phoneNumber = $safe_phone;
                                }
                            }

                            if (empty(trim($_POST["fax"]))) {
                                $faxNumber_err = "Please enter the supervisor's fax number.";
                            } else {

                                $safe_fax = trim(filter_input(INPUT_POST, 'fax', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                                if (!preg_match('/^(?:\+213|0)?[1-9]{2}[0-9]{6}$/', $safe_fax)) {
                                    $faxNumber_err = "Invalid fax format.";
                                } else {
                                    $faxNumber = $safe_fax;
                                }
                            }

                            if (empty(trim($_POST["company_name"]))) {
                                $company_err = "Please enter the company name.";
                            } else {
                                $companyName = trim(filter_input(INPUT_POST, 'company_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

                                // Check if the company name consists of only numbers
                                if (preg_match('/^\d+$/', $companyName)) {
                                    $company_err = "Company name cannot consist of only numbers.";
                                }
                            }

                            if (empty(trim($_POST["company_address"]))) {
                                $company_address_err = "Please enter the company address.";
                            } else {
                                $companyAddress = trim(filter_input(INPUT_POST, 'company_address', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                            }
                            break;
                    }
                } else {
                    $confirmEmail_err = "Emails don't match.";
                }
            }
        }

        if (empty($theme_err) && empty($description_err) && empty($startDate_err) && empty($endDate_err) && empty($period_err) && empty($fullName_err) && empty($email_err) && empty($confirmEmail_err) && empty($phoneNumber_err) && empty($faxNumber_err) && empty($company_err) && empty($company_address_err)) {
            if ($supervisor_exists === true && $company_exists === true) {
                $supervisorID = $supervisor->getInternshipSupervisorID($email)['id'];
                $RequestDate = date('d-m-Y');
                if ($internship->createRequest($_SESSION['id'], $supervisorID, 4656455466, $theme, $description, $startDate, $endDate, $period, $RequestDate, '0')) {
                    $Type = urlencode(1);
                    include '../loading.html';
                    header('Location: ../student/dashboard.php?Type=' . $Type);
                    exit;
                }
            } else {
                $companyID = $company->createCompany($companyName, $companyAddress);
                if ($companyID) {
                    $username = explode('@', $email)[0] . $companyID;
                    $supervisorID = $supervisor->createInternshipSupervisor($companyID, $email, $username, $fullName, $phoneNumber, $faxNumber);
                    if ($supervisorID) {
                        if ($internship->createRequest($_SESSION['id'], $supervisorID, 4656455466, $theme, $description, $startDate, $endDate, $period, $RequestDate, '0')) {
                            $Type = urlencode(1);
                            include '../loading.html';
                            header('Location: ../student/dashboard.php?Type=' . $Type);
                            exit;
                        }
                    }
                }
            }
        }
    } catch (Exception $e) {
        $form_error_message = $e->getMessage();
    }
}
