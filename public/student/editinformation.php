<?php
$title = "InternEase - Edit Page";
$style_file = "";
$cssframewrok = '<script src="https://cdn.tailwindcss.com"></script>';
require_once '../../app/includes/bootstrap.php';
require_once BASE_DIR . 'app/includes/autoload.php';
require_once BASE_DIR . 'app/includes/header.php';
if (isset($_GET['type'])) {
    $safetype = trim(filter_input(INPUT_GET, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
} else {
    header('location:error404.php');
}
require_once BASE_DIR . 'app/Controllers/ProfileUpdateController.php';
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== 'student') {
    $who = $_SESSION['user_type'];
    redirect_unauthorized_user($who);
} elseif (!isset($_SESSION['user_type'])) {
    header("Location:../whoami.php");
}
?>
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
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
                        <img src="../assets/images/logo.png" class="h-5" alt="InternEase Logo"/>
                    </div>
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">InternEase</span>
                </div>
            </div>
            <div class="flex items-center">
                <div class="relative ml-3">
                    <div>
                    <button type="button" class="flex text-sm rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user" onclick="toggleMenu()">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-9 h-9 rounded-full overflow-hidden" src="../assets/images/student_avatar.png" alt="user photo">
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
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem" onclick="toggleSignOutModal()">Sign out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<?php


switch ($safetype) {
    case 'persona':
        include BASE_DIR . 'app/includes/forms/personal_information_form.php';
        break;
    case 'academia':
        include BASE_DIR . 'app/includes/forms/academic_information_form.php';
        break;
    case 'auth':
        include BASE_DIR . 'app/includes/forms/login_credentials_form.php';
        break;
}

?>
<script type="text/javascript" src="../assets/js/dashboard.js?v=<?php echo time(); ?>"></script>

<?php
singOutModal();
require_once BASE_DIR . 'app/includes/footer.php';
?>