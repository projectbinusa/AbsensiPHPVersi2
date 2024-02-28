<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi App</title>
    <link rel="icon" href="<?php echo base_url(
        './src/assets/image/absensi.png'
    ); ?>" type="image/gif">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
</head>

<body>
    <?php $this->load->view('components/sidebar_admin'); ?>
    <div class="p-2 sm:ml-64">
        <!-- Card Selamat Datang -->
        <div class="mt-10 w-full">
            <div
                class="p-4 text-center bg-gray-400 border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <h2 class="text-2xl font-semibold mb-4">
                    Selamat Datang DiAbsensi
                    <span>@<?php echo $this->session->userdata(
                        'username'
                    ); ?></span>
                </h2>
                <p class="text-gray-800" id="waktu"></p>

            </div>
        </div>
        <div class="p-2 mt-5">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div
                    class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">User</h5>
                    <hr class="mb-4">
                    <div class="flex justify-between">
                        <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
                            <?= $user_count ?> User
                        </p>
                        <div>
                            <i class="fa-solid fa-users-gear fa-2xl text-blue-700"></i>
                        </div>
                    </div>
                </div>
                <div
                    class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Absensi</h5>
                    <hr class="mb-4">
                    <div class="flex justify-between">
                        <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
                            <?php if (isset($absensi['count'])): ?>
                            <?= $absensi['count'] ?> Absensi
                            <?php else: ?>
                            0 Absensi
                            <?php endif; ?>
                        </p>
                        <div>
                            <i class="fa-solid fa-address-card fa-2xl text-green-700"></i>
                        </div>
                    </div>
                </div>
                <div
                    class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Cuti</h5>
                    <hr class="mb-4">
                    <div class="flex justify-between">
                        <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
                            <?php echo $cuti_count; ?> Cuti
                        </p>
                        <div>
                            <i class="fa-solid fa-calendar-alt fa-fw fa-2xl text-purple-700"></i>
                        </div>
                    </div>
                </div>
            </div>


            <figure class="highcharts-figure">
                <div class="w-full mt-5 mb-5 p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700"
                    id="container"></div>
            </figure>

            <script>
            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Total Absensi per Hari'
                },
                xAxis: {
                    type: 'category',
                    categories: [
                        <?php foreach ($absensi as $row): ?> '<?php echo $row[
                            'tanggal_absen'
                        ]; ?>',
                        <?php endforeach; ?>
                    ]
                },
                yAxis: {
                    title: {
                        text: 'Jumlah Absensi'
                    }
                },
                series: [{
                    name: 'Total Absensi',
                    colorByPoint: true,
                    data: [
                        <?php foreach ($absensi as $row): ?> {
                            name: '<?php echo $row['tanggal_absen']; ?>',
                            y: <?php echo $row['jumlah_absensi']; ?>
                        },
                        <?php endforeach; ?>
                    ]
                }]
            });
            </script>

            <!-- Tabel Absensi -->
            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-between">
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">History absensi</h6>
                </div>
                <hr>

                <!-- Tabel -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead
                            class="text-center text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
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
                                    Jam Masuk
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Jam Pulang
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Kehadiran
                                </th>
                                </th>
                            </tr>
                        </thead>

                        <!-- Tabel Body -->
                        <tbody class="text-center">
                            <?php if (!empty($absen)): ?>
                            <?php foreach (
                                array_slice($absen, 0, 5)
                                as $no => $row
                            ): ?>
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?php echo $no + 1; ?>
                                </th>
                                <td class="px-6 py-4">
                                    <?php echo toTitleCase(nama_user($row->id_user)); ?>
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
                                    <?php echo $row->status_absen; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="5">No data available</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>

            <!-- Table Cuti -->
            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-between">
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Detail History Cuti</h6>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead
                            class="text-center text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Username
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Cuti Dari
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Sampai
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Masuk Kerja
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Keperluan
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php if (!empty($cuti)): ?>
                            <?php
                            $no = 0;
                            foreach (array_slice($cuti, 0, 5) as $row):
                                $no++; ?>
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
                                    <?php echo convDate($row->awal_cuti); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo convDate($row->akhir_cuti); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo convDate($row->masuk_kerja); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $row->keperluan_cuti; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $row->status; ?>
                                </td>
                            </tr>
                            <?php
                            endforeach;
                            ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="10" class="">Tidak ada data cuti</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <br>

            <!-- Tabel Jabatan -->
            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-between">
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Detail Data Jabatan</h6>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead
                            class="text-center text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Username
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama Jabatan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            $no = 0;
                            foreach (array_slice($jabatan, 0, 5) as $row):
                                $no++; ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50
                                    dark:hover:bg-gray-600">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?php echo $no; ?>
                                </th>
                                <td class="px-6 py-4">
                                    <?php echo toTitleCase(nama_admin($row->id_admin)); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $row->nama_jabatan; ?>
                                </td>
                            </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <br>

            <!-- Tabel Lokasi -->
            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-between">
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Detail Data Lokasi</h6>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead
                            class="text-center text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Username
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama Lokasi
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Alamat
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            $no = 0;
                            foreach (array_slice($lokasi, 0, 5) as $data):
                                $no++; ?>
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4"><?php echo $no; ?></td>
                                <td class="px-6 py-4">
                                    <?php echo toTitleCase(nama_admin($row->id_admin)); ?>
                                </td>
                                <td class="px-6 py-4"><?php echo isset(
                                    $data['nama_lokasi']
                                )
                                    ? $data['nama_lokasi']
                                    : ''; ?></td>
                                <td class="px-6 py-4"><?php echo isset(
                                    $data['alamat']
                                )
                                    ? $data['alamat']
                                    : ''; ?></td>
                            </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <br>

            <!-- Tabel Organisasi -->
            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-between">
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Detail Data Organisasi</h6>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead
                            class="text-center text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Username
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Alamat
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Telepon
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            $no = 0;
                            foreach (array_slice($organisasi, 0, 5) as $row):
                                $no++; ?>
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?php echo $no; ?>
                                </th>
                                <td class="px-6 py-4">
                                    <?php echo toTitleCase(nama_admin($row->id_admin)); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $row->alamat; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $row->nomor_telepon; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $row->email_organisasi; ?>
                                </td>
                            </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <br>

            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-between">
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Kehadiran Lebih Awal</h6>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead
                            class="text-center text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">No</th>
                                <th scope="col" class="px-6 py-3">Username</th>
                                <th scope="col" class="px-6 py-3">Jabatan</th>
                                <th scope="col" class="px-6 py-3">Jumlah Lebih Awal</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            $no = 0;
                            foreach (
                                array_slice($early_attendance, 0, 5)
                                as $attendance
                            ):
                                $no++; ?>
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?php echo $no; ?>
                                </th>
                                <td class="px-6 py-4">
                                    <?php echo toTitleCase($attendance['username']); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $attendance['nama_jabatan']; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $attendance[
                                        'early_attendance_count'
                                    ]; ?>
                                </td>
                            </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <br>

            <!-- Tabel User -->
            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-between">
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Detail Data User</h6>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead
                            class="text-center text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Username
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            $no = 0;
                            $limitedUsers = array_slice($user, 0, 5);

                            foreach ($limitedUsers as $row):
                                $no++; ?>
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?php echo $no; ?>
                                </th>
                                <td class="px-6 py-4">
                                    <?php echo toTitleCase($row['username']); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php echo $row['email']; ?>
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
        <footer class="bg-indigo-500 shadow dark:bg-gray-900">
            <div class="w-full max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
                <span class="text-sm text-gray-900 sm:text-center dark:text-gray-400">© 2024 <a href=""
                        class="hover:underline">Absensi</a> by Excellent Computer
                </span>
            </div>
        </footer>
    </div>
</body>

<script>
function updateTime() {
    var now = new Date();
    var hari = now.toLocaleDateString('id-ID', {
        weekday: 'long'
    });
    var tanggal = now.getDate();
    var bulan = now.toLocaleDateString('id-ID', {
        month: 'long'
    });
    var tahun = now.getFullYear();
    var jam = now.getHours();
    var menit = now.getMinutes();
    var detik = now.getSeconds();

    var waktuString = hari + ', ' + tanggal + ' ' + bulan + ' ' + tahun + ' - ' + jam + ':' + menit + ':' + detik;

    document.getElementById('waktu').innerHTML = waktuString;
}

// Memanggil fungsi updateTime setiap detik
setInterval(updateTime, 1000);
</script>

<?php if ($this->session->flashdata('login_success')) { ?>
<script>
Swal.fire({
    title: 'Berhasil Login',
    text: '<?php echo $this->session->flashdata('login_success'); ?>',
    icon: 'success',
    showConfirmButton: false,
    timer: 1500
})
</script>
<?php } ?>

</html>