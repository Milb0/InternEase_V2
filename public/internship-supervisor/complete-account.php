<?php
require_once '../../app/includes/bootstrap.php';
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== 'internship-supervisor') {
    $who = $_SESSION['user_type'];
    redirect_unauthorized_user($who);
} elseif (!isset($_SESSION['user_type'])) {
    header("Location:../whoami.php");
} elseif ($_SESSION['account_completed']) {
    header("Location:../internship-supervisor/dashboard.php"); // Redirect to completed page if account is already completed
}

$title = "InternEase - Information Confirmation";
$style_file = "../assets/css/confirmation.css";
require_once BASE_DIR . 'app/includes/header.php';
require_once BASE_DIR . 'app/Controllers/SupervisorAccountValidation.php';
?>


<div class="container">
    <div class="confirmation form">
        <header>Validation</header>
        <p>To make sure your information are valid, fill out this form.</p>
        <?php if (isset($HiddenInputMessage)) : ?>
            <div class="HiddenInputMessage">
                <h><?php echo $HiddenInputMessage; ?></h>
            </div>
        <?php endif; ?>
        <form action="complete-account.php" method="post">
            <div class="personal-information">
                <h2>Personal Information</h2>
                <div class="<?php echo (!empty($name_err)) ? 'error' : ''; ?>">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter your full name" value="<?php echo (!empty($name)) ? $name : $_SESSION['supervisor']['name']; ?>" required>
                    <span><?php echo $name_err; ?></span>
                </div>
                <div class="<?php echo (!empty($email_err)) ? 'error' : ''; ?>">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" value="<?php echo (!empty($email)) ? $email : $_SESSION['supervisor']['email']; ?>" required>
                    <span><?php echo $email_err; ?></span>
                </div>
                <div class="<?php echo (!empty($password_err)) ? 'error' : ''; ?>">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Must have at least 8 characters" value="<?php echo $password; ?>" required>
                    <span><?php echo $password_err; ?></span>
                </div>
                <div class="<?php echo (!empty($confirm_password_err)) ? 'error' : ''; ?>">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your password" value="<?php echo $confirm_password; ?>" required>
                    <span><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="<?php echo (!empty($phone_err)) ? 'error' : ''; ?>">
                    <label for="confirm_password">Phone Number</label>
                    <input type="text" name="phone" id="phone" placeholder="Phone number" value="<?php echo (!empty($phone)) ? $phone : $_SESSION['supervisor']['phonenumber']; ?>" required>
                    <span><?php echo $phone_err; ?></span>
                </div>
            </div>
            <div class="company-information">
                <h2>Company Information - <b><?php echo $_SESSION["sup_company"]['name']; ?></b></h2>
                <div class="<?php echo (!empty($address_err)) ? 'error' : ''; ?>">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" placeholder="address" value="<?php echo (!empty($address)) ? $address : $_SESSION["sup_company"]['address']; ?>" required>
                    <span><?php echo $address_err; ?></span>
                </div>
            </div>
            <button id="submitBtn" type="submit" disabled>Submit</button>
        </form>
    </div>
</div>
<?php
TODO: // unset the message after displaying it
$script_file = "../assets/js/auth.js";
require_once BASE_DIR . 'app/includes/footer.php';
?>