<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Cuti</title>
    <link rel="icon" href="<?php echo base_url(
        './src/assets/image/absensi.png'
    ); ?>" type="image/gif">
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .logo {
        width: 100px;
        /* Sesuaikan ukuran logo */
        height: auto;
    }

    .address {
        text-align: center;
    }

    .content p {
        margin-top: 20px;
        margin-left: 50px;
    }

    .signature-container {
        clear: both;
        margin-top: 250px;
    }


    .left-signature {
        float: left;
        margin-right: 50px;
    }

    .right-signature {
        float: right;
        margin-left: 50px;
    }
    </style>
</head>

<body>
    <?php
    // Memanggil helper
    $ci = &get_instance();
    $ci->load->helper('admin_helper');
    $cuti_id = $cuti->id_cuti;
    $organisasi_id = $cuti->id_organisasi;
    $id_admin = $this->session->userdata('id_admin');
    $nama_jabatan = get_jabatan_by_cuti_id($cuti_id);
    $nama_admin = nama_admin($id_admin);
    $nama_organisasi = tampil_organisasi($organisasi_id);
    $username = get_organisasi($organisasi_id);
    $alamat = get_alamat($organisasi_id);
    ?>
    <div class="header">
        <h1>PERMOHONAN CUTI <br><?php echo $nama_organisasi; ?></h1>
        <p><?php echo $alamat; ?></p>
        <hr>
    </div>

    <div class="address">

    </div>

    <div class="content">

        <p>Yth. HRD PT. <?php echo $nama_organisasi; ?><br>di tempat</p>
        <p>Dengan hormat,<br>yang bertanda tangan dibawah ini:</p>

        <p>Nama : <?php echo $username; ?></p>

        <p>Jabatan: <?php echo $nama_jabatan; ?></p>

        <p>Tanggal Pengambilan Cuti : <?php echo tampilkan_tanggal_indonesia(
            $cuti->awal_cuti
        ); ?> Sampai Dengan
            <?php echo tampilkan_tanggal_indonesia($cuti->akhir_cuti); ?></p>

        <p>Tanggal Kembali Kerja : <?php echo tampilkan_tanggal_indonesia(
            $cuti->masuk_kerja
        ); ?></p>

        <p>Keperluan : <?php echo $cuti->keperluan_cuti; ?></p>

        <p>Bermaksud mengajukan cuti tahunan dari <b><?php echo tampilkan_tanggal_indonesia(
            $cuti->awal_cuti
        ); ?> hingga
                <br>
                <?php echo tampilkan_tanggal_indonesia(
                    $cuti->akhir_cuti
                ); ?></b>, saya akan mulai bekerja kembali pada
            <b><?php echo tampilkan_tanggal_indonesia(
                $cuti->masuk_kerja
            ); ?></b>. <br>
        </p>
        <p>Demikian permohonan cuti ini saya ajukan. Terimakasih atas perhatian Bapak/Ibu.</p>

        <p>Tanggal <?php echo tampilkan_tanggal_indonesia(
            $cuti->awal_cuti
        ); ?></p>
        <div class="signature-container">
            <div class="left-signature">
                <p>_________________________</p>

                <p style="text-align: center;"><b>(<?php echo $username; ?>)</b></p>

                </p>
            </div>

            <div class="right-signature">
                <p>_________________________</p>
                <p style="text-align: center;">
                    <b>(<?php echo $nama_admin; ?>)</b>
                </p>
            </div>
        </div>

    </div>
</body>

</html>