<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('user_helper');
        $this->load->model('user_model');
        $this->load->library('upload');
        if (
            $this->session->userdata('logged_in') != true ||
            $this->session->userdata('role') != 'user'
        ) {
            redirect(base_url() . 'auth');
        }
    }

    public function index()
    {
        sidebar();
        $data = ['page' => 'dashboard'];
        $tanggal = date('Y-m-d');
        $id_user = $this->session->userdata('id');
        $data['total_absen'] = $this->user_model
            ->get_absen('absensi', $id_user)
            ->num_rows();
        $data['total_izin'] = $this->user_model
            ->get_izin('absensi', $id_user)
            ->num_rows();
        $data['total_cuti'] = $this->user_model
            ->get_cuti('cuti', $id_user)
            ->num_rows();
        $data['absen'] = $this->user_model->get_absensi_data_by_user($id_user);
        usort($data['absen'], function ($a, $b) {
            return strtotime($b->tanggal_absen) - strtotime($a->tanggal_absen);
        });
        $data['absensi'] = $this->user_model->get_absensi_by_user_date(
            $id_user,
            $tanggal
        );
        $data['cuti'] = $this->user_model->get_cuti_data_byuser($id_user);
        $data['id_user'] = $id_user;
        $data['absens'] = $this->user_model->get_absensi_by_user_date(
            $id_user,
            $tanggal
        );
        $data[
            'absen_pulang'
        ] = $already_absent_pulang = $this->user_model->cek_absen_pulang(
            $id_user,
            $tanggal
        );
        $this->load->view('page/user/dashboard', $data);
    }

    public function sidebar()
    {
        $id_user = $this->session->userdata('id');
        $data['user'] = $this->user_model->getUserByID($id_user);
        $this->load->view('components/sidebar_user', $data);
    }

    public function absen()
    {
        sidebar();
        $data = ['page' => 'absensi'];
        setlocale(LC_TIME, 'id_ID');
        date_default_timezone_set('Asia/Jakarta');
        $username = $this->session->userdata('username');
        $currentDateTime = date('d F Y H:i:s');
        $currentHour = date('H', strtotime($currentDateTime));
        $date = date('l, d F Y', strtotime($currentDateTime));
        $greeting = '';

        if ($currentHour >= 1 && $currentHour < 10) {
            $greeting = 'Selamat Pagi';
        } elseif ($currentHour >= 10 && $currentHour < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($currentHour >= 15 && $currentHour < 19) {
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }

        // Melewatkan variabel ke view menggunakan array
        $data = [
            'username' => $username,
            'greeting' => $greeting,
            'date' => $date,
        ];

        $this->load->view('page/user/absen', $data);
    }

    public function cuti()
    {
        sidebar();
        $data = ['page' => 'cuti'];
        $this->load->view('page/user/cuti', $data);
    }

    public function lembur()
    {
        sidebar();
        $data = ['page' => 'lembur'];

        $this->load->view('page/user/lembur', $data);
    }

    public function history_lembur()
    {
        sidebar();
        $data = ['page' => 'history_lembur'];
        $id_user = $this->session->userdata('id');
        $lembur_data = $this->user_model->getAllArrayData();

        // Memproses data lembur untuk mengonversi id_user menjadi username
        foreach ($lembur_data as $key => $row) {
            // Pisahkan nilai id_user menjadi array id-user individual
            $id_users = explode(',', $row['id_user']);

            // Untuk setiap id-user individual, ambil username yang sesuai dari tabel user
            $usernames = [];
            foreach ($id_users as $id_user) {
                // Ambil username dari tabel user berdasarkan id_user
                $username = $this->user_model->getUsernameById($id_user);
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
        $this->load->view('page/user/history_lembur', $data);
    }

    public function ajukan_lembur()
    {
        sidebar();
        $id_user_login = $this->session->userdata('id');

        // Ambil array ID user yang dipilih dari form
        $id_user_selected_string = $this->input->post('selected_users');

        $id_organisasi = $this->user_model->get_id_organisasi($id_user_login);

        $data = [
            'id_user' => $id_user_selected_string,
            'keterangan_lembur' => $this->input->post('keterangan_lembur'),
            'tanggal_lembur' => $this->input->post('tanggal_lembur'),
            'jam_mulai' => $this->input->post('jam_mulai'),
            'jam_selesai' => $this->input->post('jam_selesai'),
            'id_organisasi' => $id_organisasi,
        ];

        $this->user_model->tambah_data('lembur', $data);

        redirect(base_url('user/history_lembur'));
    }

    public function pulang()
    {
        sidebar();
        $data = ['page' => 'pulang'];
        setlocale(LC_TIME, 'id_ID');
        date_default_timezone_set('Asia/Jakarta');
        $username = $this->session->userdata('username');
        $currentDateTime = date('d F Y H:i:s');
        $currentHour = date('H', strtotime($currentDateTime));
        $date = date('l, d F Y', strtotime($currentDateTime));
        $greeting = '';

        if ($currentHour >= 1 && $currentHour < 10) {
            $greeting = 'Selamat Pagi';
        } elseif ($currentHour >= 10 && $currentHour < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($currentHour >= 15 && $currentHour < 19) {
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }

        // Melewatkan variabel ke view menggunakan array
        $data = [
            'username' => $username,
            'greeting' => $greeting,
            'date' => $date,
        ];
        // $data['absensi'] = $this->user_model->getAbsensiById($id_absensi);
        $this->load->view('page/user/pulang', $data);
    }

    public function profile()
    {
        sidebar();
        $data = ['page' => 'profile'];
        if ($this->session->userdata('id')) {
            $user_id = $this->session->userdata('id');
            $id_admin = $this->session->userdata('id_admin');
            $data = [
                'id_jabatan' => $this->session->userdata('id_jabatan'),
                'id_shift' => $this->session->userdata('id_shift'),
                'id_organisasi' => $this->session->userdata('id_organisasi'),
            ];
            $data['shift'] = $this->user_model->getShiftByIdAdmin($id_admin);
            $data['jabatan'] = $this->user_model->getJabatanByIdAdmin(
                $id_admin
            );
            $data['organisasi'] = $this->user_model
                ->get_data('organisasi')
                ->result();
            $data['user'] = $this->user_model->getUserByID($user_id);
            $this->load->view('page/user/profile', $data);
        } else {
            redirect('auth');
        }
    }

    public function edit_profile()
    {
        sidebar();
        $email = $this->input->post('email');
        $username = $this->input->post('username');
        // $id_organisasi = $this->input->post('id_organisasi');
        $id_jabatan = $this->input->post('id_jabatan');
        $id_shift = $this->input->post('id_shift');

        if ($id_jabatan && $id_shift) {
            $data = [
                'email' => $email,
                'username' => $username,
                // 'id_organisasi' => $id_organisasi,
                'id_jabatan' => $id_jabatan,
                'id_shift' => $id_shift,
            ];

            $this->session->set_userdata($data);

            $update_result = $this->user_model->update_data('user', $data, [
                'id_user' => $this->session->userdata('id'),
            ]);

            if ($update_result) {
                $this->session->set_flashdata(
                    'berhasil_ubah_foto',
                    'Data berhasil diperbarui'
                );
            } else {
                $this->session->set_flashdata(
                    'gagal_update',
                    'Gagal memperbarui data. Silakan cek log atau hubungi administrator.'
                );
            }
        } else {
            // Handle kesalahan jika nilai-nilai tidak valid
            $this->session->set_flashdata(
                'gagal_update',
                'Nilai yang diberikan tidak valid'
            );
        }

        redirect(base_url('user/profile'));
    }

    public function izin()
    {
        sidebar();
        $data = ['page' => 'izin'];
        setlocale(LC_TIME, 'id_ID');
        date_default_timezone_set('Asia/Jakarta');
        $username = $this->session->userdata('username');
        $currentDateTime = date('d F Y H:i:s');
        $currentHour = date('H', strtotime($currentDateTime));
        $date = date('l, d F Y', strtotime($currentDateTime));
        $time = date('H:i', strtotime($currentDateTime));
        $greeting = '';

        if ($currentHour >= 1 && $currentHour < 10) {
            $greeting = 'Selamat Pagi';
        } elseif ($currentHour >= 10 && $currentHour < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($currentHour >= 15 && $currentHour < 19) {
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }

        // Melewatkan variabel ke view menggunakan array
        $data = [
            'username' => $username,
            'greeting' => $greeting,
            'date' => $date,
            'time' => $time,
        ];

        $this->load->view('page/user/izin', $data);
    }

    public function izin_absen($id_absensi)
    {
        sidebar();
        $data = ['page' => 'izin_absen'];
        $absensi = $this->user_model->get_absensi_by_id($id_absensi); // Ganti dengan metode yang sesuai di model Anda

        setlocale(LC_TIME, 'id_ID');
        date_default_timezone_set('Asia/Jakarta');
        $username = $this->session->userdata('username');
        $currentDateTime = date('d F Y H:i:s');
        $currentHour = date('H', strtotime($currentDateTime));
        $date = date('l, d F Y', strtotime($currentDateTime));
        $time = date('H:i', strtotime($currentDateTime));
        $greeting = '';

        if ($currentHour >= 1 && $currentHour < 10) {
            $greeting = 'Selamat Pagi';
        } elseif ($currentHour >= 10 && $currentHour < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($currentHour >= 15 && $currentHour < 19) {
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }

        // Melewatkan variabel ke view menggunakan array
        $data = [
            'username' => $username,
            'greeting' => $greeting,
            'date' => $date,
            'time' => $time,
            'absensi' => $absensi,
        ];

        $this->load->view('page/user/izin_absen', $data);
    }

    public function aksi_absen()
    {
        $id_user = $this->session->userdata('id');
        $email = $this->session->userdata('email');
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y-m-d');
        $jam_masuk = date('H:i:s');

        // Check jika user sudah melakukan absen atau izin pada hari ini
        $already_absent = $this->user_model->cek_absen_masuk(
            $id_user,
            $tanggal
        );
        $already_requested = $this->user_model->cek_izin($id_user, $tanggal);

        // Periksa absensi terlambat atau lebih awal berdasarkan shift
        $shiftInfo = $this->user_model->get_shift_info($id_user);
        $shiftStart = strtotime($shiftInfo['jam_masuk']);
        $shiftEnd = strtotime($shiftInfo['jam_pulang']);

        $absensiTimestamp = strtotime($jam_masuk);

        if ($already_absent) {
            // Handle jika sudah melakukan absen
            $this->session->set_flashdata(
                'gagal_absen',
                'Anda sudah melakukan absen hari ini.'
            );
            redirect(base_url('user'));
        } elseif ($already_requested) {
            // Handle jika sudah mengajukan izin
            $this->session->set_flashdata(
                'gagal_absen',
                'Anda sudah mengajukan izin hari ini.'
            );
            redirect(base_url('user'));
        } else {
            // Lakukan proses absen
            $lokasi_masuk = $this->input->post('lokasi_masuk');
            $image_data = $this->input->post('image_data');

            // Konversi data URL ke gambar dan simpan di server
            $img = str_replace('data:image/png;base64,', '', $image_data);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);

            $foto_masuk = './images/foto_masuk/' . uniqid() . '.png'; // Ganti dengan ekstensi yang sesuai
            file_put_contents($foto_masuk, $data);

            // Verifikasi status absen
            if ($absensiTimestamp < $shiftStart) {
                $status_absen = 'Lebih Awal';
            } else {
                $status_absen = 'Terlambat';
            }

            // Data untuk disimpan ke dalam database
            $data = [
                'id_user' => $id_user,
                'tanggal_absen' => $tanggal,
                'keterangan_izin' => '-',
                'jam_masuk' => $jam_masuk,
                'foto_masuk' => $foto_masuk,
                'lokasi_masuk' => $lokasi_masuk,
                'keterangan_terlambat' => $this->input->post(
                    'keterangan_terlambat'
                ),
                'jam_pulang' => '00:00:00',
                'foto_pulang' => '-',
                'lokasi_pulang' => '-',
                'status' => 0,
                'status_absen' => $status_absen, // Memasukkan status absen
            ];

            // Menyisipkan data absen ke dalam database
            $inserted = $this->user_model->tambah_data('absensi', $data);

            if ($inserted) {
                // Handle jika berhasil absen
                $this->session->set_flashdata(
                    'berhasil_absen',
                    'Berhasil Absen.'
                );

                redirect(base_url('user'));
            } else {
                // Handle jika gagal absen
                $this->session->set_flashdata(
                    'gagal_absen',
                    'Gagal Absen. Silakan coba lagi.'
                );
                redirect(base_url('user'));
            }
        }
    }

    public function aksi_pulang()
    {
        $id_user = $this->session->userdata('id');
        $tanggal = date('Y-m-d');
        // $jam_pulang = date('H:i:s');
        date_default_timezone_set('Asia/Jakarta');

        // Check jika user sudah melakukan absen masuk pada hari ini
        $already_absent = $this->user_model->cek_absen_masuk(
            $id_user,
            $tanggal
        );
        // var_dump($already_absent);

        if ($already_absent) {
            $image_data = $this->input->post('image_data');
            $lokasi_pulang = $this->input->post('lokasi_pulang');
            $keterangan_pulang_awal = $this->input->post(
                'keterangan_pulang_awal'
            );

            // Image processing and file handling for the pulang photo
            $img = str_replace('data:image/png;base64,', '', $image_data);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);

            $foto_pulang = './images/foto_pulang/' . uniqid() . '.png';
            file_put_contents($foto_pulang, $data);

            // Update status absen pulang
            $data_pulang = [
                'status' => 1,
                'jam_pulang' => date('H:i:s'),
                'foto_pulang' => $foto_pulang,
                'lokasi_pulang' => $lokasi_pulang,
                'keterangan_pulang_awal' => $keterangan_pulang_awal,
            ];

            $this->user_model->updateStatusAbsenPulang(
                $id_user,
                $tanggal,
                $data_pulang
            );

            // Set flashdata for berhasil pulang
            $this->session->set_flashdata('berhasil_pulang', 'Berhasil Pulang');
            redirect('user');
        } else {
            // Set flashdata for gagal pulang
            $this->session->set_flashdata(
                'gagal_pulang',
                'Anda tidak bisa melakukan absen pulang sekarang.'
            );
            redirect('user');
        }
    }

    // public function aksi_pulang()
    // {
    //     $id_user = $this->session->userdata('id');
    //     $tanggal = date('Y-m-d');

    //     // Check jika user sudah melakukan absen masuk pada hari ini
    //     $already_absent_masuk = $this->user_model->cek_absen_masuk($id_user, $tanggal);

    //     if (!$already_absent_masuk) {
    //         // Set flashdata for gagal pulang
    //         $this->session->set_flashdata('gagal_pulang', 'Anda belum melakukan absen masuk hari ini.');
    //         redirect('user');
    //     } else {
    //         // Check jika user sudah melakukan absen pulang pada hari ini
    //         $already_absent_pulang = $this->user_model->cek_absen_pulang($id_user, $tanggal);

    //         if ($already_absent_pulang) {
    //             // Set flashdata for gagal pulang
    //             $this->session->set_flashdata('gagal_pulang', 'Anda sudah melakukan absen pulang hari ini.');
    //             redirect('user');
    //         }

    //         // Lanjutkan dengan proses absen pulang
    //         $image_data = $this->input->post('image_data');
    //         $lokasi_pulang = $this->input->post('lokasi_pulang');
    //         $keterangan_pulang_awal = $this->input->post('keterangan_pulang_awal');

    //         // Image processing and file handling for the pulang photo
    //         $img = str_replace('data:image/png;base64,', '', $image_data);
    //         $img = str_replace(' ', '+', $img);
    //         $data = base64_decode($img);

    //         $foto_pulang = './images/foto_pulang/' . uniqid() . '.png';
    //         file_put_contents($foto_pulang, $data);

    //         // Update status absen pulang
    //         $data = [
    //             'status' => 1,
    //             'jam_pulang' => date('H:i:s'),
    //             'foto_pulang' => $foto_pulang,
    //             'lokasi_pulang' => $lokasi_pulang,
    //             'keterangan_pulang_awal' => $keterangan_pulang_awal,
    //         ];

    //         $this->user_model->updateStatusAbsenPulang($id_user, $tanggal, $data);

    //         // Set flashdata for berhasil pulang
    //         $this->session->set_flashdata('berhasil_pulang', 'Berhasil Pulang');
    //         redirect('user');
    //     }
    // }

    public function aksi_izin()
    {
        $id_user = $this->session->userdata('id');
        $email = $this->session->userdata('email');
        $tanggal = date('Y-m-d');

        // Check jika user sudah melakukan absen atau izin pada hari ini
        $already_absent = $this->user_model->cek_absen_masuk(
            $id_user,
            $tanggal
        );
        $already_requested = $this->user_model->cek_izin($id_user, $tanggal);

        if ($already_requested) {
            $this->session->set_flashdata(
                'gagal_izin',
                'Anda sudah mengajukan izin hari ini.'
            );
            redirect(base_url('user/history_absensi'));
        } elseif ($already_absent) {
            $this->session->set_flashdata(
                'gagal_izin',
                'Anda sudah melakukan absen hari ini.'
            );
            redirect(base_url('user/history_absensi'));
        } else {
            // Lakukan proses pengajuan izin
            $keterangan_izin = $this->input->post('keterangan_izin');

            if (!empty($keterangan_izin)) {
                $data = [
                    'id_user' => $id_user,
                    'tanggal_absen' => $tanggal,
                    'keterangan_izin' => $keterangan_izin,
                    'jam_masuk' => '00:00:00',
                    'foto_masuk' => '-',
                    'jam_pulang' => '00:00:00',
                    'foto_pulang' => '-',
                    'lokasi_masuk' => '-',
                    'lokasi_pulang' => '-',
                    'status' => 1,
                    'status_absen' => 'Izin',
                ];

                // Menyisipkan data izin ke dalam database
                $this->user_model->tambah_data('absensi', $data);
                $this->session->set_flashdata(
                    'berhasil_izin',
                    'Berhasil Izin.'
                );

                redirect(base_url('user/history_absensi'));
            } else {
                $this->session->set_flashdata(
                    'gagal_izin',
                    'Gagal Izin. Keterangan Izin tidak boleh kosong.'
                );
                redirect(base_url('user/izin'));
            }
        }
    }

    // Aksi Cuti
    public function aksi_cuti()
    {
        $id_user = $this->session->userdata('id');
        $tanggal_sekarang = date('Y-m-d');

        $awal_cuti = $this->input->post('awal_cuti');
        $akhir_cuti = $this->input->post('akhir_cuti');
        $masuk_kerja = $this->input->post('masuk_kerja');
        $keperluan_cuti = $this->input->post('keperluan_cuti');
        $id_organisasi = $this->user_model->get_id_organisasi($id_user);
        $this->session->set_userdata('id_organisasi', $id_organisasi);

        // Periksa apakah data tidak kosong
        if (
            !empty($awal_cuti) &&
            !empty($akhir_cuti) &&
            !empty($masuk_kerja) &&
            !empty($keperluan_cuti) &&
            !empty($id_organisasi)
        ) {
            // Hitung jumlah cuti yang telah diajukan pada tahun ini
            $jumlah_cuti_setahun_ini = $this->user_model->hitung_cuti_setahun_ini(
                $id_user
            );

            // Jika jumlah cuti pada tahun ini masih kurang dari 2
            if ($jumlah_cuti_setahun_ini < 2) {
                $data = [
                    'id_user' => $id_user,
                    'awal_cuti' => $awal_cuti,
                    'akhir_cuti' => $akhir_cuti,
                    'masuk_kerja' => $masuk_kerja,
                    'keperluan_cuti' => $keperluan_cuti,
                    'status' => 'Diajukan',
                    'id_organisasi' => $id_organisasi,
                ];

                // Panggil model untuk menyimpan data cuti
                $this->user_model->tambah_data('cuti', $data);
                $this->session->set_flashdata(
                    'berhasil_cuti',
                    'Berhasil mengajukan cuti.'
                );

                redirect(base_url('user/history_cuti')); // Mengasumsikan 'user/history_cuti' adalah halaman untuk melihat riwayat cuti
            } else {
                // Tampilkan pesan kesalahan jika telah melebihi batas cuti dalam setahun
                $this->session->set_flashdata(
                    'gagal_cuti',
                    'Gagal mengajukan cuti. Anda telah mencapai batas cuti untuk tahun ini.'
                );
                redirect(base_url('user/history_cuti'));
            }
        } else {
            // Tampilkan pesan kesalahan jika ada data yang kosong
            $this->session->set_flashdata(
                'gagal_cuti',
                'Gagal mengajukan cuti. Semua field harus diisi.'
            );
            redirect(base_url('user/history_cuti'));
        }
    }

    public function aksi_ubah_detail_akun()
    {
        $image = $this->upload_image_user('image');

        $user_id = $this->session->userdata('id');
        $admin = $this->user_model->getUserByID($user_id);

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
                redirect(base_url('user/profile'));
            }
        }

        // Update the user data in the database
        $update_result = $this->user_model->update('user', $data, [
            'id_user' => $user_id,
        ]);

        if ($update_result) {
            $this->session->set_flashdata('message', 'Profil berhasil diubah');
        } else {
            $this->session->set_flashdata('message', 'Gagal mengubah profil');
        }

        redirect(base_url('user/profile'));
    }

    // Pembaruan password
    public function update_password()
    {
        $password_lama = $this->input->post('password_lama');
        $password_baru = $this->input->post('password_baru');
        $konfirmasi_password = $this->input->post('konfirmasi_password');

        $stored_password = $this->user_model->getPasswordById(
            $this->session->userdata('id')
        );

        if (md5($password_lama) != $stored_password) {
            $this->session->set_flashdata(
                'kesalahan_password_lama',
                'Password lama yang dimasukkan salah'
            );
        } else {
            if ($password_baru === $konfirmasi_password) {
                $update_result = $this->user_model->update_password(
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
        redirect(base_url('user/profile'));
    }

    public function upload_image_user($value)
    {
        // Mendapatkan ID pengguna dari sesi atau sumber lainnya
        $user_id = $this->session->userdata('id'); // Gantilah sesuai dengan sumber ID pengguna

        // Mendapatkan nama file foto saat ini
        $user = $this->user_model->getUserByID($user_id); // Gantilah dengan nama model dan metode yang sesuai
        $current_image = $user->image; // Pastikan memiliki properti image pada model

        // Generate kode unik untuk nama file baru
        $kode = round(microtime(true) * 1000);

        // Konfigurasi upload
        $config['upload_path'] = './images/user/';
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
                $image_path = './images/user/' . $current_image;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }

            // Kembalikan hasil upload baru
            return [true, $new_image];
        }
    }

    public function aksi_ubah_foto()
    {
        $image = $this->upload_image_user('image');
        $user_id = $this->session->userdata('id');
        $admin = $this->user_model->getUserByID($user_id);

        if ($image[0] == true) {
            $admin->image = $image[1];
        }

        $data = [
            'image' => $image[1],
        ];

        // Update foto di database
        $this->user_model->updateUserPhoto($user_id, $data);

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
        redirect(base_url('user/profile'));
    }

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
                $this->user_model->updateUserPassword($user_id, $data_password);
            } else {
                $this->session->set_flashdata(
                    'message',
                    'Password baru dan Konfirmasi password harus sama'
                );
                redirect(base_url('user/profile'));
            }
        }

        // Redirect ke halaman profile
        redirect(base_url('user/profile'));
    }

    public function history_cuti()
    {
        sidebar();
        $data = ['page' => 'history_cuti'];
        $id_user = $this->session->userdata('id');
        $data['cuti'] = $this->user_model->get_cuti_data_byuser($id_user);

        // Load the view
        $this->load->view('page/user/history_cuti', $data);
    }

    public function history_absensi()
    {
        sidebar();
        $data = ['page' => 'history_absensi'];
        $id_user = $this->session->userdata('id');
        $data['absensi'] = $this->user_model->get_absen_data($id_user);
        usort($data['absensi'], function ($a, $b) {
            return strtotime($b->tanggal_absen) - strtotime($a->tanggal_absen);
        });

        // Hitung jumlah terlambat dan lebih awal
        $jumlah_terlambat = $this->user_model->get_jumlah_status_absen(
            $id_user,
            'Terlambat'
        );
        $jumlah_lebih_awal = $this->user_model->get_jumlah_status_absen(
            $id_user,
            'Lebih Awal'
        );

        // Tambahkan variabel ke data
        $data['jumlah_terlambat'] = $jumlah_terlambat;
        $data['jumlah_lebih_awal'] = $jumlah_lebih_awal;

        // Load the view
        $this->load->view('page/user/history_absensi', $data);
    }

    private function calculateWorkingHours($start, $end)
    {
        $start_time = strtotime($start);
        $end_time = strtotime($end);
        $diff = $end_time - $start_time;
        $hours = floor($diff / (60 * 60)); // Calculate hours
        $minutes = floor(($diff - $hours * 60 * 60) / 60); // Calculate minutes
        return sprintf('%02d:%02d', $hours, $minutes); // Format output
    }

    public function detail_absensi($id_absensi)
    {
        sidebar();
        $data = ['page' => 'detail_absensi'];
        $data['absensi'] = $this->user_model->getAbsensiDetail($id_absensi);
        $this->load->view('page/user/detail_absensi', $data);
    }

    public function aksi_batal_cuti($id_cuti)
    {
        $deleted_rows = $this->user_model->hapus_cuti($id_cuti);

        if ($deleted_rows > 0) {
            $this->session->set_flashdata(
                'gagal_batal',
                'Gagal membatalkan cuti'
            );
        } else {
            $this->session->set_flashdata(
                'berhasil_batal',
                'Berhasil membatalkan cuti'
            );
        }

        // Redirect ke halaman setelah pembaruan data
        redirect(base_url('user/history_cuti')); // Sesuaikan dengan halaman yang diinginkan setelah pembaruan data Admin
    }

    public function aksi_ajukan_cuti($id_cuti)
    {
        $id_cuti = $this->input->post('id_cuti');
        // Buat data yang akan diupdate
        $data = [
            'status' => 'Diajukan',
            // Tambahkan field lain jika ada
        ];

        // Lakukan pembaruan data Admin
        $eksekusi = $this->user_model->update('cuti', $data, $id_cuti);
        $this->session->set_flashdata(
            'berhasil_ajukan',
            'Berhasil Mengajukan cuti kembali'
        );

        // Redirect ke halaman setelah pembaruan data
        redirect(base_url('user/history_cuti')); // Sesuaikan dengan halaman yang diinginkan setelah pembaruan data Admin
    }

    public function aksi_batal_lembur($id_lembur)
    {
        $deleted_rows = $this->user_model->hapus_lembur($id_lembur);

        if ($deleted_rows > 0) {
            $this->session->set_flashdata(
                'gagal_batal',
                'Gagal membatalkan lembur'
            );
        } else {
            $this->session->set_flashdata(
                'berhasil_batal',
                'Berhasil membatalkan lembur'
            );
        }

        // Redirect ke halaman setelah pembaruan data
        redirect(base_url('user/history_lembur')); // Sesuaikan dengan halaman yang diinginkan setelah pembaruan data Admin
    }

    public function aksi_izin_tengah_hari()
    {
        $id_absensi = $this->input->post('id_absensi');
        $keterangan_izin = $this->input->post('keterangan_izin');

        // Pastikan nilai id_absensi dan keterangan_izin tidak kosong
        if (!empty($id_absensi) && !empty($keterangan_izin)) {
            // Buat data yang akan diupdate
            $data = [
                'keterangan_izin' => $keterangan_izin,
                'status' => 1, // Update status absensi menjadi true
                // Tambahkan field lain jika ada
            ];

            // Lakukan pembaruan data Absensi
            $eksekusi = $this->user_model->update_izin(
                'absensi',
                $data,
                $id_absensi
            );

            if ($eksekusi) {
                $this->session->set_flashdata(
                    'berhasil_ajukan',
                    'Berhasil Mengajukan cuti kembali'
                );
            } else {
                $this->session->set_flashdata(
                    'gagal_ajukan',
                    'Gagal Mengajukan cuti'
                );
            }
        } else {
            $this->session->set_flashdata(
                'gagal_ajukan',
                'ID Absensi atau Keterangan Izin tidak valid'
            );
        }

        // Redirect ke halaman setelah pembaruan data
        redirect(base_url('user/history_absensi')); // Sesuaikan dengan halaman yang diinginkan setelah pembaruan data Absensi
    }

    public function batal_izin($id_absensi)
    {
        // Panggil model untuk membatalkan izin
        $result = $this->user_model->cancel_permission($id_absensi);

        if ($result) {
            // Izin berhasil dibatalkan
            echo 'Izin berhasil dibatalkan.';
        } else {
            // Ada kesalahan saat membatalkan izin
            echo 'Gagal membatalkan izin. Silakan coba lagi.';
        }
        redirect(base_url('user/history_absensi')); // Sesuaikan dengan halaman yang diinginkan setelah pembaruan data Absensi
    }

    public function izin_terlambat()
    {
        setlocale(LC_TIME, 'id_ID');
        date_default_timezone_set('Asia/Jakarta');
        $username = $this->session->userdata('username');
        $currentDateTime = date('d F Y H:i:s');
        $currentHour = date('H', strtotime($currentDateTime));
        $date = date('l, d F Y', strtotime($currentDateTime));
        $time = date('H:i', strtotime($currentDateTime));
        $greeting = '';

        if ($currentHour >= 1 && $currentHour < 10) {
            $greeting = 'Selamat Pagi';
        } elseif ($currentHour >= 10 && $currentHour < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($currentHour >= 15 && $currentHour < 19) {
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }

        // Melewatkan variabel ke view menggunakan array
        $data = [
            'username' => $username,
            'greeting' => $greeting,
            'date' => $date,
            'time' => $time,
        ];

        $this->load->view('page/user/izin_terlambat', $data);
    }
}