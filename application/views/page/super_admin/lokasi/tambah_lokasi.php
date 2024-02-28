<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi App</title>
    <link rel="icon" href="<?php echo base_url('./src/assets/image/absensi.png'); ?>" type="image/gif">
</head>

<body>
    <?php $this->load->view('components/sidebar_super_admin'); ?>
    <div class="p-4 sm:ml-64">
        <div class="p-5 mt-10">

            <!-- Card -->
            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">

                <!-- Header -->
                <div class="flex justify-between">
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Tambah Lokasi</h6>
                </div>

                <hr>

                <div class="mt-5 text-left">
                    <form method="post" action="<?php echo site_url('superadmin/tambah_lokasi'); ?>">
                        <!-- Form Input -->
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <!-- Nama Lokasi Input -->
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="nama_lokasi" id="nama_lokasi"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " autocomplete="off"
                                    value="<?php echo isset($nama_lokasi) ? $nama_lokasi : ''; ?>" required />
                                <label for="nama_lokasi"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Nama Lokasi
                                </label>
                            </div>

                            <!-- Alamat Kantor Input -->
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="alamat_kantor" id="alamat_kantor"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " autocomplete="off"
                                    value="<?php echo isset($alamat) ? $alamat : ''; ?>" required />
                                <label for="alamat_kantor"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Alamat Kantor
                                </label>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <!-- Pilihan User -->
                            <div class="relative z-0 w-full mb-6 group">
                                <select id="organisasi" name="id_organisasi"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    required>
                                    <option selected>Pilih Organisasi</option>
                                    <?php foreach ($organisasi as $row): ?>
                                    <option value="<?php echo $row->id_organisasi; ?>">
                                        <?php echo $row->nama_organisasi; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="organisasi"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                </label>
                            </div>
                        </div>
                        <div class="relative z-0 w-full mb-6 group">
                            <select id="admin" name="id_admin"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                required>
                                <option selected>Pilih Admin</option>
                                <?php foreach ($admin as $row): ?>
                                <option value="<?php echo $row->id_admin; ?>">
                                    <?php echo $row->email; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <label for="admin"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            </label>
                        </div>
                </div>
            </div><!-- Button -->
            <div class="flex justify-between">
                <a class="focus:outline-none text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                    href="javascript:history.go(-1)"><i class="fa-solid fa-arrow-left"></i></a>
                <button type="submit"
                    class="text-white bg-indigo-500 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800"><i
                        class="fa-solid fa-floppy-disk"></i></button>
            </div>
            </form>
        </div>
    </div>
    </div>
    </div>
</body>

<script>
function showPassword() {
    var passwordInput = document.getElementById("password");
    var showPassCheckbox = document.getElementById("showpass");
    if (showPassCheckbox.checked) {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}
</script>

</html>