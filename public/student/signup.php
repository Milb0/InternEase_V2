<?php
$title = "InternEase - Sign Up";
$style_file = "";
$cssframewrok = '<script src="https://cdn.tailwindcss.com"></script>';
require_once '../../app/includes/bootstrap.php';
require_once BASE_DIR . 'app/includes/header.php';
if (isset($_SESSION['user_type'])) {
    $who = $_SESSION['user_type'];
    redirect_unauthorized_user($who);
}
require_once BASE_DIR . 'app/Controllers/RegisterController.php';
?>
<div class="min-h-screen p-6 bg-[#00796b] flex items-center justify-center dark:bg-gray-800">
    <div class="container max-w-screen-lg mx-auto ">
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
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3 mt-4">
                    <div class="text-black mb-2 dark:text-white">
                        <p class="font-medium text-4xl">Sign Up</p>
                        <p class="text-base">Create your account</p>
                    </div>

                    <div class="lg:col-span-2 text-black font-normal dark:text-white">
                        <form method="POST" action="signup.php">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                <div class="<?php echo (!empty($name_err)) ? 'md:col-span-5 text-red-500' : 'md:col-span-5'; ?>">
                                    <label for="name">Full Name</label>
                                    <input type="text" name="name" id="name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white<?php echo (!empty($name_err)) ? 'border-red-500' : ''; ?>" placeholder="Your Full Name" value="<?php echo $name; ?>" required />
                                    <span><?php echo $name_err; ?></span>
                                </div>

                                <div class="<?php echo (!empty($email_err)) ? 'md:col-span-5 text-red-500' : 'md:col-span-5'; ?>">
                                    <label for="email">University Email Address</label>
                                    <input type="email" name="email" id="email" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white<?php echo (!empty($name_err)) ? 'border-red-500' : ''; ?>" placeholder="Your University Email ( ...@univ-constantine2.dz )" value="<?php echo $email; ?>" required />
                                    <span><?php echo $email_err; ?></span>
                                </div>

                                <div class="md:col-span-2 <?php echo (!empty($password_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="password">Password</label>
                                    <div class="relative">

                                    <input type="password" name="password" id="password" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white <?php echo (!empty($password_err)) ? 'border-red-500' : ''; ?>" placeholder="Enter your Password" value="<?php echo $password; ?>" required />
                                    <span class="absolute top-3 right-3 cursor-pointer" onclick="togglePasswordVisibility('password')">
                                            <i id="password" class="far fa-eye"></i>
                                        </span>
            </div>
                                    <span><?php echo $password_err; ?></span>
                                </div>

                                <div class="md:col-span-2 <?php echo (!empty($confirm_password_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white <?php echo (!empty($confirm_password_err)) ? 'border-red-500' : ''; ?>" placeholder="Confirm your Password" value="<?php echo $confirm_password; ?>" required />
                                    <span><?php echo $confirm_password_err; ?></span>
                                </div>

                                <div class="md:col-span-2 <?php echo (!empty($birth_date_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="birth_date">Birth Date</label>
                                    <input type="date" name="birth_date" id="birth_date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white <?php echo (!empty($birth_date_err)) ? 'border-red-500' : ''; ?>" placeholder="" value="<?php echo $birth_date; ?>" required />
                                    <span><?php echo $birth_date_err; ?></span>
                                </div>

                                <div class="md:col-span-3 <?php echo (!empty($birth_place_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="birth_place">Birth Place</label>
                                    <input type="text" name="birth_place" id="birth_place" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white <?php echo (!empty($birth_place_err)) ? 'border-red-500' : ''; ?>" placeholder="Enter your Birth Place" value="<?php echo $birth_place; ?>" required />
                                    <span><?php echo $birth_place_err; ?></span>
                                </div>

                                <div class="<?php echo (!empty($phone_err)) ? 'md:col-span-5 text-red-500' : 'md:col-span-5'; ?>">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" name="phone" id="phone" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white<?php echo (!empty($phone_err)) ? 'border-red-500' : ''; ?>" placeholder="Your Phone number. (ex: +213542392529 or 054239259)" value="<?php echo $phone; ?>" required />
                                    <span><?php echo $phone_err; ?></span>
                                </div>

                                <div class="md:col-span-3 <?php echo (!empty($department_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="grade">Department</label>
                                    <select name="department" id="department" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                        <option value="" disabled selected>Select department</option>
                                        <option value="Fundamental Computer Science and its Applications" <?php echo ($department === "Fundamental Computer Science and its Applications") ? "selected" : ""; ?>>Fundamental Computer Science and its Applications</option>
                                        <option value="Software and Information Systems Technologies" <?php echo ($department === 'Software and Information Systems Technologies') ? 'selected' : ''; ?>>Software and Information Systems Technologies</option>
                                    </select>
                                    <span><?php echo $department_err; ?></span>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="grade">Grade</label>
                                    <p id="tempgradp" class=" flex items-center h-10 border mt-1 rounded px-4 w-full bg-gray-50 text-black dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"> First Select a Department </p>
                                    <select name="grade" id="grade" style="display: none;" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                        <option value="" disabled selected>Select a grade</option>
                                    </select>
                                    <span><?php echo $grade_err; ?></span>
                                </div>

                                <div class="md:col-span-5 <?php echo (!empty($student_card_id_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="student_card_id">Confirm Email</label>
                                    <input type="number" name="student_card_id" id="student_card_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white<?php echo (!empty($student_card_id_err)) ? 'border-red-500' : ''; ?>" placeholder="Enter your Student ID Card" value="<?php echo $student_card_id; ?>" required />
                                    <span><?php echo $student_card_id_err; ?></span>
                                </div>

                                <div class="md:col-span-4 text-right mt-5">
                                        <button type="submit" class="bg-[#009579] hover:bg-[#006653] text-white text-lg font-medium w-full py-1.5 w-full rounded">Create Account</button>
                                </div>
                                <div class="md:col-span-1 text-right mt-5">
                                        <a href='../whoami.php'><button type="button" class="bg-gray-400 hover:bg-gray-600 text-white text-lg font-medium w-full py-1.5 w-full rounded">Cancel</button></a>
                                </div>
                            </div>
                        </form>
                        <div class="md:col-span-5 flex  justify-center">
                            <span class=" mt-3 rounded w-full text-black text-lg font-regular dark:text-white"> Already Have an Account?  
                                <a href="login.php" class="text-[#009579] hover:underline decoration-[#009579] dark:text-[#009579]"> Log in</a>
                            </span>
                        </div>
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

