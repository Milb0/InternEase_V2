<?php
$title = "InternEase - Examination";
$style_file = "";
$cssframewrok = '<script src="https://cdn.tailwindcss.com"></script>';
require_once '../../app/includes/bootstrap.php';
require_once BASE_DIR . 'app/includes/autoload.php';
require_once BASE_DIR . 'app/includes/header.php';
require_once BASE_DIR . 'app/Controllers/ExaminationProcessController.php';
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== 'DepartmentHead') {
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
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>
                <div class="flex ml-2 md:mr-24">
                    <div class="bg-gray-400 bg-opacity-10 inline-block p-2 rounded dark:bg-opacity-0">
                        <img src="../assets/images/logo.png" class="h-5" alt="InternEase Logo" />
                    </div>
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">InternEase</span>
                </div>
            </div>
            <div class="flex items-center">
                <div class="relative ml-3">
                    <div>
                        <button type="button" class="flex text-sm rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user" onclick="toggleMenu()">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-9 h-9 rounded-full overflow-hidden" src="../assets/images/teacher_avatar.png" alt="user photo">
                        </button>
                    </div>
                    <div class="absolute right-0 mt-2 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600 hidden" id="dropdown-user">
                        <ul class="py-1" role="none">
                            <li>
                                <a href="dashboard.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Dashboard</a>
                            </li>
                            <li>
                                <a href="profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Profile</a>
                            </li>
                            <li>
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem" onclick="toggleSignOutModal()">Sign out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center dark:bg-gray-800">
    <div class="container max-w-screen-lg mx-auto  dark:text-white ">
        <div>
            <div class="bg-white rounded-lg shadow-lg p-6 dark:bg-gray-600">
                <h3 class="text-xl font-medium text-gray-900 mb-6  dark:text-white ">Internship Details</h3>
                <hr class="w-full bg-gray-400 mt-2 mb-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    <div>
                        <p class="font-medium">Student's Full Name</p>
                        <p id="FullName-info"><?php echo $result['name']; ?></p>
                    </div>
                    <div>
                        <p class="font-medium">Their University Card ID</p>
                        <p id="CardID-info"><?php echo $result['StudentCardID']; ?></p>
                    </div>
                    <div>
                        <p class="font-medium">Grade</p>
                        <p id="Grade-info"><?php echo $result['grade']; ?></p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    <div>
                        <p class="font-medium">Social Security Number</p>
                        <p id="SSN-info"><?php echo $result['SSN']; ?></p>
                    </div>
                    <div>
                        <p class="font-medium">Email Address</p>
                        <p id="Email-info"><?php echo $result['email']; ?></p>
                    </div>
                    <div>
                        <p class="font-medium">Phone Number</p>
                        <p id="theme-info"><?php echo $result['phonenumber']; ?></p>
                    </div>
                </div>

                <hr class="w-full bg-gray-400 mt-2 mb-4">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="font-medium">Internship's Theme</p>
                        <p id="theme-info"><?php echo $result['theme']; ?></p>
                    </div>
                    <div>
                        <p class="font-medium">Internship's Description</p>
                        <p id="description-info"><?php echo $result['description']; ?></p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    <div>
                        <p class="font-medium">Start Date</p>
                        <p id="start-date-info"><?php echo $result['StartDate']; ?></p>
                    </div>
                    <div>
                        <p class="font-medium">End Date</p>
                        <p id="end-date-info"><?php echo $result['EndDate']; ?></p>
                    </div>
                    <div>
                        <p class="font-medium">Period</p>
                        <p id="period-info"><?php echo $result['period']; ?></p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="font-medium">Supervisor Name</p>
                        <p id="supervisor-name-info"><?php echo $result['supervisor_name']; ?></p>
                    </div>
                    <div>
                        <p class="font-medium">Supervisor Email</p>
                        <p id="supervisor-email-info"><?php echo $result['supervisor_email']; ?></p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="font-medium">Phone Number</p>
                        <p id="phone-number-info"><?php echo $result['supervisor_phonenumber']; ?></p>
                    </div>
                    <div>
                        <p class="font-medium">Fax Number</p>
                        <p id="fax-number-info"><?php echo $result['faxnumber']; ?></p>
                    </div>
                </div>

                <hr class="w-full bg-gray-400 mt-2 mb-4">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="font-medium">Company Name</p>
                        <p id="company-name-info"><?php echo $result['company_name']; ?></p>
                    </div>
                    <div>
                        <p class="font-medium">Company Address</p>
                        <p id="company-address-info"><?php echo $result['company_address']; ?></p>
                    </div>
                </div>
                <div class="col-span-3">
                        <hr class="w-full bg-gray-400 mt-4 mb-6">
                        <div class="flex justify-end space-x-2">
                            <button onclick="toggleConfirmationModal();" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">Confirm</button>
                            <button onclick="toggleRefusalModal();"  class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700">Refuse</button>
                            <a href="dashboard.php"><button class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 dark:hover:bg-gray-700">Cancel</button></a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<?php
include BASE_DIR . 'app/includes/confirmationModal.php';
include BASE_DIR . 'app/includes/refusalModal.php';
singOutModal();

echo '<script type="text/javascript" src="../assets/js/dashboard.js?v=<?php echo time(); ?>"></script>';
require_once BASE_DIR . 'app/includes/footer.php';
?>