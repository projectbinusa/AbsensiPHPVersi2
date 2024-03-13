<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <main id="content" class="flex-1 p-4 sm:p-6">
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex justify-between">
                        <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Rekap Bulanan Semua Karyawan
                        </h6>
                    </div>
                    <hr>
                    <form action="<?= base_url(
                        'admin/rekap_bulanan'
                    ) ?>" method="get" class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-5">
                        <select
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            id="bulan" name="bulan">
                            <option>Pilih Bulan</option>
                            <option value="01" <?php if (
                                    isset($_GET['bulan']) &&
                                    $_GET['bulan'] == '1'
                                ) {
                                    echo 'selected';
                                } ?>>Januari
                            </option>
                            <option value="02" <?php if (
                                    isset($_GET['bulan']) &&
                                    $_GET['bulan'] == '2'
                                ) {
                                    echo 'selected';
                                } ?>>Februari
                            </option>
                            <option value="03" <?php if (
                                    isset($_GET['bulan']) &&
                                    $_GET['bulan'] == '3'
                                ) {
                                    echo 'selected';
                                } ?>>Maret
                            </option>
                            <option value="04" <?php if (
                                    isset($_GET['bulan']) &&
                                    $_GET['bulan'] == '4'
                                ) {
                                    echo 'selected';
                                } ?>>April
                            </option>
                            <option value="05" <?php if (
                                    isset($_GET['bulan']) &&
                                    $_GET['bulan'] == '5'
                                ) {
                                    echo 'selected';
                                } ?>>Mei
                            </option>
                            <option value="06" <?php if (
                                    isset($_GET['bulan']) &&
                                    $_GET['bulan'] == '6'
                                ) {
                                    echo 'selected';
                                } ?>>Juni
                            </option>
                            <option value="07" <?php if (
                                    isset($_GET['bulan']) &&
                                    $_GET['bulan'] == '7'
                                ) {
                                    echo 'selected';
                                } ?>>Juli
                            </option>
                            <option value="08" <?php if (
                                    isset($_GET['bulan']) &&
                                    $_GET['bulan'] == '8'
                                ) {
                                    echo 'selected';
                                } ?>>Agustus
                            </option>
                            <option value="09" <?php if (
                                    isset($_GET['bulan']) &&
                                    $_GET['bulan'] == '9'
                                ) {
                                    echo 'selected';
                                } ?>>September
                            </option>
                            <option value="10" <?php if (
                                    isset($_GET['bulan']) &&
                                    $_GET['bulan'] == '10'
                                ) {
                                    echo 'selected';
                                } ?>>Oktober
                            </option>
                            <option value="11" <?php if (
                                    isset($_GET['bulan']) &&
                                    $_GET['bulan'] == '11'
                                ) {
                                    echo 'selected';
                                } ?>>November
                            </option>
                            <option value="12" <?php if (
                                    isset($_GET['bulan']) &&
                                    $_GET['bulan'] == '12'
                                ) {
                                    echo 'selected';
                                } ?>>Desember
                            </option>
                        </select>
                        <input type="number" id="form_tahun" name="tahun" value="<?= isset($_GET['tahun'])
                                ? $_GET['tahun']
                                : '' ?>"
                            class="w-40 sm:w-64 sm:w-40 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 ml-3 "
                            placeholder="Pilih Tahun" pattern="[0-9]{4}">
                        <label for="tahun"
                            class="mx-2 mb-2 absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-900 dark:text-white ml-auto"></label>
                        <div class="flex sm:flex-row gap-4 mx-auto items-center">
                            <button type="submit"
                                class="bg-indigo-500 hover:bg-indigo text-white font-bold py-2 px-4 rounded inline-block">
                                <i class="fa-solid fa-filter"></i>
                            </button>
                            <a href="<?= base_url('admin/export_all_karyawan') .
                                '?bulan=' .
                                (isset($_GET['bulan']) ? $_GET['bulan'] : '') .
                                '&tahun=' .
                                (isset($_GET['tahun'])
                                    ? $_GET['tahun']
                                    : '') ?>"
                                class="exp bg-green-500 hover:bg-green text-white font-bold py-2 px-4 rounded inline-block ml-auto">
                                <i class="fa-solid fa-file-export"></i>
                            </a>
                        </div>
                    </form>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5 px-4 py-3">
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
                                        Jam Pulang
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
                                foreach ($absensi as $row):

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
                                        $start_time = strtotime(
                                            $row->jam_masuk
                                        );
                                        $end_time = strtotime($row->jam_pulang);
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
                                    <th scope="row" class="px-6 py-4">
                                        <?php echo toTitleCase(
                                            nama_user($row->id_user)
                                        ); ?>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?php echo convDate(
                                            $row->tanggal_absen
                                        ); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $row->jam_masuk; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $row->jam_pulang; ?>
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

</html>