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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
</head>

<body>

    <!-- Navbar -->
    <nav class="fixed top-0 z-50 w-full bg-indigo-200 border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">

                    <!-- Hamburger Menu -->
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-black rounded-lg sm:hidden">
                        <i class="fa-solid fa-bars fa-xl" aria-hidden="true"></i>
                    </button>
                    <a class="flex ml-2 md:mr-24">

                        <!-- Logo Aplikasi -->
                        <img src="<?php echo base_url(
                            './src/assets/image/binussmg.png'
                        ); ?>" class="h-10 mr-3" alt="Absensi Logo" />

                        <!-- Nama Aplikasi -->
                        <span
                            class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">Absensi
                            App</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ml-3">
                        <div>
                            <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full object-cover" src="<?= base_url(
                                    '/images/user/' . $user->image
                                ) ?>" alt="user photo"></a>
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-indigo-50 divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                            id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm text-gray-900 dark:text-white" role="none">
                                    <?= $user->username ?>
                                </p>
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                    <?= $user->email ?>
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a href="<?php echo base_url(
                                        'user/profile'
                                    ); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100
                                        dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Profile</a>
                                </li>
                                <li>
                                    <a onclick="confirmLogout();"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Log out</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-indigo-50 border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-indigo-50 dark:bg-gray-800">
            <ul class="space-y-2 font-medium">

                <!-- Menu Dashboard -->
                <li>
                    <a href="<?php echo base_url('user'); ?>"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i
                            class="fa-solid fa-house fa-fw fa-lg me-3 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('user/history_absensi'); ?>"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i
                            class="fa-solid fa-clock-rotate-left fa-fw fa-lg me-3 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Absen</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('user/history_cuti'); ?>"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i
                            class="fa-solid fa-calendar-alt fa-fw fa-lg me-3 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Cuti</span>
                    </a>
                </li>
                <!-- <li>
                    <a href="<?php echo base_url('user/history_lembur'); ?>"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i
                            class="fa-solid fa-business-time fa-fw fa-lg me-3 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Lembur</span>
                    </a>
                </li> -->
                <li>
                    <div class="flex flex-col items-center w-full mt-2 border-t border-gray-700 py-5">
                        <span class="font-semibold ">v 2.0.0</span>
                    </div>
                </li>
            </ul>
        </div>
    </aside>

    <div class="p-4 sm:ml-64">
    </div>
</body>

<script>
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
            window.location.href = "<?php echo base_url('auth/logout'); ?>";
        }
    });
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>

</html>