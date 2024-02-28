<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi App</title>
    <link rel="icon" href="<?php echo base_url(
        './src/assets/image/absensi.png'
    ); ?>" type="image/gif">
</head>

<body>
    <?php $this->load->view('components/sidebar_admin'); ?>
    <div class="p-4 sm:ml-64">
        <div class="p-5 mt-10">

            <!-- Card -->
            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-between">
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Detail Lokasi</h6>
                </div>

                <hr>
                <br>

                <!-- GET Data dan ID -->
                <!-- <?php
                $lokasiId = isset($_GET['id']) ? $_GET['id'] : null;
                if ($lokasiId !== null) {
                    // Panggil model untuk mendapatkan data lokasi berdasarkan ID
                    $this->load->model('admin_model');
                    $lokasiData = $this->admin_model->getLokasiData($lokasiId);

                    if ($lokasiData) {
                        foreach ($lokasiData as $lokasi):
                            // Tampilkan data lokasi
                            echo 'ID: ' . $lokasi->id_lokasi . '<br>';
                        endforeach;
                    } else {
                        echo 'Data lokasi tidak ditemukan.';
                    }
                } else {
                    echo 'ID ';
                }
                ?> -->

                <div class="mt-5 text-left">
                    <?php foreach ($lokasi as $lokasi): ?>
                    <!-- Form Input -->
                    <form action="<?php echo base_url(
                        ''
                    ); ?>" method="post" enctype="multipart/form-data">
                        <!-- Nama & Alamat Input -->
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="nama_lokasi" id="nama_lokasi"
                                    value="<?php echo $lokasi->nama_lokasi; ?>"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " autocomplete="off" required readonly />
                                <label for="nama_lokasi"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nama
                                    Lokasi
                                </label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="alamat" id="alamat" value="<?php echo $lokasi->alamat; ?>"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " autocomplete="off" required readonly />
                                <label for="alamat"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Alamat
                                </label>
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="flex justify-between">
                            <a class="focus:outline-none text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                href="javascript:history.go(-1)"> <i class="fa-solid fa-arrow-left"></i>
                            </a>
                        </div>
                    </form>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>