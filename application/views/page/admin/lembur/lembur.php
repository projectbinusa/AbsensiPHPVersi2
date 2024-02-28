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
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">

</head>


<body>
    <?php $this->load->view('components/sidebar_admin'); ?>
    <div class="p-4 sm:ml-64">
        <div class="p-5 mt-10">

            <!-- Card -->
            <div
                class="w-full py-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 relative overflow-x-auto">
                <div class="flex justify-between">
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Lembur</h6>
                </div>

                <hr class="mb-5">

                <!-- Tabel -->
                <table id="datalembur" class="py-5">
                    <!-- Tabel Head -->
                    <thead class="border-8 border-sky-500">
                        <tr>
                            <th>
                                No
                            </th>
                            <th class="scrollable-col sl-scrollbar-x">
                                Nama
                            </th>
                            <th>
                                Keterangan Lembur
                            </th>
                            <th>
                                Tanggal Lembur
                            </th>
                            <th>
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <!-- Tabel Body -->
                    <tbody class='text-left'>
                        <?php
                        $no = 0;
                        foreach ($lembur as $row):
                            $no++; ?>
                        <tr>
                            <th>
                                <?php echo $no; ?>
                            </th>
                            <th class="scrollable-col sl-scrollbar-x">
                                <?php echo toTitleCase($row['id_user']); ?>
                            </th>
                            <td>
                                <?php echo $row['keterangan_lembur']; ?>
                            </td>
                            <td>
                                <?php echo convDate($row['tanggal_lembur']); ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-start">
                                    <a id="downloadPdfButton" type="button" target="_blank" href="<?php echo base_url(
                                        'admin/surat_lembur/'
                                    ) . $row['id_lembur']; ?>"
                                        class="text-white bg-yellow-400 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                                        <i class="fa-solid fa-print"></i>
                                    </a>
                                    <a id="downloadPdfButton" type="button" target="_blank" href="<?php echo base_url(
                                        'admin/laporan_surat_lembur/'
                                    ) . $row['id_lembur']; ?>"
                                        class="text-white bg-indigo-700 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
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
$(document).ready(function() {
    var table = $('#datalembur').DataTable({
        lengthChange: false, // Menonaktifkan opsi "Show entries"
        searching: true, // Menampilkan kolom pencarian
        paging: true, // Menampilkan paginasi
        ordering: true, // Menampilkan sorting
        info: true, // Menampilkan informasi halaman
        "dom": '<"top"f>rt<"bottom"lip>',
    })
});
</script>



<!-- <script>
function batal_cuti(id_lembur) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Batalkan cuti!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?php echo base_url(
                'user/aksi_batal_cuti/'
            ); ?>" + id_lembur;
        }
    });
}
</script>

<?php if ($this->session->flashdata('berhasil_batal')) { ?>
<script>
Swal.fire({
    title: "Berhasil",
    text: "<?php echo $this->session->flashdata('berhasil_batal'); ?>",
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

<?php if ($this->session->flashdata('gagal_cuti')) { ?>
<script>
Swal.fire({
    title: "Gagal",
    text: "<?php echo $this->session->flashdata('gagal_cuti'); ?>",
    icon: "error",
    showConfirmButton: false,
    timer: 1500
});
</script>
<?php } ?>

<?php if ($this->session->flashdata('berhasil_batal')) { ?>
<script>
Swal.fire({
    title: "Berhasil",
    text: "<?php echo $this->session->flashdata('berhasil_batal'); ?>",
    icon: "success",
    showConfirmButton: false,
    timer: 1500
});
</script>
<?php } ?>

<?php if ($this->session->flashdata('gagal_batal')) { ?>
<script>
Swal.fire({
    title: "Gagal",
    text: "<?php echo $this->session->flashdata('gagal_batal'); ?>",
    icon: "error",
    showConfirmButton: false,
    timer: 1500
});
</script>
<?php } ?> -->

</html>