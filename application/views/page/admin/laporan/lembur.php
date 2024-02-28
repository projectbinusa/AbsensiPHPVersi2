<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Lembur</title>
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
    $id_admin = $this->session->userdata('id_admin');
    $lembur_id = $lembur->id_lembur;
    $nama_organisasi = tampil_organisasi($organisasi_id);
    $alamat = get_alamat($organisasi_id);
    $nama_admin = nama_admin($id_admin);
    $nama_jabatan = get_jabatan_by_lembur_id($lembur_id);
    $nama_organisasi = tampil_organisasi($organisasi_id);
    $username = get_organisasi($organisasi_id);
    ?>
    <div class="header">
        <h1>PERNYATAAN LEMBUR <br><?php echo $nama_organisasi; ?></h1>
        <p><?php echo $alamat; ?></p>
        <hr>
    </div>

    <div class="content">
        <!-- Isi konten surat disini -->

        <p>Yth. HRD PT. <?php echo $nama_organisasi; ?><br>di tempat</p>
        <p>Dengan hormat, <br>yang bertanda tangan dibawah ini:</p>

        <p>Nama : <?php echo $username; ?></p>

        <p>Jabatan: <?php echo $nama_jabatan; ?></p>

        <p>Untuk melaksanakan lembur pada: <?php echo tampilkan_tanggal_indonesia(
            $lembur->tanggal_lembur
        ); ?></p>
        <p>keterangan Lembur: <?php echo $lembur->keterangan_lembur; ?></p>

        <div class="mt-4">
            <p>Demikian surat ini buat, untuk digunakan sebagaimana mestinya.</p>
            <p>Terimakasih atas perhatian Bapak/Ibu.</p>
        </div>

        <div class="signature-container">
            <div class="left-signature">
                <p>_________________________</p>

                <p style="text-align: center;"><b><?php echo $username; ?></b></p>
            </div>

            <div class="right-signature">
                <p>_________________________</p>
                <p style="text-align: center;">
                    <b><?php echo $nama_admin; ?></b>
                </p>
            </div>
        </div>

    </div>
</body>

</html>