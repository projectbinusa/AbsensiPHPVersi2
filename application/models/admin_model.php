<?php
class Admin_model extends CI_Model
{
    // Menampilkan role user
    public function get_user()
    {
        $this->db->where('id_user', 'user');
        $query = $this->db->get('user');
        return $query->result();
    }

    // Mendapatkan semua data dari tabel tertentu
    function get_data($table)
    {
        return $this->db->get($table);
    }

    // Menampilkan data absen per id admin
    public function get_absen_by_admin($id_admin)
    {
        $this->db->where('id_absensi', $id_admin);
        return $this->db->get('absensi');
    }

    public function get_user_by_id_admin($id_admin)
    {
        $this->db->where('id_admin', $id_admin);
        return $this->db->get('user')->result();
    }

    public function get_jabatan_by_id_admin($id_admin)
    {
        $this->db->where('id_admin', $id_admin);
        return $this->db->get('jabatan')->result();
    }

    public function get_shift_by_id_admin($id_admin)
    {
        $this->db->where('id_admin', $id_admin);
        return $this->db->get('shift')->result();
    }

    // Menambahkan data ke dalam tabel
    public function tambah_data($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function tambah_jabatan($data)
    {
        $this->db->insert('jabatan', $data);
        // Jika Anda ingin mendapatkan ID jabatan yang baru ditambahkan, Anda bisa menggunakan $this->db->insert_id();
    }

    public function get_employee_count_by_jabatan_and_admin($id_admin)
    {
        $this->db->select(
            'jabatan.nama_jabatan, COUNT(user.id_user) as jumlah_karyawan'
        );
        $this->db->from('jabatan');
        $this->db->join('user', 'jabatan.id_jabatan = user.id_jabatan', 'left');
        $this->db->where('jabatan.id_admin', $id_admin); // Menambahkan filter berdasarkan id_admin
        $this->db->group_by('jabatan.nama_jabatan');
        return $this->db->get()->result();
    }

    public function get_user_by_id($id)
    {
        // Ambil data pengguna berdasarkan ID
        return $this->db->get_where('user', ['id_user' => $id])->row();
    }

    public function update_admin($id_admin, $data)
    {
        $this->db->where('id_admin', $id_admin);
        $this->db->update('admin', $data);
        return $this->db->affected_rows();
    }

    public function getAdminByID($id)
    {
        $this->db->select('*');
        $this->db->from('admin');
        $this->db->where('id_admin', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_employee_count_by_shift()
    {
        $this->db->select(
            'shift.nama_shift, COUNT(user.id_user) as jumlah_karyawan'
        );
        $this->db->from('shift');
        $this->db->join('user', 'shift.id_shift = user.id_shift', 'left');
        $this->db->group_by('shift.nama_shift');
        return $this->db->get()->result();
    }

    public function update($tabel, $data, $where)
    {
        $data = $this->db->update($tabel, $data, $where);
        return $this->db->affected_rows();
    }

    // Menampilkan jumlah user
    public function get_user_count($id_admin)
    {
        // Modifikasi query untuk menghitung jumlah user yang terkait dengan admin tertentu
        $this->db->where('id_admin', $id_admin);
        return $this->db->count_all_results('user');
    }

    public function get_user_data_byy_admin($id_admin)
    {
        // Modifikasi query untuk mendapatkan data user yang terkait dengan admin tertentu
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('id_admin', $id_admin);
        return $this->db->get()->result();
    }

    // Metode untuk menghitung jumlah data absensi
    public function get_absensi_count()
    {
        $this->db->from('absensi');
        return $this->db->count_all_results();
    }

    // Menampilkan Jumlah Cuti
    public function get_cuti_count()
    {
        $this->db->select('COUNT(*) as cuti_count');
        $query = $this->db->get('cuti');

        return $query->row()->cuti_count;
    }

    public function hapus_organisasi($id_organisasi)
    {
        // Misalnya, menggunakan query database untuk menghapus data organisasi berdasarkan ID
        // Gantilah bagian ini sesuai dengan struktur tabel dan kebutuhan aplikasi Anda
        $this->db->where('id_organisasi', $id_organisasi);
        $this->db->delete('organisasi'); // Gantilah 'nama_tabel_organisasi' dengan nama tabel sebenarnya
    }
    public function get_superadmin_data()
    {
        // Replace 'your_superadmin_table' with your actual table name
        $query = $this->db->get('admin');
        if (!$query) {
            log_message('error', 'Database Error: ' . $this->db->error());
            return false;
        }
        return $query->row_array();
    }

    public function get_organisasi_by_id($id_organisasi)
    {
        $this->db->where('id_organisasi', $id_organisasi);
        $query = $this->db->get('organisasi'); // Ganti 'nama_tabel_organisasi' dengan nama tabel organisasi Anda

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null; // Return null jika organisasi tidak ditemukan
        }
    }

    public function update_organisasi($id_organisasi, $data)
    {
        // Lakukan pembaruan data Admin
        $this->db->where('id_organisasi', $id_organisasi);
        $this->db->update('organisasi', $data);
    }

    public function getOrganisasiById($id_organisasi)
    {
        // Misalnya, menggunakan query database untuk mengambil data organisasi berdasarkan ID
        // Gantilah bagian ini sesuai dengan struktur tabel dan kebutuhan aplikasi Anda
        $this->db->select('*');
        $this->db->from('organisasi');
        $this->db->where('id_organisasi', $id_organisasi);
        $query = $this->db->get();

        // Mengembalikan satu baris hasil query sebagai objek
        return $query->row();
    }

    public function getOrganisasiData($id)
    {
        // Sesuaikan dengan struktur tabel di database Anda
        $this->db->select('*');
        $this->db->from('organisasi');
        $this->db->where('id_organisasi', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function edit_user($id_user, $data)
    {
        // Lakukan pembaruan data Admin
        $this->db->where('id_user', $id_user);
        $this->db->update('user', $data);
    }

    public function getUserDetails($user_id)
    {
        $this->db->where('id_user', $user_id); // Sesuaikan kolom yang merepresentasikan ID pengguna
        $query = $this->db->get('user'); // Sesuaikan 'users' dengan nama tabel pengguna

        if ($query->num_rows() > 0) {
            return $query->row(); // Mengembalikan satu baris data user
        } else {
            return false; // Mengembalikan false jika tidak ada data ditemukan
        }
    }

    public function getOrganisasiDetails($organisasi_id)
    {
        $this->db->where('id_organisasi', $organisasi_id); // Sesuaikan kolom yang merepresentasikan ID pengguna
        $query = $this->db->get('organisasi'); // Sesuaikan 'users' dengan nama tabel pengguna

        if ($query->num_rows() > 0) {
            return $query->row(); // Mengembalikan satu baris data user
        } else {
            return false; // Mengembalikan false jika tidak ada data ditemukan
        }
    }

    public function getUserId($id_user)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_organisasi_by_admin_id($id_admin)
    {
        $this->db->where('id_admin', $id_admin); // Sesuaikan dengan kolom yang merepresentasikan ID admin
        $query = $this->db->get('organisasi'); // Sesuaikan 'organisasi' dengan nama tabel organisasi

        if ($query->num_rows() > 0) {
            return $query->result(); // Mengembalikan hasil query sebagai array objek
        } else {
            return false; // Mengembalikan false jika tidak ada data ditemukan
        }
    }

    public function GetDataAbsensi($id_user, $bulan, $tanggal, $tahun)
    {
        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->join('user', 'absensi.id_user = user.id_user');
        $this->db->where('absensi.id_user', $id_user);
        $this->db->where('user.id_admin', $this->session->userdata('id'));

        // Tambahan filter berdasarkan bulan, tanggal, dan tahun
        if ($bulan) {
            $this->db->where('MONTH(absensi.tanggal_absen)', $bulan);
        }
        if ($tanggal) {
            $this->db->where('DAY(absensi.tanggal_absen)', $tanggal);
        }
        if ($tahun) {
            $this->db->where('YEAR(absensi.tanggal_absen)', $tahun);
        }

        return $this->db->get()->result();
    }

    public function getIdUserByIdAdmin($id_admin)
    {
        $this->db->select('id_user');
        $this->db->from('user');
        $this->db->where('id_admin', $id_admin);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->id_user;
        } else {
            return null;
        }
    }

    public function getCutiByIdUser($id_user)
    {
        $this->db->select('*');
        $this->db->from('cuti');
        $this->db->where('id_user', $id_user);

        $query = $this->db->get();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function getUsersByIdAdmin($id_admin)
    {
        $this->db->select('id_user');
        $this->db->from('user');
        $this->db->where('id_admin', $id_admin);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result(); // Mengembalikan semua data yang sesuai
        } else {
            return null;
        }
    }

    public function hapus_user($id_user)
    {
        // Misalnya, menggunakan query database untuk menghapus data organisasi berdasarkan ID
        // Gantilah bagian ini sesuai dengan struktur tabel dan kebutuhan aplikasi Anda
        $this->db->where('id_user', $id_user);
        $this->db->delete('user'); // Gantilah 'nama_tabel_organisasi' dengan nama tabel sebenarnya
    }
    // Searching
    public function search_data($table, $column, $keyword)
    {
        $this->db->like($column, $keyword);
        return $this->db->get($table);
    }

    public function get_all_lokasi()
    {
        // Ganti 'lokasi' dengan nama tabel yang sesuai di database Anda
        $query = $this->db->get('lokasi');

        // Mengembalikan hasil query sebagai array
        return $query->result_array();
    }

    public function tambah_lokasi($data)
    {
        $this->db->insert('lokasi', $data);
    }

    public function getLokasiData($id_lokasi)
    {
        // Assuming 'lokasi' is your table name
        $this->db->where('id_lokasi', $id_lokasi);
        $query = $this->db->get('lokasi');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function detail_lokasi($lokasi_id)
    {
        $data['lokasi'] = $this->admin_model->getLokasiData($lokasi_id);

        // Mengirim data lokasi ke view
        $this->load->view('page/admin/detail_lokasi', $data);
    }

    public function getLokasiById($id_lokasi)
    {
        // Assuming 'lokasi' is the table name in your database
        $query = $this->db->get_where('lokasi', ['id_lokasi' => $id_lokasi]);

        // Return the result as an object
        return $query->row();
    }

    public function update_lokasi($id_lokasi, $data)
    {
        // Update lokasi berdasarkan id_lokasi
        $this->db->where('id_lokasi', $id_lokasi);
        $this->db->update('lokasi', $data);
    }

    // In your Admin_model.php
    public function hapus_lokasi($id_lokasi)
    {
        // Your deletion logic here
        $this->db->where('id_lokasi', $id_lokasi);
        $this->db->delete('lokasi');
    }

    public function get_all_user()
    {
        // Gantilah dengan metode yang sesuai untuk mengambil data pengguna dari database
        $query = $this->db->get('user');
        return $query->result();
    }

    // Menampilkan Dan Mengget Data
    public function getShiftData($id)
    {
        // Sesuaikan dengan struktur tabel di database Anda
        $this->db->select('*');
        $this->db->from('shift');
        $this->db->where('id_shift', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row(); // Menggunakan row() untuk mendapatkan satu baris
        } else {
            return false;
        }
    }

    //  GET ID Shift
    public function getShiftId($id_shift)
    {
        $this->db->select('*');
        $this->db->from('shift');
        $this->db->where('id_shift', $id_shift);
        $query = $this->db->get();

        return $query->row();
    }

    // Update
    public function update_shift($id_shift, $data)
    {
        // Lakukan pembaruan data Admin
        $this->db->where('id_shift', $id_shift);
        $this->db->update('shift', $data);
    }

    // GET Admin Shift
    public function get_admin_data()
    {
        $query = $this->db->get('admin');
        return $query->result();
    }

    public function get_last_shift()
    {
        // Ambil semua data shift
        $query = $this->db->get('shift');
        return $query->result();
    }

    // Hapus Shift
    public function hapus_shift($id_shift)
    {
        $this->db->where('id_shift', $id_shift);
        $this->db->delete('shift');
    }

    public function getJabatanId($id_jabatan)
    {
        $this->db->select('*');
        $this->db->from('jabatan');
        $this->db->where('id_jabatan', $id_jabatan);
        $query = $this->db->get();

        return $query->row();
    }

    // hapus jabatan
    public function hapus_jabatan($id_jabatan)
    {
        $this->db->where('id_jabatan', $id_jabatan);
        $this->db->delete('jabatan');
    }

    public function getJabatanDetails($id_jabatan)
    {
        // Gantilah 'nama_table' dengan nama tabel yang sesuai di database Anda
        $this->db->where('id_jabatan', $id_jabatan);
        $query = $this->db->get('jabatan'); // Gantilah 'nama_table' dengan nama tabel yang sesuai di database Anda

        // Jika query berhasil dan ada hasil
        if ($query->num_rows() > 0) {
            return $query->row(); // Mengembalikan satu baris hasil sebagai objek
        } else {
            return null; // Mengembalikan null jika tidak ada hasil
        }
    }
    public function update_jabatan($id_jabatan, $data)
    {
        // Gantilah 'jabatan' dengan nama tabel yang sesuai di database Anda
        $this->db->where('id_jabatan', $id_jabatan);
        $this->db->update('jabatan', $data);
    }

    public function pagination($table_name, $limit, $offset)
    {
        $this->db->limit($limit, $offset);
        $query = $this->db->get($table_name);

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return [];
    }

    public function count_all($table_name)
    {
        return $this->db->get($table_name)->num_rows();
    }

    public function get_data_by_id_admin($table, $id_admin)
    {
        $this->db->where('id_admin', $id_admin);
        return $this->db->get($table);
    }

    public function get_organisasi_pusat($id_admin)
    {
        $this->db->where('id_admin', $id_admin);
        $this->db->where('status', 'pusat');
        return $this->db->get('organisasi')->result();
    }

    function get_all_organisasi($id_admin)
    {
        $this->db->where('id_admin', $id_admin);
        return $this->db->get('organisasi')->result();
    }

    public function updateStatusCuti($cutiId, $status)
    {
        // Lakukan pembaruan status di sini
        // Misalnya, jika menggunakan Query Builder:
        $this->db->where('id_cuti', $cutiId);
        $this->db->update('cuti', ['status' => $status]);
    }

    public function get_realtime_absensi_5_days()
    {
        $this->db->select('tanggal_absen, COUNT(*) as absensi_count');
        $this->db->from('absensi');
        $this->db->where('keterangan_izin', 'Masuk');
        $this->db->where('tanggal_absen >= CURDATE() - INTERVAL 5 DAY');
        $this->db->group_by('tanggal_absen');
        $this->db->order_by('tanggal_absen', 'ASC');

        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }

    /// Di dalam Admin_model
    public function get_early_attendance_by_user($id_admin)
    {
        $this->db->select(
            'u.username, j.nama_jabatan, COUNT(*) as early_attendance_count'
        );
        $this->db->from('absensi a');
        $this->db->join('user u', 'a.id_user = u.id_user', 'left');
        $this->db->join('jabatan j', 'u.id_jabatan = j.id_jabatan', 'left');
        $this->db->join('admin adm', 'u.id_admin = adm.id_admin', 'left');
        $this->db->where('adm.id_admin', $id_admin);
        $this->db->where('a.status_absen', 'Lebih Awal');
        $this->db->group_by('u.username, j.nama_jabatan');
        $this->db->order_by('early_attendance_count', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getKehadiranData($id_admin)
    {
        $query = $this->db
            ->select(
                'user.username, jabatan.id_jabatan, 
                   COUNT(CASE WHEN absensi.status_absen = "Terlambat" THEN 1 END) AS jumlah_terlambat, 
                   COUNT(CASE WHEN absensi.status_absen = "Lebih Awal" THEN 1 END) AS jumlah_lebih_awal'
            )
            ->from('user')
            ->join('absensi', 'user.id_user = absensi.id_user', 'left') // Menggunakan left join agar semua user tetap ditampilkan
            ->join('jabatan', 'user.id_jabatan = jabatan.id_jabatan') // Sesuaikan dengan kolom yang menunjukkan hubungan antara user dan jabatan
            ->where('user.id_admin', $id_admin)
            ->group_by('user.id_user'); // Mengelompokkan data berdasarkan id_user

        return $query->get()->result_array();
    }

    // Mendapatkan data per hari berdasarkan tanggal
    public function getRekapHarian($tanggal, $id_admin)
    {
        // Ambil data absensi berdasarkan tanggal, id_admin, dan relasi dengan pengguna
        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->join('user', 'absensi.id_user = user.id_user');
        $this->db->where('absensi.tanggal_absen', $tanggal);
        $this->db->where('user.id_admin', $id_admin);

        $query = $this->db->get();
        return $query->result();
    }

    public function exportRekapHarian()
    {
        // Replace this with your actual database query to retrieve the data
        $query = $this->db->get('absensi');
        return $query->result();
    }

    public function getRekapPerMinggu($start_date, $end_date, $id_admin)
    {
        // Assuming you have relationships between tables and using CodeIgniter's active record or query builder.
        $this->load->database();
        $end_date = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime('-7 days', strtotime($end_date)));
        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->join('user', 'user.id_user = absensi.id_user');
        // Add more joins if you have additional tables related to user.
        $this->db->where('user.id_admin', $id_admin);

        if ($start_date && $end_date) {
            $this->db->where('absensi.tanggal_absen >=', $start_date);
            $this->db->where('absensi.tanggal_absen <=', $end_date);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    // Mendapatkan rekap harian berdasarkan bulan
    public function getRekapHarianByBulan($bulan)
    {
        $this->db->select('absensi.*, user.*');
        $this->db->from('absensi');
        $this->db->join('user', 'absensi.id_user = user.id_user', 'left');
        $this->db->where('MONTH(absensi.tanggal_absen)', $bulan);
        $query = $this->db->get();
        return $query->result();
    }

    // Mendapatkan data bulanan berdasarkan bulan
    public function getRekapPerBulan()
    {
        $query = $this->db->get('absensi');
        return $query->result(); // Sesuaikan sesuai dengan struktur database Anda
    }

    public function updateAdminPassword($user_id, $data_password)
    {
        $update_result = $this->db->update('admin', $data_password, [
            'id_admin' => $user_id,
        ]);

        return $update_result ? true : false;
    }

    public function get_cuti_by_id($tabel, $id_cuti)
    {
        $data = $this->db
            ->where('id_cuti', $id_cuti)
            ->get($tabel)
            ->row();
        return $data;
    }

    public function get_user_id_admin($id_admin)
    {
        $this->db->select('id_user');
        $this->db->from('user');
        $this->db->where('id_admin', $id_admin);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            // Mengembalikan ID pengguna terkait
            return $query->row()->id_user;
        } else {
            return null; // Mengembalikan null jika tidak ada ID pengguna terkait
        }
    }

    public function get_id_organisasi()
    {
        $id_organisasi = $this->session->userdata('id_organisasi');

        return $id_organisasi;
    }

    public function getAbsensiDetail($id_absensi)
    {
        $this->db->where('id_absensi', $id_absensi);
        $query = $this->db->get('absensi');
        return $query->row();
    }

    public function get_all_organisasii()
    {
        return $this->db->get('organisasi')->result();
    }

    // Filter Button
    public function filterAbsensi($id_admin, $bulan, $tanggal, $tahun)
    {
        $this->db->select('absensi.*');
        $this->db->from('absensi');
        $this->db->join('user', 'user.id_user = absensi.id_user');
        $this->db->join('admin', 'admin.id_admin = user.id_admin');

        // Sesuaikan dengan relasi antara user dan admin
        $this->db->where('admin.id_admin', $id_admin);

        // Filter berdasarkan tanggal_absen
        if (!empty($bulan)) {
            $this->db->where('MONTH(absensi.tanggal_absen)', $bulan);
        }
        if (!empty($tanggal)) {
            $this->db->where('DAY(absensi.tanggal_absen)', $tanggal);
        }
        if (!empty($tahun)) {
            $this->db->where('YEAR(absensi.tanggal_absen)', $tahun);
        }

        $query = $this->db->get();

        return $query->result();
    }

    public function get_bulanan($date, $admin_id)
    {
        $this->db->select('absensi.*');
        $this->db->from('absensi');
        $this->db->join('user', 'user.id_user = absensi.id_user');
        $this->db->join('admin', 'admin.id_admin = user.id_admin');
        $this->db->where('MONTH(absensi.tanggal_absen)', $date);
        $this->db->where('admin.id_admin', $admin_id);
        $this->db->order_by('user.username', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }

    public function get_perkaryawan($admin_id, $user_id)
    {
        $this->db->select('absensi.*');
        $this->db->from('absensi');
        $this->db->join('user', 'user.id_user = absensi.id_user');
        $this->db->join('admin', 'admin.id_admin = user.id_admin');
        $this->db->where('admin.id_admin', $admin_id);
        $this->db->where('user.id_user', $user_id);
        $this->db->order_by('user.username', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_karyawan($admin_id, $bulan, $tahun)
    {
        $this->db->select(
            'absensi.*, MONTH(absensi.tanggal_absen) as bulan, YEAR(absensi.tanggal_absen) as tahun'
        );
        $this->db->from('absensi');
        $this->db->join('user', 'user.id_user = absensi.id_user');
        $this->db->join('admin', 'admin.id_admin = user.id_admin');
        $this->db->where('admin.id_admin', $admin_id);
        $this->db->where('YEAR(absensi.tanggal_absen)', $tahun);
        $this->db->where('MONTH(absensi.tanggal_absen)', $bulan);
        $this->db->order_by('user.username', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }

    public function getAllArrayData()
    {
        $query = $this->db->get('lembur'); // Mengambil semua data dari tabel lembur
        if ($query->num_rows() > 0) {
            $result_array = $query->result_array(); // Mengambil hasil query dan konversi menjadi array
            return $result_array;
        } else {
            return []; // Jika tidak ada data, kembalikan array kosong
        }
    }

    // Export absensi
    public function get_absensi_data($filter = [])
    {
        $this->db->select(
            'id_user, tanggal_absen, keterangan_izin, jam_masuk, jam_pulang, lokasi_masuk, lokasi_pulang, status_absen'
        );
        $this->db->from('absensi');

        // Menambahkan filter jika ada
        if (!empty($filter['bulan']) && !empty($filter['tahun'])) {
            $this->db->where('MONTH(tanggal_absen) =', $filter['bulan']);
            $this->db->where('YEAR(tanggal_absen) =', $filter['tahun']);
        }

        $query = $this->db->get();

        return $query->result();
        // Mengembalikan array kosong jika tidak ada data yang ditemukan
    }

    public function get_jabatan_data()
    {
        $query = $this->db->get('jabatan');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return [];
        }
    }

    public function get_lokasi_data()
    {
        // Fetch lokasi data from your database table
        $query = $this->db->get('lokasi');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }

    public function get_organisasi_data()
    {
        // Fetch organisasi data from your database table
        $query = $this->db->get('organisasi');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return [];
        }
    }

    public function get_user_data()
    {
        // Fetch user data from your database table
        $query = $this->db->get('user');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return [];
        }
    }

    public function count_users_by_organisasi($id_organisasi)
    {
        // Menghitung jumlah pengguna berdasarkan id_organisasi
        $this->db->where('id_organisasi', $id_organisasi);
        $query = $this->db->get('user'); // Ganti 'users' dengan nama tabel pengguna di database Anda

        return $query->num_rows(); // Mengembalikan jumlah baris yang cocok dengan kondisi
    }

    public function updateAdminPhoto($user_id, $data)
    {
        $update_result = $this->db->update('admin', $data, [
            'id_admin' => $user_id,
        ]);

        return $update_result ? true : false;
    }

    public function update_password($id_admin, $new_password)
    {
        $this->db->set('password', $new_password);
        $this->db->where('id_admin', $id_admin);
        $this->db->update('admin'); // Replace 'your_user_table' with the actual table name

        return $this->db->affected_rows() > 0;
    }

    public function get_jumlah_status_absen($id_user, $status)
    {
        return $this->db
            ->where('id_user', $id_user)
            ->where('status_absen', $status)
            ->from('absensi')
            ->count_all_results();
    }

    public function update_data($table, $data, $where)
    {
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }

    // Memperbarui gambar pengguna
    public function update_image($user_id, $new_image)
    {
        $data = [
            'image' => $new_image,
        ];

        $this->db->where('id_admin', $user_id);
        $this->db->update('admin', $data);

        return $this->db->affected_rows();
    }

    // untuk uubah password
    public function getPasswordById($id_admin)
    {
        $this->db->select('password');
        $this->db->from('admin'); // Replace 'your_user_table' with the actual table name
        $this->db->where('id_admin', $id_admin);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->password;
        } else {
            return false;
        }
    }
    public function get_all_admin()
    {
        // Assuming you have a table named 'admin' with columns like 'id_admin', 'nama_admin', etc.

        $this->db->select('*');
        $this->db->from('admin');

        $query = $this->db->get();

        // Check if there are results
        if ($query->num_rows() > 0) {
            return $query->result(); // Return the result set as an array of objects
        } else {
            return []; // Return an empty array if no results found
        }
    }

    public function get_absen_data()
    {
        $id_admin = $this->session->userdata('id');
        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->join('user', 'absensi.id_user = user.id_user');
        $this->db->where('user.id_admin', $id_admin); // Menambahkan kondisi WHERE
        $this->db->order_by('tanggal_absen', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_jabatan_data_by_admin($id_admin)
    {
        $this->db->select('*');
        $this->db->from('jabatan');
        $this->db->where('id_admin', $id_admin); // Sesuaikan nama kolom sesuai dengan struktur tabel Anda
        $query = $this->db->get();

        return $query->result();
    }

    // Model Function to Get Cuti Data
    public function get_cuti_data()
    {
        $id_admin = $this->session->userdata('id');
        $this->db->select('cuti.*, user.*, admin.*'); // Pilih kolom yang dibutuhkan
        $this->db->from('cuti');
        $this->db->join('user', 'cuti.id_user = user.id_user');
        $this->db->join('admin', 'user.id_admin = admin.id_admin');
        $this->db->where('admin.id_admin', $id_admin); // Filter berdasarkan id_admin yang sedang login
        $this->db->order_by('cuti.awal_cuti', 'desc'); // Sesuaikan dengan kolom tanggal cuti
        $query = $this->db->get();

        return $query->result();
    }

    public function get_lembur_data()
    {
        $id_admin = $this->session->userdata('id');
        $this->db->select('lembur.*, user.*, admin.*'); // Pilih kolom yang dibutuhkan
        $this->db->from('lembur');
        $this->db->join('user', 'lembur.id_user = user.id_user');
        $this->db->join('admin', 'user.id_admin = admin.id_admin');
        $this->db->where('admin.id_admin', $id_admin); // Filter berdasarkan id_admin yang sedang login
        // $this->db->order_by('cuti.awal_cuti', 'desc'); // Sesuaikan dengan kolom tanggal cuti
        $query = $this->db->get();

        return $query->result();
    }

    public function get_lokasi_data_by_admin($id_admin)
    {
        // Gantilah 'id_admin' dan 'id_lokasi' dengan nama kolom yang sesuai di tabel database Anda
        $this->db->select('*');
        $this->db->from('lokasi');
        $this->db->where('id_admin', $id_admin);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_user_data_by_admin($id_admin)
    {
        $this->db->where('id_admin', $id_admin);
        return $this->db->get('user')->result_array();
    }

    public function get_organisasi_by_admin($id_admin)
    {
        $this->db->select('o.id_organisasi, o.nama_organisasi');
        $this->db->from('organisasi o');
        $this->db->join('admin a', 'a.id_admin = o.id_admin');
        $this->db->where('o.id_admin', $id_admin);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_absen_data_by_admin($id_admin)
    {
        $today = date('Y-m-d'); // Ambil tanggal hari ini
        $this->db->select('COUNT(id_absensi) as count');
        $this->db->from('absensi');
        $this->db->join('user', 'user.id_user = absensi.id_user');
        $this->db->where('user.id_admin', $id_admin);
        $this->db->where('DATE(absensi.tanggal_absen)', $today); // Filter absensi hanya untuk hari ini

        $query = $this->db->get();
        return $query->row()->count;
    }

    public function get_cuti_count_by_admin($id_admin)
    {
        $this->db->select('COUNT(id_cuti) as total_cuti');
        $this->db->from('cuti');
        $this->db->join('user', 'cuti.id_user = user.id_user');
        $this->db->where('user.id_admin', $id_admin);

        $query = $this->db->get();
        $result = $query->row();

        return $result->total_cuti;
    }

    public function getJabatanByIdAdmin($id_admin)
    {
        $this->db->select('*');
        $this->db->from('jabatan');
        $this->db->where('id_admin', $id_admin); // Sesuaikan dengan kolom relasi di tabel jabatan
        return $this->db->get()->result();
    }

    public function getShiftByIdAdmin($id_admin)
    {
        $this->db->select('id_shift, nama_shift');
        $this->db->from('shift');
        $this->db->where('id_admin', $id_admin);

        $query = $this->db->get();
        return $query->result();
    }

    public function getOrganisasiByIdAdmin($id_admin)
    {
        $this->db->select('id_organisasi, nama_organisasi');
        $this->db->from('organisasi');
        $this->db->where('id_admin', $id_admin);
        $query = $this->db->get();

        return $query->result();
    }

    public function getJumlahTerlambatLebihAwal($id_admin)
    {
        $this->db->select(
            'user.id_user, user.username, jabatan.nama_jabatan, 
       COUNT(CASE WHEN absensi.status_absen = "Terlambat" THEN 1 END) as jumlah_terlambat,
       COUNT(CASE WHEN absensi.status_absen = "Lebih Awal" THEN 1 END) as jumlah_lebih_awal'
        );
        $this->db->from('user');
        $this->db->join('absensi', 'user.id_user = absensi.id_user');
        $this->db->join('jabatan', 'user.id_jabatan = jabatan.id_jabatan'); // Sesuaikan dengan nama tabel dan kolom yang sesuai
        $this->db->where('user.id_admin', $id_admin);
        $this->db->group_by('user.id_user');

        return $this->db->get()->result();
    }

    public function getAbsensiByAdmin($id_admin)
    {
        // Sesuaikan dengan struktur tabel Anda
        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->join('user', 'absensi.id_user = user.id_user');
        $this->db->where('user.id_admin', $id_admin);

        $query = $this->db->get();
        return $query->result();
    }

    // history absen
    public function get_all_users()
    {
        return $this->db->get('user')->result();
    }

    public function get_users_by_admin($id_admin)
    {
        $this->db->select('id_user, username');
        $this->db->from('user');
        $this->db->where('id_admin', $id_admin);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_username_data($id_user)
    {
        // Ambil id_admin dari sesi (sesuaikan dengan cara Anda menyimpan id_admin)
        $id_admin = $this->session->userdata('id_admin');

        $this->db->select('*');
        $this->db->from('absensi');
        $this->db->where('absensi.id_user', $id_user); // Tambahkan alias tabel pada kolom id_user

        // Bergabungkan dengan tabel user dan admin untuk memeriksa hubungan hierarki
        $this->db->join('user', 'user.id_user = absensi.id_user');
        $this->db->join('admin', 'admin.id_admin = user.id_admin');

        // Pastikan absensi hanya diambil untuk id_user yang memiliki relasi dengan id_admin yang sedang login
        $this->db->where('admin.id_admin', $id_admin);

        $query = $this->db->get();
        return $query->result();
    }

    public function get_user_shift($id_shift)
    {
        // Sesuaikan dengan struktur tabel dan nama kolom pada tabel shift
        $this->db->select('jam_pulang');
        $this->db->from('shift');
        $this->db->where('id_shift', $id_shift);
        $query = $this->db->get();

        return $query->row();
    }

    public function get_shift_end_time($id_shift)
    {
        // Gantilah dengan logika atau kueri database yang sesuai
        $this->db->select('jam_pulang'); // Sesuaikan dengan nama kolom jam pulang di tabel shift
        $this->db->from('shift');
        $this->db->where('id_shift', $id_shift);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->jam_pulang;
        } else {
            return null; // Atau sesuaikan dengan nilai default yang sesuai
        }
    }

    public function get_absensi_count_by_date($date)
    {
        // Gantilah 'nama_tabel_absensi' dengan nama tabel absensi di database Anda
        $this->db->select('COUNT(*) as jumlah_absensi');
        $this->db->from('absensi');
        $this->db->where('tanggal_absen', $date); // Gantilah 'tanggal_absen' dengan nama kolom tanggal di tabel absensi

        $query = $this->db->get();
        $result = $query->row();

        // Mengembalikan jumlah absen pada tanggal tertentu
        return isset($result->jumlah_absensi) ? $result->jumlah_absensi : 0;
    }

    public function get_realtime_absensi_by_admin($id_admin)
    {
        $this->db->select('a.tanggal_absen, COUNT(*) as jumlah_absensi');
        $this->db->from('absensi a');
        $this->db->join('user u', 'a.id_user = u.id_user');
        $this->db->where('u.id_admin', $id_admin);
        $this->db->group_by('a.tanggal_absen');
        $this->db->order_by('a.tanggal_absen', 'DESC');
        $this->db->limit(6);

        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }

    public function get_lembur_by_id($tabel, $id_lembur)
    {
        $data = $this->db
            ->where('id_lembur', $id_lembur)
            ->get($tabel)
            ->row();
        return $data;
    }

    // Di dalam model Anda (admin_model.php)
    public function get_id_lembur_by_user($id_user)
    {
        $this->db->select('id_lembur');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('lembur');
        $data['nama_users'] = [];
        return $query->result();
    }

    public function get_lembur_by_user($id_lembur)
    {
        $this->db->where('id_lembur', $id_lembur);
        $query = $this->db->get('lembur');
        return $query->result();
    }

    public function get_jabatan_by_user_id($id_user)
    {
        // Jalankan kueri join untuk menggabungkan tabel user dan jabatan
        $this->db->select('jabatan.id_jabatan');
        $this->db->from('user');
        $this->db->join('jabatan', 'user.id_jabatan = jabatan.id_jabatan');
        $this->db->where('user.id_user', $id_user);
        $query = $this->db->get();

        // Periksa apakah kueri berhasil dijalankan
        if ($query->num_rows() > 0) {
            // Jika ada hasil, kembalikan id_jabatan
            return $query->row()->id_jabatan;
        } else {
            // Jika tidak ada hasil, kembalikan false atau nilai default lainnya
            return false;
        }
    }

    public function getUsernameById($id_user)
    {
        // Ambil username berdasarkan id_user dari tabel user
        $this->db->select('username');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('user');

        // Periksa apakah query berhasil dieksekusi
        if ($query->num_rows() > 0) {
            // Jika ada hasil, kembalikan username
            return $query->row()->username;
        } else {
            // Jika tidak ada hasil, kembalikan null
            return null;
        }
    }

    public function getNamaUser($id_user)
    {
        // Query ke tabel user untuk mendapatkan username berdasarkan id_user
        $this->db->select('username');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get('user');

        // Jika query berhasil dan data ditemukan
        if ($query->num_rows() > 0) {
            // Ambil hasil query dan kembalikan username
            $result = $query->row();
            return $result->username;
        } else {
            // Jika tidak ditemukan, kembalikan null atau nilai default yang sesuai
            return null;
        }
    }
}
?>