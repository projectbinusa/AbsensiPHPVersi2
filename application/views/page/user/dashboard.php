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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</head>
<style>
@media only screen and (max-width: 768px) {
    .disable-mobile {
        pointer-events: none;
        opacity: 0.6;
        cursor: not-allowed;
    }
}
</style>

<body>
    <?php $this->load->view('components/sidebar_user'); ?>
    <div class="p-2 sm:ml-64">
        <div class="mt-10 w-full">
            <div class="p-4 text-center">
                <div
                    class="p-4 text-center bg-indigo-100 border border-indigo-200 rounded-lg shadow sm:p-8 dark:bg-indigo-800 dark:border-indigo-700">
                    <h2 class="text-2xl font-semibold mb-4">
                        Selamat Datang
                        <span>@<?php echo $this->session->userdata(
                            'username'
                        ); ?></span>
                    </h2>
                    <p class="text-gray-800 my-4" id="waktu"></p>
                    <hr class="my-3" style="border: 1px solid black">
                    <div class="hidden md:block">
                        <div class="grid grid-cols-3 md:grid-cols-3 gap-4">
                            <div>
                                <?php if (!$absens): ?>
                                <a href="<?= base_url('user/absen') ?>"
                                    class="md:flex w-full flex-col items-center bg-green-400 border-green-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-green-100 dark:border-green-400 dark:bg-green-500 dark:hover:bg-green-500 px-5 py-2">
                                    <div class="hidden md:block w-2/5">
                                        <i class="fa-solid fa-arrow-right-to-bracket fa-2xl"></i>
                                    </div>
                                    <div class="text-left p-4 leading-normal">
                                        <h3>Masuk</h3>
                                        <p>Absen masuk.</p>
                                    </div>
                                </a>
                                <?php else: ?>
                                <div class="md:flex w-full flex-col items-center bg-green-400 border-green-200 rounded-lg shadow md:flex-row md:max-w-xl px-5 py-2 opacity-50 cursor-not-allowed"
                                    style="opacity: 0.6;">
                                    <div class=" hidden md:block w-2/5">
                                        <i class="fa-solid fa-arrow-right-to-bracket fa-2xl"></i>
                                    </div>
                                    <div class="text-left p-4 leading-normal">
                                        <h3>Jam Masuk</h3>
                                        <p><?= $absensi->jam_masuk ?></p>
                                    </div>
                                </div>
                                <?php endif; ?>

                            </div>
                            <div>
                                <?php if ($absens): ?>
                                <a href="<?= base_url('user/pulang') ?>"
                                    class="md:flex w-full flex-col items-center bg-red-500 border-red-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-red-100 dark:border-red-400 dark:bg-red-500 dark:hover:bg-red-500 px-5 py-2">
                                    <div class="hidden md:block w-2/5">
                                        <i class="fa-solid fa-arrow-right-from-bracket fa-2xl"></i>
                                    </div>
                                    <div class="text-left p-4 leading-normal">
                                        <h3>Pulang</h3>
                                        <p>Absen pulang.</p>
                                    </div>
                                </a>
                                <?php else: ?>
                                <div class="md:flex w-full flex-col items-center bg-red-500 border-red-200 rounded-lg shadow md:flex-row md:max-w-xl px-5 py-2 opacity-50 cursor-not-allowed"
                                    style="opacity: 0.6;">
                                    <div class="hidden md:block w-2/5">
                                        <i class="fa-solid fa-arrow-right-from-bracket fa-2xl"></i>
                                    </div>
                                    <div class="text-left p-4 leading-normal">
                                        <h3>Pulang</h3>
                                        <p>Absen pulang.</p>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div>
                                <a href="<?php echo base_url('user/izin'); ?>"
                                    class="md:flex w-full flex-col items-center bg-red-500 border-red-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-indigo-100 dark:border-indigo-700 dark:bg-indigo-800 dark:hover:bg-indigo-700 px-5 py-2">
                                    <div class="hidden md:block w-2/5">
                                        <i class="fa-solid fa-circle-xmark fa-2xl"></i>
                                    </div>
                                    <div class="text-left p-4 leading-normal">
                                        <h3>Izin</h3>
                                        <p>Ajukan izin.</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="mt-10 flex justify-center">
                            <a href="<?php echo base_url('user/cuti'); ?>"
                                class="md:flex mx-auto w-2/4 flex-col items-center bg-indigo-400 border-indigo-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-indigo-100 dark:border-indigo-700 dark:bg-indigo-800 dark:hover:bg-indigo-700 px-5 py-2">
                                <div class="hidden md:block w-2/5">
                                    <i class="fa-solid fa-calendar-day fa-2xl"></i>
                                </div>
                                <div class="text-left p-4 leading-normal">
                                    <h3>Cuti</h3>
                                    <p>Ajukan izin cuti.</p>
                                </div>
                            </a>
                        </div>

                    </div>

                    <!-- MOBILE  -->

                    <div class="md:hidden">
                        <div class="grid grid-cols-3 md:grid-cols-3 gap-4">
                            <div class="mb-4">
                                <?php if (!$absens): ?>
                                <a href="<?= base_url('user/absen') ?>"
                                    class="w-full flex flex-col items-center bg-green-400 border-green-200 rounded-full shadow md:flex-row md:max-w-xl hover:bg-green-100 dark:border-green-400 dark:bg-green-500 dark:hover:bg-green-500 px-5 py-2">
                                    <div class="w-2/5 md:w-auto my-4">
                                        <i class="fa-solid fa-arrow-right-to-bracket fa-2xl mb-2 md:mb-0"></i>
                                    </div>
                                </a>
                                <div class="text-center md:text-left">
                                    <h3 class="md:hidden mb-1 mt-2 text-1xl font-semibold">Masuk</h3>
                                </div>
                                <?php else: ?>
                                <div class="w-full flex flex-col items-center bg-green-400 border-green-200 rounded-full shadow md:flex-row md:max-w-xl px-5 py-2 opacity-50 cursor-not-allowed"
                                    style="opacity: 0.6;">
                                    <div class="w-2/5 md:w-auto my-4">
                                        <i class="fa-solid fa-arrow-right-to-bracket fa-2xl mb-2 md:mb-0"></i>
                                    </div>
                                </div>
                                <div class="text-center md:text-left">
                                    <h3 class="md:hidden mb-1 mt-2 text-1xl font-semibold">Masuk</h3>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <?php if ($absens): ?>
                                <a href="<?= base_url('user/pulang') ?>"
                                    class="w-full flex flex-col items-center bg-red-500 border-red-200 rounded-full shadow md:flex-row md:max-w-xl hover:bg-red-100 dark:border-red-400 dark:bg-red-500 dark:hover:bg-red-500 px-5 py-2">
                                    <div class="w-2/5 md:w-auto my-4">
                                        <i class="fa-solid fa-arrow-right-from-bracket fa-2xl mb-2 md:mb-0"></i>
                                    </div>
                                </a>
                                <div class="text-center md:text-left">
                                    <h3 class="md:hidden mb-1 mt-2 text-1xl font-semibold">Pulang</h3>
                                </div>
                                <?php else: ?>
                                <div
                                    class="w-full flex flex-col items-center bg-red-400 border-red-200 rounded-full shadow md:flex-row md:max-w-xl px-5 py-2 opacity-50 cursor-not-allowed">
                                    <div class="w-2/5 md:w-auto my-4">
                                        <i class="fa-solid fa-arrow-right-from-bracket fa-2xl mb-2 md:mb-0"></i>
                                    </div>
                                </div>
                                <div class="text-center md:text-left">
                                    <h3 class="md:hidden mb-1 mt-2 text-1xl font-semibold">Pulang</h3>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-4">
                                <a href="<?php echo base_url('user/izin'); ?>"
                                    class="w-full  flex flex-col items-center bg-red-500 border-red-200 rounded-full shadow md:flex-row md:max-w-xl hover:bg-indigo-100 dark:border-indigo-700 dark:bg-indigo-800 dark:hover:bg-indigo-700 px-5 py-2">
                                    <div class="w-2/5 md:w-auto my-4">
                                        <i class="fa-solid fa-circle-xmark fa-2xl mb-2 md:mb-0"></i>
                                    </div>
                                </a>
                                <div class="text-center md:text-left">
                                    <h3 class="md:hidden mb-1 mt-2 text-1xl font-semibold">Izin</h3>
                                </div>
                            </div>
                        </div>

                        <div class="grid mt-3 grid-cols-2 md:grid-cols-2">
                            <div class="mb-4">
                                <a href="<?php echo base_url('user/cuti'); ?>"
                                    class="w-1/2 mx-auto flex flex-col items-center bg-indigo-400 border-indigo-200 rounded-full shadow md:flex-row md:max-w-xl hover:bg-indigo-100 dark:border-indigo-700 dark:bg-indigo-800 dark:hover:bg-indigo-700 px-5 py-2">
                                    <div class="w-2/5 md:w-auto my-4">
                                        <i class="fa-solid fa-calendar-day fa-2xl mb-2 md:mb-0"></i>
                                    </div>
                                </a>
                                <div class="text-center md:text-left">
                                    <h3 class="md:hidden mb-1 mt-2 text-1xl font-semibold">Cuti</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-2 mt-2">
            <div class="p-2">
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-4 mb-5">
                    <div
                        class="w-full p-4 text-center bg-white border border-gray-500 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                        <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Absen</h5>
                        <hr class="mb-4 border-gray-900">
                        <div class="flex justify-between">
                            <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
                                <?= $total_absen ?> Total
                            </p>
                            <div>
                                <i class="fa-solid fa-clock-rotate-left fa-fw fa-lg me-3 fa-2xl text-blue-400"></i>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-full p-4 text-center bg-white border border-gray-500 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                        <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Izin</h5>
                        <hr class="mb-4 border-gray-900">
                        <div class="flex justify-between">
                            <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
                                <?= $total_izin ?> Izin
                            </p>
                            <div>
                                <i class="fa-solid fa-circle-xmark fa-fw fa-lg me-3 fa-2xl text-green-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

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
                                        Tanggal
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Kehadiran
                                    </th>
                                </tr>
                            </thead>
                            <!-- Tabel Body -->
                            <tbody class="text-center">
                                <?php
                                $no = 0;
                                foreach ($absen as $row):
                                    if ($no < 5):
                                        $no++; ?>
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?php echo $no; ?>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?php echo convDate(
                                            $row->tanggal_absen
                                        ); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $row->status_absen; ?>
                                    </td>
                                </tr>
                                <?php
                                    else:
                                        break;
                                    endif;
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="flex justify-end">
                        <a class="focus:outline-none text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                            href="<?= base_url(
                                'user/history_absensi'
                            ) ?>" title="Ke Riwayat Absensi">
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <br>
                <br>
                <div
                    class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex justify-between">
                        <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Permohonan cuti</h6>
                    </div>
                    <hr>

                    <!-- Tabel -->
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-center text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Keperluan Cuti</th>
                                </tr>
                            </thead>
                            <!-- Tabel Body -->
                            <tbody class="text-center">
                                <?php
                                $no = 0;
                                foreach ($cuti as $row):
                                    if ($no < 5):
                                        $no++; ?>
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?php echo $no; ?>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?php echo $row->keperluan_cuti; ?>
                                    </td>
                                </tr>
                                <?php
                                    else:
                                        break;
                                    endif;
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="flex justify-end">
                        <a class="focus:outline-none text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                            href="<?= base_url(
                                'user/history_cuti'
                            ) ?>" title="Ke Riwayat Absensi">
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('components/footer'); ?>
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

    var waktuString = hari + ', ' + tanggal + ' ' + bulan + ' ' + tahun + ' - ' + jam + ':' + menit + ':' +
        detik;

    document.getElementById('waktu').innerHTML = waktuString;
}

