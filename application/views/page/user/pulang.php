<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi App</title>
    <link rel="icon" href="<?php echo base_url(
        './src/assets/image/absensi.png'
    ); ?>" type="image/gif">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
    .leaflet-container {
        height: 400px;
        width: 600px;
        max-width: 100%;
        max-height: 100%;
    }

    #video {
        transform: scaleX(-1);
    }

    #photoContainer img {
        transform: scaleX(-1);
    }
    </style>
</head>

<body>
    <?php $this->load->view('components/sidebar_user'); ?>
    <div class="p-4 sm:ml-64">
        <div class="p-5 mt-10">
            <div
                class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <form id="FormPulang" action="<?php echo base_url(
                    'user/aksi_pulang'
                ); ?>" method="post">

                    <div class="mb-4 text-left">
                        <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Absen Pulang</h6>
                        <div class="text-center mb-5">
                            <p id="waktu"></p>
                            <?php echo $greeting; ?>,
                            <span><?php echo $this->session->userdata(
                                'username'
                            ); ?></span>
                        </div>
                        <hr class="mb-7">
                        <h6 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">
                        </h6>
                        <div class="grid grid-cols-1 md:grid-cols-1 md:gap-12">
                            <div class="mb-4 text-center">
                                <label for="webcam" class="block text-sm font-semibold mb-2">Foto:</label>
                                <div class="flex items-center justify-center mb-3">
                                    <div id="photoContainer" class="border border-gray-300 rounded-md"></div>
                                    <video id="video" width="auto" height="auto" autoplay></video>
                                    <canvas id="canvas" style="display:none;"></canvas>
                                    <input type="hidden" name="image_data" id="image-data" />
                                </div>
                                <button type="button" id="capture-btn"
                                    class="bg-indigo-500 text-white px-4 py-2 rounded-md mb-3">
                                    <i class="fa-solid fa-camera"></i>
                                </button>
                                <label for="map" class="block text-sm font-semibold mb-2">Lokasi:</label>
                                <div id="address"></div>
                                <div class="flex items-center justify-center">
                                    <div id="map" style="position: relative; z-index: 1; aspect-ratio: 4/3;">
                                        <input type="hidden" name="lokasi_pulang" id="lokasi_pulang" />
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 text-left">
                                <div class="relative z-0 w-full mb-6 group">
                                    <input type="text" name="keterangan_pulang_awal" id="keterangan_pulang_awal"
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                                        placeholder=" " autocomplete="off" required />
                                    <label for="keterangan_pulang_awal"
                                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Keterangan
                                        Pulang Awal</label>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between mt-5">
                            <a class="text-white bg-red-500 px-4 py-2 rounded-md" href="javascript:history.go(-1)"><i
                                    class="fa-solid fa-arrow-left"></i></a>
                        </div>
                </form>
                <script>
                // Menambahkan script JavaScript untuk mendapatkan dan menampilkan longitude dan latitude
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;

                    // Menyimpan nilai latitude dan longitude di input tersembunyi
                    document.getElementById("lokasi_pulang").value = "Latitude: " + latitude + ", Longitude: " +
                        longitude;

                    fetch(
                            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&zoom=18&addressdetails=1`
                        )
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            var address = data.display_name;
                            document.getElementById('address').innerHTML = 'Alamat: ' + address;
                        })
                        .catch(error => console.error('Error:', error));
                });
                </script>

                <script>
                // Fungsi untuk mengambil foto dan mengirim formulir
                function captureAndSubmit() {
                    const video = document.getElementById('video');
                    const canvas = document.getElementById('canvas');
                    const photoContainer = document.getElementById('photoContainer');

                    const context = canvas.getContext('2d');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);

                    const imageData = canvas.toDataURL('image/png');
                    const imgElement = document.createElement('img');
                    imgElement.src = imageData;
                    photoContainer.innerHTML = '';
                    photoContainer.appendChild(imgElement);

                    // Simpan data gambar yang diambil ke dalam variabel global
                    capturedImageData = imageData;

                    // Sembunyikan elemen video setelah gambar diambil
                    video.style.display = 'none';

                    // Setel nilai input tersembunyi dengan data gambar yang diambil
                    const imageDataInput = document.getElementById('image-data');
                    imageDataInput.value = capturedImageData;

                    // Submit form
                    document.getElementById('FormPulang').submit();
                }

                document.addEventListener('DOMContentLoaded', function() {
                    const video = document.getElementById('video');
                    const captureBtn = document.getElementById('capture-btn');

                    navigator.mediaDevices.getUserMedia({
                            video: true
                        })
                        .then(stream => {
                            video.srcObject = stream;
                        })
                        .catch(err => console.error('Error accessing camera:', err));

                    captureBtn.addEventListener('click', captureAndSubmit);
                });
                </script>
            </div>
        </div>
    </div>
</body>
<script>
function updateTime() {
    var now = new Date();
    var hari = now.toLocaleDateString('id-ID', {
        weekday: 'long'
    });
    var tanggal = now.getDate();
    var bulan = now.toLocaleDateString('id-ID', {
        month: 'long'
    });
    var tahun = now.getFullYear();
    var jam = now.getHours();
    var menit = now.getMinutes();
    var detik = now.getSeconds();

    var waktuString = hari + ', ' + tanggal + ' ' + bulan + ' ' + tahun + ' - ' + jam + ':' + menit + ':' + detik;

    document.getElementById('waktu').innerHTML = waktuString;
}

// Memanggil fungsi updateTime setiap detik
setInterval(updateTime, 1000);
</script>

</html>