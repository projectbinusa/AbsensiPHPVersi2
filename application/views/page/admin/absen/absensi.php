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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
</head>

<body>
    <?php $this->load->view('components/sidebar_admin'); ?>
    <div class="p-4 sm:ml-64">
        <div class="p-5 mt-10">

            <!-- Card -->
            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-between">
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Detail History Absensi</h6>
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
                    <div class="flex items-center p-4">

                        <form id="form-filter" action="<?php echo base_url(
                            'Admin/aksi_filter'
                        ); ?>" class="flex gap-4 mx-10">
                            <!-- Form Bulan -->
                            <div class="relative flex items-center">
                                <label for="bulan" class="mx-10 mb-2 text-gray-900 dark:text-white sm:mr-4"></label>
                                <select id="select" name="bulan"
                                    class="w-40 sm:w-64 sm:w-40 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mx-3">
                                    <option value="" disabled selected>Pilih Bulan</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>

                            <!-- Form Tanggal -->
                            <div class="relative flex items-center mx-3">
                                <input type="text" id="tanggal" name="tanggal"
                                    class="w-40 sm:w-64 sm:w-40 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mx-3"
                                    placeholder="Pilih Tanggal" min="<?= date(
                                        'Y-m-d'
                                    ) ?>" max="<?= date(
    'Y-m-d'
) ?>" autocomplete="off">
                                <label for="tanggal"
                                    class="mx-2 mb-2 absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-900 dark:text-white mx-3 "></label>
                            </div>

                            <!-- Form Tahun -->
                            <div class="relative flex items-center">
                                <input type="number" id="form_tahun" name="tahun"
                                    class="w-40 sm:w-64 sm:w-40 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 ml-3 "
                                    placeholder="Pilih Tahun" pattern="[0-9]{4}">
                                <label for="tahun"
                                    class="mx-2 mb-2 absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-900 dark:text-white ml-auto">
                                </label>
                            </div>
                        </form>

                        <!-- Tombol untuk Semua Form -->
                        <button type="button" id="submit-button"
                            class="bg-indigo-500 hover:bg-indigo text-white font-bold py-2 px-4 rounded inline-block ml-2">
                            <i class="fa-solid fa-filter"></i>
                        </button>
                        <a href="<?= base_url('Admin/export_absensi') ?>"
                            class="exp bg-green-500 hover:bg-green text-white font-bold py-2 px-4 rounded inline-block ml-2">
                            <i class="fa-solid fa-file-export"></i>
                        </a>

                    </div>
                </div>

                <br>

                <!-- Tabel -->
                <div class="relative overflow-x-auto mt-5">
                    <table id="absen" class="w-full text-left text-sm text-left text-gray-500 dark:text-gray-400">
                        <!-- Tabel Head -->
                        <thead
                            class="text-left text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Username
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tanggal
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Kehadiran
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
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-left">
                            <?php
                            $no = 0;
                            foreach ($absensi as $row):
                                $no++; 
                                $hours = 0;
                                $minutes = 0;
                                // Hitung jam kerja
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
                                    <?php echo toTitleCase(nama_user($row->id_user)); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo convDate($row->tanggal_absen); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $row->status_absen; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $row->jam_masuk; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <img src="<?= base_url($row->foto_masuk) ?>" alt=""
                                        class="block py-2.5 px-0 w-25 max-h-32 h-25 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        id="foto_masuk" style="max-width: 100px; max-height: 100px;">
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $row->jam_pulang; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <img src="<?= base_url($row->foto_pulang) ?>" alt=""
                                        class="block py-2.5 px-0 w-25 max-h-96 h-25 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        id="foto_masuk" style="max-width: 100px; max-height: 100px;">
                                </td>
                                <td class="px-6 py-4">
                                    <?php
                                        $time = DateTime::createFromFormat('H:i', $jam_kerja);
                                        if ($time === false) {
                                            echo "-";
                                        } else {
                                            $hours = $time->format('H');
                                            $minutes = $time->format('i');
                                            echo $hours . ' jam ' . $minutes . ' menit';
                                        }
                                    ?>
                                </td>
                                <td class="px-6 py-4">
                                    <a type="button" href="<?= base_url(
                                        'admin/detail_absen/' . $row->id_absensi
                                    ) ?>"
                                        class="text-white bg-indigo-500 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 mx-1 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('#absen').DataTable({
            lengthChange: false, // Menonaktifkan opsi "Show entries"
            searching: true, // Menampilkan kolom pencarian
            paging: true, // Menampilkan paginasi
            ordering: true, // Menampilkan sorting
            info: true, // Menampilkan informasi halaman
            "dom": '<"top"f>rt<"bottom"lip>',
        });
    });
    </script>

    <!-- Untuk JS Form Bulan, Tanggal, Tahun-->
    <script>
    $(document).ready(function() {
        $("#submit-button").click(function() {

            // Ambil nilai dari formulir
            var bulan = $("#select").val();
            var tanggal = $("#tanggal").val();
            var tahun = $("#form_tahun").val();

            // Kirim permintaan AJAX ke server
            $.ajax({
                url: "<?php echo base_url('Admin/aksi_filter'); ?>",
                type: "post",
                data: {
                    bulan: bulan,
                    tanggal: tanggal,
                    tahun: tahun
                },
                success: function(response) {
                    // Perbarui tabel dengan data yang telah difilter
                    $("#absensi-table tbody").replaceWith($(response).find('tbody'));
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
    });
    </script>
    <!-- JS Untuk Tahun -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil elemen input tahun
        var tahunInput = document.getElementById('form_tahun');

        // Dapatkan tahun saat ini
        var tahunSaatIni = new Date().getFullYear();

        // Isi input tahun dengan tahun saat ini
        tahunInput.value = tahunSaatIni;
    });
    </script>
</body>

</html>