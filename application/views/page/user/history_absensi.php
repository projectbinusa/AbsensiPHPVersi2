<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi App</title>
    <link rel="icon" href="<?php echo base_url(
        './src/assets/image/absensi.png'
    ); ?>" type="image/gif">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
</head>

<style>
.dataTables_wrapper select,
.dataTables_wrapper .dataTables_filter input {
    color: #4F709C;
    padding-left: 1rem;
    padding-right: 1rem;
    padding-top: .5rem;
    padding-bottom: .5rem;
    line-height: 1.25;
    border-width: 2px;
    border-radius: .25rem;
    background-color: #F5F7F8;
    margin: 10px 0;
}

.dataTables_wrapper .dataTables_filter input {
    margin-left: 9px;
}
</style>


<body>
    <?php $this->load->view('components/sidebar_user'); ?>
    <div class="p-4 sm:ml-64">
        <div class="p-5 mt-10">

            <!-- Card -->
            <div
                class="w-full py-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 relative overflow-x-auto">
                <div class="flex justify-between">
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">History absensi</h6>
                </div>

                <hr class="mb-5">

                <!-- Tabel -->
                <table id="dataAbsen">
                    <thead>
                        <tr>
                            <th>
                                No
                            </th>
                            <th>
                                Tanggal
                            </th>
                            <th>
                                Jam Masuk
                            </th>
                            <th>
                                Jam Pulang
                            </th>
                            <th>
                                Keterangan
                            </th>
                            <th>
                                Kehadiran
                            </th>
                            <th>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <!-- Tabel Body -->
                    <tbody>
                        <?php
                        $no = 0;
                        foreach ($absensi as $row):
                            $no++; ?>
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th><?php echo $no; ?></th>
                            <td><?php echo convDate(
                                $row->tanggal_absen
                            ); ?></td>
                            <td><?php echo $row->jam_masuk; ?></td>
                            <td><?php echo $row->jam_pulang; ?></td>
                            <td><?php echo $row->keterangan_izin; ?></td>
                            <td><?php echo $row->status_absen; ?></td>
                            <td class="px-5 py-3">
                                <div class="flex justify-center">
                                    <?php if ($row->keterangan_izin == '-'): ?>
                                    <a type="button" href="<?= base_url(
                                        'user/detail_absensi/' .
                                            $row->id_absensi
                                    ) ?>"
                                        class="text-white bg-indigo-500 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 mx-1 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                    <a type="button" href="<?= base_url(
                                        'user/izin_absen/' . $row->id_absensi
                                    ) ?>"
                                        class="text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 mx-1 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
                                        <i class="fa-solid fa-user-plus"></i>
                                    </a>
                                    <?php else: ?>
                                    <a type="button" href="<?= base_url(
                                        'user/detail_absensi/' .
                                            $row->id_absensi
                                    ) ?>"
                                        class="text-white bg-indigo-500 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 mx-1 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                    <?php endif; ?>
                                </div>
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

</body>

<script>
function toggleModal() {
    document.getElementById('modal').classList.toggle('hidden')
}

$(document).ready(function() {

    var table = $('#dataAbsen').DataTable({
        lengthChange: false, // Menonaktifkan opsi "Show entries"
        searching: true, // Menampilkan kolom pencarian
        paging: true, // Menampilkan paginasi
        ordering: true, // Menampilkan sorting
        info: true, // Menampilkan informasi halaman
        "dom": '<"top"f>rt<"bottom"lip>',
    })
});
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

</html>