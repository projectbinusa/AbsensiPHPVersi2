<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi App</title>
    <link rel="icon" href="<?php echo base_url(
        './src/assets/image/absensi.png'
    ); ?>" type="image/gif">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
</head>

<body>
    <?php $this->load->view('components/sidebar_admin'); ?>
    <div class="p-4 sm:ml-64">
        <div class="p-5 mt-10">
            <main id="content" class="flex-1 p-4 sm:p-6">
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex justify-between">
                        <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Rekap Perkaryawan</h6>
                    </div>
                    <hr>
                    <form action="<?php base_url(
                        'admin/rekap_perkaryawan'
                    ); ?>" method="post" class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-5">
                        <select
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 js-example-basic-single"
                            id="id_user" name="id_user">
                            <option>Pilih Karyawan</option>
                            <?php
                            $no = 0;
                            foreach ($karyawan as $row):
                                $no++; ?>
                            <option value="<?php echo $row->id_user; ?>">
                                <?php echo toTitleCase($row->username); ?>
                            </option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                        <div class="flex sm:flex-row gap-4 mx-auto items-center">
                            <button type="submit"
                                class="bg-indigo-500 hover:bg-indigo text-white font-bold py-2 px-4 rounded inline-block">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                            <a href="<?= base_url(
                                'Admin/export_perkaryawan'
                            ) ?>"
                                class="exp bg-green-500 hover:bg-green text-white font-bold py-2 px-4 rounded inline-block ml-auto">
                                <i class="fa-solid fa-file-export"></i>
                            </a>
                        </div>
                    </form>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
                        <h5 class="mb-2 text-l font-bold text-gray-900 dark:text-white">Rekap Atas Nama :
                            <?php
                            $id = $this->session->userdata('user_id');

                            if ($id != 0) {
                                // Menggunakan fungsi toTitleCase dan nama_user untuk mendapatkan teks yang akan ditampilkan
                                $formattedName = toTitleCase(
                                    nama_user(
                                        $this->session->userdata('user_id')
                                    )
                                );
                                echo "{$formattedName}";
                            } else {
                                echo '-';
                            }
                            ?>
                        </h5>

                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-left text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jam Masuk
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Foto Masuk
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jam Pulang
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Foto Pulang
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jam Kerja
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Keterangan
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-left">
                                <?php
                                $no = 0;
                                foreach ($absen as $row):

                                    $no++;
                                    $hours = 0;
                                    $minutes = 0;
                                    $jam_masuk = $row->jam_masuk;
                                    $jam_pulang = $row->jam_pulang;
                                    $jam_kerja = '-';

                                    if (
                                        $jam_masuk != '00:00:00' &&
                                        $jam_pulang != '00:00:00'
                                    ) {
                                        $start_time = strtotime($jam_masuk);
                                        $end_time = strtotime($jam_pulang);
                                        $diff = $end_time - $start_time;
                                        $hours = floor($diff / (60 * 60));
                                        $minutes = floor(
                                            ($diff - $hours * 60 * 60) / 60
                                        );
                                        $jam_kerja = sprintf(
                                            '%02d:%02d',
                                            $hours,
                                            $minutes
                                        );
                                    }
                                    ?>
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?php echo $no; ?>
                                    </th>

                                    <td class="px-6 py-4">
                                        <?php echo toTitleCase(
                                            nama_user($row->id_user)
                                        ); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo convDate(
                                            $row->tanggal_absen
                                        ); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $row->jam_masuk; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <img src="<?= base_url(
                                            $row->foto_masuk
                                        ) ?>" alt=""
                                            class="block py-2.5 px-0 w-25 max-h-32 h-25 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            id="foto_masuk" style="max-width: 100px; max-height: 100px;">
                                    </td>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $row->jam_pulang; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <img src="<?= base_url(
                                            $row->foto_pulang
                                        ) ?>" alt=""
                                            class="block py-2.5 px-0 w-25 max-h-32 h-25 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                            id="foto_masuk" style="max-width: 100px; max-height: 100px;">
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php
                                        $time = DateTime::createFromFormat(
                                            'H:i',
                                            $jam_kerja
                                        );
                                        if ($time === false) {
                                            echo '-';
                                        } else {
                                            $hours = $time->format('H');
                                            $minutes = $time->format('i');
                                            echo $hours .
                                                ' jam ' .
                                                $minutes .
                                                ' menit';
                                        }
                                        ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $row->keterangan_izin; ?>
                                    </td>
                                </tr>
                                <?php
                                endforeach;
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
<script>
// Initialize Select2
$(document).ready(function() {
    $('#dataKaryawan').DataTable();
    $('.js-example-basic-single').select2();
});
</script>

</html>