<?php
$title = "InternEase - Completed Internships";
$style_file = "";
$cssframewrok = '<script src="https://cdn.tailwindcss.com"></script>';
require_once '../../app/includes/bootstrap.php';
require_once BASE_DIR . 'app/includes/autoload.php';
require_once BASE_DIR . 'app/includes/header.php';
require_once BASE_DIR . 'app/Controllers/FetchStudentController.php';
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
                            <img class="w-9 h-9 rounded-full overflow-hidden" src="../assets/images/student_avatar.png" alt="user photo">
                        </button>
                    </div>
                    <div class="absolute right-0 mt-2 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600 hidden" id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900 dark:text-white" role="none">
                                <?php echo $result['name']; ?>
                            </p>
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                <?php echo $result['email']; ?>
                            </p>
                        </div>
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

<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li>
                <a href="dashboard.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fa fa-home"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fa-solid fa-list"></i>
                    <span class="flex-1 ml-3 whitespace-nowrap">Completed Internships</span>
                </a>
            </li>
            <li>
                <a href="profile.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fa-solid fa-user"></i>
                    <span class="flex-1 ml-3 whitespace-nowrap">Profile</span>
                </a>
            </li>
            <li>
                <a href="contactus.php" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fa-solid fa-envelope-open-text"></i>
                    <span class="flex-1 ml-3 whitespace-nowrap">Contact Us</span>
                </a>
            </li>
            <li>
                <a class="flex items-center p-2 text-gray-900 rounded-lg cursor-pointer dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700" onclick="toggleSignOutModal()">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span class="flex-1 ml-3 whitespace-nowrap">Sign Out</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

<div class="p-4 sm:ml-64 h-screen pt-5 dark:bg-gray-800 dark:border-gray-700 flex flex-col">
    <div class="p-4 mt-14 flex-grow">
        <div class="flex flex-col justify-end mb-4 rounded bg-gray-50 dark:bg-gray-800 overflow-x-auto flex-grow">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                    Your Internships
                    <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Browse Your internships and take control</p>
                </caption>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Internship Number
                        </th>
                        <th scope="col" class="px-6 py-3">
                            End Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Period
                        </th>
                        <th scope="col" class="px-6 py-3">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $internshipRequest = new InternshipRequest($db_conn);

                    // Fetch internship requests for the student
                    $requests = $internshipRequest->getCompletedRequestsByStudent($_SESSION['id']);

                    // Iterate over the requests and display them in the table
                    if (empty($requests)) {
                        echo '
                        <tr>
                        <td colspan="5" class="px-6 py-4 text-center">
                        <img src="../assets/images/no-internship.png" alt="Nothing to display." class="mx-auto max-w-xs">
                        </td>
                        </tr>
                        ';
                    } else {
                        foreach ($requests as $request) {
                            $theme = $request['theme'];
                            $period = $request['period'];
                            $endDate = $request['EndDate'];
                            $url_slug = $request['url_slug'];
                            $actions = '
                            <div class="flex justify-end space-x-2">
                            <a href="http://localhost/internease/student/viewdetails.php?internship=' . $url_slug . '" class="viewDetailsButton px-4 py-2 text-base relative cursor-pointer ">
                            <i class="fa-solid fa-eye text-black hover:text-blue-400 dark:text-white" title="View Details"></i>
                            <span class="absolute top-2 left-1/2 -translate-x-1/2 transform -translate-y-full text-xs bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-400 px-2 py-1 rounded-md whitespace-nowrap">View Details</span>
                        </a>
                            <a href="http://localhost/internease/student/attendance.php?internship=' . $url_slug . '" class="viewDetailsButton px-4 py-2 text-base relative cursor-pointer ">
                                        <i class="fa-solid fa-calendar text-black hover:text-blue-400 dark:text-white"></i>
                                     <span class="absolute top-2 left-1/2 -translate-x-1/2 transform -translate-y-full text-xs bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-400 px-2 py-1 rounded-md whitespace-nowrap">Check Presence</span>
                                 </a>
                                 <a href="http://localhost/internease/student/attestation.php?internship=' . $url_slug . '" class="viewDetailsButton px-4 py-2 text-base relative cursor-pointer ">
                                     
                                    <i class="fa-solid fa-stamp text-black hover:text-blue-400 dark:text-white"></i>
                                     <span class="absolute top-2 left-1/2 -translate-x-1/2 transform -translate-y-full text-xs bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-400 px-2 py-1 rounded-md whitespace-nowrap">Get Certificate</span>
                                 </a>
                                 <a href="http://localhost/internease/student/grade.php?internship=' . $url_slug . '" class="viewDetailsButton px-4 py-2 text-base relative cursor-pointer ">
                                    <i class="fa-solid fa-clipboard text-black hover:text-blue-400 dark:text-white"></i>
                                     <span class="absolute top-2 left-1/2 -translate-x-1/2 transform -translate-y-full text-xs bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-400 px-2 py-1 rounded-md whitespace-nowrap">Get Certificate</span>
                                 </a>
                             </div>
                         ';

                            echo '
                <tr class="bg-white dark:bg-gray-800">
                <td class="px-6 py-4 font-medium text-black whitespace-nowrap dark:text-white">
                ' . $theme . '
                </td>
                <td class="px-6 py-4">
                ' . $period . ' days ' . '
                </td>
                <td class="px-6 py-4">
                ' . $endDate . '
                </td>
                <td class="px-6 py-4 text-right">
                ' . $actions . '
                </td>
                </tr>
                ';
                        }
                    }
                    ?>

                </tbody>
            </table>


        </div>
    </div>
</div>
<script type="text/javascript" src="../assets/js/dashboard.js?v=<?php echo time(); ?>"></script>
<?php
singOutModal();
require_once BASE_DIR . 'app/includes/footer.php';
?>