<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi App</title>
    <link rel="icon" href="<?php echo base_url('./src/assets/image/absensi.png'); ?>" type="image/gif">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php $this->load->view('components/sidebar_super_admin'); ?>
    <div class="p-4 sm:ml-64">
        <div class="p-5 mt-10">

            <!-- Card -->
            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-between">
                    <h6 class="mb-5 text-xl font-bold text-gray-900 dark:text-white">Detail Absensi Karyawan</h6>
                </div>
                <hr>

                <div class="mt-5 text-left">
                    <!-- Form Input -->
                    <form action="<?php echo base_url(''); ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_absensi" value="<?php echo $absensi->id_absensi; ?>">
                        <div class="relative z-0 w-full mb-6 group">
                            <input type="text" name="tanggal" id="tanggal"
                                value="<?php echo convDate($absensi->tanggal_absen); ?>"
                                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                placeholder=" " autocomplete="off" required readonly />
                            <label for="tanggal"
                                class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                Tanggal
                            </label>
                        </div>
                    </form>
                </div>

                <div class="grid md:grid-cols-2 md:gap-6 text-left">
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="jam_masuk" id="jam_masuk"
                            value="<?php echo $absensi->jam_masuk; ?>"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " autocomplete="off" required readonly />
                        <label for="jam_masuk"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jam 
                            Masuk
                        </label>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="jam_pulang" id="jam_pulang" 
                            value="<?php echo $absensi->jam_pulang; ?>"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " autocomplete="off" required readonly />
                        <label for="jam_pulang"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jam 
                            Pulang
                        </label>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6 text-left">
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="lokasi_masuk" id="lokasi_masuk"
                            value="<?php echo $absensi->lokasi_masuk; ?>"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " autocomplete="off" required readonly />
                        <label for="lokasi_masuk"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Lokasi 
                            Masuk
                        </label>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <input type="text" name="lokasi_pulang" id="lokasi_pulang" 
                            value="<?php echo $absensi->lokasi_pulang; ?>"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " autocomplete="off" required readonly />
                        <label for="lokasi_pulang"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Lokasi 
                            Pulang
                        </label>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6 text-left">
                    <div class="relative z-0 w-full mb-6 group flex justify-center items-center">
                        <?php if (!empty($absensi->foto_masuk)): ?>
                            <img src="<?= base_url($absensi->foto_masuk); ?>" name="foto_masuk" alt="Foto Masuk"
                                class="block py-2.5 px-0 w-80 max-h-96 max-w-full h-auto text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                id="foto_masuk" required />
                        <?php else: ?>
                            <span class="text-gray-500 dark:text-gray-400">Foto Masuk tidak tersedia</span>
                        <?php endif; ?>
                        <label for="foto_masuk"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Foto
                            Masuk
                        </label>
                    </div>
                    <div class="relative z-0 w-full mb-6 group flex justify-center items-center">
                        <?php if (!empty($absensi->foto_masuk)): ?>
                            <img src="<?= base_url($absensi->foto_pulang); ?>" name="foto_pulang" alt="Foto Pulang"
                            class="block py-2.5 px-0 w-80 max-w-full h-auto text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            id="foto_pulang" required />
                        <?php else: ?>
                            <span class="text-gray-500 dark:text-gray-400">Foto Masuk tidak tersedia</span>
                        <?php endif; ?>
                        <label for="lokasi_pulang"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Foto 
                            Pulang
                        </label>
                    </div>
                </div>

                <!-- Button -->
                <div class="flex justify-between">
                    <a class="focus:outline-none text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                        href="javascript:history.go(-1)"> <i class="fa-solid fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>