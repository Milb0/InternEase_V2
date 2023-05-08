<?php
$title = "InternEase - Log in";
$style_file = "../assets/css/auth.css";
require_once '../../app/includes/bootstrap.php';
require_once BASE_DIR . 'app/includes/header.php';
if (isset($_SESSION['user_type'])) {
    $who = $_SESSION['user_type'];
    redirect_unauthorized_user($who);
}
require_once BASE_DIR . 'app/Controllers/LogInController.php';
?>
<div class="container">
    <div class="login form">
        <header>Login</header>
        <p>Enter you information</p>
        <?php if (isset($HiddenInputMessage)) : ?>
            <div class="HiddenInputMessage">
                <h><?php echo $HiddenInputMessage; ?></h>
            </div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <div class="<?php echo (!empty($email_err)) ? 'error' : ''; ?>">
                <input type="email" placeholder="Enter your email" name="email" value="<?php echo $email; ?>" required />
                <span><?php echo $email_err; ?></span>
            </div>
            <div class="<?php echo (!empty($password_err)) ? 'error' : ''; ?>">
                <input type="password" placeholder="Enter your password" name="password" required />
                <span><?php echo $password_err; ?></span>
            </div>
            <input type="hidden" name="identity" value="internshipsupervisor">
            <button id="submitBtn" type="submit" disabled>Submit</button>
        </form>
    </div>
</div>
<?php
TODO: // unset the message after displaying it
$script_file = "../assets/js/auth.js";
require_once BASE_DIR . 'app/includes/footer.php';
 ?>