// Memanggil fungsi updateTime setiap detik
setInterval(updateTime, 1000);
</script>

<?php if ($this->session->flashdata('berhasil_absen')) { ?>
<script>
Swal.fire({
    title: "Berhasil",
    text: "<?php echo $this->session->flashdata('berhasil_absen'); ?>",
    icon: "success",
    showConfirmButton: false,
    timer: 1500
});
</script>
<?php } ?>

<?php if ($this->session->flashdata('berhasil_izin')) { ?>
<script>
Swal.fire({
    title: "Berhasil",
    text: "<?php echo $this->session->flashdata('berhasil_izin'); ?>",
    icon: "success",
    showConfirmButton: false,
    timer: 1500
});
</script>
<?php } ?>


<?php if ($this->session->flashdata('berhasil_cuti')) { ?>
<script>
Swal.fire({
    title: "Berhasil",
    text: "<?php echo $this->session->flashdata('berhasil_cuti'); ?>",
    icon: "success",
    showConfirmButton: false,
    timer: 1500
});
</script>
<?php } ?>

<?php if ($this->session->flashdata('berhasil_pulang')) { ?>
<script>
Swal.fire({
    title: "Berhasil",
    text: "<?php echo $this->session->flashdata('berhasil_pulang'); ?>",
    icon: "success",
    showConfirmButton: false,
    timer: 1500
});
</script>
<?php } ?>

