<div class="min-h-screen p-6 bg-gray-100 flex items-center justify-center dark:bg-gray-800">
    <div class="container max-w-screen-lg mx-auto">
        <div>
            <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6 dark:bg-gray-500">
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3 mt-4">
                    <div class="text-black mb-2 dark:text-white">
                        <p class="font-medium text-xl">Academic Information</p>
                        <p>Change what you know</p>
                    </div>

                    <div class="lg:col-span-2 text-black font-normal dark:text-white">
                        <form method="POST" action="editinformation.php?type=academia">
                            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                <div class="md:col-span-5 <?php echo (!empty($univ_name_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="univ_name">University</label>
                                    <input type="text" name="univ_name" id="univ_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black <?php echo (!empty($univ_name_err)) ? 'border-red-500' : ''; ?>" placeholder="University name" value="<?php echo $univ_name; ?>" required />
                                    <span><?php echo $univ_name_err; ?></span>
                                </div>

                                <div class="md:col-span-5 <?php echo (!empty($fac_name_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="fac_name">Faculty</label>
                                    <input type="text" name="fac_name" id="fac_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black <?php echo (!empty($fac_name_err)) ? 'border-red-500' : ''; ?>" placeholder="Faculty name" value="<?php echo $fac_name; ?>" required />
                                    <span><?php echo $fac_name_err; ?></span>
                                </div>
                                
                                <div class="md:col-span-5 <?php echo (!empty($dep_name_err)) ? 'text-red-500' : ''; ?>">
                                    <label for="dep_name">Department</label>
                                    <input type="text" name="dep_name" id="dep_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black <?php echo (!empty($dep_name_err)) ? 'border-red-500' : ''; ?>" placeholder="Department name" value="<?php echo $dep_name; ?>" required />
                                    <span><?php echo $dep_name_err; ?></span>
                                </div>

                                <div class="md:col-span-5">
                                    <label for="grade">Degree Prepared</label>
                                    <select name="grade" id="grade" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 dark:text-black">
                                        <option value="L3" <?php echo ($grade === "L3") ? 'selected' : ''; ?>>Bachelor Degree</option>
                                        <option value="Masters" <?php echo ($grade === "Masters") ? 'selected' : ''; ?>>Master Degree</option>
                                    </select>
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
