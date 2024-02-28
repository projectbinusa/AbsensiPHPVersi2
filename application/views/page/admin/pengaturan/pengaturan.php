<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi App</title>
    <link rel="icon" href="<?php echo base_url('./src/assets/image/absensi.png'); ?>" type="image/gif">
</head>

<body>
    <?php $this->load->view('components/sidebar_admin'); ?>
    <div class="p-4 sm:ml-64">
        <div class="p-5 mt-10">


            <!-- Card -->
            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <!-- Header -->
                <div class="flex justify-between">
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Pengaturan Web</h6>
                </div>

                <div class="mt-5 text-left">

                    <div class="inline-flex rounded-md shadow-sm" role="group">
                        <button type="button" onclick="window.location.href = '<?php echo base_url(
                            'admin/pengaturan'
                        ); ?>'"
                            class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-l-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                            Pengaturan Web
                        </button>
                        <button type="button" onclick="window.location.href = '<?php echo base_url(
                            'admin/profile_pengaturan'
                        ); ?>'"
                            class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-r-md hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                            Profile
                        </button>
                    </div>

                    <!-- Form Input -->
                    <form action="#" method="post" enctype="multipart/form-data">

                        <!-- Nama Input -->
                        <div>
                            <label for="nama" class="block text-gray-700 font-bold mb-2">Nama:</label>
                            <input type="text" id="nama" name="nama"
                                class="w-full mb-4 border-2 border-gray-300 p-2 rounded-md focus:outline-none focus:border-indigo-500"
                                required>
                        </div>
                        <!-- Deskripsi Input -->
                        <div>
                            <label for="deskripsi" class="block text-gray-700 font-bold mb-2">Deskripsi:</label>
                            <input type="text" id="deskripsi" name="deskripsi"
                                class="w-full border-2 border-gray-300 p-2 rounded-md focus:outline-none focus:border-indigo-500"
                                required>
                        </div>
                        <!-- No Telepon Input -->
                        <div>
                            <label for="no telepon" class="block text-gray-700 font-bold mb-2">No Telepon:</label>
                            <input type="no" id="no telepon" name="no telepon"
                                class="w-full border-2 border-gray-300 p-2 rounded-md focus:outline-none focus:border-indigo-500"
                                required>
                        </div>
                        <!-- Alamat Input -->
                        <div>
                            <label for=" alamat" class="block text-gray-700 font-bold mb-2"> Alamat:</label>
                            <input type="text" id=" alamat" name=" alamat"
                                class="w-full border-2 border-gray-300 p-2 rounded-md focus:outline-none focus:border-indigo-500"
                                required>
                        </div>
                        <!--  Email Input -->
                        <div>
                            <label for=" email" class="block text-gray-700 font-bold mb-2">Email:</label>
                            <input type="email" id=" email" name=" email"
                                class="w-full border-2 border-gray-300 p-2 rounded-md focus:outline-none focus:border-indigo-500"
                                required>
                        </div>
                        <!--  Email domain Input -->
                        <div>
                            <label for=" email domain" class="block text-gray-700 font-bold mb-2"> Email Domain:</label>
                            <input type="email" id=" email domain" name=" email domain"
                                class="w-full border-2 border-gray-300 p-2 rounded-md focus:outline-none focus:border-indigo-500"
                                required>
                        </div>
                        <!--  Alamat Website Input -->
                        <div>
                            <label for=" alamat Website" class="block text-gray-700 font-bold mb-2"> alamat
                                Website:</label>
                            <input type="text" id=" alamat Website" name=" alamat Website"
                                class="w-full border-2 border-gray-300 p-2 rounded-md focus:outline-none focus:border-indigo-500"
                                required>
                        </div>
                        <br>
                        <label for=" alamat Website" class="block text-gray-700 font-bold mb-2"> Logo :</label>
                        <textarea id="message" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Write your thoughts here..."></textarea>
                        <br>
                        <!-- Button -->
                        <div class="flex justify-between">
                            <!-- Tombol untuk Menyimpan -->
                            <button type="submit"
                                class="text-white bg-green-500 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800"><i
                                    class="fa-solid fa-check"></i>
                                Save
                            </button>

                            <!-- Tombol untuk Mereset -->
                            <button type="reset"
                                class="text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-900">
                                Reset
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</body>

</html>