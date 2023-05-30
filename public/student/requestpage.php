<?php
$title = "InternEase - Internship Requesting";
$style_file = "";
$cssframewrok = '<script src="https://cdn.tailwindcss.com"></script>';
require_once '../../app/includes/bootstrap.php';
require_once BASE_DIR . 'app/includes/autoload.php';
require_once BASE_DIR . 'app/includes/header.php';
require_once BASE_DIR . 'app/Controllers/RequestController.php';
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== 'student') {
    $who = $_SESSION['user_type'];
    redirect_unauthorized_user($who);
} elseif (!isset($_SESSION['user_type'])) {
    header("Location:../whoami.php");
}
?>

<nav class=" top-0 z-50 w-full bg-gray-100 border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <div class="flex md:mr-24">
                    <div class="inline-block p-2">
                        <img src="../assets/images/logo.png" class="h-5" alt="InternEase Logo" />
                    </div>
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">InternEase</span>
                </div>
            </div>
            <div class="flex items-center">
                <div class="relative ml-3">
                    <div>
                        <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user" onclick="toggleMenu()">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
                        </button>
                    </div>
                    <div class="absolute right-0 mt-2 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600 hidden" id="dropdown-user">
                        
                        <ul class="py-1" role="none">
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Dashboard</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Profile</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Sign out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center dark:bg-gray-800">
    <div class="container max-w-screen-lg mx-auto">
        <div>
            <h2 class="font-semibold text-2xl text-black-800 mb-6 dark:text-white">Internship Application</h2>
            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6 dark:bg-gray-500">
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3 mt-4">
                    <div class="text-black mb-2 dark:text-white">
                        <p class="font-medium text-xl">Application Details</p>
                        <p>Please fill out all the fields.</p>
                    </div>

                    <div class="lg:col-span-2 text-black font-normal dark:text-white">
                        <form method="POST" action="requestpage.php">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                <div class="<?php echo (!empty($theme_err)) ? 'md:col-span-5 text-red-500' : 'md:col-span-5'; ?>">
                                    <label for="theme">Internship Theme</label>
                                    <input type="text" name="theme" id="theme" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black<?php echo (!empty($theme_err)) ? 'border-red-500' : ''; ?>" placeholder="Your Internship Theme" value="<?php echo $theme; ?>" required />
                                    <span><?php echo $theme_err; ?></span>
                                </div>

                                <div class="<?php echo (!empty($description_err)) ? 'md:col-span-5 text-red-500' : 'md:col-span-5'; ?>">
                                    <label for="description">Description</label>
                                    <textarea rows="4" name="description" id="description" class="border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black<?php echo (!empty($description_err)) ? 'border-red-500' : ''; ?>" placeholder="Enter your internship description here..." required><?php echo $description; ?></textarea>
                                    <span><?php echo $description_err; ?></span>
                                    <p id="description-counter" class="text-xs text-gray-700">0/1000 characters</p>
                                </div>


                                <div class="md:col-span-2 <?php echo (!empty($startDate_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black <?php echo (!empty($startDate_err)) ? 'border-red-500' : ''; ?>" placeholder="" value="<?php echo $startDate; ?>" required />
                                    <span><?php echo $startDate_err; ?></span>
                                </div>

                                <div class="md:col-span-2 <?php echo (!empty($endDate_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black <?php echo (!empty($endDate_err)) ? 'border-red-500' : ''; ?>" placeholder="" value="<?php echo $endDate; ?>" required />
                                    <span><?php echo $endDate_err; ?></span>
                                </div>

                                <div class="md:col-span-1 <?php echo (!empty($period_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="period">Period (per days)</label>
                                    <input type="number" name="period" id="period" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black<?php echo (!empty($period_err)) ? 'border-red-500' : ''; ?>" placeholder="" value="<?php echo $period; ?>" required />
                                    <span><?php echo $period_err; ?></span>
                                </div>


                                <div class="<?php echo (!empty($fullName_err)) ? 'md:col-span-5 text-red-500' : 'md:col-span-5'; ?>">
                                    <label for="full_name">Supervisor Full Name</label>
                                    <input type="text" name="full_name" id="full_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black<?php echo (!empty($fullName_err)) ? 'border-red-500' : ''; ?>" placeholder="Your supervisor full name" value="<?php echo $fullName; ?>" required />
                                    <span><?php echo $fullName_err; ?></span>
                                </div>

                                <div class="md:col-span-5 <?php echo (!empty($email_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black<?php echo (!empty($email_err)) ? 'border-red-500' : ''; ?>" placeholder="email@domain.com" value="<?php echo $email; ?>" required />
                                    <span><?php echo $email_err; ?></span>
                                </div>

                                <div class="md:col-span-5 <?php echo (!empty($confirmEmail_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="confirm_email">Confirm Email</label>
                                    <input type="text" name="confirm_email" id="confirm_email" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black <?php echo (!empty($confirmEmail_err)) ? 'border-red-500' : ''; ?>" placeholder="Confirm your supervisor's email" value="<?php echo $confirmEmail; ?>" required />
                                    <span><?php echo $confirmEmail_err; ?></span>
                                </div>
                                <div class="md:col-span-2 <?php echo (!empty($phoneNumber_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="phonenumber">Phone Number</label>
                                    <input type="tel" name="phonenumber" id="phonenumber" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black<?php echo (!empty($phoneNumber_err)) ? 'border-red-500' : ''; ?>" value="" placeholder="Your supervisor's phone number" value="<?php echo $phoneNumber; ?>" required />
                                    <span><?php echo $phoneNumber_err; ?></span>
                                </div>
                                <div class="md:col-span-2 <?php echo (!empty($faxNumber_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="fax">Fax Number</label>
                                    <input type="tel" name="fax" id="fax" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black<?php echo (!empty($faxNumber_err)) ? 'border-red-500' : ''; ?>" placeholder="Your supervisor's work fax number" value="<?php echo $faxNumber; ?>" required />
                                    <span><?php echo $faxNumber_err; ?></span>
                                </div>
                                <div class="md:col-span-5">
                                    <hr class="w-full bg-gray-400 mt-2 mb-4">
                                </div>

                                <div class="md:col-span-2 <?php echo (!empty($company_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="company_name">Company Name</label>
                                    <input type="text" name="company_name" id="company_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black<?php echo (!empty($company_err)) ? 'border-red-500' : ''; ?>" placeholder="ex: Algerie poste" value="<?php echo $companyName; ?>" required />
                                    <span><?php echo $company_err; ?></span>
                                </div>
                                <div class="md:col-span-3 <?php echo (!empty($company_address_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="company_address">Company Address</label>
                                    <input type="text" name="company_address" id="company_address" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black<?php echo (!empty($company_address_err)) ? 'border-red-500' : ''; ?>" placeholder="ex: UV N°1 Ilot 01 Cité Nouvelle Ville..." value="<?php echo $companyAddress; ?>" required />
                                    <span><?php echo $company_address_err;?></span>
                                </div>

                                <div class="md:col-span-5 text-right mt-5">
                                    <div class="inline-flex items-end space-x-4">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-lg font-medium py-1.5 px-6 rounded">Submit</button>
                                        <a href="dashboard.php"><button type="button" class="bg-gray-500 hover:bg-gray-700 text-white text-lg font-medium py-1.5 px-6 rounded">Cancel</button></a>
                                    </div>
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