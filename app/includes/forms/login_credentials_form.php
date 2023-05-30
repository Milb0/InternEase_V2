<div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center dark:bg-gray-800">
    <div class="container max-w-screen-lg mx-auto">
        <div>
            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6 dark:bg-gray-500">
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3 mt-4">
                    <div class="text-black mb-2 dark:text-white">
                        <p class="font-medium text-xl">Login Credentials</p>
                        <p>Change what you know</p>
                    </div>

                    <div class="lg:col-span-2 text-black font-normal dark:text-white">
                        <form method="POST" action="editinformation.php?type=auth">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                <div class="md:col-span-5">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black" placeholder="Enter Your Old Password" required />
                                </div>
                                <div class="md:col-span-5">
                                    <label for="password">Confirm New Password</label>
                                    <input type="password" name="new-password" id="new-password" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black" placeholder="Enter Your New Password" required />
                                </div>
                                <div class="md:col-span-5">
                                    <label for="password">Confirm Password</label>
                                    <input type="password" name="confirm-password" id="confirm-password" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black" placeholder="Confirm Your New Password" required />
                                </div>

                                <div class="md:col-span-5">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">Save Changes</button>
                                    <a href="dashboard.php"><button type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mt-4">Cancel</button></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
