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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php $this->load->view('components/sidebar_super_admin'); ?>
    <div class="p-4 sm:ml-64">
        <div class="p-5">
            <!-- Card -->
            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-between">
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Data User</h6>
                    <a type="button" href="<?php echo base_url('superadmin/tambah_user'); ?>"
                        class="text-white bg-indigo-500 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                        <i class="fa-solid fa-plus"></i>
                    </a>
                </div>
                <hr>
                <!-- Tabel -->
                <div class='relative overflow-x-auto mt-4'>
                    <div class="table-responsive">
                        <table id="dataUser" class="w-full text-sm text-gray-500 dark:text-gray-400 mb-4 mt-4">
                            <!-- Tabel Head -->
                            <thead
                                class="text-center text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-4">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-4">
                                        Username
                                    </th>
                                    <th scope="col" class="px-6 py-4">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-4">
                                        Admin
                                    </th>
                                    <th scope="col" class="px-6 py-4">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <!-- Tabel Body -->
                            <tbody class='text-left'>
                                <?php foreach ($user as $row): ?>
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?php echo ++$start; ?>
                                    </th>
                                    <td class="px-6 py-4">
                                        <?php echo $row->username; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo $row->email; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo nama_admin($row->id_admin); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-start">
                                            <a type="button"
                                                href="<?php echo base_url('superadmin/detail_user/' . $row->id_user); ?>"
                                                class="text-white bg-indigo-500 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 mx-1 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </a>
                                            <a type="button"
                                                href="<?php echo base_url('superadmin/update_user/' . $row->id_user); ?>"
                                                class="text-white bg-yellow-400 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 mx-1 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a type="button" onclick="hapusUser(<?php echo $row->id_user; ?>)"
                                                class="text-white bg-red-600 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 mx-1 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                                                <i class="fa-solid fa-trash"></i>
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
        $('#dataUser').DataTable({
            responsive: true
        });
    });

    function hapusUser(idUser) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data user akan dihapus!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo base_url('superadmin/hapus_user/'); ?>" + idUser;
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
</body>

</html>