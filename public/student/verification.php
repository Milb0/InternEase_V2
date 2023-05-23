<?php

/**

*The verification page of the InternEase web application.
*This page allows the student to enter the verification code sent to their email in order to verify their account.
*/
TODO: //Implement Session User Authentication  //Verify if the verification code is set in session

require_once '../../app/includes/bootstrap.php';
$title = "InternEase - Verification";
$style_file = "../assets/css/auth.css";
$cssframewrok = '';
require_once BASE_DIR . 'app/includes/header.php';
if (!isset($_SESSION['verification_code'])) {
header("Location: ../error.php?message=Verification code not set");
exit;
}

require_once BASE_DIR . 'app/Controllers/VerificationController.php';
echo $_SESSION["verification_code"]."</br>";
echo $_SESSION["email"]."</br>";
var_dump($code, $_SESSION["verification_code"]);
echo "hello";
?>

<body>
    <div class="container">
        <div class="login form">
            <header>Verify your Account</header>
            <p>Please enter the code that was sent to your Account's email</p>
            <form action="verification.php" method="post">
                <div class="<?php echo (!empty($code_err)) ? 'error' : ''; ?>">
                    <input type="text" placeholder="Enter the code" name="code"/>
                    <span><?php echo $code_err; ?></span>
                </div>
                <button type="submit">Verify</button>
            </form>
        </div>
    </div>
</body>
<?php
$script_file = "";
require_once BASE_DIR . 'app/includes/footer.php';
?>