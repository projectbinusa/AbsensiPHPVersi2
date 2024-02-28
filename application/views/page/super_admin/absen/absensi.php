<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi App</title>
    <link rel="icon" href="<?php echo base_url('./src/assets/image/absensi.png'); ?>" type="image/gif">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css" />
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
</head>

<body>
    <?php $this->load->view('components/sidebar_super_admin'); ?>
    <div class="p-4 sm:ml-64">
        <div class="p-5">
            <!-- Card -->
            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-between">
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Data Absensi</h6>
                </div>
                <hr>
                <!-- Tabel -->
                <div class="relative overflow-x-auto mt-4">
                    <div class="table-responsive">
                        <table id="dataAbsen"
                            class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-auto mb-4">
                            <!-- Kepala Tabel -->
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-4">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-4">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-4">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-4">
                                        Jam Masuk
                                    </th>
                                    <th scope="col" class="px-6 py-4">
                                        Jam Pulang
                                    </th>
                                    <th scope="col" class="px-6 py-4">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <!-- Tubuh Tabel -->
                            <tbody>
                                <?php
                                $no = 0;
                                foreach ($absensi as $row):
                                    $no++; ?>
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?php echo $no; ?>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?php echo nama_user($row->id_user); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo convDate($row->tanggal_absen); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $row->jam_masuk; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $row->jam_pulang; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-start">
                                            <a type="button" href="<?= base_url(
                                                'superadmin/detail_absen/' .
                                                    $row->id_absensi
                                            ) ?>"
                                                class="text-white bg-indigo-500 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 mx-1 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('#dataAbsen').DataTable({
            responsive: true
        });
    });
    </script>
</body>

</html>