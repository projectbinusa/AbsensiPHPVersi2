<?php

class M_model extends CI_Model
{
    // Menambahkan data ke dalam tabel
    public function tambah_data($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function addAdmin($data)
    {
        $this->db->insert('admin', $data);
    }

    // Mendapatkan semua data dari tabel tertentu
    function get_data($table)
    {
        return $this->db->get($table);
    }

    public function create_superadmin(
        $email,
        $username,
        $password_hash
    ) {
        // Data yang akan disimpan dalam tabel superadmin
        $data = [
            'email' => $email,
            'username' => $username,
            'password' => $password_hash,
            // Kolom lain yang Anda perlukan
        ];

        // Simpan data ke dalam tabel superadmin
        $this->db->insert('superadmin', $data);
    }

    public function countData($table)
    {
        return $this->db->count_all($table);
    }

    public function get_by_id($table, $id_column, $id)
    {
        $data = $this->db->where($id_column, $id)->get($table);
        return $data;
    }

    public function get_absensi_by_id_admin($id_admin)
    {
        $this->db->where('id_absensi', $id_admin);
        return $this->db->get('absensi');
    }

    public function getUserByID($id)
    {
        $this->db->select('*');
        $this->db->from('superadmin');
        $this->db->where('id_superadmin', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function getAdminOptions()
    {
        $this->db->select('id_admin, username'); // Sesuaikan kolom yang sesuai
        $query = $this->db->get('admin'); // Gantilah 'admin' dengan nama tabel yang sesuai

        if ($query->num_rows() > 0) {
            $result = $query->result();
            $admin_options = [];

            foreach ($result as $admin) {
                $admin_options[$admin->id_admin] = $admin->username;
            }

            return $admin_options;
        } else {
            return []; // Kembalikan array kosong jika tidak ada admin
        }
    }

    // Mendapatkan data dari tabel berdasarkan kondisi tertentu
    function getwhere($table, $data)
    {
        return $this->db->get_where($table, $data);
    }

    public function getUserInfo($id)
    {
        $q = $this->db->get_where('user', ['id_user' => $id], 1);
        if ($this->db->affected_rows() > 0) {
            $row = $q->row();
            return $row;
        } else {
            error_log('no user found getUserInfo(' . $id . ')');
            return false;
        }
    }

    public function getUserInfoByEmail($email)
    {
        $q = $this->db->get_where('user', ['email' => $email], 1);
        if ($this->db->affected_rows() > 0) {
            $row = $q->row();
            return $row;
        }
    }

    public function insertToken($user_id)
    {
        $token = substr(sha1(rand()), 0, 30);
        $date = date('Y-m-d');

        $string = [
            'token' => $token,
            'user_id' => $user_id,
            'created' => $date,
        ];
        $query = $this->db->insert_string('tokens', $string);
        $this->db->query($query);
        return $token . $user_id;
    }

    public function isTokenValid($token)
    {
        $tkn = substr($token, 0, 30);
        $uid = substr($token, 30);

        $q = $this->db->get_where(
            'tokens',
            [
                'tokens.token' => $tkn,
                'tokens.user_id' => $uid,
            ],
            1
        );

        if ($this->db->affected_rows() > 0) {
            $row = $q->row();

            $created = $row->created;
            $createdTS = strtotime($created);
            $today = date('Y-m-d');
            $todayTS = strtotime($today);

            if ($createdTS != $todayTS) {
                return false;
            }

            $user_info = $this->getUserInfo($row->user_id);
            return $user_info;
        } else {
            return false;
        }
    }

    public function updatePassword($post)
    {
        $this->db->where('id_user', $post['id_user']);
        $this->db->update('user', ['password' => $post['password']]);
        return true;
    }

    public function get_admin_id($id_organisasi)
    {
        $this->db->select('id_admin');
        $this->db->from('organisasi');
        $this->db->where('id_organisasi', $id_organisasi);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->id_admin;
        } else {
            return null;
        }
    }

    public function get_admin_details($id_organisasi)
    {
        $this->db->select('a.id_admin, a.id_jabatan, a.id_shift');
        $this->db->from('admin a');
        $this->db->join('organisasi o', 'o.id_admin = a.id_admin');
        $this->db->where('o.id_organisasi', $id_organisasi);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array(); // Mengembalikan hasil dalam bentuk array asosiatif
        } else {
            return null; // Jika tidak ada data yang ditemukan
        }
    }

    public function get_jabatan_by_admin($id_admin)
    {
        $this->db->select('*');
        $this->db->from('jabatan');
        $this->db->where('id_admin', $id_admin);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result(); // Mengembalikan hasil dalam bentuk array objek
        } else {
            return null; // Jika tidak ada data yang ditemukan
        }
    }

    public function get_shift_by_admin($id_admin)
    {
        $this->db->select('*');
        $this->db->from('shift');
        $this->db->where('id_admin', $id_admin);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result(); // Mengembalikan hasil dalam bentuk array objek
        } else {
            return null; // Jika tidak ada data yang ditemukan
        }
    }

    public function get_user_by_email($email)
    {
        $query = $this->db->get_where('user', ['email' => $email]);
        return $query->row_array();
    }

    public function get_user_by_reset_token($token)
    {
        $query = $this->db->get_where('user', ['reset_token' => $token], 1);
        return $query->row_array();
    }

    public function set_reset_token($user_id, $token)
    {
        $token_expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $data = [
            'reset_token' => $token,
            'token_expiration' => $token_expiration,
        ];

        $this->db->where('id_user', $user_id);
        $this->db->update('user', $data);
    }

    public function getPasswordById($id)
    {
        $this->db->select('password');
        $this->db->where('id_user', $id);
        $query = $this->db->get('user');

        if ($query->num_rows() == 1) {
            $row = $query->row();
            return $row->password;
        } else {
            return false;
        }
    }

    public function update_password($id, $new_password)
    {
        $this->db->set('password', $new_password);
        $this->db->where('id_user', $id);
        $this->db->update('user');

        return $this->db->affected_rows() > 0;
    }

    public function is_user_registered($username, $email)
    {
        $this->db->where('username', $username);
        $this->db->or_where('email', $email);
        $query = $this->db->get('user');

        return $query->num_rows() > 0;
    }

    public function is_superadmin_registered($username, $email)
    {
        $this->db->where('username', $username);
        $this->db->or_where('email', $email);
        $query = $this->db->get('superadmin');

        return $query->num_rows() > 0;
    }

}
?>