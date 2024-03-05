<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi App</title>
    <link rel="icon" href="<?php echo base_url(
        './src/assets/image/absensi.png'
    ); ?>" type="image/gif">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body>
    <?php $this->load->view('components/sidebar_user'); ?>
    <div class="p-4 sm:ml-64">
        <div class="p-5 mt-10">

            <!-- Card -->
            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-between">
                    <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Detail absensi</h6>
                </div>
                <hr>

                <div class="mt-5 text-left">
                    <!-- Form Input -->

                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_absensi" value="<?php echo $absensi->id_absensi; ?>">

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="jam_masuk" id="jam_masuk" value="<?php echo nama_user(
                                    $absensi->id_user
                                ); ?>"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " autocomplete="off" required readonly />
                                <label for="jam_masuk"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Username
                                </label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="jam_pulang" id="jam_pulang" value="<?php echo convDate(
                                    $absensi->tanggal_absen
                                ); ?>"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " autocomplete="off" required readonly />
                                <label for="jam_pulang"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Tanggal
                                </label>
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="jam_masuk" id="jam_masuk"
                                    value="<?php echo $absensi->jam_masuk; ?>"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " autocomplete="off" required readonly />
                                <label for="jam_masuk"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jam
                                    Masuk
                                </label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="jam_pulang" id="jam_pulang"
                                    value="<?php echo $absensi->jam_pulang; ?>"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " autocomplete="off" required readonly />
                                <label for="jam_pulang"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Jam
                                    Pulang
                                </label>
                            </div>
                            <div class="relative mb-2 z-0 w-full mb-6 group">
                                <div id="mapMasuk" class="mt-4"
                                    style="position: relative; z-index: 1; aspect-ratio: 4/3;">
                                </div>
                                <label for="lokasi_masuk"
                                    class="peer-focus:font-medium absolute mb-2 text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Lokasi
                                    Masuk
                                </label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <div id="mapPulang" class="mt-4"
                                    style="position: relative; z-index: 1; aspect-ratio: 4/3;">
                                </div>
                                <label for="lokasi_pulang"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Lokasi
                                    Pulang
                                </label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <a href="<?= base_url(
                                    $absensi->foto_masuk
                                ) ?>" data-lightbox="foto-masuk">
                                    <img src="<?= base_url(
                                        $absensi->foto_masuk
                                    ) ?>" name="foto_masuk" alt="Foto masuk"
                                        class="block py-2.5 px-0 w-100 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        id="foto_masuk" required />
                                </a>
                                <label for="foto_masuk"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Foto
                                    Masuk
                                </label>
                            </div>

                            <div class="relative z-0 w-full mb-6 group">
                                <a href="<?= base_url(
                                    $absensi->foto_pulang
                                ) ?>" data-lightbox="foto-pulang">
                                    <img src="<?= base_url(
                                        $absensi->foto_pulang
                                    ) ?>" name="foto_pulang" alt="Foto pulang"
                                        class="block py-2.5 px-0 w-100 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        id="foto_pulang" required />
                                </a>
                                <label for="foto_pulang"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Foto
                                    pulang
                                </label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="status_absen" id="status_absen"
                                    value="<?php echo $absensi->status_absen; ?>"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " autocomplete="off" required readonly />
                                <label for="status_absen"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Status
                                    Absen
                                </label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="keterangan_terlambat" id="keterangan_terlambat"
                                    value="<?php echo $absensi->keterangan_terlambat; ?>"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " autocomplete="off" required readonly />
                                <label for="keterangan_terlambat"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keterangan
                                    Terlambat
                                </label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="keterangan_pulang_awal" id="keterangan_pulang_awal"
                                    value="<?php echo $absensi->keterangan_pulang_awal; ?>"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " autocomplete="off" required readonly />
                                <label for="keterangan_pulang_awal"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keterangan
                                    Pulang Awal
                                </label>
                            </div>
                            <div class="relative z-0 w-full mb-6 group">
                                <input type="text" name="keterangan_izin" id="keterangan_izin"
                                    value="<?php echo $absensi->keterangan_izin; ?>"
                                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                    placeholder=" " autocomplete="off" required readonly />
                                <label for="keterangan_izin"
                                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keterangan
                                    Izin
                                </label>
                            </div>
                        </div>
                </div>
                <!-- Button -->
                <div class="flex justify-between">
                    <a class="focus:outline-none text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                        href="javascript:history.go(-1)"> <i class="fa-solid fa-arrow-left"></i>
                    </a>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
const mapMasuk = L.map('mapMasuk');
const tilesMasuk = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(mapMasuk);

const mapPulang = L.map('mapPulang');
const tilesPulang = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(mapPulang);

// Fungsi untuk menampilkan peta pada lokasi tertentu dan alamat
function tampilkanPeta(map, lokasi) {
    const koordinat = lokasi.split(', ');
    const latitude = parseFloat(koordinat[0].split(':')[1]);
    const longitude = parseFloat(koordinat[1].split(':')[1]);

    // Setel tampilan peta dan tambahkan marker
    map.setView([latitude, longitude], 13);
    const marker = L.marker([latitude, longitude]).addTo(map);

    // Fetch alamat dari Nominatim
    fetch(
            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&zoom=18&addressdetails=1`
        )
        .then(response => response.json())
        .then(data => {
            console.log(data);
            var address = data.display_name;

            // Tampilkan alamat di dalam popup marker
            marker.bindPopup('Alamat: ' + address).openPopup();
        })
        .catch(error => console.error('Error:', error));
}

// Panggil fungsi saat halaman dimuat
window.onload = function() {
    tampilkanPeta(mapMasuk, "<?php echo $absensi->lokasi_masuk; ?>");
    tampilkanPeta(mapPulang, "<?php echo $absensi->lokasi_pulang; ?>");
};
</script>

</html>