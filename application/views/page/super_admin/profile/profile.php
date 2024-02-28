<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi App</title>
    <link rel="icon" href="<?php echo base_url(
        './src/assets/image/absensi.png'
    ); ?>" type="image/gif">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(
        'assets/css/responsive.css'
    ); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(
        'assets/css/profile.css'
    ); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
#profile-picture-container {
    width: 200px;
    height: 200px;
    overflow: hidden;
}

#profile-picture-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    border-radius: 50%;
}
</style>

<body>
    <?php $this->load->view('components/sidebar_super_admin'); ?>
    <div class="p-5 sm:ml-64">
        <div class="p-5 mt-10">
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                    data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab"
                            data-tabs-target="#profile" type="button" role="tab" aria-controls="profile"
                            aria-selected="false">Profile</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                            id="detail-tab" data-tabs-target="#detail" type="button" role="tab" aria-controls="detail"
                            aria-selected="false">Detail Akun</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                            id="settings-tab" data-tabs-target="#settings" type="button" role="tab"
                            aria-controls="settings" aria-selected="false">Settings</button>
                    </li>
                </ul>
            </div>
            <div id="default-tab-content">
                <div class="hidden" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="bg-white rounded-lg shadow-md p-8 border border-gray-300">
                        <div class="text-2xl font-semibold mb-5">Profile Picture</div>
                        <hr>
                        <div class="card-body text-center">

                            <div id="profile-picture-container"
                                class="rounded-full mt-2 mx-auto my-auto w-48 h-48 md:w-40 md:h-40 lg:w-56 lg:h-56 xl:w-64 xl:h-64 object-cover">
                                <img class="h-full object-cover rounded-full" src="<?= base_url(
                                        './images/superadmin/' .
                                            $superadmin->image
                                    ) ?>" alt="Profile Picture">
                            </div>
                            <div class="small font-italic text-muted mb-4">JPG atau PNG tidak lebih besar dari 5 MB
                            </div>
                            <p class="small font-italic text-muted mb-4">Disarankan berukuran 1:1</p>
                            <form action="<?= base_url(
                                'superadmin/aksi_ubah_foto'
                            ) ?>" method="post" class="grid gap-4" enctype="multipart/form-data">
                                <div>
                                    <div class="text-xl font-semibold mb-4">Previews</div>
                                </div>
                                <div id="image-preview" class="hidden flex items-center justify-center">
                                    <img id="preview"
                                        class="rounded-full mt-2 mx-auto my-auto w-48 h-48 md:w-40 md:h-40 lg:w-56 lg:h-56 xl:w-64 xl:h-64 object-cover">
                                </div>
                                <div class="flex items-center mb-2">
                                    <div
                                        class="text-white bg-green-500 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800 mx-auto">
                                        <label for="image" class="text-white rounded-md" style="cursor: pointer; ">
                                            <i class="fas fa-pen-to-square"></i>
                                        </label>
                                        <input type="file" name="image" id="image" accept="image/*"
                                            onchange="previewImage()" style="display: none;">
                                    </div>


                                    <button type="submit"
                                        class="text-white bg-indigo-500 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800 mx-auto">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="hidden" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                    <div class="bg-white rounded-lg shadow-md p-8 border border-gray-300">
                        <div class="text-3xl font-semibold mb-8">Detail Akun</div>
                        <form method="post" action="<?= base_url(
                            'superadmin/edit_profile'
                        ) ?>">
                            <div class="mb-4">
                                <label for="username" class="block mb-1 text-sm">Nama Lengkap</label>
                                <input type="text" autocomplete="off" class="border rounded-md w-full p-2" id="username"
                                    name="username" value="<?php echo $superadmin->username; ?>">
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block mb-1 text-sm">Email</label>
                                <input type="text" class="border rounded-md w-full p-2" id="email" name="email"
                                    value="<?php echo $superadmin->email; ?>" readonly>
                            </div>
                            <div class="flex justify-end">
                                <button
                                    class="text-white bg-indigo-500 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800"
                                    type="submit"><i class="fa-solid fa-floppy-disk"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="hidden" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                    <div class="bg-white rounded-lg shadow-md p-8 border border-gray-300">
                        <div class="text-xl font-semibold mb-4">Ganti Password</div>
                        <form method="post" action="<?= base_url(
                            'superadmin/update_password'
                        ) ?>">
                            <div class="w-full lg:w-1/2 m-2 mb-4 lg:mb-0">
                                <label for="passwordLama" class="block mb-1 text-sm">Password Lama</label>
                                <input type="password" class="border rounded-md w-full p-2" id="passwordLama"
                                    name="password_lama" required>
                            </div>
                            <div class="w-full lg:w-1/2 m-2 mb-4 lg:mb-0">
                                <label for="passwordBaru" class="block mb-1 text-sm">Password Baru</label>
                                <input type="password" class="border rounded-md w-full p-2" id="passwordBaru"
                                    name="password_baru" required>
                            </div>
                            <div class="w-full lg:w-1/2 m-2">
                                <label for="konfirmasiPassword" class="block mb-1 text-sm">Konfirmasi
                                    Password</label>
                                <input type="password" class="border rounded-md w-full p-2" id="konfirmasiPassword"
                                    name="konfirmasi_password" required>
                            </div>
                            <div class="flex items-start mt-3 mb-3 ml-2">
                                <div class="flex items-center h-5">
                                    <input id="showpass" type="checkbox" value=""
                                        class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800"
                                        onchange="showPassword()">
                                </div>
                                <label for="showpass"
                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Show
                                    Password</label>
                            </div>
                            <div class="flex justify-end">
                                <button
                                    class="text-white bg-indigo-500 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800"
                                    type="submit"><i class="fa-solid fa-floppy-disk"></i></button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
        // Fungsi untuk menampilkan konfirmasi SweetAlert saat tombol logout ditekan
        function confirmLogout() {
            Swal.fire({
                title: 'Yakin ingin logout?',
                text: "Anda akan keluar dari akun Anda.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika konfirmasi "Ya", maka alihkan ke logout
                    window.location.href = "<?php echo base_url(
                        'auth/logout'
                    ); ?>";
                }
            });
        }

        function previewImage() {
            var input = document.getElementById('image');
            var preview = document.getElementById('preview');
            var previewContainer = document.getElementById('image-preview');

            previewContainer.style.display = 'block';

            var file = input.files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.src = reader.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
            }
        }
        </script>
        <script>
        function showPassword() {
            var oldPasswordInput = document.getElementById('passwordLama');
            var passwordInput = document.getElementById('passwordBaru');
            var confirmPasswordInput = document.getElementById('konfirmasiPassword');
            var showPassCheckbox = document.getElementById('showpass');

            if (showPassCheckbox.checked) {
                oldPasswordInput.type = 'text';
                passwordInput.type = 'text';
                confirmPasswordInput.type = 'text';
            } else {
                oldPasswordInput.type = 'password';
                passwordInput.type = 'password';
                confirmPasswordInput.type = 'password';
            }
        }
        </script>
        <?php if ($this->session->flashdata('kesalahan_password')) { ?>
        <script>
        Swal.fire({
            title: "Error!",
            text: "<?php echo $this->session->flashdata(
                'kesalahan_password'
            ); ?>",
            icon: "warning",
            showConfirmButton: false,
            timer: 1500
        });
        </script>
        <?php } ?>

        <?php if ($this->session->flashdata('gagal_update')) { ?>
        <script>
        Swal.fire({
            title: "Error!",
            text: "<?php echo $this->session->flashdata('gagal_update'); ?>",
            icon: "error",
            showConfirmButton: false,
            timer: 1500
        });
        </script>
        <?php } ?>

        <?php if ($this->session->flashdata('error_profile')) { ?>
        <script>
        Swal.fire({
            title: "Error!",
            text: "<?php echo $this->session->flashdata('error_profile'); ?>",
            icon: "error",
            showConfirmButton: false,
            timer: 1500
        });
        </script>
        <?php } ?>

        <?php if ($this->session->flashdata('kesalahan_password_lama')) { ?>
        <script>
        Swal.fire({
            title: "Error!",
            text: "<?php echo $this->session->flashdata(
                'kesalahan_password_lama'
            ); ?>",
            icon: "error",
            showConfirmButton: false,
            timer: 1500
        });
        </script>
        <?php } ?>

        <?php if ($this->session->flashdata('berhasil_ubah_foto')) { ?>
        <script>
        Swal.fire({
            title: "Berhasil",
            text: "<?php echo $this->session->flashdata(
                'berhasil_ubah_foto'
            ); ?>",
            icon: "success",
            showConfirmButton: false,
            timer: 1500
        });
        </script>
        <?php } ?>

        <?php if ($this->session->flashdata('ubah_password')) { ?>
        <script>
        Swal.fire({
            title: "Success!",
            text: "<?php echo $this->session->flashdata('ubah_password'); ?>",
            icon: "success",
            showConfirmButton: false,
            timer: 1500
        });
        </script>
        <?php } ?>

        <?php if ($this->session->flashdata('update_ubah_foto')) { ?>
        <script>
        Swal.fire({
            title: "Success!",
            text: "<?php echo $this->session->flashdata(
                'update_ubah_foto'
            ); ?>",
            icon: "success",
            showConfirmButton: false,
            timer: 1500
        });
        </script>
        <?php } ?>

</body>

</html>