<?php
$title = "InternEase - Sign Up";
$style_file = "../assets/css/auth.css";
require_once '../../app/includes/bootstrap.php';
require_once BASE_DIR . 'app/includes/header.php';
if (isset($_SESSION['user_type'])) {
    $who = $_SESSION['user_type'];
    redirect_unauthorized_user($who);
}
require_once BASE_DIR .'app/Controllers/RegisterController.php';
?>
<div class="container">
    <div class="form">
        <header>Sign Up</header>
        <p>Please fill this form to create an account.</p>
        <form action="signup.php" method="post">
            <div class="<?php echo (!empty($name_err)) ? 'error' : ''; ?>">
                <input type="text" name="name" id="name" placeholder="Enter your full name" value="<?php echo $name; ?>" required>
                <span><?php echo $name_err; ?></span>
            </div>
            <div class="<?php echo (!empty($email_err)) ? 'error' : ''; ?>">
                <input type="email" name="email" id="email" placeholder="Enter your email" value="<?php echo $email; ?>" required>
                <span><?php echo $email_err; ?></span>
            </div>
            <div class="<?php echo (!empty($password_err)) ? 'error' : ''; ?>">
                <input type="password" name="password" id="password" placeholder="Enter your password" value="<?php echo $password; ?>" required>
                <span><?php echo $password_err; ?></span>
            </div>
            <div class="<?php echo (!empty($confirm_password_err)) ? 'error' : ''; ?>">
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm you password" value="<?php echo $confirm_password; ?>" required>
                <span><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="<?php echo (!empty($phone_err)) ? 'error' : ''; ?>">
                <input type="text" name="phone" id="phone" placeholder="Enter your phone number (ex:+213542392222)" value="<?php echo $phone; ?>" required>
                <span><?php echo $phone_err; ?></span>
            </div>
            <div>
                <select name="department" id="department" required>
                    <option value="" disabled selected>Select department</option>
                    <option value="Mathematics and Informatics" <?php echo ($department === "Mathematics and Informatics") ? "selected" : ""; ?>>Mathematics and Informatics</option>
                    <option value="Informatique Fondamentale et ses Applications" <?php echo ($department === "Informatique Fondamentale et ses Applications") ? "selected" : ""; ?>>Informatique Fondamentale et ses Applications</option>
                    <option value="Technologies des Logiciels et des Systèmes d'Information" <?php echo ($department === "Technologies des Logiciels et des Systèmes d'Information") ? "selected" : ""; ?>>Technologies des Logiciels et des Systèmes d'Information</option>
                </select>
                <?php if (!empty($department_err)) : ?>
                    <span class="error"><?php echo $department_err; ?></span>
                <?php endif; ?>
            </div>
            <button type="submit" id="submitBtn" disabled>Submit</button>
        </form>
        <div class="signup">
            <span class="signup">Already have an account?
                <a href="login.php">Log in</a>
            </span>
        </div>
    </div>
</div>
<?php
$script_file = "../assets/js/app.js";
require_once BASE_DIR . 'app/includes/footer.php';
?>