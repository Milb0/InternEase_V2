<div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center dark:bg-gray-800">
    <div class="container max-w-screen-lg mx-auto">
        <div>
            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6 dark:bg-gray-700 dark:border-gray-600">
                <?php if (!empty($form_error_message)) {
                        echo '<div id="alert-additional-content-3" class="p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800 relative" role="alert">
                    <div class="flex items-center">
                        <i class="fa-solid fa-circle-info w-4 h-4 mr-2"></i>
                        <h3 class="text-lg font-medium">'.$form_error_message.'</h3>
                    </div>
                    <button id="alert-close-button" onclick="closeAlertDialogue()" type="button" class="absolute top-1 right-1 -mt-1 -mr-1 text-red-800 rounded-lg p-1.5 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-blue-400" aria-label="Close">
                        <i class="fa-solid fa-circle-xmark w-5 h-5 text-red-800 dark:text-red-800"></i>
                    </button>
                </div>';
                }
                ?>
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3 mt-4">
                    <div class="text-black mb-2 dark:text-white">
                        <p class="font-medium text-xl">Login Credentials</p>
                        <p>Change what you know</p>
                    </div>

                    <div class="lg:col-span-2 text-black font-normal dark:text-white">
                        <form method="POST" action="editinformation.php?type=auth">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                <div class="md:col-span-5 <?php echo (!empty($old_password_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="old-password">Password</label>
                                    <input type="password" name="old-password" id="old-password" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white <?php echo (!empty($old_password_err)) ? 'border-red-500' : ''; ?>" value="<?php echo $old_password; ?>" placeholder="Enter Your Old Password" required />
                                    <span><?php echo $old_password_err; ?></span>
                                </div>
                                <div class="md:col-span-5 <?php echo (!empty($new_password_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="new-password">New Password</label>
                                    <div class="relative">
                                        <input type="password" name="new-password" id="new-password" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white <?php echo (!empty($new_password_err)) ? 'border-red-500' : ''; ?>" value="<?php echo $new_password; ?>" placeholder="Enter Your New Password" required />
                                        <span class="absolute top-3 right-3 cursor-pointer" onclick="togglePasswordVisibility('new-password')">
                                            <i id="new-password-icon" class="far fa-eye"></i>
                                        </span>
                                    </div>
                                    <span><?php echo $new_password_err; ?></span>
                                </div>

                                <div class="md:col-span-5 <?php echo (!empty($confirm_password_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="confirm-password">Confirm new Password</label>
                                    <div class="relative">
                                    <input type="password" name="confirm-password" id="confirm-password" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white <?php echo (!empty($confirm_password_err)) ? 'border-red-500' : ''; ?>" value="<?php echo $confirm_password; ?>" placeholder=" Confirm Your New Password" required />
                                        <span class="absolute top-3 right-3 cursor-pointer" onclick="togglePasswordVisibility('confirm-password')">
                                            <i id="confirm-password-icon" class="far fa-eye"></i>
                                        </span>
                                    </div>
                                    <span><?php echo $confirm_password_err; ?></span>
                                </div>

                                <div class="md:col-span-5">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">Save Changes</button>
                                    <a href="profile.php"><button type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mt-4">Cancel</button></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>