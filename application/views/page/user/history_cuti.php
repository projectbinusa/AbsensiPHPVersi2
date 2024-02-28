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
    <?php $this->load->view('components/sidebar_user'); ?>
    <div class="p-4 sm:ml-64">
        <div class="p-5 mt-10">

            <!-- Card -->
            <div
                class="w-full py-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 relative overflow-x-auto">
                <div class="flex justify-between">
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">History Cuti</h6>
                </div>

                <hr class="mb-5">

                <!-- Tabel -->
                <table id="dataCuti" class="py-5">
                    <!-- Tabel Head -->
                    <thead class="border-8 border-sky-500">
                        <tr>
                            <th>
                                No
                            </th>

                            <th>
                                Cuti Dari
                            </th>
                            <th>
                                Sampai
                            </th>
                            <th>
                                Masuk Kerja
                            </th>
                            <th>
                                Keperluan
                            </th>
                            <th>
                                Status
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
                            foreach ($cuti as $row):
                                $no++; ?>
                        <tr>
                            <th>
                                <?php echo $no; ?>
                            </th>
                            <td>
                                <?php echo convDate($row->awal_cuti); ?>
                            </td>
                            <td>
                                <?php echo convDate($row->akhir_cuti); ?>
                            </td>
                            <td>
                                <?php echo convDate($row->masuk_kerja); ?>
                            </td>
                            <td>
                                <?php echo $row->keperluan_cuti; ?>
                            </td>
                            <td>
                                <?php echo $row->status; ?>
                            </td>
                            <td>
                                <div class="flex justify-between">
                                    <a type="button" onclick="batal_cuti(<?php echo $row->id_cuti; ?>)"
                                        class="text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 mx-1 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
                                        <i class="fa-solid fa-circle-xmark"></i>
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
    var table = $('#dataCuti').DataTable({
        lengthChange: false, // Menonaktifkan opsi "Show entries"
        searching: true, // Menampilkan kolom pencarian
        paging: true, // Menampilkan paginasi
        ordering: true, // Menampilkan sorting
        info: true, // Menampilkan informasi halaman
        "dom": '<"top"f>rt<"bottom"lip>',
    })
});
</script>



<script>
function batal_cuti(id_cuti) {
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
            ); ?>" + id_cuti;
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
<?php } ?>

</html>