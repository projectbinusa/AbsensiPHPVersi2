Superadmin.php:

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SuperAdmin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('super_helper');
        $this->load->model('super_model');
        $this->load->library('upload');
        $this->load->library('session');
        $this->load->library('pagination');
        if (
            $this->session->userdata('logged_in') != true ||
            $this->session->userdata('role') != 'superadmin'
        ) {
            redirect(base_url() . 'auth');
        }
    }

    // 1. Page
    // Page Dashboard / Utama
    public function index()
    {
        $id_superadmin = $this->session->userdata('id');
        $id_admin = $this->super_model->get_admin_data_by_superadmin(
            $id_superadmin
        );
        // echo "ID Admin: " . $id_admin;
        $data['organisasi'] = $this->super_model
            ->get_data('organisasi')
            ->num_rows();
        $data['admin'] = $this->super_model->get_admin_count_by_superadmin(
            $id_superadmin
        );
        $data['user'] = $this->super_model->get_user_count();
        $data['users'] = $this->super_model->get_user();
        $this->load->view('page/super_admin/dashboard', $data);
    }

    // Sidebar
    // public function sidebar(){
    //     $id_superadmin = $this->session->userdata('id');
    //     $data['superadmin'] = $this->super_model->getSuperAdminByID($id_superadmin);
    //     $this->load->view('components/sidebar_super_admin', $data);
    // }

    // Page Organisasi
    public function organisasi()
    {
        sidebar();
        $data['start'] = $this->uri->segment(3);

        // Get the id_superadmin that is currently logged in
        $id_superadmin_logged_in = $this->session->userdata('id');

        // Data Organisasi based on the relationships
        $data['organisasi'] = $this->super_model
            ->get_data('organisasi')
            ->result();

        $filtered_organisasi = [];

        foreach ($data['organisasi'] as $row) {
            // Check if the id_admin associated with this id_organisasi is associated with the logged-in id_superadmin
            $id_admin = $row->id_admin;
            $admin_data = $this->super_model
                ->get_data_by_id('admin', ['id_admin' => $id_admin])
                ->row();

            if ($admin_data->id_superadmin == $id_superadmin_logged_in) {
                // If yes, add this row to the filtered data
                $filtered_organisasi[] = $row;
            }
        }

        $data['organisasi'] = $filtered_organisasi;

        $this->load->view('page/super_admin/organisasi/organisasi', $data);
    }

    // Page Tambah Organisasi
    public function tambah_organisasi()
    {
        sidebar();
        $id_superadmin = $this->session->userdata('id');
        $data['admin'] = $this->super_model->get_admin_by_superadminn(
            $id_superadmin
        );
        $this->load->view(
            'page/super_admin/organisasi/tambah_organisasi',
            $data
        );
    }

    // Page Update Organisasi
    public function update_organisasi($id_organisasi)
    {
        sidebar();
        $data['organisasi'] = $this->super_model->getOrganisasiById(
            $id_organisasi
        );
        $this->load->view(
            'page/super_admin/organisasi/update_organisasi',
            $data
        );
    }

    public function detail_organisasi($organisasi_id)
    {
        sidebar();
        $id_superadmin = $this->session->userdata('id_superadmin');

        $data['organisasi'] = $this->super_model->getOrganisasiDetails(
            $organisasi_id,
            $id_superadmin
        );

        $this->load->view(
            'page/super_admin/organisasi/detail_organisasi',
            $data
        );
    }

    // Page Admin
    public function admin()
    {
        sidebar();
        $id_superadmin = $this->session->userdata('id');

        $data['start'] = $this->uri->segment(3);

        // Memanggil fungsi baru pada model dengan menambahkan kriteria id_superadmin
        $data['user'] = $this->super_model
            ->get_admin_by_superadmin('admin', $id_superadmin)
            ->result();

        $this->load->view('page/super_admin/admin/admin', $data);
    }

    // Page Jabatan
    public function jabatan()
    {
        sidebar();
        $data['start'] = $this->uri->segment(3);

        $id_superadmin = $this->session->userdata('id');
        $admin_id = $this->super_model->get_admin_id_by_superadmin_id(
            $id_superadmin
        );

        $data['jabatan'] = $this->super_model
            ->get_jabatan_by_admin_id($admin_id)
            ->result();

        $this->load->view('page/super_admin/jabatan/jabatan', $data);
    }

    // Page Tambah Admin
    public function tambah_admin()
    {
        sidebar();
        // $data['id_superadmin'] = $this->session->userdata('id');
        $data['organisasi'] = $this->super_model
            ->get_data('organisasi')
            ->result();
        $this->load->view('page/super_admin/admin/tambah_admin', $data);
    }

    // Page Edit Admin
    public function update_admin($id_admin)
    {
        sidebar();
        // $id_admin = $this->session->userdata('id_admin');
        $data['admin'] = $this->super_model->getAdminById($id_admin);
        $this->load->view('page/super_admin/admin/update_admin', $data);
    }

    // Page Detail admin
    public function detail_admin($admin_id)
    {
        sidebar();
        // $data['id_superadmin'] = $this->session->userdata('id');
        $user_id = $this->session->userdata('id');
        $data['admin'] = $this->super_model->getAdminDetails($admin_id);
        $this->load->view('page/super_admin/admin/detail_admin', $data);
    }

    // Page User
    public function user()
    {
        sidebar();
        $data['start'] = $this->uri->segment(3);

        // Dapatkan ID superadmin yang sedang login dari sesi
        $id_superadmin = $this->session->userdata('id');

        // Ambil hanya pengguna yang terkait dengan admin yang terkait dengan superadmin yang sedang login
        $data['user'] = $this->super_model
            ->get_users_by_superadmin($id_superadmin)
            ->result();

        $this->load->view('page/super_admin/user/user', $data);
    }

    // Page Tambah User
    public function tambah_user()
    {
        sidebar();
        $id_superadmin = $this->session->userdata('id');
        $data['admin'] = $this->super_model->get_data('admin')->result();
        $data[
            'organisasi'
        ] = $this->super_model->get_all_organisasi_by_superadmin(
            $id_superadmin
        );
        $data['shift'] = $this->super_model->get_shift_by_superadminn(
            $id_superadmin
        );
        $data['jabatan'] = $this->super_model->get_jabatan_by_superadmin(
            $id_superadmin
        );

        $this->load->view('page/super_admin/user/tambah_user', $data);
    }

    // Page Update User
    public function update_user($id_user)
    {
        sidebar();
        $data['user'] = $this->super_model->getUserId($id_user);
        $this->load->view('page/super_admin/user/update_user', $data);
    }

    // Page Detail User
    public function detail_user($user_id)
    {
        sidebar();
        $data['user'] = $this->super_model->getUserDetails($user_id);

        // Mengirim data pengguna ke view
        $this->load->view('page/super_admin/user/detail_user', $data);
    }

    // Page Absensi
    public function absensi()
    {
        sidebar();
        $data['start'] = $this->uri->segment(3);

        // Mengambil id_superadmin yang sedang login
        $id_superadmin = $this->session->userdata('id');

        // Mengambil data absensi sesuai dengan relasi yang diinginkan
        $data['absensi'] = $this->super_model
            ->getAbsensiData($id_superadmin)
            ->result();

        $this->load->view('page/super_admin/absen/absensi', $data);
    }

    // Page Tambah Jabatan
    public function tambah_jabatan()
    {
        sidebar();
        $id_superadmin = $this->session->userdata('id');
        $data['admin'] = $this->super_model->get_admin_by_superadminn(
            $id_superadmin
        );
        $this->load->view('page/super_admin/jabatan/tambah_jabatan', $data);
    }

    // Page Update Jabatan
    public function update_jabatan($id_jabatan)
    {
        sidebar();
        $data['jabatan'] = $this->super_model->getJabatanId($id_jabatan);
        $this->load->view('page/super_admin/jabatan/update_jabatan', $data);
    }

    public function shift()
    {
        sidebar();
        $data['start'] = $this->uri->segment(3);

        $id_superadmin = $this->session->userdata('id');
        $data['shift'] = $this->super_model->get_shift_by_superadmin(
            $id_superadmin
        );

        $this->load->view('page/super_admin/shift/shift', $data);
    }

    // Page Tambah Shift
    public function tambah_shift()
    {
        sidebar();
        $id_superadmin = $this->session->userdata('id');
        $data['admin'] = $this->super_model->get_admin_by_superadminn(
            $id_superadmin
        );
        $this->load->view('page/super_admin/shift/tambah_shift', $data);
    }

    // Page Update Shift
    public function update_shift($id_shift)
    {
        sidebar();
        $data['shift'] = $this->super_model->getShiftId($id_shift);
        $this->load->view('page/super_admin/shift/update_shift', $data);
    }

    // Page Profile
    public function profile()
    {
        if ($this->session->userdata('id')) {
            $user_id = $this->session->userdata('id');
            $data['superadmin'] = $this->super_model->getSuperAdminByID(
                $user_id
            );

            $this->load->view('page/super_admin/profile/profile', $data);
        } else {
            redirect('auth');
        }
    }

    // page detail absen
    public function detail_absen($id_absensi)
    {
        sidebar();
        $data['absensi'] = $this->super_model->getAbsensiDetails($id_absensi);
        // Menampilkan view update_jabatan dengan data jabatan
        $this->load->view('page/super_admin/absen/detail_absensi', $data);
    }

    // page detail jabatan
    public function detail_jabatan($id_jabatan)
    {
        sidebar();
        $data['jabatan'] = $this->super_model->getJabatanDetails($id_jabatan);

        // Mengirim data pengguna ke view
        $this->load->view('page/super_admin/jabatan/detail_jabatan', $data);
    }

    public function detail_shift($id_shift)
    {
        sidebar();
        // Memanggil method getShiftDetails untuk mendapatkan data shift berdasarkan ID
        $data['shift'] = $this->super_model->getShiftDetails($id_shift);

        if ($data['shift']) {
            // Jika data shift ditemukan, tambahkan informasi lain yang dibutuhkan ke dalam data
            $data['judul'] = 'Detail Shift - Superadmin';
            $data['deskripsi'] =
                'Ini adalah halaman detail shift untuk superadmin.';
            $this->load->view('page/super_admin/shift/detail_shift', $data);
        } else {
            // Jika data shift tidak ditemukan, lakukan sesuai kebutuhan aplikasi Anda
            // Misalnya, tampilkan pesan error atau lakukan redirect ke halaman lain
            // Contoh: $this->load->view('page/error/not_found');
            // atau: redirect('superadmin/shift_not_found');
        }
    }

    public function lokasi()
    {
        sidebar();
        // Dapatkan ID superadmin yang sedang login dari sesi
        $superadmin_id = $this->session->userdata('id');

        // Dapatkan ID admin berdasarkan ID superadmin
        $admin_id = $this->super_model->get_admin_id_by_superadmin(
            $superadmin_id
        );

        // Data lokasi
        $data['lokasi'] = $this->super_model
            ->get_lokasi_by_admin_id($admin_id)
            ->result();
        $data['organisasi'] = $this->super_model
            ->get_data('organisasi')
            ->result();

        // Data lain dan tampilkan view
        $this->load->view('page/super_admin/lokasi/lokasi', $data);
    }

    // page tambah lokasi
    public function tambah_lokasi()
    {
        sidebar();
        $id_superadmin = $this->session->userdata('id');

        // Get organizational data
        $data[
            'organisasi'
        ] = $this->super_model->get_all_organisasi_by_superadmin(
            $id_superadmin
        );
        $data['admin'] = $this->super_model->get_admin_by_superadminn(
            $id_superadmin
        );

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Form telah disubmit, lakukan logika penyimpanan data ke database atau tindakan lainnya
            $lokasi_data = [
                'nama_lokasi' => $this->input->post('nama_lokasi'),
                'alamat' => $this->input->post('alamat_kantor'),
                'id_organisasi' => $this->input->post('id_organisasi'), // Fix the input field name
                'id_admin' => $this->input->post('id_admin'), // Fix the input field name
                // tambahkan kolom lainnya sesuai kebutuhan
            ];

            // Check if 'id_organisasi' is set and not null
            if ($lokasi_data['id_organisasi']) {
                // Tidak perlu menggunakan $this->db->set($data);
                // Setelah mendapatkan data, baru Anda bisa menggunakan metode set untuk operasi insert
                // Anda perlu mengatur setiap kolom yang ingin diinsert
                foreach ($lokasi_data as $key => $value) {
                    $this->db->set($key, $value);
                }

                $this->db->insert('lokasi');

                // Redirect ke halaman admin/lokasi setelah menambahkan data
                redirect('superadmin/lokasi');
            } else {
                // Handle the case where 'id_organisasi' is not set or null
                // You might want to show an error message or redirect to the form page with an error
                echo 'Error: ID Organisasi cannot be null.';
            }
        } else {
            // Form belum disubmit, ambil data organisasi dan tampilkan view untuk mengisi form
            $this->load->view('page/super_admin/lokasi/tambah_lokasi', $data);
        }
    }

    // page detail lokasi
    public function detail_lokasi($lokasi_id)
    {
        sidebar();
        $data['lokasi'] = $this->super_model->getLokasiData($lokasi_id);

        // Mengirim data lokasi ke view
        $this->load->view('page/super_admin/lokasi/detail_lokasi', $data);
    }

    // page update lokasi
    public function update_lokasi($id_lokasi)
    {
        sidebar();
        // Load necessary models or helpers here
        $this->load->model('super_model');

        // Assuming you have a method in your model to get location details by ID
        $data['lokasi'] = $this->super_model->getLokasiById($id_lokasi);

        // Load the view for updating location details
        $this->load->view('page/super_admin/lokasi/update_lokasi', $data);
    }

    public function aksi_edit_lokasi()
    {
        sidebar();
        // Mendapatkan data dari form
        $id_lokasi = $this->input->post('id_lokasi');
        $nama_lokasi = $this->input->post('nama_lokasi');
        $alamat = $this->input->post('alamat');

        // Buat data yang akan diupdate
        $data = [
            'nama_lokasi' => $nama_lokasi,
            'alamat' => $alamat,
            // Tambahkan field lain jika ada
        ];

        // Lakukan pembaruan data Lokasi
        $this->super_model->update_lokasi($id_lokasi, $data);
        $this->session->set_flashdata(
            'berhasil_update',
            'Berhasil mengubah data'
        );

        // Redirect ke halaman setelah pembaruan data
        redirect('superadmin/lokasi'); // Sesuaikan dengan halaman yang diinginkan setelah pembaruan data Lokasi
    }

    public function hapus_lokasi($id_lokasi)
    {
        $this->super_model->hapus_lokasi($id_lokasi); // Assuming you have a method 'hapus_lokasi' in the model
        redirect('superadmin/lokasi');
    }

    // ini page buat ubah password nya
    public function aksi_ubah_password()
    {
        $user_id = $this->session->userdata('id');
        $password_baru = $this->input->post('password_baru');
        $konfirmasi_password = $this->input->post('konfirmasi_password');

        // Check if new password is provided
        if (!empty($password_baru)) {
            // Check if the new password matches the confirmation
            if ($password_baru === $konfirmasi_password) {
                $data_password = [
                    'password' => md5($password_baru),
                ];

                // Update password di database
                $this->super_model->updateSuperAdminPassword(
                    $user_id,
                    $data_password
                );
            } else {
                $this->session->set_flashdata(
                    'message',
                    'Password baru dan Konfirmasi password harus sama'
                );
                redirect(base_url('superadmin/profile'));
            }
        }

        // Redirect ke halaman profile
        redirect(base_url('superadmin/profile'));
    }

    // 2. Aksi

    // aksi tambah admin
    public function aksi_tambah_admin()
    {
        $id_superadmin = $this->session->userdata('id');
        // Ambil data yang diperlukan dari form
        $password = $this->input->post('password');
        if (strlen($password) < 8) {
            // Password kurang dari 8 karakter, berikan pesan kesalahan
            $this->session->set_flashdata(
                'gagal_tambah',
                'Password harus memiliki panjang minimal 8 karakter'
            );
            redirect('superadmin/admin'); // Redirect kembali ke halaman sebelumnya
            return; // Hentikan eksekusi jika validasi gagal
        }

        // Ambil data yang diperlukan dari form
        $data = [
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'password' => md5($password), // Simpan kata sandi yang telah di-MD5
            'image' => 'User.png',
            'id_superadmin' => $id_superadmin,
            'role' => 'admin',
            // sesuaikan dengan kolom lainnya
        ];

        // Simpan data ke tabel
        $this->super_model->tambah_data('admin', $data); // Panggil method pada model
        $this->session->set_flashdata(
            'berhasil_tambah',
            'Berhasil Menambahkan Data'
        );

        // Redirect kembali ke halaman dashboard superadmin
        redirect('superadmin/admin');
    }

    // aksi tambah organisasi
    public function aksi_tambah_organisasi()
    {
        $id_superadmin = $this->session->userdata('id');
        // Ambil data yang diperlukan dari form
        $data = [
            'nama_organisasi' => $this->input->post('nama_organisasi'),
            'alamat' => $this->input->post('alamat'),
            'nomor_telepon' => $this->input->post('nomor_telepon'),
            'email_organisasi' => $this->input->post('email_organisasi'),
            'kecamatan' => $this->input->post('kecamatan'),
            'kabupaten' => $this->input->post('kabupaten'),
            'provinsi' => $this->input->post('provinsi'),
            'id_admin' => $this->input->post('id_admin'),
            'status' => 'pusat',
            // sesuaikan dengan kolom lainnya
        ];

        // Simpan data ke tabel
        $this->super_model->tambah_data('organisasi', $data); // Panggil method pada model
        $this->session->set_flashdata(
            'berhasil_tambah',
            'Berhasil Menambahkan Data'
        );

        // Redirect kembali ke halaman dashboard superadmin
        redirect('superadmin/organisasi');
    }

    // aksi tambah user
    public function aksi_tambah_user()
    {
        // Ambil data yang diperlukan dari form
        $password = $this->input->post('password');
        if (strlen($password) < 8) {
            // Password kurang dari 8 karakter, berikan pesan kesalahan
            $this->session->set_flashdata(
                'gagal_tambah',
                'Password harus memiliki panjang minimal 8 karakter'
            );
            redirect('superadmin/user'); // Redirect kembali ke halaman sebelumnya
            return; // Hentikan eksekusi jika validasi gagal
        }

        // Ambil data yang diperlukan dari form
        $data = [
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'password' => md5($password),
            'id_admin' => '', // Untuk menampung id_admin yang akan diambil
            'id_organisasi' => $this->input->post('id_organisasi'),
            'id_shift' => $this->input->post('id_shift'),
            'id_jabatan' => $this->input->post('id_jabatan'),
            'image' => 'User.png',
            'role' => 'user',
        ];

        // Ambil id_admin berdasarkan id_organisasi yang dipilih
        $id_admin = $this->super_model->get_id_admin_by_organisasi(
            $data['id_organisasi']
        ); // Ganti dengan model dan method yang sesuai

        if ($id_admin) {
            $data['id_admin'] = $id_admin; // Jika berhasil, set id_admin
            $this->super_model->tambah_data('user', $data); // Simpan data ke tabel
            $this->session->set_flashdata(
                'berhasil_tambah',
                'Berhasil Menambahkan Data'
            );
            redirect('superadmin/user');
        } else {
            $this->session->set_flashdata(
                'gagal_tambah',
                'Tidak ada admin yang terkait dengan organisasi ini'
            );
            redirect('superadmin/tambah_user'); // Redirect kembali ke halaman formulir tambah user
        }
    }

    // aksi tambah jabatan
    public function aksi_tambah_jabatan()
    {
        $id_superadmin = $this->session->userdata('id');
        // Ambil data yang diperlukan dari form
        $data = [
            'nama_jabatan' => $this->input->post('nama_jabatan'),
            'id_admin' => $this->input->post('id_admin'),
            // sesuaikan dengan kolom lainnya
        ];

        // Simpan data ke tabel
        $this->super_model->tambah_data('jabatan', $data); // Panggil method pada model
        $this->session->set_flashdata(
            'berhasil_tambah',
            'Berhasil Menambahkan Data'
        );

        // Redirect kembali ke halaman dashboard superadmin
        redirect('superadmin/jabatan');
    }

    // aksi tambah shift
    public function aksi_tambah_shift()
    {
        $id_superadmin = $this->session->userdata('id');
        // Ambil data yang diperlukan dari form
        $data = [
            'nama_shift' => $this->input->post('nama_shift'),
            'jam_masuk' => $this->input->post('jam_masuk'),
            'jam_pulang' => $this->input->post('jam_pulang'),
            'id_admin' => $this->input->post('id_admin'),
            // sesuaikan dengan kolom lainnya
        ];

        // Simpan data ke tabel
        $this->super_model->tambah_data('shift', $data); // Panggil method pada model
        $this->session->set_flashdata(
            'berhasil_tambah',
            'Berhasil Menambahkan Data'
        );

        // Redirect kembali ke halaman dashboard superadmin
        redirect('superadmin/shift');
    }

    private function deleteOldImage($old_image)
    {
        // Check if the old image exists
        if (!empty($old_image)) {
            $image_path = './images/logo/' . $old_image;

            // Check if the file exists before attempting to delete it
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
    }

    private function upload_image_logo($value, $old_image)
    {
        $kode = round(microtime(true) * 1000);

        // Konfigurasi upload
        $config['upload_path'] = './images/logo/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 30000;
        $config['file_name'] = $kode;
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($value)) {
            return [false, ''];
        } else {
            // Jika upload berhasil, dapatkan informasi file baru
            $fn = $this->upload->data();
            $new_image = $fn['file_name'];

            // Hapus file lama
            $this->deleteOldImage($old_image);

            return [true, $new_image];
        }
    }

    // Aksi Update Organisasi
    public function aksi_edit_organisasi()
    {
        // Mendapatkan data dari form
        $id_organisasi = $this->input->post('id_organisasi');
        $nama_organisasi = $this->input->post('nama_organisasi');
        $nomor_telepon = $this->input->post('nomor_telepon');
        $email_organisasi = $this->input->post('email_organisasi');
        $kecamatan = $this->input->post('kecamatan');
        $alamat = $this->input->post('alamat');
        $kabupaten = $this->input->post('kabupaten');
        $provinsi = $this->input->post('provinsi');

        // Ambil data organisasi dari model berdasarkan ID
        $organisasi = $this->super_model->get_organisasi_by_id($id_organisasi);

        // Tambahkan ini untuk upload logo
        $image = $this->upload_image_logo('image', $organisasi->image);
        if ($image[0] == true) {
            // Set properti image pada objek $organisasi
            $organisasi->image = $image[1];
        }

        // Buat data yang akan diupdate
        $data = [
            'nama_organisasi' => $nama_organisasi,
            'email_organisasi' => $email_organisasi,
            'nomor_telepon' => $nomor_telepon,
            'kecamatan' => $kecamatan,
            'alamat' => $alamat,
            'kabupaten' => $kabupaten,
            'provinsi' => $provinsi,
            'image' => $image[1],
            // Tambahkan field lain jika ada
        ];

        // Lakukan pembaruan data Admin
        $eksekusi = $this->super_model->update_organisasi(
            $id_organisasi,
            $data
        );
        $this->session->set_flashdata(
            'berhasil_update',
            'Berhasil mengubah data'
        );

        // Redirect ke halaman setelah pembaruan data
        redirect(base_url('superadmin/organisasi')); // Sesuaikan dengan halaman yang diinginkan setelah pembaruan data Admin
    }

    // Aksi Update User
    public function aksi_edit_user()
    {
        // Mendapatkan data dari form
        $id_user = $this->input->post('id_user');
        $username = $this->input->post('username');

        // Buat data yang akan diupdate
        $data = [
            'username' => $username,
            // Tambahkan field lain jika ada
        ];

        // Lakukan pembaruan data Admin
        $this->super_model->update_user($id_user, $data);
        $this->session->set_flashdata(
            'berhasil_update',
            'Berhasil mengubah data'
        );

        // Redirect ke halaman setelah pembaruan data
        redirect('superadmin/user'); // Sesuaikan dengan halaman yang diinginkan setelah pembaruan data Admin
    }

    // aksi Update jabatan
    public function aksi_edit_jabatan()
    {
        // Mendapatkan data dari form
        $id_jabatan = $this->input->post('id_jabatan');
        $nama_jabatan = $this->input->post('nama_jabatan');

        // Buat data yang akan diupdate
        $data = [
            'nama_jabatan' => $this->input->post('nama_jabatan'),
            // Tambahkan field lain jika ada
        ];

        // Lakukan pembaruan data Admin
        $this->super_model->update_jabatan($id_jabatan, $data);
        $this->session->set_flashdata(
            'berhasil_update',
            'Berhasil mengubah data'
        );

        // Redirect kembali ke halaman dashboard superadmin
        redirect('superadmin/jabatan');
    }

    // aksi Update jabatan
    public function aksi_edit_shift()
    {
        // Mendapatkan data dari form
        $id_shift = $this->input->post('id_shift');
        $nama_shift = $this->input->post('nama_shift');
        $jam_masuk = $this->input->post('jam_masuk');
        $jam_pulang = $this->input->post('jam_pulang');

        // Buat data yang akan diupdate
        $data = [
            'nama_shift' => $this->input->post('nama_shift'),
            'jam_masuk' => $this->input->post('jam_masuk'),
            'jam_pulang' => $this->input->post('jam_pulang'),
            // Tambahkan field lain jika ada
        ];

        // Lakukan pembaruan data Admin
        $this->super_model->update_shift($id_shift, $data);
        $this->session->set_flashdata(
            'berhasil_update',
            'Berhasil mengubah data'
        );

        // Redirect kembali ke halaman dashboard superadmin
        redirect('superadmin/shift');
    }

    // aksi Update admin
    public function aksi_edit_admin()
    {
        // Mendapatkan data dari form
        $id_admin = $this->input->post('id_admin');
        $email = $this->input->post('email');
        $username = $this->input->post('username');

        // Buat data yang akan diupdate
        $data = [
            'email' => $email,
            'username' => $username,
            // Tambahkan field lain jika ada
        ];

        // Lakukan pembaruan data Admin
        $this->super_model->update_admin($id_admin, $data);
        $this->session->set_flashdata(
            'berhasil_update',
            'Berhasil mengubah data'
        );

        // Redirect ke halaman setelah pembaruan data
        redirect('superadmin/admin'); // Sesuaikan dengan halaman yang diinginkan setelah pembaruan data Admin
    }

    // aksi hapus admin
    public function hapus_admin($id_admin)
    {
        $this->super_model->hapus_admin($id_admin);
        redirect('superadmin/admin');
    }

    // aksi hapus organisasi
    public function hapus_organisasi($id_organisasi)
    {
        $this->super_model->hapus_organisasi($id_organisasi);
        redirect('superadmin/organisasi');
    }

    // aksi hapus jabatan
    public function hapus_jabatan($id_jabatan)
    {
        $this->super_model->hapus_jabatan($id_jabatan);
        redirect('superadmin/jabatan');
    }

    // aksi hapus shift
    public function hapus_shift($id_shift)
    {
        $this->super_model->hapus_shift($id_shift);
        redirect('superadmin/shift');
    }

    // aksi hapus user
    public function hapus_user($id_user)
    {
        $this->super_model->hapus_user($id_user);
        redirect('superadmin/user');
    }

    // aksi ubah akun
    public function aksi_ubah_detail_akun()
    {
        $image = $this->upload_image_superadmin('image');

        $user_id = $this->session->userdata('id');
        $admin = $this->super_model->getSuperAdminByID($user_id);

        if ($image[0] == true) {
            $admin->image = $image[1];
        }

        $password_baru = $this->input->post('password_baru');
        $konfirmasi_password = $this->input->post('konfirmasi_password');
        $email = $this->input->post('email');
        $username = $this->input->post('username');

        $data = [
            'image' => $image[1],
            'email' => $email,
            'username' => $username,
        ];

        // Check if new password is provided
        if (!empty($password_baru)) {
            // Check if the new password matches the confirmation
            if ($password_baru === $konfirmasi_password) {
                $data['password'] = md5($password_baru);
            } else {
                $this->session->set_flashdata(
                    'message',
                    'Password baru dan Konfirmasi password harus sama'
                );
                redirect(base_url('superadmin/profile'));
            }
        }

        // Update the superadmin data in the database
        $update_result = $this->super_model->update('superadmin', $data, [
            'id_superadmin' => $user_id,
        ]);

        if ($update_result) {
            $this->session->set_flashdata('message', 'Profil berhasil diubah');
        } else {
            $this->session->set_flashdata('message', 'Gagal mengubah profil');
        }

        redirect(base_url('superadmin/profile'));
    }

    // 3. Lain-lain
    public function get_realtime_absensi()
    {
        sidebar();
        // Panggil metode di dalam model untuk mendapatkan data absensi real-time
        $realtime_absensi = $this->super_model->get_realtime_absensi();

        // Mengirim data dalam format JSON
        echo json_encode($realtime_absensi);
    }

    // 3. Lain-lain
    // untuk ubah foto
    public function aksi_ubah_foto()
    {
        $image = $this->upload_image_superadmin('image');
        $user_id = $this->session->userdata('id');
        $admin = $this->super_model->getSuperAdminByID($user_id);

        if ($image[0] == true) {
            $admin->image = $image[1];
        }

        $data = [
            'image' => $image[1],
        ];

        // Update foto di database
        $this->super_model->updateSuperAdminPhoto($user_id, $data);

        // Set flash data untuk memberi tahu user tentang hasil pembaruan foto
        if ($update_result) {
            $this->session->set_flashdata(
                'gagal_update',
                'Gagal mengubah foto'
            );
        } else {
            $this->session->set_flashdata(
                'berhasil_ubah_foto',
                'Berhasil mengubah foto'
            );
        }

        // Redirect ke halaman profile
        redirect(base_url('superadmin/profile'));
    }

    public function update_password()
    {
        $password_lama = $this->input->post('password_lama');
        $password_baru = $this->input->post('password_baru');
        $konfirmasi_password = $this->input->post('konfirmasi_password');

        $stored_password = $this->super_model->getPasswordById(
            $this->session->userdata('id')
        );

        if (md5($password_lama) != $stored_password) {
            $this->session->set_flashdata(
                'kesalahan_password_lama',
                'Password lama yang dimasukkan salah'
            );
        } else {
            if ($password_baru === $konfirmasi_password) {
                $update_result = $this->super_model->update_password(
                    $this->session->userdata('id'),
                    md5($password_baru)
                );
                if ($update_result) {
                    $this->session->set_flashdata(
                        'ubah_password',
                        'Berhasil mengubah password'
                    );
                } else {
                    $this->session->set_flashdata(
                        'gagal_update',
                        'Gagal memperbarui password'
                    );
                }
            } else {
                $this->session->set_flashdata(
                    'kesalahan_password',
                    'Password baru dan Konfirmasi password tidak sama'
                );
            }
        }
        redirect(base_url('superadmin/profile'));
    }

    // Pembaruan profil admin
    public function edit_profile()
    {
        $email = $this->input->post('email');
        $username = $this->input->post('username');

        $data = [
            'email' => $email,
            'username' => $username,
        ];

        $this->session->set_userdata($data);

        $update_result = $this->super_model->update_data('superadmin', $data, [
            'id_superadmin' => $this->session->userdata('id'),
        ]);

        if ($update_result) {
            $this->session->set_flashdata(
                'berhasil_ubah_foto',
                'Data berhasil diperbarui'
            );
        } else {
            $this->session->set_flashdata(
                'gagal_update',
                'Gagal memperbarui data'
            );
        }

        redirect(base_url('superadmin/profile'));
    }

    public function upload_image_superadmin($value)
    {
        // Mendapatkan ID pengguna dari sesi
        $user_id = $this->session->userdata('id');

        // Mendapatkan nama file foto saat ini
        $superadmin = $this->super_model->getSuperAdminByID($user_id);
        $current_image = $superadmin->image;

        // Generate kode unik untuk nama file baru
        $kode = round(microtime(true) * 1000);

        // Konfigurasi upload
        $config['upload_path'] = './images/superadmin/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 30000;
        $config['file_name'] = $kode;
        $this->upload->initialize($config);

        // Lakukan proses upload
        if (!$this->upload->do_upload($value)) {
            return [false, ''];
        } else {
            // Jika upload berhasil, dapatkan informasi file baru
            $fn = $this->upload->data();
            $new_image = $fn['file_name'];

            // Hapus foto sebelumnya jika ada
            if (!empty($current_image)) {
                $image_path = './images/superadmin/' . $current_image;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }

            // Kembalikan hasil upload baru
            return [true, $new_image];
        }
    }

    // public function tampil_admin()
    // {
    //     $this->load->model('nama_model_anda'); // Ganti 'nama_model_anda' dengan nama model yang sesuai
    //     $data['user'] = $this->nama_model_anda->get_all_admin(); // Mengambil data admin
    //     $data['total_admin'] = $this->nama_model_anda->get_admin_count(); // Menghitung jumlah admin

    //     // Lainnya seperti pengaturan tampilan flashdata

    //     $this->load->view('page/super_admin/dashboard', $data);
    // }

    // public function token()
    // {
    //     sidebar();
    //     $this->load->model('super_model');
    //     $data['user'] = $this->super_model->get_user();

    //     // Lainnya seperti pengaturan tampilan flashdata

    //     $this->load->view('page/super_admin/token/token', $data);
    // }
}