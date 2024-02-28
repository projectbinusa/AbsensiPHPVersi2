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
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Data Lokasi</h6>
                    <a type="button" href="<?php echo base_url(
                        'admin/tambah_lokasi'
                    ); ?>"
                        class="text-white bg-indigo-500 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800"><i
                            class="fa-solid fa-plus"></i></a>
                </div>
                <hr>

                <!-- Tabel -->
                <div class="relative overflow-x-auto mt-5">
                    <table id="dataLokasi"
                        class="w-full text-center text-sm text-left text-gray-500 dark:text-gray-400">

                        <!-- Tabel Head -->
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">No</th>
                                <th scope="col" class="px-6 py-3">Nama Lokasi</th>
                                <th scope="col" class="px-6 py-3">Alamat</th>
                                <th scope="col" class="px-6 py-3">Jumlah Karyawan</th>
                                <th scope="col" class="px-6 py-3">Organisasi</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <!-- Tabel Body -->
                        <?php
                        $no = 0;
                        foreach ($lokasi as $data):
                            $no++; ?>
                        <tr
                            class="text-left bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4"> <?php echo $no; ?>
                            <td class="px-6 py-4">
                                <?php echo $data->nama_lokasi; ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo $data->alamat; ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php
                                // Tampilkan jumlah karyawan berdasarkan id_organisasi
                                $jumlah_karyawan = $this->admin_model->count_users_by_organisasi(
                                    $data->id_organisasi
                                );
                                echo $jumlah_karyawan;
                                ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo nama_organisasi(
                                    $data->id_organisasi
                                ); ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-start">
                                    <a type="button" href="<?= base_url(
                                        'admin/detail_lokasi/' .
                                            $data->id_lokasi
                                    ) ?>"
                                        class="text-white bg-indigo-500 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 mx-1 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                    <a type="button" href="<?php echo base_url(
                                        'admin/update_lokasi/' .
                                            $data->id_lokasi
                                    ); ?>"
                                        class="text-white bg-yellow-400 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="javascript:void(0);"
                                        onclick="hapusLokasi('<?php echo $data->id_lokasi; ?>')"
                                        class="text-white bg-red-600 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php
                        endforeach;
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
$(document).ready(function() {
    $('#dataLokasi').DataTable({
        lengthChange: false, // Menonaktifkan opsi "Show entries"
        searching: true, // Menampilkan kolom pencarian
        paging: true, // Menampilkan paginasi
        ordering: true, // Menampilkan sorting
        info: true, // Menampilkan informasi halaman
        "dom": '<"top"f>rt<"bottom"lip>',
    });
});
</script>

<script>
function hapusLokasi(idLokasi) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Data lokasi beserta karyawan yang terkait akan dihapus!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Contoh SweetAlert berhasil (gantilah ini dengan respons server sebenarnya)
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data lokasi berhasil dihapus.',
                icon: 'success',
                timer: 1500, // Waktu dalam milidetik sebelum SweetAlert ditutup secara otomatis (1.5 detik dalam contoh ini)
                showConfirmButton: false // Menyembunyikan tombol OK
            }).then(() => {
                // Redirect atau lakukan tindakan lain setelah penghapusan berhasil
                window.location.href = "<?php echo base_url(
                    'admin/hapus_lokasi/'
                ); ?>" + idLokasi;
            });
        }
    });
}
</script>
<?php if ($this->session->flashdata('berhasil_update')) { ?>
<script>
Swal.fire({
    title: "Berhasil",
    text: "<?php echo $this->session->flashdata('berhasil_update'); ?>",
    icon: "success",
    showConfirmButton: false,
    timer: 1500
});
</script>
<?php } ?>

<?php if ($this->session->flashdata('berhasil_tambah')) { ?>
<script>
Swal.fire({
    title: "Berhasil",
    text: "<?php echo $this->session->flashdata('berhasil_tambah'); ?>",
    icon: "success",
    showConfirmButton: false,
    timer: 1500
});
</script>
<?php } ?>

</html>