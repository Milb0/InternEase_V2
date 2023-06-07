<?php
require_once '../../app/includes/bootstrap.php';
$title = "InternEase - Verification";
$style_file = "";
$cssframewrok = '<script src="https://cdn.tailwindcss.com"></script>';
if (!isset($_SESSION['verification_code'])) {
header("Location: ../whoami.php");
exit;
}
require_once BASE_DIR . 'app/Controllers/VerificationController.php';
require_once BASE_DIR . 'app/includes/header.php';
?>
<div class="min-h-screen p-6 bg-[#00796b] flex items-center justify-center dark:bg-gray-800">
    <div class="container max-w-screen-md">
        <div>
            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6 dark:bg-gray-700 dark:border-gray-600">
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
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 mt-4">
                    <div class="text-black mb-2 dark:text-white">
                        <p class="font-medium text-4xl">Verify your Account</p>
                        <p class="text-base">Please enter the code that was sent to your Account's email</p>
                    </div>
                    <div class="text-black font-normal dark:text-white">
                        <form method="POST" action="verification.php">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1">
                                <div class="<?php echo (!empty($code_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="code">Confirm Email</label>
                                    <input type="number" name="code" id="code" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white <?php echo (!empty($code_err)) ? 'border-red-500 text-black' : ''; ?>" placeholder="Enter the verification code here"/>
                                    <span><?php echo $code_err; ?></span>
                                </div>
                                <div class="text-right mt-5">
                                    <button type="submit" class="bg-[#009579] hover:bg-[#006653] text-white text-lg font-medium w-full py-1.5 w-full rounded">Verify My Account</button>
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