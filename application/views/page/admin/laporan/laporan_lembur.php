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
        font-size: 10px;
    }

    .address {
        text-align: center;
    }

    hr {
        width: 260px;
    }

    .content p {
        margin-top: 10px;
        margin-left: 50px;
    }

    .signature-container {
        clear: both;
        margin-top: 250px;
    }


    .left-signature {
        float: left;
        margin-right: 10px;
    }

    .right-signature {
        float: right;
        margin-left: 50px;
    }
    </style>
</head>

<body>

    <div class="header">
        <h1>LAPORAN KERJA LEMBUR <br></h1>
        <hr>
    </div>

    <div class="content">
        <!-- Isi konten surat disini -->
        <?php if (!empty($lembur)): ?>
        <?php foreach ($lembur as $index => $row):

            $hours = 0;
            $minutes = 0;
            $jam_mulai = $row->jam_mulai;
            $jam_selesai = $row->jam_selesai;
            $jam_kerja = '-';
            if ($jam_mulai != '00:00:00' && $jam_selesai != '00:00:00') {
                $start_time = strtotime($jam_mulai);
                $end_time = strtotime($jam_selesai);
                $diff = $end_time - $start_time;
                $hours = floor($diff / (60 * 60));
                $minutes = floor(($diff - $hours * 60 * 60) / 60);
                $jam_kerja = sprintf('%02d:%02d', $hours, $minutes);
            }
            ?>
        <!-- <?php
        $id = $row->id_user;
        var_dump($id);
        ?> -->
        <p>Nama : <?php echo $nama_users[$index]; ?></p>
        <p>Jabatan: <?php echo nama_jabatan($id_jabatan); ?></p>
        <p>Dengan surat ini menerangkan bahwa yang tersebut telah melaksanakan kerja lembur. Dengan rincian seperti
            berikut :</p>
        <table style="border-collapse: collapse; margin-left: 50px; width: 90%;">
            <thead>
                <tr style="border: thin solid black;">
                    <th style="border: thin solid black;">No</th>
                    <th style="border: thin solid black;">Tanggal</th>
                    <th style="border: thin solid black;">Uraian Tugas</th>
                    <th style="border: thin solid black;">Jam Mulai</th>
                    <th style="border: thin solid black;">Jam Keluar</th>
                    <th style="border: thin solid black;">Total Jam Lembur</th>
                </tr>

            </thead>
            <tbody>

                <tr style="border: thin solid black;">
                    <td style="border: thin solid black;"><?php echo $index +
                        1; ?></td>
                    <td style="border: thin solid black;"><?php echo $row->tanggal_lembur; ?></td>
                    <td style="border: thin solid black;"><?php echo $row->keterangan_lembur; ?></td>
                    <td style="border: thin solid black;"><?php echo $row->jam_mulai; ?></td>
                    <td style="border: thin solid black;"><?php echo $row->jam_selesai; ?></td>
                    <td style="border: thin solid black;"><?php if (
                        $hours > 0
                    ) {
                        echo $hours . ' Jam ' . $minutes . ' menit';
                    } else {
                        echo $minutes . ' Menit';
                    } ?>
                    </td>
                </tr>
                <tr style="border: thin solid black;">
                    <td colspan="7" style="text-align: center;">Tidak ada data lembur</td>
                </tr>
            </tbody>
        </table>
        <p>Semarang, <?php echo $row->tanggal_lembur; ?></p> <br>
        <p>Mengetahui,</p>
    </div>

    <div class="signature-container">
        <div class="left-signature">
            <p>_________________________</p>

            <p style="text-align: center;"><b></b></p>
        </div>
    </div>

    <?php
        endforeach; ?>
    <?php else: ?>
    <?php endif; ?>
    </div>
</body>

</html>