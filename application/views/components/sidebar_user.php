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

<?php
$id_user = $_SESSION['id'];
$email = $_SESSION['email'];
$username = $_SESSION['username'];
$image = $_SESSION['image'];
?>

<body>
    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full bg-gray-50 border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidebar">
        <div class="flex flex-col items-center w-40 h-full overflow-hidden text-gray-400 bg-gray-900">
            <a class="flex items-center w-full px-3 mt-3" href="#">
                <img src="<?php echo base_url(
                            './src/assets/image/absensi.png'
                        ); ?>" class="h-10 mr-3  bg-gray-700 rounded" alt="Absensi Logo" />
                <span class="self-center text-xl font-semibold sm:text-xl whitespace-nowrap dark:text-white">Absensi
                    App</span>
            </a>
            <div class="w-full px-2">
                <div class="flex flex-col items-center w-full mt-3 border-t border-gray-700">
                    <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300 <?=$page == 'dashboard' ? 'text-gray-200 bg-gray-700' :'' ?>"
                        href=" <?php echo base_url('user') ?>">
                        <i
                            class="fa-solid fa-house fa-fw fa-lg me-3 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="ml-2 text-sm font-medium">Dasboard</span>
                    </a>
                    <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300 <?=$page == 'history_absensi' ? 'text-gray-200 bg-gray-700' :'' ?>"
                        href="<?php echo base_url('user/history_absensi') ?>">
                        <i
                            class="fa-solid fa-clock-rotate-left fa-fw fa-lg me-3 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="ml-2 text-sm font-medium">Absensi</span>
                    </a>
                    <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300 <?=$page == 'history_cuti' ? 'text-gray-200 bg-gray-700' :'' ?>"
                        href="<?php echo base_url('user/history_cuti') ?>">
                        <i
                            class="fa-solid fa-umbrella-beach fa-fw fa-lg me-3 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="ml-2 text-sm font-medium">Cuti</span>
                    </a>
                    <a class="flex items-center w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300 <?=$page == 'history_lembur' ? 'text-gray-200 bg-gray-700' :'' ?>"
                        href="<?php echo base_url('user/history_lembur') ?>">
                        <i
                            class="fa-solid fa-laptop fa-fw fa-lg me-3 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="ml-2 text-sm font-medium">Lembur</span>
                    </a>
                </div>
                <div class="flex flex-col items-center w-full mt-2 border-t border-gray-700 py-5">
                    <span class="font-semibold ">v 1.0.0</span>
                </div>
            </div>
            <a class="flex items-center justify-center w-full h-16 mt-auto bg-gray-800 hover:bg-gray-700 hover:text-gray-300 absolute bottom-0"
                href="#">
                <i
                    class="fa-solid fa-right-from-bracket fa-fw fa-lg me-3 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                <span class="ml-2 text-sm font-medium">Logout</span>
            </a>
        </div>
    </aside>

    <div class="sm:ml-64">
        <header class="bg-gray-900 top-0 text-gray-400">
            <div class="px-3 py-4 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                            aria-controls="logo-sidebar" type="button"
                            class="inline-flex items-center p-2 text-sm text-black rounded-lg sm:hidden">
                            <i class="fa-solid fa-bars fa-xl" aria-hidden="true"></i>
                        </button>
                        <a class="inline-flex items-center p-2 text-sm text-black rounded-lg sm:hidden">
                            <img src="<?php echo base_url(
                            './src/assets/image/absensi.png'
                        ); ?>" class="h-10 mr-3 bg-gray-700 rounded" alt="Absensi Logo" />
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
                                    <img class="w-10 h-10 rounded-full object-cover" src="<?= base_url(
                                    '/images/user/' . $image
                                ) ?>" alt="user photo"></a>
                                </button>
                            </div>
                            <div class="z-50 hidden my-4 text-base list-none bg-gray-50 divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                                id="dropdown-user">
                                <div class="px-4 py-3" role="none">
                                    <p class="text-sm text-gray-900 dark:text-white" role="none">
                                        <?= $username ?>
                                    </p>
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300"
                                        role="none">
                                        <?= $email ?>
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
        </header>
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