<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi App</title>
    <link rel="icon" href="<?php echo base_url(
        './src/assets/image/absensi.png'
    ); ?>" type="image/gif">
    <link rel="stylesheet" type="text/css"
        href="https://rawgit.com/nobleclem/jQuery-MultiSelect/master/jquery.multiselect.css" />
    <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
    <script src="https://rawgit.com/nobleclem/jQuery-MultiSelect/master/jquery.multiselect.js"></script>
</head>

<body>
    <?php $this->load->view('components/sidebar_user'); ?>
    <div class="p-4 sm:ml-64">
        <div class="p-5 mt-10">
            <!-- Card -->
            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <!-- Header -->
                <div class="flex justify-between">
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Lembur</h6>
                </div>

                <hr>

                <div class="mt-5 text-left">
                    <!-- Form Input -->
                    <form action="<?php echo base_url(
                        'user/ajukan_lembur'
                    ); ?>" method="post" class="text-left">

                        <div class="grid md:grid-cols-2 md:gap-6">

                            <!-- Tanggal Input -->
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="date" name="tanggal_lembur" id="tanggal_lembur"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " autocomplete="off" required />
                                <label for="tanggal_lembur"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Tanggal Lembur
                                </label>
                            </div>

                            <!-- Keterangan Input -->
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="keterangan_lembur" id="keterangan_lembur"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " autocomplete="off" required />
                                <label for="keterangan_lembur"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                    Keterangan Lembur
                                </label>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 md:gap-6">

                            <!-- Jam Mulai Input -->
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="time" name="jam_mulai" id="jam_mulai"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " autocomplete="off" required />
                                <label for="jam_mulai"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jam
                                    Mulai</label>
                            </div>

                            <!-- Jam Selesai Input -->
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="time" name="jam_selesai" id="jam_selesai"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " autocomplete="off" required />
                                <label for="jam_selesai"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jam
                                    Selesai</label>
                            </div>
                        </div>
                        <div class="facilities">
                            <label for="userSelect" class="label">Pilih User</label>
                            <select id="userSelect" name="id_user[]" multiple="multiple">
                                <option value="">--- All ---</option>
                                <?php
                                $query = $this->db->get('user');
                                $users = $query->result();
                                foreach ($users as $user): ?>
                                <option value="<?php echo $user->id_user; ?>"><?php echo $user->username; ?></option>
                                <?php endforeach;
                                ?>
                            </select>
                        </div>
                        <br>
                        <br>
                        <input type="hidden" id="selectedUsers" name="selected_users" readonly>
                        <button type="button" onclick="addSelectedUsers()"></button>

                        <!-- Button -->
                        <div class="flex justify-between">
                            <a class="focus:outline-none text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                href="javascript:history.go(-1)"><i class="fa-solid fa-arrow-left"></i></a>
                            <button type="submit"
                                class="text-white bg-indigo-500 hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800"><i
                                    class="fa-solid fa-floppy-disk"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
function updateSelectedUsers() {
    var select = document.getElementById("userSelect");
    var input = document.getElementById("selectedUsers");
    var selectedUsers = [];
    for (var i = 0; i < select.options.length; i++) {
        if (select.options[i].selected) {
            selectedUsers.push(select.options[i].value); // Menambahkan nilai ke dalam array selectedUsers
        }
    }
    input.value = selectedUsers.join(','); // Mengubah array menjadi string dengan koma sebagai pemisah
}

$(function() {
    var my_options = $('.facilities select option');
    var selected = $('.facilities').find('select').val();

    my_options.sort(function(a, b) {
        if (a.text > b.text) return 1;
        if (a.text < b.text) return -1;
        return 0
    })

    $('.facilities').find('select').empty().append(my_options);
    $('.facilities').find('select').val(selected);

    // set it to multiple
    $('.facilities').find('select').attr('multiple', true);

    // remove all option
    $('.facilities').find('select option[value=""]').remove();
    // add multiple select checkbox feature.
    $('.facilities').find('select').multiselect();

    // Attach event listener to the select element
    $('#userSelect').change(updateSelectedUsers);
})
</script>


</html>