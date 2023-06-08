<?php
$title = "InternEase - Log in";
$style_file = "";
$cssframewrok = '<script src="https://cdn.tailwindcss.com"></script>';
require_once '../../app/includes/bootstrap.php';
require_once BASE_DIR . 'app/includes/header.php';
if (isset($_SESSION['user_type'])) {
    $who = $_SESSION['user_type'];
    redirect_unauthorized_user($who);
}
require_once BASE_DIR . 'app/Controllers/LogInController.php';

?>
<div class="min-h-screen p-6 bg-[#00796b] flex items-center justify-center dark:bg-gray-800">
    <div class="container max-w-screen-lg mx-auto ">
        <div>
            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6 dark:bg-gray-700 dark:border-gray-600">
                <?php if (isset($_SESSION['message'])) {
                    echo '<div id="alert-additional-content-3" class="p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800 relative" role="alert">
                    <div class="flex items-center">
                        <i class="fa-solid fa-circle-info w-4 h-4 mr-2"></i>
                        <h3 class="text-lg font-medium">' . $_SESSION['message'] . '</h3>
                    </div>
                    <button id="alert-close-button" onclick="closeAlertDialogue()" type="button" class="absolute top-1 right-1 -mt-1 -mr-1 text-green-800 rounded-lg p-1.5 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-blue-400" aria-label="Close">
                        <i class="fa-solid fa-circle-xmark w-5 h-5 text-green-800 dark:text-green-800"></i>
                    </button>
                </div>';
                }
                ?>
                <?php if (!empty($form_error_message)) {
                    echo '<div id="alert-additional-content-3" class="p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800 relative" role="alert">
                    <div class="flex items-center">
                        <i class="fa-solid fa-circle-info w-4 h-4 mr-2"></i>
                        <h3 class="text-lg font-medium">' . $form_error_message . '</h3>
                    </div>
                    <button id="alert-close-button" onclick="closeAlertDialogue()" type="button" class="absolute top-1 right-1 -mt-1 -mr-1 text-red-800 rounded-lg p-1.5 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-blue-400" aria-label="Close">
                        <i class="fa-solid fa-circle-xmark w-5 h-5 text-red-800 dark:text-red-800"></i>
                    </button>
                </div>';
                }
                ?>
                <?php if (isset($HiddenInputMessage)) {
                    echo '<div id="alert-additional-content-3" class="p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800 relative" role="alert">
                    <div class="flex items-center">
                        <i class="fa-solid fa-circle-info w-4 h-4 mr-2"></i>
                        <h3 class="text-lg font-medium">' . $HiddenInputMessage . '</h3>
                    </div>
                    <button id="alert-close-button" onclick="closeAlertDialogue()" type="button" class="absolute top-1 right-1 -mt-1 -mr-1 text-red-800 rounded-lg p-1.5 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-blue-400" aria-label="Close">
                        <i class="fa-solid fa-circle-xmark w-5 h-5 text-red-800 dark:text-red-800"></i>
                    </button>
                </div>';
                }
                ?>

                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3 mt-4">
                    <div class="text-black mb-2 dark:text-white">
                        <p class="font-medium text-4xl">Log in</p>
                        <p class="text-base">Access your Account</p>
                    </div>

                    <div class="lg:col-span-2 text-black font-normal dark:text-white">
                        <form method="POST" action="login.php">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                <div class="<?php echo (!empty($email_err)) ? 'md:col-span-5 text-red-500' : 'md:col-span-5'; ?>">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" id="email" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white<?php echo (!empty($name_err)) ? 'border-red-500' : ''; ?>" placeholder="Enter Your Email" value="<?php echo $email; ?>" required />
                                    <span><?php echo $email_err; ?></span>
                                </div>

                                <div class="md:col-span-5 <?php echo (!empty($password_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white <?php echo (!empty($password_err)) ? 'border-red-500' : ''; ?>" placeholder="Enter your Password" value="<?php echo $password; ?>" required />
                                    <span><?php echo $password_err; ?></span>
                                </div>
                                <input type="hidden" name="identity" value="DepartmentHead">
                                <div class="md:col-span-4 text-right mt-5">
                                        <button type="submit" class="bg-[#009579] hover:bg-[#006653] text-white text-lg font-medium w-full py-1.5 w-full rounded">Log in</button>
                                </div>
                                <div class="md:col-span-1 text-right mt-5">
                                        <a href='../whoami.php'><button type="button" class="bg-gray-400 hover:bg-gray-600 text-white text-lg font-medium w-full py-1.5 w-full rounded">Cancel</button></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../assets/js/dashboard.js?v=<?php echo time(); ?>"></script>
<?php
require_once BASE_DIR . 'app/includes/footer.php';
 ?>