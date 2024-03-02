<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->library('upload');
        $this->load->helper('admin_helper');
        $this->load->library('pagination');
        if (
            $this->session->userdata('logged_in') != true ||
            $this->session->userdata('role') != 'admin'
        ) {
            redirect(base_url() . 'auth');
        }
    }

    // 1. Page
    // Page Dashboard
    public function index()
    {
        $id_admin = $this->session->userdata('id');
        $data[
            'early_attendance'
        ] = $this->admin_model->get_early_attendance_by_user($id_admin);
        $data['jabatan'] = $this->admin_model->get_jabatan_data_by_admin(
            $id_admin
        );
        $data[
            'jumlah_kehadiran'
        ] = $this->admin_model->getJumlahTerlambatLebihAwal($id_admin);
        $data['cuti_count'] = $this->admin_model->get_cuti_count_by_admin(
            $id_admin
        );
        $data['cuti'] = $this->admin_model->get_cuti_data();
        $id_admin = $this->session->userdata('id');
        $data['user_count'] = $this->admin_model->get_user_count($id_admin);
        $data['user'] = $this->admin_model->get_user_data_by_admin($id_admin);
        $data['absensi']['count'] = $this->admin_model->get_absen_data_by_admin(
            $id_admin
        );
        $data['absensi']['data'] = $this->admin_model->get_absen_data_by_admin(
            $id_admin
        );
        $data['absen'] = $this->admin_model->getAbsensiByAdmin($id_admin);
        usort($data['absen'], function ($a, $b) {
            return strtotime($b->tanggal_absen) - strtotime($a->tanggal_absen);
        });
        $data['lokasi'] = $this->admin_model->get_lokasi_data_by_admin(
            $id_admin
        );
        $data['organisasi'] = $this->admin_model->get_all_organisasi($id_admin);
        $data['jabatan'] = $this->admin_model->get_jabatan_data_by_admin(
            $id_admin
        );
        $data['absensi'] = $this->admin_model->get_realtime_absensi_by_admin(
            $id_admin
        );
        $this->load->view('page/admin/dashboard', $data);
    }

    // Sidebar
    public function sidebar(){
        $id_admin = $this->session->userdata('id');
        $data['admin'] = $this->admin_model->getAdminByID($id_admin);
        $this->load->view('components/sidebar_admin', $data);
    }
    
    // Page Organisasi
    public function organisasi()
    {
        $id_admin = $this->session->userdata('id');
        $data['user'] = $this->admin_model->get_data('user')->result();
        $data['organisasi'] = $this->admin_model->get_organisasi_pusat(
            $id_admin
        );
        $this->load->view('page/admin/organisasi/organisasi', $data);
    }

    // Page Tabel Organisasi
    public function all_organisasi()
    {
        $id_admin = $this->session->userdata('id');
        $data['user'] = $this->admin_model->get_data('user')->result();
        $data['organisasi'] = $this->admin_model->get_all_organisasi($id_admin);
        $this->load->view('page/admin/organisasi/all_organisasi', $data);
    }

    // Page Jabatan
    public function jabatan()
    {
        $id_admin = $this->session->userdata('id_admin');

        $data['jabatan'] = $this->admin_model
            ->get_data_by_id_admin('jabatan', $id_admin)
            ->result();
        $this->load->view('page/admin/jabatan/jabatan', $data);
    }

    public function cuti()
    {
        $id_admin = $this->session->userdata('id_admin');
        $id_user = $this->admin_model->getIdUserByIdAdmin($id_admin);

        $data['cuti'] = $this->admin_model->get_cuti_data();

        $this->load->view('page/admin/cuti/cuti', $data);
    }

    public function lembur()
    {
        $id_admin = $this->session->userdata('id_admin');
        $id_user = $this->admin_model->getIdUserByIdAdmin($id_admin);

        // Ambil data lembur dari model
        $lembur_data = $this->admin_model->getAllArrayData();

        // Memproses data lembur untuk mengonversi id_user menjadi username
        foreach ($lembur_data as $key => $row) {
            // Pisahkan nilai id_user menjadi array id-user individual
            $id_users = explode(',', $row['id_user']);

            // Untuk setiap id-user individual, ambil username yang sesuai dari tabel user
            $usernames = [];
            foreach ($id_users as $id_user) {
                // Ambil username dari tabel user berdasarkan id_user
                $username = $this->admin_model->getUsernameById($id_user);
                // Jika username ditemukan, tambahkan ke dalam array usernames
                if ($username !== null) {
                    $usernames[] = $username;
                }
            }

            // Gabungkan usernames yang sesuai menjadi string yang dapat digunakan dalam tampilan
            $username_string = implode(', ', $usernames);

            // Setel kembali nilai id_user dengan username yang sesuai
            $lembur_data[$key]['id_user'] = $username_string;
        }

        // Siapkan data untuk dikirim ke view
        $data['lembur'] = $lembur_data;

        // Memuat view dan mengirimkan data ke view
        $this->load->view('page/admin/lembur/lembur', $data);
    }

    public function user()
    {
        $id_admin = $this->session->userdata('id_admin');

        $data['user'] = $this->admin_model
            ->get_data_by_id_admin('user', $id_admin)
            ->result();

        $this->load->view('page/admin/user/user', $data);
    }

    public function absensi()
    {
        $id_admin = $this->session->userdata('id');

        // Menggunakan model untuk mendapatkan seluruh id_user berdasarkan id_admin
        $id_user_array = $this->admin_model->getUsersByIdAdmin($id_admin);

        // Mengambil semua id_user dari array
        $id_users = array_column($id_user_array, 'id_user');

        // var_dump('id user =============>', $id_users);

        if (!empty($id_users)) {
            // Ambil data dari formulir
            $bulan = $this->input->get('bulan');
            $tanggal = $this->input->get('tanggal');
            $tahun = $this->input->get('tahun');

            // Menggunakan model untuk mendapatkan data absensi berdasarkan seluruh id_user
            $data['absensi'] = [];

            foreach ($id_users as $id_user) {
                $absensi_user = $this->admin_model->GetDataAbsensi(
                    $id_user,
                    $bulan,
                    $tanggal,
                    $tahun
                );

                if (!empty($absensi_user)) {
                    $data['absensi'] = array_merge($data['absensi'], $absensi_user);
                }
            }

            // Fungsi untuk mengurutkan data berdasarkan tanggal secara descending
            $sortByDateDescending = function ($a, $b) {
                return strtotime($b->tanggal_absen) - strtotime($a->tanggal_absen);
            };

            // Mengurutkan data absensi
            usort($data['absensi'], $sortByDateDescending);

            $keyword = $this->input->get('keyword');
            if ($keyword !== null && $keyword !== '') {
                $data['absensi'] = $this->admin_model
                    ->search_data('absensi', 'status_absen', $keyword)
                    ->result();

                // Mengurutkan data absensi setelah pencarian
                usort($data['absensi'], $sortByDateDescending);
            }

            $this->load->view('page/admin/absen/absensi', $data);
        } else {
            echo "Tidak ada id_user yang ditemukan untuk admin ini.";
        }
    }

    // Page Profile
    public function profile()
    {
        if ($this->session->userdata('id')) {
            $user_id = $this->session->userdata('id');
            $data['admin'] = $this->admin_model->getAdminByID($user_id);

            $this->load->view('page/admin/profile/profile', $data);
        } else {
            redirect('auth');
        }
    }

    // Page Detail Shift
    public function detail_shift()
    {
        // Mendefinisikan data yang akan digunakan dalam tampilan
        $data = [
            'judul' => 'Detail Shift',
            'deskripsi' => 'Ini adalah halaman detail shift.',
        ];
        $this->load->view('page/admin/shift/detail_shift', $data);
    }

    // Page Update Shift
    public function update_shift($id_shift)
    {
        $data['shift'] = $this->admin_model->getShiftId($id_shift);
        $this->load->view('page/admin/shift/update_shift', $data);
    }

    // Page Tambah Organisasi
    public function tambah_organisasi()
    {
        $this->load->view('page/admin/organisasi/tambah_organisasi');
    }

    // Page rekap harian
    public function rekap_harian()
    {
        $tanggal = $this->input->get('tanggal');
        $id_admin = $this->session->userdata('id_admin');

        $data['perhari'] = $this->admin_model->getRekapHarian(
            $tanggal,
            $id_admin
        );
        $this->load->view('page/admin/rekap/rekap_harian', $data);
    }

    public function rekap_mingguan()
    {
        $start_date = $this->input->get('start_date') ?: null;
        $end_date = $this->input->get('end_date') ?: null;

        // Assuming you have a way to get the logged-in admin's ID, replace '1' with the actual admin ID.
        $id_admin = $this->session->userdata('id_admin');

        if ($start_date && $end_date) {
            $data['perminggu'] = $this->admin_model->getRekapPerMinggu(
                $start_date,
                $end_date,
                $id_admin
            );
        } else {
            $data['perminggu'] = [];
        }

        $this->load->view('page/admin/rekap/rekap_mingguan', $data);
    }

    public function rekap_simpel()
    {
        $bulan = $this->input->post('bulan');
        $admin_id = $this->session->userdata('id_admin'); // Assuming you store admin ID in the session
        $data['absen'] = $this->admin_model->get_bulanan($bulan, $admin_id);
        $this->session->set_flashdata('bulan', $bulan);
        $this->load->view('page/admin/rekap/rekap_simpel', $data);
    }

    public function rekap_perkaryawan()
    {
        $user_id = $this->input->post('id_user');
        $admin_id = $this->session->userdata('id_admin'); // Assuming you store admin ID in the session
        $data['absen'] = $this->admin_model->get_perkaryawan(
            $admin_id,
            $user_id
        );
        $data['karyawan'] = $this->admin_model
            ->get_data_by_id_admin('user', $admin_id)
            ->result();
        $this->session->set_flashdata('user_id', $user_id);
        $this->load->view('page/admin/rekap/rekap_perkaryawan', $data);
    }

    public function rekap_bulanan()
    {
        $id_admin = $this->session->userdata('id_admin');
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');

        $data['absensi'] = $this->admin_model->get_all_karyawan(
            $id_admin,
            $bulan,
            $tahun
        );
        $this->load->view('page/admin/rekap/rekap_bulanan', $data);
    }

    // Page Detail Organisasi
    public function detail_organisasi($organisasi_id)
    {
        $data['organisasi'] = $this->admin_model->getOrganisasiDetails(
            $organisasi_id
        );

        $this->load->view('page/admin/organisasi/detail_organisasi', $data);
    }

    // Page Detail User
    public function detail_user($user_id)
    {
        $data['user'] = $this->admin_model->getUserDetails($user_id);

        // Mengirim data pengguna ke view
        $this->load->view('page/admin/user/detail_user', $data);
    }

    // Page tambah user
    public function tambah_user()
    {
        $id_admin = $this->session->userdata('id_admin');

        $data['admin'] = $this->admin_model->get_data('admin')->result();
        $data['organisasi'] = $this->admin_model->getOrganisasiByIdAdmin(
            $id_admin
        );
        $data['shift'] = $this->admin_model->getShiftByIdAdmin($id_admin);
        $data['jabatan'] = $this->admin_model->getJabatanByIdAdmin($id_admin);
        $this->load->view('page/admin/user/tambah_user', $data);
    }

    // Page tambah shift
    public function tambah_shift()
    {
        $data['admin'] = $this->admin_model->get_data('admin')->result();
        $this->load->view('page/admin/shift/tambah_shift', $data);
    }

    // Page tambah jabatan
    public function tambah_jabatan()
    {
        $this->load->view('page/admin/jabatan/tambah_jabatan');
    }

    // Page update organisasi
    public function update_organisasi($id_organisasi)
    {
        $data['organisasi'] = $this->admin_model->getOrganisasiById(
            $id_organisasi
        );
        $this->load->view('page/admin/organisasi/update_organisasi', $data);
    }

    // Page Update User
    public function update_user($id_user)
    {
        $id_admin = $this->session->userdata('id');
        $id_jabatan = $this->session->userdata('id_jabatan');
        $id_shift = $this->session->userdata('id_shift');
        $id_organisasi = $this->session->userdata('id_organisasi');

        $data['user'] = $this->admin_model->getUserId($id_user);
        $data['shift'] = $this->admin_model->get_shift_by_id_admin($id_admin);
        $data['jabatan'] = $this->admin_model->get_jabatan_by_id_admin(
            $id_admin
        );
        $data['organisasi'] = $this->admin_model
            ->get_data('organisasi')
            ->result();

        $this->load->view('page/admin/user/update_user', $data);
    }

    public function lokasi()
    {
        $id_admin = $this->session->userdata('id_admin');

        // Data lokasi
        $data['lokasi'] = $this->admin_model
            ->get_data_by_id_admin('lokasi', $id_admin)
            ->result();

        // Menampilkan view dengan data
        $this->load->view('page/admin/lokasi/lokasi', $data);
    }

    // page tambah lokasi
    public function tambah_lokasi()
    {
        $this->load->model('admin_model');

        // Get organizational data
        $data['organisasi'] = $this->admin_model->get_all_organisasii();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lokasi_data = [
                'nama_lokasi' => $this->input->post('nama_lokasi'),
                'alamat' => $this->input->post('alamat_kantor'),
                'id_organisasi' => $this->input->post('id_organisasi'),
                'id_admin' => $this->session->userdata('id_admin'), // Mengambil id_admin dari sesi login
                // tambahkan kolom lainnya sesuai kebutuhan
            ];

            if ($lokasi_data['id_organisasi']) {
                foreach ($lokasi_data as $key => $value) {
                    $this->db->set($key, $value);
                }

                $this->db->insert('lokasi');

                redirect('admin/lokasi');
            } else {
                echo 'Error: ID Organisasi cannot be null.';
            }
        } else {
            $this->load->view('page/admin/lokasi/tambah_lokasi', $data);
        }
    }

    // page detail lokasi
    public function detail_lokasi($lokasi_id)
    {
        $data['lokasi'] = $this->admin_model->getLokasiData($lokasi_id);

        // Mengirim data lokasi ke view
        $this->load->view('page/admin/lokasi/detail_lokasi', $data);
    }

    // page update lokasi
    public function update_lokasi($id_lokasi)
    {
        // Load necessary models or helpers here
        $this->load->model('admin_model');

        // Assuming you have a method in your model to get location details by ID
        $data['lokasi'] = $this->admin_model->getLokasiById($id_lokasi);

        // Load the view for updating location details
        $this->load->view('page/admin/lokasi/update_lokasi', $data);
    }

    // page detail jabatan
    public function detail_jabatan($id_jabatan)
    {
        $data['jabatan'] = $this->admin_model->getJabatanDetails($id_jabatan);

        // Mengirim data pengguna ke view
        $this->load->view('page/admin/jabatan/detail_jabatan', $data);
    }

    // page update jabatan
    public function update_jabatan($id_jabatan)
    {
        $data['jabatan'] = $this->admin_model->getJabatanId($id_jabatan);

        // Menampilkan view update_jabatan dengan data jabatan
        $this->load->view('page/admin/jabatan/update_jabatan', $data);
    }

    // page shift
    public function shift()
    {
        $id_admin = $this->session->userdata('id');
        $data['shift'] = $this->admin_model->get_shift_by_id_admin($id_admin);
        $data[
            'employee_counts'
        ] = $this->admin_model->get_employee_count_by_shift();
        $this->load->view('page/admin/shift/shift', $data);
    }

    // page detail absen
    public function detail_absen($id_absensi)
    {
        $data['absensi'] = $this->admin_model->getAbsensiDetail($id_absensi);
        // Menampilkan view update_jabatan dengan data jabatan
        $this->load->view('page/admin/absen/detail_absensi', $data);
    }

    // 2. Aksi
    // aksi hapus organisasi
    public function hapus_organisasi($id_organisasi)
    {
        $this->admin_model->hapus_organisasi($id_organisasi);
        redirect('admin/organisasi');
    }

    // aksi update organisasi
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
        $organisasi = $this->admin_model->get_organisasi_by_id($id_organisasi);

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

        // Lakukan pembaruan data Organisasi
        $this->admin_model->update_organisasi($id_organisasi, $data);
        $this->session->set_flashdata(
            'berhasil_update',
            'Berhasil mengubah data'
        );

        // Redirect ke halaman setelah pembaruan data
        redirect('admin/organisasi'); // Sesuaikan dengan halaman yang diinginkan setelah pembaruan data Organisasi
    }

    // aksi tambah organisasi
    public function aksi_tambah_organisasi()
    {
        $id_admin = $this->session->userdata('id');
        $status = 'pusat'; // Default status

        // Cek apakah ada data dengan id_admin yang diambil dari session
        $data_existing = $this->admin_model->get_organisasi_by_admin_id(
            $id_admin
        );

        if ($data_existing) {
            // Jika ada data dengan id_admin yang diambil dari session
            $status = 'cabang';
        }

        // Ambil data yang diperlukan dari form
        $data = [
            'nama_organisasi' => $this->input->post('nama_organisasi'),
            'alamat' => $this->input->post('alamat'),
            'nomor_telepon' => $this->input->post('nomor_telepon'),
            'email_organisasi' => $this->input->post('email_organisasi'),
            'kecamatan' => $this->input->post('kecamatan'),
            'kabupaten' => $this->input->post('kabupaten'),
            'provinsi' => $this->input->post('provinsi'),
            'id_admin' => $id_admin,
            'status' => $status,
            // sesuaikan dengan kolom lainnya
        ];

        // Simpan data ke tabel
        $this->admin_model->tambah_data('organisasi', $data); // Panggil method pada model
        $this->session->set_flashdata(
            'berhasil_tambah',
            'Berhasil Menambahkan Data'
        );

        // Redirect kembali ke halaman dashboard admin
        redirect('admin/organisasi');
    }

    // Aksi tambah user
    public function aksi_tambah_user()
    {
        $id_admin = $this->session->userdata('id');

        // Ambil data yang diperlukan dari form
        $password = $this->input->post('password');
        if (strlen($password) < 8) {
            // Password kurang dari 8 karakter, berikan pesan kesalahan
            $this->session->set_flashdata(
                'gagal_tambah',
                'Password harus memiliki panjang minimal 8 karakter'
            );
            redirect('admin/user'); // Redirect kembali ke halaman sebelumnya
            return; // Hentikan eksekusi jika validasi gagal
        }

        // Ambil data yang diperlukan dari form
        $data = [
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'password' => md5($password), // Simpan kata sandi yang telah di-MD5
            'id_admin' => $id_admin,
            'id_organisasi' => $this->input->post('id_organisasi'),
            'id_shift' => $this->input->post('id_shift'),
            'id_jabatan' => $this->input->post('id_jabatan'),
            'image' => 'User.png',
            'role' => 'user',
            // sesuaikan dengan kolom lainnya
        ];

        // Simpan data ke tabel
        $this->admin_model->tambah_data('user', $data); // Panggil method pada model
        $this->session->set_flashdata(
            'berhasil_tambah',
            'Berhasil Menambahkan Data'
        );

        // Redirect kembali ke halaman dashboard superadmin
        redirect('admin/user');
    }

    // Aksi Tambah Jabatan
    public function aksi_tambah_jabatan()
    {
        $id_admin = $this->session->userdata('id');

        // Ambil data yang diperlukan dari form
        $data = [
            'nama_jabatan' => $this->input->post('nama_jabatan'),
            'id_admin' => $id_admin,
            // sesuaikan dengan kolom lainnya
        ];

        // Simpan data ke tabel
        $this->admin_model->tambah_data('jabatan', $data); // Panggil method pada model
        $this->session->set_flashdata(
            'berhasil_tambah',
            'Berhasil Menambahkan Data'
        );

        // Redirect kembali ke halaman dashboard superadmin
        redirect('admin/jabatan');
    }

    public function aksi_ubah_foto()
    {
        $image = $this->upload_image_admin('image');
        $user_id = $this->session->userdata('id');
        $admin = $this->admin_model->getAdminByID($user_id);

        if ($image[0] == true) {
            $admin->image = $image[1];
        }

        $data = [
            'image' => $image[1],
        ];

        // Update foto di database
        $update_result = $this->admin_model->updateAdminPhoto($user_id, $data);

        // Set flash data untuk memberi tahu user tentang hasil pembaruan foto
        if ($update_result) {
            $this->session->set_flashdata(
                'berhasil_ubah_foto',
                'Berhasil mengubah foto'
            );
        } else {
            $this->session->set_flashdata(
                'gagal_update',
                'Gagal mengubah foto'
            );
        }

        // Redirect ke halaman profile
        redirect(base_url('admin/profile'));
    }

    // aksi ubah akun
    public function edit_profile()
    {
        $email = $this->input->post('email');
        $username = $this->input->post('username');

        $data = [
            'email' => $email,
            'username' => $username,
        ];

        $this->session->set_userdata($data);
        
        $update_result = $this->admin_model->update_data('admin', $data, [
            'id_admin' => $this->session->userdata('id'),
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

        redirect(base_url('admin/profile'));
    }

    // aksi ubah akun
    public function aksi_ubah_akun()
    {
        $image = $this->upload_image_admin('image');

        $user_id = $this->session->userdata('id');
        $admin = $this->admin_model->getAdminByID($user_id);

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
                redirect(base_url('admin/profile'));
            }
        }

        // Update the admin data in the database
        $update_result = $this->admin_model->update('admin', $data, [
            'id_admin' => $user_id,
        ]);

        if ($update_result) {
            $this->session->set_flashdata('message', 'Profil berhasil diubah');
        } else {
            $this->session->set_flashdata('message', 'Gagal mengubah profil');
        }

        redirect(base_url('admin/profile'));
    }

    // Hapus User
    public function hapus_user($id_user)
    {
        $this->admin_model->hapus_user($id_user);
        redirect('admin/user');
    }

    // Aksi Update User
    public function aksi_edit_user()
    {
        // Mendapatkan data dari form
        $id_user = $this->input->post('id_user');
        $username = $this->input->post('username');
        $id_shift = $this->input->post('id_shift');
        $id_jabatan = $this->input->post('id_jabatan');

        // Buat data yang akan diupdate
        $data = [
            'username' => $username,
            'id_shift' => $id_shift,
            'id_jabatan' => $id_jabatan,
            // Tambahkan field lain jika ada
        ];

        // Lakukan pembaruan data Admin
        $this->admin_model->edit_user($id_user, $data);
        $this->session->set_flashdata(
            'berhasil_update',
            'Berhasil mengubah data'
        );

        // Redirect ke halaman setelah pembaruan data
        redirect('admin/user'); // Sesuaikan dengan halaman yang diinginkan setelah pembaruan data Admin
    }

    // aksi Tambah Shift
    public function aksi_tambah_shift()
    {
        // Ambil data yang diperlukan dari form
        $data = [
            'nama_shift' => $this->input->post('name'),
            'jam_masuk' => $this->input->post('time_masuk'),
            'jam_pulang' => $this->input->post('time_pulang'),
            'id_admin' => $this->session->userdata('id'),
        ];

        // Simpan data ke tabel
        $this->admin_model->tambah_data('shift', $data); // Panggil method pada
        $this->session->set_flashdata(
            'berhasil_tambah',
            'Berhasil Menambahkan Data'
        );

        // Redirect kembali ke halaman dashboard superadmin
        redirect('admin/shift');
    }

    // Aksi Update Shift
    public function aksi_edit_shift()
    {
        // Mendapatkan data dari form
        $id_shift = $this->input->post('id_shift');
        $nama_shift = $this->input->post('nama_shift');
        $jam_masuk = $this->input->post('jam_masuk');
        $jam_pulang = $this->input->post('jam_pulang');

        // Buat data yang akan diupdate
        $data = [
            'nama_shift' => $nama_shift,
            'jam_masuk' => $jam_masuk,
            'jam_pulang' => $jam_pulang,
        ];

        // Lakukan pembaruan data Admin
        $this->admin_model->update_shift($id_shift, $data);
        $this->session->set_flashdata(
            'berhasil_update',
            'Berhasil mengubah data'
        );

        // Redirect ke halaman setelah pembaruan data
        redirect('admin/shift');
    }

    // Hapus Shift
    public function hapus_shift($id_shift)
    {
        $this->admin_model->hapus_shift($id_shift);
        redirect('admin/shift');
    }

    //    aksi update
    public function aksi_edit_lokasi()
    {
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
        $this->admin_model->update_lokasi($id_lokasi, $data);
        $this->session->set_flashdata(
            'berhasil_update',
            'Berhasil mengubah data'
        );

        // Redirect ke halaman setelah pembaruan data
        redirect('admin/lokasi'); // Sesuaikan dengan halaman yang diinginkan setelah pembaruan data Lokasi
    }

    // aksi hapus lokasi
    public function hapus_lokasi($id_lokasi)
    {
        $this->admin_model->hapus_lokasi($id_lokasi); // Assuming you have a method 'hapus_lokasi' in the model
        redirect('admin/lokasi');
        $this->session->set_flashdata('hapus_lokasi');
    }

    // aksi ubah jabatan
    public function aksi_edit_jabatan()
    {
        // Mendapatkan data dari form
        $id_jabatan = $this->input->post('id_jabatan');
        $nama_jabatan = $this->input->post('nama_jabatan');

        // Buat data yang akan diupdate
        $data = [
            'nama_jabatan' => $nama_jabatan,
            // Tambahkan field lain jika ada
        ];

        // Lakukan pembaruan data Jabatan
        $this->admin_model->update_jabatan($id_jabatan, $data);
        $this->session->set_flashdata(
            'berhasil_update',
            'Berhasil mengubah data'
        );

        // Redirect ke halaman setelah pembaruan data
        redirect('admin/jabatan'); // Sesuaikan dengan halaman yang diinginkan setelah pembaruan data Jabatan
    }

    // Hapus Jabatan
    public function hapus_jabatan($id_jabatan)
    {
        $this->admin_model->hapus_jabatan($id_jabatan);
        redirect('admin/jabatan');
    }

    // Untuk Aksi Setuju & Tidak Cuti
    public function setujuCuti($cutiId)
    {
        $this->admin_model->updateStatusCuti($cutiId, 'Disetujui');

        // Anda dapat memberikan respons JSON jika diperlukan.
        echo json_encode(['status' => 'Disetujui']);
    }

    public function tidakSetujuCuti($cutiId)
    {
        $this->admin_model->updateStatusCuti($cutiId, 'Tidak Disetujui');

        // Anda dapat memberikan respons JSON jika diperlukan.
        echo json_encode(['status' => 'Tidak Disetujui']);
    }

    // 3. Lain-lain
    // Pembaruan password
    public function update_password()
    {
        $password_lama = $this->input->post('password_lama');
        $password_baru = $this->input->post('password_baru');
        $konfirmasi_password = $this->input->post('konfirmasi_password');

        $stored_password = $this->admin_model->getPasswordById(
            $this->session->userdata('id')
        );

        if (md5($password_lama) != $stored_password) {
            $this->session->set_flashdata(
                'kesalahan_password_lama',
                'Password lama yang dimasukkan salah'
            );
        } else {
            if ($password_baru === $konfirmasi_password) {
                $update_result = $this->admin_model->update_password(
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
        redirect(base_url('admin/profile'));
    }

    // upload image
    public function upload_image_admin($value)
    {
        // Mendapatkan ID pengguna dari sesi
        $user_id = $this->session->userdata('id');

        // Mendapatkan nama file foto saat ini
        $admin = $this->admin_model->getAdminByID($user_id);
        $current_image = $admin->image;

        // Generate kode unik untuk nama file baru
        $kode = round(microtime(true) * 1000);

        // Konfigurasi upload
        $config['upload_path'] = './images/admin/';
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
                $image_path = './images/admin/' . $current_image;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }

            // Kembalikan hasil upload baru
            return [true, $new_image];
        }
    }

    // Fungsi untuk menghapus file lama saat upload logo baru
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

    // Fungsi untuk menghapus file lama
    private function deleteOldImage($old_image)
    {
        // Pastikan file lama tidak kosong sebelum menghapus
        if (!empty($old_image)) {
            $image_path = './images/logo/' . $old_image;

            // Hapus file lama jika ada
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
    }

    public function export_perkaryawan()
	{
		$user_id = $this->session->flashdata('user_id');
		$admin_id = $this->session->userdata('id_admin'); // Assuming you store admin ID in the session
		$nama_lengkap_karyawan = nama_user($user_id);
		$nama_karyawan = explode(' ', $nama_lengkap_karyawan)[0];

		// Provide both $bulan and $admin_id to the get_perkaryawan method
		$data = $this->admin_model->get_perkaryawan($admin_id, $user_id);

		// Remove redundant usort if data is already sorted
		// usort($data, function ($a, $b) {
		//     return strcmp(nama_user($a->id_user), nama_user($b->id_user));
		// });

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Style untuk judul
		$style_title = [
			'font' => [
				'bold' => true,
				'size' => 18,
				'color' => ['argb' => 'FFFFFF'],
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['argb' => '4F81BD'],
			],
		];

		// Style untuk header kolom
		$style_header = [
			'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['argb' => '4F81BD'],
			],
		];

		// Style untuk baris data
		$style_data = [
			'alignment' => [
				'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
			],
		];

		// Set judul
		$sheet->setCellValue('A1', 'REKAP ' . $nama_lengkap_karyawan);
		$sheet->mergeCells('A1:G1');

		$sheet->getStyle('A1:G1')->applyFromArray($style_title);

		// Set header kolom
		$sheet->setCellValue('A3', 'NO');
		$sheet->setCellValue('B3', 'USERNAME');
		$sheet->setCellValue('C3', 'TANGGAL');
		$sheet->setCellValue('D3', 'KETERANGAN');
		$sheet->setCellValue('E3', 'JAM MASUK');
		$sheet->setCellValue('F3', 'JAM PULANG');
		$sheet->setCellValue('G3', 'KEHADIRAN');

		// Set data
		$no = 1;
		$row = 4;
		$temp = [];
		$day = new DateTime($data[0]->tanggal_absen);

		for ($i = 0; $i < count($data); $i++) {
			$now = new DateTime($data[$i]->tanggal_absen);

			array_push($temp, $data[$i]);

			// Check if the next data point exists
			if (isset($data[$i + 1])) {
				// Check if the dates are different
				if ($now->format('Y/m/d') != $day->format('Y/m/d')) {
					$selisih = $now->diff($day)->days;
					for ($j = 0; $j < $selisih; $j++) {
						$object = new stdClass();
						$object->id_user = $user_id;
						$object->tanggal_absen = $day->format("Y/m/d");
						$object->keterangan_izin = "-";
						$object->jam_masuk = "-";
						$object->foto_masuk = "-";  
						$object->lokasi_masuk = "-";
						$object->jam_pulang = "-";  
						$object->foto_pulang = "-";  
						$object->lokasi_pulang = "-";  
						$object->status = "0";  
						$object->status_absen = "Tidak masuk";  
						$object->keterangan_terlambat = "-";  
						$object->keterangan_pulang_awal = "-";  

						$day->modify('+1 day');

						array_push($temp, $object);
					}
					$day->modify($data[$i + 1]->tanggal_absen);
				}
			}
		}

		foreach ($temp as $absen_data) {
			$sheet->setCellValue('A' . $row, $no);
			$sheet->setCellValue('B' . $row, nama_user($absen_data->id_user));
			$sheet->setCellValue('C' . $row, convDate($absen_data->tanggal_absen));
			$sheet->setCellValue('D' . $row, $absen_data->keterangan_izin);
			$sheet->setCellValue('E' . $row, $absen_data->jam_masuk);
			$sheet->setCellValue('F' . $row, $absen_data->jam_pulang);
			$sheet->setCellValue('G' . $row, $absen_data->status_absen);

			// Tambahkan warna untuk baris yang memiliki status_absen "Terlambat"
			if ($absen_data->status_absen == 'Terlambat') {
				$sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray([
					'fill' => [
						'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
						'startColor' => ['argb' => 'FAF3AD'],
					],
				]);
			}

			if ($absen_data->status_absen == 'Tidak masuk') {
				$sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray([
					'fill' => [
						'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
						'startColor' => ['argb' => 'FF0000'],
					],
				]);
			}

			// Tambahkan warna untuk baris yang memiliki jam masuk "00:00:00"
			if ($absen_data->jam_masuk == '00:00:00') {
				$sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray([
					'fill' => [
						'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
						'startColor' => ['argb' => 'BDD7EE'],
					],
				]);
			}

			$no++;
			$row++;
		}

		// Atur lebar kolom
		$sheet->getColumnDimension('A')->setWidth(5);
		$sheet->getColumnDimension('B')->setWidth(25);
		$sheet->getColumnDimension('C')->setWidth(25);
		$sheet->getColumnDimension('D')->setWidth(20);
		$sheet->getColumnDimension('E')->setWidth(30);
		$sheet->getColumnDimension('F')->setWidth(30);
		$sheet->getColumnDimension('G')->setWidth(30);

		// Atur tinggi baris secara otomatis
		$sheet->getDefaultRowDimension()->setRowHeight(-1);

		// Atur orientasi dan judul halaman
		$sheet
			->getPageSetup()
			->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
		$sheet->setTitle('REKAP ' . $nama_karyawan);

		// Set header untuk file Excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header(
			'Content-Disposition: attachment; filename="REKAP ' .
				$nama_karyawan .
				'.xlsx"'
		);
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
	}


    public function export_all_karyawan()
    {
        $id_admin = $this->session->userdata('id_admin');
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $rekap = $this->admin_model->get_all_karyawan(
            $id_admin,
            $bulan,
            $tahun
        );
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Style untuk judul
        $style_title = [
            'font' => [
                'bold' => true,
                'size' => 18,
                'color' => ['argb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '4F81BD'],
            ],
        ];

        // Style untuk header kolom
        $style_header = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']],
            'alignment' => [
                'horizontal' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '4F81BD'],
            ],
        ];

        // Style untuk baris data
        $style_data = [
            'alignment' => [
                'vertical' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];

        // Set judul
        $sheet->setCellValue('A1', 'REKAP BULANAN KARYAWAN ');
        $sheet->mergeCells('A1:G1');

        $sheet
            ->getStyle('A1')
            ->getFont()
            ->setBold(true);

        // Set header kolom
        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'NAMA');
        $sheet->setCellValue('C3', 'TANGGAL');
        $sheet->setCellValue('D3', 'JAM MASUK');
        $sheet->setCellValue('E3', 'JAM PULANG');
        $sheet->setCellValue('F3', 'JAM KERJA');
        $sheet->setCellValue('G3', 'KETERANGAN');
        $sheet->setCellValue('H3', 'KEHADIRAN');

        // Set data
        $no = 1;
        $row = 4;
        // Initialize an associative array to store rows based on id_user
        $userRows = [];

        foreach ($rekap as $data) {
            // Check if the id_user key exists in the associative array
            if (!isset($userRows[$data->id_user])) {
                // If not, initialize an empty array for that id_user
                $userRows[$data->id_user] = [];
            }
        
            // Hitung selisih waktu antara jam_masuk dan jam_pulang
            $jamMasuk = new DateTime($data->tanggal_absen . ' ' . $data->jam_masuk);
            $jamPulang = new DateTime($data->tanggal_absen . ' ' . $data->jam_pulang);
            $selisihWaktu = $jamMasuk->diff($jamPulang);
        
            // Format selisih waktu ke dalam jam dan menit
            $durasiKerja = $selisihWaktu->format('%H jam %i menit');
        
            // Populate the row for the current data
            $userRows[$data->id_user][] = [
                'A' => $no,
                'B' => toTitleCase(nama_user($data->id_user)),
                'C' => convDate($data->tanggal_absen),
                'D' => $data->jam_masuk,
                'E' => $data->jam_pulang,
                'F' => $durasiKerja, // Tambahkan kolom durasi kerja
                'G' => $data->keterangan_izin,
                'H' => $data->status_absen,
            ];
        
            $no++;
        }
        

        // Iterate over the userRows associative array to populate the spreadsheet
        foreach ($userRows as $userId => $rows) {
            foreach ($rows as $rowData) {
                // var_dump($rowData);
                // echo '<br />';
                $sheet->setCellValue('A' . $row, $rowData['A']);
                $sheet->setCellValue('B' . $row, $rowData['B']);
                $sheet->setCellValue('C' . $row, $rowData['C']);
                $sheet->setCellValue('D' . $row, $rowData['D']);
                $sheet->setCellValue('E' . $row, $rowData['E']);
                $sheet->setCellValue('F' . $row, $rowData['F']);
                $sheet->setCellValue('G' . $row, $rowData['G']);
                $sheet->setCellValue('H' . $row, $rowData['H']);

                // Apply formatting based on conditions (e.g., Terlambat or jam_masuk)
                if ($rowData['H'] == 'Terlambat') {
                    $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FAF3AD'],
                        ],
                    ]);
                }

                if ($rowData['E'] == '00:00:00') {
                    $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'BDD7EE'],
                        ],
                    ]);
                }

                $row++;
            }
        }

        // Atur lebar kolom
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(50);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(30);

        // Atur tinggi baris secara otomatis
        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        // Atur orientasi dan judul halaman
        $sheet
            ->getPageSetup()
            ->setOrientation(
                \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE
            );
        $sheet->setTitle('REKAP KARYAWAN PERBULAN');

        // Set header untuk file Excel
        header(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
        header(
            'Content-Disposition: attachment; filename="REKAP KARYAWAN PERBULANAN.xlsx"'
        );
        header('Cache-Control: max-age=0');

        // Simpan file Excel dan tampilkan ke output
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    // Untuk mengexport data per minggu
    public function export_mingguan()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $id_admin = $this->session->userdata('id');

        if ($start_date) {
            $end_date = date('Y-m-d', strtotime($start_date . ' + 7 days'));

            $admin_id = $this->session->userdata('id_admin');

            $data['perminggu'] = $this->admin_model->getRekapPerMinggu(
                $start_date,
                $end_date,
                $id_admin
            );
        } else {
            $data['perminggu'] = [];
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Style untuk judul
        $style_title = [
            'font' => [
                'bold' => true,
                'size' => 18,
                'color' => ['argb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '4F81BD'],
            ],
        ];

        // Style untuk header kolom
        $style_header = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']],
            'alignment' => [
                'horizontal' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '4F81BD'],
            ],
        ];

        // Style untuk baris data
        $style_data = [
            'alignment' => [
                'vertical' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];

        // Set judul
        $sheet->setCellValue('A1', 'REKAP MINGGUAN')->mergeCells('A1:G1');
        $sheet->getStyle('A1:G1')->applyFromArray($style_title);

        // Set header kolom
        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'NAMA');
        $sheet->setCellValue('C3', 'TANGGAL');
        $sheet->setCellValue('E3', 'JAM MASUK');
        $sheet->setCellValue('F3', 'JAM PULANG');
        $sheet->setCellValue('D3', 'KETERANGAN');
        $sheet->setCellValue('G3', 'KEHADIRAN');
        $sheet->getStyle('A3:G3')->applyFromArray($style_header);

        $data_per_minggu = $this->admin_model->getRekapPerMinggu(
            $start_date,
            $end_date,
            $id_admin
        );

        usort($data_per_minggu, function ($a, $b) {
            return strcmp($a['username'], $b['username']);
        });

        // Set data
        $no = 1;
        $numrow = 4;
        foreach ($data_per_minggu as $row) {
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, nama_user($row['id_user']));
            $sheet->setCellValue('C' . $numrow, $row['tanggal_absen']);
            $sheet->setCellValue('E' . $numrow, $row['jam_masuk']);
            $sheet->setCellValue('F' . $numrow, $row['jam_pulang']);
            $sheet->setCellValue('D' . $numrow, $row['keterangan_izin']);
            $sheet->setCellValue('G' . $numrow, $row['status_absen']);

            if ($row['status_absen'] == 'Terlambat') {
                $sheet
                    ->getStyle('A' . $numrow . ':G' . $numrow)
                    ->applyFromArray([
                        'fill' => [
                            'fillType' =>
                                \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FAF3AD'],
                        ],
                    ]);
            }

            // Tambahkan warna untuk baris yang memiliki jam masuk "00:00:00"
            if ($row['jam_masuk'] == '00:00:00') {
                $sheet
                    ->getStyle('A' . $numrow . ':G' . $numrow)
                    ->applyFromArray([
                        'fill' => [
                            'fillType' =>
                                \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'BDD7EE'],
                        ],
                    ]);
            }

            $no++;
            $numrow++;
        }

        // Atur lebar kolom
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(30);

        // Atur tinggi baris secara otomatis
        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        // Atur orientasi dan judul halaman
        $sheet
            ->getPageSetup()
            ->setOrientation(
                \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE
            );
        $sheet->setTitle('REKAP MINGGUAN');

        // Set header untuk file Excel
        header(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
        header(
            'Content-Disposition: attachment; filename="REKAP MINGGUAN.xlsx"'
        );
        header('Cache-Control: max-age=0');

        // Simpan file Excel dan tampilkan ke output
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    // Untuk mengexport data per hari
    public function export_harian()
    {
        $tanggal = date('Y-m-d'); // Ambil tanggal hari ini

        // Mendapatkan id_admin yang sedang login (contoh: Anda dapat menggantinya sesuai dengan logika otentikasi Anda)
        $id_admin = $this->session->userdata('id_admin');

        $data['perhari'] = $this->admin_model->getRekapHarian(
            $tanggal,
            $id_admin
        );

        usort($data['perhari'], function ($a, $b) {
            return strcmp(nama_user($a->id_user), nama_user($b->id_user));
        });

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Style untuk judul
        $style_title = [
            'font' => [
                'bold' => true,
                'size' => 18,
                'color' => ['argb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '4F81BD'],
            ],
        ];

        // Style untuk header kolom
        $style_header = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']],
            'alignment' => [
                'horizontal' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '4F81BD'],
            ],
        ];

        // Style untuk baris data
        $style_data = [
            'alignment' => [
                'vertical' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];

        // Set judul
        $sheet->setCellValue('A1', 'REKAP HARIAN')->mergeCells('A1:G1');
        $sheet->getStyle('A1:G1')->applyFromArray($style_title);

        // Set header kolom
        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'NAMA');
        $sheet->setCellValue('C3', 'TANGGAL');
        $sheet->setCellValue('E3', 'JAM MASUK');
        $sheet->setCellValue('F3', 'JAM PULANG');
        $sheet->setCellValue('D3', 'KETERANGAN');
        $sheet->setCellValue('G3', 'KEHADIRAN');
        $sheet->getStyle('A3:G3')->applyFromArray($style_header);

        // Set data
        $no = 1;
        $numrow = 4;
        foreach ($data['perhari'] as $row) {
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, nama_user($row->id_user));
            $sheet->setCellValue('C' . $numrow, convDate($row->tanggal_absen));
            $sheet->setCellValue('E' . $numrow, $row->jam_masuk);
            $sheet->setCellValue('F' . $numrow, $row->jam_pulang);
            $sheet->setCellValue('D' . $numrow, $row->keterangan_izin);
            $sheet->setCellValue('G' . $numrow, $row->status_absen);

            if ($row->status_absen == 'Terlambat') {
                $sheet
                    ->getStyle('A' . $numrow . ':G' . $numrow)
                    ->applyFromArray([
                        'fill' => [
                            'fillType' =>
                                \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FAF3AD'],
                        ],
                    ]);
            }

            // Tambahkan warna untuk baris yang memiliki jam masuk "00:00:00"
            if ($row->jam_masuk == '00:00:00') {
                $sheet
                    ->getStyle('A' . $numrow . ':G' . $numrow)
                    ->applyFromArray([
                        'fill' => [
                            'fillType' =>
                                \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'BDD7EE'],
                        ],
                    ]);
            }

            $no++;
            $numrow++;
        }

        // Atur lebar kolom
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(30);

        // Atur tinggi baris secara otomatis
        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        // Atur orientasi dan judul halaman
        $sheet
            ->getPageSetup()
            ->setOrientation(
                \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE
            );
        $sheet->setTitle('REKAP HARIAN');

        // Set header untuk file Excel
        header(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
        header('Content-Disposition: attachment; filename="REKAP HARIAN.xlsx"');
        header('Cache-Control: max-age=0');

        // Simpan file Excel dan tampilkan ke output
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function permohonan_pdf($id_cuti)
    {
        $this->load->library('mypdf');
        $id_user = $this->admin_model->get_user_id_admin(
            $this->session->userdata('id_admin')
        );
        $data['cuti'] = $this->admin_model->get_cuti_by_id('cuti', $id_cuti);
        if ($data['cuti']) {
            $id_user = $data['cuti']->id_user;
            $id_organisasi = $data['cuti']->id_organisasi;
            $data['user'] = $this->admin_model->get_user_by_id($id_user);
            $data['organisasi'] = $this->admin_model->get_organisasi_by_id(
                $id_organisasi
            );
        }
        $this->mypdf->generate('/page/admin/laporan/dompdf', $data);
    }

    public function surat_lembur($id_lembur)
    {
        $this->load->library('mypdf');

        $id_user = $this->admin_model->get_user_id_admin(
            $this->session->userdata('id_admin')
        );
        $data['lembur'] = $this->admin_model->get_lembur_by_id(
            'lembur',
            $id_lembur
        );

        if ($data['lembur']) {
            $id_user = $data['lembur']->id_user;
            $id_organisasi = $data['lembur']->id_organisasi;
            $data['user'] = $this->admin_model->get_user_by_id($id_user);
            $data['organisasi'] = $this->admin_model->get_organisasi_by_id(
                $id_organisasi
            );

            // Menambahkan variabel $organisasi_id ke dalam array $data
            $data['organisasi_id'] = $id_organisasi;
        }

        // Memanggil view dan melewatkan data
        $this->mypdf->generate('/page/admin/laporan/lembur', $data);
    }

    // Untuk Aksi Filter
    public function aksi_filter()
    {
        $this->load->model('admin_model');

        // Ambil nilai filter dari formulir
        $bulan = $this->input->post('bulan');
        $tanggal = $this->input->post('tanggal');
        $tahun = $this->input->post('tahun');
        $id_admin = $this->session->userdata('id');

        // Panggil model untuk mendapatkan data absensi
        $dataAbsensi = $this->admin_model->filterAbsensi(
            $id_admin,
            $bulan,
            $tanggal,
            $tahun
        );

        // Mengurutkan kembali data absensi berdasarkan tanggal secara descending
        usort($dataAbsensi, function ($a, $b) {
            return strtotime($b->tanggal_absen) - strtotime($a->tanggal_absen);
        });

        // Kirim data yang sudah disaring ke view
        $data['absensi'] = $dataAbsensi;

        // Load view yang menampilkan hasil filter
        $this->load->view('page/admin/absen/absensi', $data);
    }

    // Export History Absensi
    public function export_absensi()
    {
        // Mengambil nilai filter dari query string URL
        $bulan = $this->input->post('bulan');
        $tanggal = $this->input->post('tanggal');
        $tahun = $this->input->post('tahun');
        $id_admin = $this->session->userdata('id');

        // Filter data berdasarkan nilai yang ada
        $absensiData = $this->admin_model->filterAbsensi(
            $id_admin,
            $bulan,
            $tanggal,
            $tahun
        );

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $style_row = [
            'font' => ['bold' => true],
            'alignment' => [
                'vertical' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->setCellValue('A1', 'HISTORY ABSENSI');
        $sheet->mergeCells('A1:G1');
        $sheet
            ->getStyle('A1')
            ->getFont()
            ->setBold(true);

        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'NAMA');
        $sheet->setCellValue('C3', 'TANGGAL');
        $sheet->setCellValue('G3', 'JAM MASUK');
        $sheet->setCellValue('H3', 'JAM PULANG');
        $sheet->setCellValue('D3', 'KETERANGAN');
        $sheet->setCellValue('I3', 'KEHADIRAN');

        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);
        $sheet->getStyle('H3')->applyFromArray($style_col);
        $sheet->getStyle('I3')->applyFromArray($style_col);

        $no = 1;
        $numrow = 4;
        foreach ($absensiData as $row) {
            $formattedDate = convDate($row->tanggal_absen);
            $user_data = nama_user($row->id_user);

            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $user_data);
            $sheet->setCellValue('C' . $numrow, $formattedDate);
            $sheet->setCellValue('G' . $numrow, $row->jam_masuk);
            $sheet->setCellValue('H' . $numrow, $row->jam_pulang);
            $sheet->setCellValue('D' . $numrow, $row->keterangan_izin);
            $sheet->setCellValue('I' . $numrow, $row->status_absen);

            // Tambahkan warna untuk baris yang memiliki status_absen "Terlambat"
            if ($row->status_absen == 'Terlambat') {
                $sheet
                    ->getStyle('A' . $numrow . ':I' . $numrow)
                    ->getFill()
                    ->setFillType(
                        \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
                    )
                    ->getStartColor()
                    ->setARGB('FEFA03'); // Orange color
            }

            // Tambahkan warna untuk baris yang memiliki status_absen "Terlambat"
            if ($row->jam_masuk == '00:00:00') {
                $sheet
                    ->getStyle('A' . $numrow . ':H' . $numrow)
                    ->getFill()
                    ->setFillType(
                        \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
                    )
                    ->getStartColor()
                    ->setARGB('09CEFE'); // Orange color
            }

            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('H' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('I' . $numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(40);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(40);

        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $sheet
            ->getPageSetup()
            ->setOrientation(
                \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE
            );

        $sheet->setTitle('HISTORY ABSENSI');

        header(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
        header(
            'Content-Disposition: attachment; filename="HISTORY_ABSENSI.xlsx"'
        );
        header('Cache-Control: max-age=0');

        ob_clean();
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function kehadiran()
    {
        // Mendapatkan id_admin yang sedang login (contoh: menggunakan sesi)
        $id_admin = $this->session->userdata('id_admin');

        // Mendapatkan id_user yang terkait dengan id_admin
        $id_user = $this->admin_model->getIdUserByIdAdmin($id_admin);

        $data['user'] = $this->admin_model->getKehadiranData($id_admin);
        $this->load->view('page/admin/kehadiran/kehadiran', $data);
    }

    // page history absen
    public function history_absen()
    {
        $this->load->model('admin_model');

        // Ambil id_admin dari sesi (misalnya setelah admin login)
        $id_admin = $this->session->userdata('id_admin');

        // Ambil data user yang terkait dengan id_admin yang sedang login
        $data['user'] = $this->admin_model->get_users_by_admin($id_admin);

        if ($this->input->post('id_user')) {
            $id_user = $this->input->post('id_user');
            $data['absensi'] = $this->admin_model->get_username_data($id_user);
        } else {
            $data['absensi'] = $this->admin_model->get_username_data(0); // Atau isi dengan nilai default sesuai kebutuhan
        }

        $this->load->view('page/admin/absen/history_absen', $data);
    }

    // Untuk mengexport data simpel per bulanan
    public function export_simple()
    {
        $bulan = $this->session->flashdata('bulan');
        $admin_id = $this->session->userdata('id_admin');
        // var_dump($admin_id);
        $user_id = '2';
        // var_dump($id_user);
        // echo '<br />';

        // $data = $this->admin_model->get_bulanan($bulan, $admin_id);
        $data = $this->admin_model->get_perkaryawan($admin_id, $user_id);

		$list_user = $this->admin_model->get_user_by_id_admin($admin_id);

        usort($data, function ($a, $b) {
            return strcmp(nama_user($a->id_user), nama_user($b->id_user));
        });

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Style untuk judul
        $style_title = [
            'font' => [
                'bold' => true,
                'size' => 18,
                'color' => ['argb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '4F81BD'],
            ],
        ];

        // Style untuk header kolom
        $style_header = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']],
            'alignment' => [
                'horizontal' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '4F81BD'],
            ],
        ];

		$style_izin = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '0000FF'],
            ],
			'borders' => [
				'outline' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => '000000'],
				]
			]
        ];

		$style_telat = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFF00'],
            ],
			'borders' => [
				'outline' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => '000000'],
				]
			]
        ];

		$style_lupa = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => '964B00'],
            ],
			'borders' => [
				'outline' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => '000000'],
				]
			]
        ];

		$style_alpa = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF0000'],
            ],
			'borders' => [
				'outline' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => '000000'],
				]
			]
        ];

        // Style untuk baris data
        $style_data = [
            'alignment' => [
                'vertical' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];

        // Set judul
        $sheet->setCellValue('A1', 'REKAP BULANAN')->mergeCells('A1:G1');
        $sheet->getStyle('A1:J1')->applyFromArray($style_title);

        // Set header kolom
        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'NAMA');
        $sheet->setCellValue('C3', 'TANGGAL');
        $sheet->setCellValue('D3', 'IJIN');
        $sheet->setCellValue('E3', 'TANGGAL');
        $sheet->setCellValue('F3', 'TERLAMBAT');
        $sheet->setCellValue('G3', 'TANGGAL');
        $sheet->setCellValue('H3', 'TIDAK ABSEN PULANG');
        $sheet->setCellValue('I3', 'TANGGAL');
        $sheet->setCellValue('J3', 'TANPA KETERANGAN');
        $sheet->getStyle('A3:J3')->applyFromArray($style_header);

        // Set data
        $no = 1;
        $row = 4;

		$no1 = 1;
        $row2 = 4;
        $temp = [];
        $day = new DateTime($data[0]->tanggal_absen);

        for ($i = 0; $i < count($data); $i++) {
            $now = new DateTime($data[$i]->tanggal_absen);
            if ($now->format('Y/m/d') == $day->format('Y/m/d')) {
                array_push($temp, $data[$i]);
                $day->modify('+1 day');
            } else {
                $selisih = $now->diff($day)->days;
                for ($j = 0; $j < $selisih; $j++) {
                    $object = new stdClass();
                    $object->id_user = $user_id;
                    $object->tanggal_absen = $day->format('Y/m/d');
                    $object->keterangan_izin = '-';
                    $object->jam_masuk = '-';
                    $object->foto_masuk = '-';
                    $object->lokasi_masuk = '-';
                    $object->jam_pulang = '-';
                    $object->foto_pulang = '-';
                    $object->lokasi_pulang = '-';
                    $object->status = '0';
                    $object->status_absen = 'Tidak masuk';
                    $object->keterangan_terlambat = '-';
                    $object->keterangan_pulang_awal = '-';
        
                    $day->modify('+1 day');
        
                    array_push($temp, $object);
                }
        
                // Periksa apakah $i + 1 adalah indeks yang valid sebelum mengaksesnya
                if ($i + 1 < count($data)) {
                    $day->modify($data[$i + 1]->tanggal_absen);
                    // var_dump($data[$i + 1]->tanggal_absen);
                }
            }
        }        

		$alpa=[];
		$telat=[];
		$lupa=[];
		$izin=[];
		foreach ($temp as $item) {
            // var_dump($item->id_user, $item->status_absen);
            // echo'<br />';
            if ($item->status_absen === 'Tidak masuk') {
                array_push($alpa, $item->id_user, $item->tanggal_absen);
                // var_dump('ini alpa -------------------------------->',$alpa);
                // echo'<br />';
            } else if ($item->status_absen === 'Terlambat'){
                array_push($telat, $item->id_user, $item->tanggal_absen);
                // var_dump('ini telat -------------------------------->',$telat);
                // echo'<br />';
            } else if ($item->status_absen === 'Lupa'){
                array_push($lupa, $item->id_user, $item->tanggal_absen);
                // var_dump('ini lupa ---------------------------------->',$lupa);
                // echo'<br />';
            } else if ($item->status_absen === 'Izin'){
                array_push($izin, $item->id_user, $item->tanggal_absen);
                // var_dump('ini izin ----------------------------------->',$izin);
                // echo'<br />';
		    }
	    }

        foreach ($list_user as $nama) {
            // var_dump($nama->id_user);
            // echo'<br />';

            $id = $nama->id_user;
            // var_dump($id);
			$sheet->setCellValue('A' . $row, $no); 
            $sheet->setCellValue('B' . $row, toTitleCase(nama_user($nama->id_user)));
            
			// $shift_jam_masuk = $this->admin_model->getShiftJamMasuk($item->tanggal_absen);
			// $selisih_jam = strtotime($item->jam_masuk) - strtotime($shift_jam_masuk);
			// $selisih_format = gmdate('H:i:s', abs($selisih_jam));

			$sheet->getStyle('D'.$row, $no)->applyFromArray($style_izin);
			$sheet->getStyle('F'.$row, $no)->applyFromArray($style_telat);
			$sheet->getStyle('H'.$row, $no)->applyFromArray($style_lupa);
			$sheet->getStyle('J'.$row, $no)->applyFromArray($style_alpa);

            // var_dump($izin[0]);
            if (!empty($alpa) && $id === $alpa[0]) {
                $est = implode(", ", $alpa)."\n";
                $sheet->setCellValue('I' . $row, $est);
                $sheet->setCellValue('J' . $row, 'Tanpa Keterangan');
                $sheet->getStyle('I'.$row)->getAlignment()->setWrapText(true);
            }
            if (!empty($telat) && $id === $telat[0]) {
                // var_dump($telat);
                $est2 = implode(", ", $telat)."\n";
                $sheet->setCellValue('E' . $row, $est2);
                $sheet->setCellValue('F' . $row, 'Contoh Terlambat');
                $sheet->getStyle('E'.$row)->getAlignment()->setWrapText(true);
            }
            if (!empty($izin) && $id === $izin[0]) {
                $est3 = implode(", ", $izin)."\n";
                $sheet->setCellValue('C' . $row, $est3);
                $sheet->setCellValue('D' . $row, 'Contoh Izin');
                // var_dump($nama->keterangan_izin);
                $sheet->getStyle('C'.$row)->getAlignment()->setWrapText(true);
            }
            if (!empty($lupa) && $id === $lupa[0]) {
                $est4 = implode(", ", $lupa)."\n";
                $sheet->setCellValue('G' . $row, $est4);
                $sheet->setCellValue('H' . $row, 'Contoh Lupa absen');
                $sheet->getStyle('G'.$row)->getAlignment()->setWrapText(true);
            }
            
            
            // $est3 = implode(", ", $izin)."\n";
            // // var_dump('ini izin ---------------->', $est3);
            // // echo'<br />';
            // $sheet->setCellValue('C' . $row, $est3);
			// $sheet->getStyle('C'.$row)->getAlignment()->setWrapText(true);

			// $est2 = implode(", ", $telat)."\n";
            // // var_dump('ini telat ---------------->',$est2);
            // // echo'<br />';
            // $sheet->setCellValue('E' . $row, $est2);
			// $sheet->getStyle('E'.$row)->getAlignment()->setWrapText(true);
            
			// $est4 = implode(", ", $lupa)."\n";
            // // var_dump('ini lupa ------------------>', $est4);
            // // echo'<br />';
            // $sheet->setCellValue('G' . $row, $est4);
			// $sheet->getStyle('G'.$row)->getAlignment()->setWrapText(true);
            
			// $est = implode(", ", $alpa)."\n";
            // // var_dump('ini alpa ------------------->', $est);
            // // echo'<br />';
            // $sheet->setCellValue('I' . $row, $est);
			// $sheet->getStyle('I'.$row)->getAlignment()->setWrapText(true);

            // if ($item->keterangan_izin == '-') {
            //     $sheet->setCellValue('C' . $row, ''); // Jika keterangan_izin adalah "-", biarkan kolom kosong
            // } else {
            //     $sheet->setCellValue(
            //         'C' . $row,
            //         convDate($item->tanggal_absen)
            //     );
            // }
            // $sheet->setCellValue('D' . $row, $item->keterangan_izin);

            // if ($item->status_absen == 'Terlambat') {
            //     $sheet->setCellValue(
            //         'E' . $row,
            //         convDate($item->tanggal_absen)
            //     );
            // } else {
            //     $sheet->setCellValue('E' . $row, '');
            // }
            // $sheet->setCellValue('F' . $row, $selisih_format);

            // if ($item->keterangan_izin == '-') {
            //     $sheet->setCellValue('G' . $row, '');
            //     $sheet->setCellValue('H' . $row, '');
            //     $sheet->setCellValue('I' . $row, '');
            //     $sheet->setCellValue('J' . $row, '');
            // } else {
            //     $sheet->setCellValue(
            //         'G' . $row,
            //         convDate($item->tanggal_absen)
            //     );
            //     $sheet->setCellValue('H' . $row, $item->status_absen);
            //     $sheet->setCellValue(
            //         'I' . $row,
            //         convDate($item->tanggal_absen)
            //     );
            //     $sheet->setCellValue('J' . $row, $item->status_absen);
            // }
		$no++;
		$row++;
	    }

        // Atur lebar kolom
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(30);
        $sheet->getColumnDimension('J')->setWidth(30);

        // Atur tinggi baris secara otomatis
        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        // Atur orientasi dan judul halaman
        $sheet
            ->getPageSetup()
            ->setOrientation(
                \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE
            );
        $sheet->setTitle('REKAP BULANAN');

        // Set header untuk file Excel
        header(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
        header(
            'Content-Disposition: attachment; filename="REKAP BULANAN.xlsx"'
        );
        header('Cache-Control: max-age=0');

        // Simpan file Excel dan tampilkan ke output
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function laporan_surat_lembur($id_lembur)
    {
        $this->load->library('mypdf');

        $id_admin = $this->session->userdata('id_admin');

        // Mendapatkan ID User berdasarkan ID Admin
        $id_user = $this->admin_model->get_user_id_admin($id_admin);

        // Mendapatkan ID Jabatan berdasarkan ID User
        $id_jabatan = $this->admin_model->get_jabatan_by_user_id($id_user);

        // Data yang akan dikirimkan ke view
        // $data['id_user'] = $id_user;
        $data['id_jabatan'] = $id_jabatan;
        $data['lembur'] = $this->admin_model->get_lembur_by_user($id_lembur);
        // Loop melalui setiap data lembur
        foreach ($data['lembur'] as $row) {
            // Explode kolom id_user menjadi array
            $id_users = explode(',', $row->id_user);

            // Inisialisasi array untuk menyimpan nama pengguna
            $nama_users = [];

            // Loop melalui setiap id pengguna
            foreach ($id_users as $id_user) {
                // Panggil fungsi getNamaUser dari model User_model untuk mendapatkan nama pengguna
                $nama_user = nama_user($id_user);

                // Tambahkan nama pengguna ke array
                $nama_users[] = $nama_user;
            }

            // Gabungkan semua nama pengguna menjadi satu string dan simpan di dalam array $data['nama_users']
            $data['nama_users'][] = implode(', ', $nama_users);
        }

        $this->mypdf->generate('/page/admin/laporan/laporan_lembur', $data);
    }
}

?>