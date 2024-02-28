<?php

function tampil_organisasi($id_organisasi)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db
        ->where('id_organisasi', $id_organisasi)
        ->get('organisasi');
    foreach ($result->result() as $c) {
        $stmt = $c->nama_organisasi;
        return $stmt;
    }
}

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
function nama_jabatan($id_jabatan)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id_jabatan', $id_jabatan)->get('jabatan');
    foreach ($result->result() as $c) {
        $tmt = $c->nama_jabatan;
        return $tmt;
    }
}
function nama_shift($id_shift)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id_shift', $id_shift)->get('shift');
    foreach ($result->result() as $c) {
        $tmt = $c->nama_shift;
        return $tmt;
    }
}
function nama_organisasi($id_organisasi)
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

function get_alamat($id_organisasi)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db
        ->where('id_organisasi', $id_organisasi)
        ->get('organisasi');
    foreach ($result->result() as $c) {
        $tmt = $c->alamat;
        return $tmt;
    }
}

function get_organisasi($id_organisasi)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id_organisasi', $id_organisasi)->get('user');
    foreach ($result->result() as $c) {
        $tmt = $c->username;
        return $tmt;
    }
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

function tampilkan_tanggal_indonesia($tanggal)
{
    $date = new DateTime($tanggal);
    $monthNames = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];

    $day = $date->format('d');
    $month = $date->format('n') - 1; // Format bulan dimulai dari 1, sedangkan array dimulai dari 0
    $year = $date->format('Y');

    return $day . ' ' . $monthNames[$month] . ' ' . $year;
}

function get_jabatan_by_cuti_id($cuti_id)
{
    // Ambil instance CI
    $ci = &get_instance();

    // Load database
    $ci->load->database();

    // Query untuk mengambil data jabatan berdasarkan cuti_id
    $query = $ci->db
        ->select('jabatan.nama_jabatan')
        ->from('cuti')
        ->join('user', 'cuti.id_user = user.id_user')
        ->join('jabatan', 'user.id_jabatan = jabatan.id_jabatan')
        ->where('cuti.id_cuti', $cuti_id)
        ->get();

    if ($query && $query->num_rows() > 0) {
        $result = $query->row();
        return $result->nama_jabatan;
    }

    return 'Nama Jabatan Tidak Ditemukan';
}

function get_jabatan_by_id_lembur($id_lembur)
{
    // Ambil instance CI
    $ci = &get_instance();

    // Load database
    $ci->load->database();

    // Query untuk mengambil data jabatan berdasarkan id_lembur$id_lembur
    $query = $ci->db
        ->select('jabatan.nama_jabatan')
        ->from('lembur')
        ->join('user', 'lembur.id_user = user.id_user')
        ->join('jabatan', 'user.id_jabatan = jabatan.id_jabatan')
        ->where('lembur.id_lembur', $id_lembur)
        ->get();

    // Periksa apakah query berhasil dan hasilnya ada
    if ($query && $query->num_rows() > 0) {
        // Ambil nama jabatan dari hasil query
        $result = $query->row();
        return $result->nama_jabatan;
    }

    // Kembalikan nilai default jika tidak ada data yang ditemukan
    return 'Nama Jabatan Tidak Ditemukan';
}

function get_nama_jabatan_from_cuti($id_cuti)
{
    $ci = &get_instance();
    $ci->load->database();

    // Menggunakan JOIN untuk mengambil data dari tabel cuti, user, dan jabatan
    $result = $ci->db
        ->select('jabatan.nama_jabatan as nama_jabatan')
        ->from('cuti')
        ->join('user', 'cuti.id_user = user.id_user')
        ->join('jabatan', 'user.id_jabatan = jabatan.id_jabatan')
        ->where('cuti.id_cuti', $id_cuti)
        ->get();

    if ($result->num_rows() > 0) {
        $row = $result->row();
        return $row->nama_jabatan;
    }

    // Jika tidak ada informasi yang ditemukan, kembalikan nilai null atau sesuai kebutuhan
    return null;
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
function jumlah_karyawan($id_jabatan)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id_jabatan', $id_jabatan)->get('user');
    foreach ($result->result() as $c) {
        $tmt = $c->username;
        return $result->num_rows();
    }
}
function jumlah_karyawan_lokasi($id_lokasi)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id_lokasi', $id_lokasi)->get('lokasi');
    return $result->num_rows();
}

// Format tanggal Indonesia
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

function get_jabatan_by_lembur_id($lembur_id)
{
    // Ambil instance CI
    $ci = &get_instance();

    $ci->load->database();

    $query = $ci->db
        ->select('jabatan.nama_jabatan')
        ->from('lembur')
        ->join('user', 'lembur.id_user = user.id_user')
        ->join('jabatan', 'user.id_jabatan = jabatan.id_jabatan')
        ->where('lembur.id_lembur', $lembur_id)
        ->get();

    if ($query && $query->num_rows() > 0) {
        $result = $query->row();
        return $result->nama_jabatan;
    }

    return 'Nama Jabatan Tidak Ditemukan';
}

function get_jam_masuk($id_user)
{
    $ci = &get_instance();
    $ci->load->database();

    // Ambil id shift dari tabel user
    $user_shift = $ci->db
        ->select('id_shift')
        ->where('id_user', $id_user)
        ->get('user')
        ->row();

    if ($user_shift) {
        // Ambil jam masuk dari tabel shift berdasarkan id shift
        $shift_info = $ci->db
            ->select('jam_masuk')
            ->where('id_shift', $user_shift->id_shift)
            ->get('shift')
            ->row();

        if ($shift_info) {
            return $shift_info->jam_masuk;
        } else {
            return 'Tidak ada informasi shift untuk pengguna ini.';
        }
    } else {
        return 'Tidak ada informasi pengguna dengan ID yang diberikan.';
    }
}

function toTitleCase($input)
{
    $result = ucwords($input);

    return $result;
}

if (!function_exists('nama_user')) {
    function nama_user($id_user)
    {
        // Logika untuk mendapatkan nama user berdasarkan id_user
        // Misalnya, menggunakan model untuk mendapatkan nama dari tabel user
        $CI = &get_instance();
        $CI->load->model('User_model');
        return $CI->User_model->getUsernameById($id_user);
    }
}

function formatJamKerja($jamMasuk, $jamPulang) {
    // Hitung selisih waktu antara jam_masuk dan jam_pulang
    $jamMasukObj = DateTime::createFromFormat('H:i', $jamMasuk);
    $jamPulangObj = DateTime::createFromFormat('H:i', $jamPulang);
    $selisihWaktu = $jamMasukObj->diff($jamPulangObj);

    // Format selisih waktu ke dalam jam dan menit
    return $selisihWaktu->format('%H jam %i menit');
}

?>