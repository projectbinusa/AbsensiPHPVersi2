<?php

class Super_model extends CI_Model
{
    // Menampilkan jumlah user
    public function get_user_count()
    {
        $this->db->where('role', 'user');
        $query = $this->db->get('user');
        return $query->num_rows();
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

    public function get_admin_count_by_superadmin($id_superadmin)
    {
        $this->db->select('COUNT(*) as admin_count');
        $this->db->from('admin');
        $this->db->where('id_superadmin', $id_superadmin);
        $query = $this->db->get();

        // Cek apakah query berhasil dieksekusi
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->admin_count;
        } else {
            return 0;
        }
    }

    // Tambahan: fungsi untuk mendapatkan data admin
    public function get_admin_data_by_superadmin($id_superadmin)
    {
        $this->db->select('id_admin');
        $this->db->from('admin');
        $this->db->where('id_superadmin', $id_superadmin);
        $query = $this->db->get();

        // Cek apakah query berhasil dieksekusi
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return [];
        }
    }

    // public function get_admin_count_by_superadmin($id_superadmin)
    // {
    //     $this->db->select('COUNT(*) as admin_count');
    //     $this->db->from('organisasi');
    //     $this->db->where('id_superadmin', $id_superadmin);
    //     $query = $this->db->get();

    //     // Cek apakah query berhasil dieksekusi
    //     if ($query->num_rows() > 0) {
    //         $row = $query->row();
    //         return $row->admin_count;
    //     } else {
    //         return 0;
    //     }
    // }

    public function getAdminById($id_admin)
    {
        $this->db->select('*');
        $this->db->from('admin');
        $this->db->where('id_admin', $id_admin);
        $query = $this->db->get();

        return $query->row();
    }

    public function getOrganisasiById($id_organisasi)
    {
        $this->db->select('*');
        $this->db->from('organisasi');
        $this->db->where('id_organisasi', $id_organisasi);
        $query = $this->db->get();

        return $query->row();
    }

    public function update_organisasi($id_organisasi, $data)
    {
        // Lakukan pembaruan data Admin
        $this->db->where('id_organisasi', $id_organisasi);
        $this->db->update('organisasi', $data);
    }

    public function update_user($id_user, $data)
    {
        // Lakukan pembaruan data Admin
        $this->db->where('id_user', $id_user);
        $this->db->update('user', $data);
    }

    public function update_admin($id_admin, $data)
    {
        // Lakukan pembaruan data Admin
        $this->db->where('id_admin', $id_admin);
        $this->db->update('admin', $data);
    }

    public function update_jabatan($id_jabatan, $data)
    {
        // Lakukan pembaruan data Admin
        $this->db->where('id_jabatan', $id_jabatan);
        $this->db->update('jabatan', $data);
    }

    public function get_admin_id_by_superadmin($superadmin_id)
    {
        $this->db->select('id_admin');
        $this->db->from('admin');
        $this->db->where('id_superadmin', $superadmin_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->id_admin;
        } else {
            return null; // Sesuaikan dengan kebutuhan Anda jika tidak ada admin yang terkait
        }
    }

    public function get_lokasi_by_admin_id($admin_id)
    {
        $this->db->select('*');
        $this->db->from('lokasi');
        $this->db->where('id_admin', $admin_id);
        $query = $this->db->get();

        return $query;
    }

    public function getAbsensiData($id_superadmin)
    {
        $this->db->select('absensi.*');
        $this->db->from('absensi');
        $this->db->join('user', 'user.id_user = absensi.id_user');
        $this->db->join('admin', 'admin.id_admin = user.id_admin');
        $this->db->join(
            'superadmin',
            'superadmin.id_superadmin = admin.id_superadmin'
        );
        $this->db->where('superadmin.id_superadmin', $id_superadmin);

        return $this->db->get();
    }

    // super_model

    public function get_users_by_superadmin($id_superadmin)
    {
        $this->db->select('user.*');
        $this->db->from('user');
        $this->db->join('admin', 'admin.id_admin = user.id_admin');
        $this->db->where('admin.id_superadmin', $id_superadmin);
        return $this->db->get();
    }

    public function get_shift_by_superadmin($id_superadmin)
    {
        $this->db->select('shift.*');
        $this->db->from('shift');
        $this->db->join('admin', 'admin.id_admin = shift.id_admin');
        $this->db->where('admin.id_superadmin', $id_superadmin);
        $query = $this->db->get();

        return $query->result();
    }

    public function update_shift($id_shift, $data)
    {
        // Lakukan pembaruan data Admin
        $this->db->where('id_shift', $id_shift);
        $this->db->update('shift', $data);
    }

    public function get_user()
    {
        // Ambil id_superadmin dari session
        $superadmin_id = $this->session->userdata('id');

        // Pastikan id_superadmin tidak kosong sebelum menjalankan query
        if (!empty($superadmin_id)) {
            $query = $this->db->query("
                SELECT user.*
                FROM user
                JOIN admin ON user.id_admin = admin.id_admin
                WHERE admin.id_superadmin = $superadmin_id
            ");

            return $query->result();
        } else {
            // Handle jika id_superadmin tidak tersedia
            return [];
        }
    }

    function get_admin_by_superadmin($table, $id_superadmin)
    {
        $this->db->where('id_superadmin', $id_superadmin);
        return $this->db->get($table);
    }

    // Mendapatkan semua data dari tabel tertentu
    function get_data($table)
    {
        return $this->db->get($table);
    }

    // Menambahkan data ke dalam tabel
    public function tambah_data($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function getOrganisasiId($id_admin)
    {
        // Mengambil data organisasi dari basis data berdasarkan ID admin
        $this->db->where('id_admin', $id_admin);
        $query = $this->db->get('organisasi');

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return []; // Mengembalikan array kosong jika tidak ada data yang ditemukan
        }
    }

    public function getJabatanId($id_jabatan)
    {
        $this->db->select('*');
        $this->db->from('jabatan');
        $this->db->where('id_jabatan', $id_jabatan);
        $query = $this->db->get();

        return $query->row();
    }

    public function getShiftId($id_shift)
    {
        $this->db->select('*');
        $this->db->from('shift');
        $this->db->where('id_shift', $id_shift);
        $query = $this->db->get();

        return $query->row();
    }

    public function getUserId($id_user)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get();

        return $query->row();
    }

    public function hapus_admin($id_admin)
    {
        $this->db->where('id_admin', $id_admin);
        $this->db->delete('admin');
    }

    public function hapus_user($id_user)
    {
        $this->db->where('id_user', $id_user);
        $this->db->delete('user');
    }

    public function hapus_organisasi($id_organisasi)
    {
        $this->db->where('id_organisasi', $id_organisasi);
        $this->db->delete('organisasi');
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

    public function getAdminDetails($admin_id)
    {
        $this->db->where('id_admin', $admin_id); // Sesuaikan kolom yang merepresentasikan ID pengguna
        $query = $this->db->get('admin'); // Sesuaikan 'users' dengan nama tabel pengguna

        if ($query->num_rows() > 0) {
            return $query->row(); // Mengembalikan satu baris data user
        } else {
            return false; // Mengembalikan false jika tidak ada data ditemukan
        }
    }

    public function getUserData($id)
    {
        // Sesuaikan dengan struktur tabel di database Anda
        $this->db->select('*');
        $this->db->from('user'); // Ganti 'user' sesuai dengan nama tabel Anda
        $this->db->where('id_user', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function hapus_jabatan($id_jabatan)
    {
        $this->db->where('id_jabatan', $id_jabatan);
        $this->db->delete('jabatan');
    }

    public function hapus_shift($id_shift)
    {
        $this->db->where('id_shift', $id_shift);
        $this->db->delete('shift');
    }

    // Menghapus data dari tabel berdasarkan kondisi
    public function delete($table, $field, $id)
    {
        $data = $this->db->delete($table, [$field => $id]);
        return $data;
    }

    public function get_superadmin_data()
    {
        // Replace 'your_superadmin_table' with your actual table name
        $query = $this->db->get('superadmin');
        if (!$query) {
            log_message('error', 'Database Error: ' . $this->db->error());
            return false;
        }
        return $query->row_array();
    }

    // Menampilkan Dan Mengget Data
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

    // public function pagination($table_name, $limit, $offset)
    // {
    //     $this->db->limit($limit, $offset);
    //     $query = $this->db->get($table_name);

    //     if ($query->num_rows() > 0) {
    //         return $query->result();
    //     }
    //     return [];
    // }

    public function count_all($table_name)
    {
        return $this->db->get($table_name)->num_rows();
    }

    public function getSuperAdminByID($id)
    {
        $this->db->select('*');
        $this->db->from('superadmin');
        $this->db->where('id_superadmin', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function update($tabel, $data, $where)
    {
        $data = $this->db->update($tabel, $data, $where);
        return $this->db->affected_rows();
    }

    public function getJabatanDetails($id_jabatan)
    {
        // Gantilah 'nama_table' dengan nama tabel yang sesuai di database Anda
        $this->db->where('id_jabatan', $id_jabatan);
        $query = $this->db->get('jabatan'); // Gantilah 'jabatan' dengan nama tabel yang sesuai di database Anda

        // Jika query berhasil dan ada hasil
        if ($query->num_rows() > 0) {
            return $query->row(); // Mengembalikan satu baris hasil sebagai objek
        } else {
            return null; // Mengembalikan null jika tidak ada hasil
        }
    }

    public function getShiftDetails($id_shift)
    {
        $this->db->where('id_shift', $id_shift);
        $query = $this->db->get('shift'); // Sesuaikan dengan nama tabel untuk shift pada database Anda

        if ($query->num_rows() > 0) {
            return $query->row(); // Mengembalikan satu baris hasil sebagai objek
        } else {
            return null;
        }
    }

    public function get_all_lokasi()
    {
        // Ganti 'lokasi' dengan nama tabel yang sesuai di database Anda
        $query = $this->db->get('lokasi');

        // Mengembalikan hasil query sebagai array
        return $query->result_array();
    }

    public function get_all_user()
    {
        // Sesuaikan nama tabel dan field sesuai dengan struktur database Anda
        $query = $this->db->get('user');
        return $query->result();
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

    public function updateSuperAdminPassword($user_id, $data_password)
    {
        $update_result = $this->db->update('superadmin', $data_password, [
            'id_superadmin' => $user_id,
        ]);

        return $update_result ? true : false;
    }

    public function getAbsensiDetails($id_absensi)
    {
        // Gantilah 'nama_table' dengan nama tabel yang sesuai di database Anda
        $this->db->where('id_absensi', $id_absensi);
        $query = $this->db->get('absensi'); // Gantilah 'nama_table' dengan nama tabel yang sesuai di database Anda

        // Jika query berhasil dan ada hasil
        if ($query->num_rows() > 0) {
            return $query->row(); // Mengembalikan satu baris hasil sebagai objek
        } else {
            return null; // Mengembalikan null jika tidak ada hasil
        }
    }

    public function get_id_admin_by_organisasi($id_organisasi)
    {
        $this->db->select('id_admin');
        $this->db->from('organisasi');
        $this->db->where('id_organisasi', $id_organisasi);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->id_admin;
        } else {
            return false; // Return false jika tidak ada hasil
        }
    }

    public function get_all_organisasi()
    {
        return $this->db->get('organisasi')->result();
    }

    public function updateSuperAdminPhoto($user_id, $data)
    {
        $update_result = $this->db->update('superadmin', $data, [
            'id_superadmin' => $user_id,
        ]);

        return $update_result ? true : false;
    }

    // untuk uubah password
    public function getPasswordById($id_superadmin)
    {
        $this->db->select('password');
        $this->db->from('superadmin'); // Replace 'your_user_table' with the actual table name
        $this->db->where('id_superadmin', $id_superadmin);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->password;
        } else {
            return false;
        }
    }

    public function update_password($id_superadmin, $new_password)
    {
        $this->db->set('password', $new_password);
        $this->db->where('id_superadmin', $id_superadmin);
        $this->db->update('superadmin'); // Replace 'your_user_table' with the actual table name

        return $this->db->affected_rows() > 0;
    }

    public function update_data($table, $data, $where)
    {
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }

    public function get_current_image($user_id)
    {
        $this->db->select('image');
        $this->db->from('superadmin');
        $this->db->where('id_superadmin', $user_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->image;
        }

        return null;
    }

    // Memperbarui gambar pengguna
    public function update_image($user_id, $new_image)
    {
        $data = [
            'image' => $new_image,
        ];

        $this->db->where('id_superadmin', $user_id);
        $this->db->update('superadmin', $data);

        return $this->db->affected_rows();
    }

    public function get_data_by_id($table, $where)
    {
        $this->db->where($where);
        return $this->db->get($table);
    }

    public function get_all_admin()
    {
        $this->db->select('*');
        $this->db->from('admin');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return [];
        }
    }

    public function get_admin_id_by_superadmin_id($id_superadmin)
    {
        $this->db->select('id_admin');
        $this->db->where('id_superadmin', $id_superadmin);
        $result = $this->db->get('admin')->row();

        return $result ? $result->id_admin : null;
    }

    public function get_jabatan_by_admin_id($id_admin)
    {
        $this->db->select('jabatan.*');
        $this->db->from('jabatan');
        $this->db->where('jabatan.id_admin', $id_admin);
        $result = $this->db->get();

        return $result;
    }

    public function get_admin_by_superadminn($id_superadmin)
    {
        $query = $this->db->query("
            SELECT admin.*
            FROM admin
            WHERE admin.id_superadmin = $id_superadmin
        ");

        return $query->result();
    }

    public function get_all_organisasi_by_superadmin($id_superadmin)
    {
        $query = $this->db->query("
        SELECT organisasi.*
        FROM organisasi
        JOIN admin ON organisasi.id_admin = admin.id_admin
        WHERE admin.id_superadmin = $id_superadmin
    ");

        // Debugging: Cetak hasil kueri
        echo $this->db->last_query(); // Cetak kueri terakhir ke layar

        return $query->result();
    }

    public function get_jabatan_by_superadmin($id_superadmin)
    {
        $query = $this->db->query("
            SELECT jabatan.*
            FROM jabatan
            JOIN admin ON jabatan.id_admin = admin.id_admin
            WHERE admin.id_superadmin = $id_superadmin
        ");

        return $query->result();
    }

    public function get_shift_by_superadminn($id_superadmin)
    {
        // Sesuaikan query berdasarkan struktur tabel dan relasi antar tabel
        $query = $this->db->query("
            SELECT shift.*
            FROM shift
            JOIN admin ON shift.id_admin = admin.id_admin
            WHERE admin.id_superadmin = $id_superadmin
        ");

        return $query->result();
    }
}
?>
