<?php
function organisasi($id_organisasi)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db
        ->where('id_organisasi', $id_organisasi)
        ->get('organisasi');
    foreach ($result->result() as $c) {
        $tmt = $c->nama_organisasi;
        return $tmt;
    }
}

function convDate($date)
{
    $bulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    $tanggal = date('d', strtotime($date)); // Mengambil tanggal dari timestamp
    $bulan = $bulan[date('n', strtotime($date))]; // Mengambil bulan dalam bentuk string
    $tahun = date('Y', strtotime($date)); // Mengambil tahun dari timestamp

    return $tanggal . ' ' . $bulan . ' ' . $tahun; // Mengembalikan tanggal yang diformat
}

function convDateTime($dateTime)
{
    // Periksa apakah $dateTime adalah null
    if ($dateTime === null) {
        return '-';
    }

    $bulan = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    $tanggal = date('d', strtotime($dateTime)); // Mengambil tanggal dari timestamp
    $bulan = $bulan[date('n', strtotime($dateTime))]; // Mengambil bulan dalam bentuk string
    $tahun = date('Y', strtotime($dateTime)); // Mengambil tahun dari timestamp
    $jam = date('H', strtotime($dateTime)); // Mengambil jam dari timestamp
    $menit = date('i', strtotime($dateTime)); // Mengambil menit dari timestamp
    $detik = date('s', strtotime($dateTime)); // Mengambil detik dari timestamp

    return $tanggal .
        ' ' .
        $bulan .
        ' ' .
        $tahun .
        ' ' .
        $jam .
        ':' .
        $menit .
        ':' .
        $detik; // Mengembalikan datetime yang diformat
}

function nama_user($id_user)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id_user', $id_user)->get('user');
    foreach ($result->result() as $c) {
        $tmt = $c->username;
        return $tmt;
    }
}

function getNamaHari($date)
{
    // Array nama hari dalam bahasa Indonesia
    $nama_hari = [
        'Minggu',
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
    ];

    // Mendapatkan indeks hari dari timestamp
    $index_hari = date('w', strtotime($date));

    // Mengembalikan nama hari sesuai dengan indeks
    return $nama_hari[$index_hari];
}

function nama_admin($id_admin)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id_admin', $id_admin)->get('admin');
    foreach ($result->result() as $c) {
        $tmt = $c->username;
        return $tmt;
    }
}
?>