<?php if ($this->session->flashdata('gagal_absen')) { ?>
<script>
Swal.fire({
    title: "Gagal",
    text: "<?php echo $this->session->flashdata('gagal_absen'); ?>",
    icon: "error",
    showConfirmButton: false,
    timer: 1500
});
</script>
<?php } ?>

<?php if ($this->session->flashdata('gagal_izin')) { ?>
<script>
Swal.fire({
    title: "Gagal",
    text: "<?php echo $this->session->flashdata('gagal_izin'); ?>",
    icon: "error",
    showConfirmButton: false,
    timer: 1500
});
</script>
<?php } ?>

<?php if ($this->session->flashdata('gagal_pulang')) { ?>
<script>
Swal.fire({
    title: "Gagal",
    text: "<?php echo $this->session->flashdata('gagal_pulang'); ?>",
    icon: "error",
    showConfirmButton: false,
    timer: 1500
});
</script>
<?php } ?>

<?php if ($this->session->flashdata('berhasil_pulang')) { ?>
<script>
Swal.fire({
    title: "Berhasil",
    text: "<?php echo $this->session->flashdata('berhasil_pulang'); ?>",
    icon: "success",
    showConfirmButton: false,
    timer: 1500
});
</script>
<?php } ?>

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
<script>
// Fungsi untuk men-disable tombol Absen Masuk
function disableAbsenButton() {
    var absenButton = document.getElementById('absenButton');
    absenButton.disabled = true;
    absenButton.classList.add(
        'disabled'
    ); // (Opsional) Tambahkan kelas CSS 'disabled' untuk memberi gaya berbeda pada tombol yang dinonaktifkan
}

// Panggil fungsi disableAbsenButton jika user sudah melakukan absen
<?php if ($already_absent || $already_requested): ?>
window.onload = disableAbsenButton;
<?php endif; ?>
</script>

</html>