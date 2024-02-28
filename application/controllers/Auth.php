<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Auth extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('m_model');
    }

    public function index()
    {
        // Cek apakah pengguna sudah login
        if ($this->session->userdata('logged_in') === true) {
            // Jika sudah login, arahkan ke halaman yang sesuai dengan peran pengguna
            $role = $this->session->userdata('role');
            if ($role == 'superadmin') {
                redirect(base_url('superadmin'));
            } elseif ($role == 'admin') {
                redirect(base_url('admin'));
            } elseif ($role == 'user') {
                redirect(base_url('user'));
            }
        }

        // Jika belum login, tampilkan halaman login
        $this->load->view('auth/login');
    }

    public function register()
    {
        $data['organisasi'] = $this->m_model->get_data('organisasi')->result();
        $this->load->view('auth/register', $data);
    }

    public function register_user()
    {
        $data['organisasi'] = $this->m_model->get_data('organisasi')->result();
        $this->load->view('auth/register_user', $data);
    }

    // Aksi register untuk registrasi superadmin
    public function aksi_register_superadmin()
    {
        $username = $this->input->post('username', true);
        $email = $this->input->post('email', true);
        $password = $this->input->post('password', true);

        // Validasi input
        if (empty($username) || empty($password)) {
            // Tampilkan pesan error jika ada input yang kosong
            $this->session->set_flashdata('error', 'Semua field harus diisi.');
            redirect(base_url() . 'auth/register'); // sesuaikan dengan URL halaman registrasi .
        } elseif (strlen($password) < 8) {
            $this->session->set_flashdata(
                'register_error',
                'Password minimal 8 huruf.'
            );
            redirect(base_url('auth/register'));
        } else {
            // Check if superadmin already exists
            if ($this->m_model->is_superadmin_registered($username, $email)) {
                $this->session->set_flashdata(
                    'register_error',
                    'Superadmin sudah terdaftar.'
                );
                redirect(base_url('auth/register'));
            }

            // Data for new superadmin
            $data = [
                'username' => $username,
                'email' => $email,
                'image' => 'User.png',
                'password' => md5($password), // Simpan kata sandi yang telah di-MD5
                'role' => 'superadmin', // Atur peran menjadi superadmin
            ];

            // Save superadmin data to the database
            $this->m_model->tambah_data('superadmin', $data);
            $this->session->set_flashdata(
                'register_success',
                'Registrasi berhasil, Silakan login.'
            );

            // Redirect to login page after successful registration
            redirect(base_url() . ''); // sesuaikan dengan URL halaman login
        }
    }

    // Aksi register user
    public function aksi_register_user()
    {
        $username = $this->input->post('username', true);
        $email = $this->input->post('email', true);
        $password = $this->input->post('password', true);
        $id_organisasi = $this->input->post('id_organisasi', true);

        // Validasi input
        if (empty($username) || empty($password)) {
            // Tampilkan pesan error jika ada input yang kosong
            $this->session->set_flashdata('error', 'Semua field harus diisi.');
            redirect(base_url() . 'auth/register'); // sesuaikan dengan URL halaman registrasi .
        } elseif (strlen($password) < 8) {
            $this->session->set_flashdata(
                'register_error',
                'Password minimal 8 huruf.'
            );
            redirect(base_url('auth/register'));
        } else {
            // Check if username or email already exists
            if ($this->m_model->is_user_registered($username, $email)) {
                $this->session->set_flashdata(
                    'register_error',
                    'Username atau email sudah terdaftar.'
                );
                redirect(base_url('auth/register'));
            }

            // Data for new user
            $data = [
                'username' => $username,
                'email' => $email,
                'image' => 'User.png',
                'password' => md5($password), // Simpan kata sandi yang telah di-MD5
                'id_organisasi' => $id_organisasi,
                'id_admin' => $this->m_model->get_admin_id($id_organisasi),
                'image' => 'User.png',
                'role' => 'user',
            ];

            // Save user data to the database
            $this->m_model->tambah_data('user', $data);
            $this->session->set_flashdata(
                'register_success',
                'Registrasi berhasil, Silakan login.'
            );

            // Redirect to login page after successful registration
            redirect(base_url() . ''); // sesuaikan dengan URL halaman login
        }
    }

    public function aksi_login()
    {
        // Mengambil data email dan password yang dikirimkan melalui form login.
        $email = $this->input->post('email', true);
        $password = $this->input->post('password', true);

        // Mencari data pengguna di tiga tabel yang mungkin memiliki pengguna dengan alamat email yang sesuai.
        $tables = ['superadmin', 'admin', 'user'];

        foreach ($tables as $table) {
            // Membuat array $data untuk mencari pengguna berdasarkan alamat email.
            $data = [
                'email' => $email,
            ];

            // Mencari data pengguna dengan alamat email yang sesuai dalam database.
            $query = $this->m_model->getwhere($table, $data);
            // Mengambil hasil pencarian dalam bentuk array asosiatif.
            $result = $query->row_array();

            // Memeriksa apakah hasil pencarian tidak kosong dan kata sandi cocok.
            if (!empty($result) && md5($password) === $result['password']) {
                // Jika berhasil login:

                // Membuat array $data_sess untuk sesi pengguna.
                $data_sess = [
                    'logged_in' => true, // Menandakan bahwa pengguna sudah login.
                    'email' => $result['email'],
                    'username' => $result['username'],
                    'role' => $result['role'], // Menyimpan peran pengguna (admin/karyawan).
                    'image' => $result['image'],
                    'id' => $result['id_' . $table], // Mendapatkan ID pengguna dari tabel yang tepat.
                    'id_organisasi' => $result['id_organisasi'],
                    'id_shift' => $result['id_shift'],
                    'id_jabatan' => $result['id_jabatan'],
                    'id_admin' => $result['id_admin'],
                ];
                // Mengatur data sesi pengguna dengan informasi di atas.
                $this->session->set_userdata($data_sess);
                $this->session->set_flashdata(
                    'login_success',
                    'Selamat Datang Di Absensi.'
                );

                // Mengarahkan pengguna ke halaman berdasarkan peran mereka.
                redirect(base_url() . $table);
            }
        }

        // Jika tidak ada pengguna yang cocok dengan email dan kata sandi yang diberikan.
        $this->session->set_flashdata('login_error', 'Silahkan coba kembali.');
        redirect(base_url() . ''); // Mengarahkan pengguna kembali ke halaman login.
    }

    // Aksi logout
    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url(''));
    }

    public function lupa_password()
    {
        $this->load->view('auth/lupa_password', $data);
    }

    public function send_reset_email()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules(
            'email',
            'Email',
            'trim|required|valid_email'
        );

        if ($this->form_validation->run() === false) {
            $response = [
                'status' => 'error',
                'message' => validation_errors(),
            ];
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }

        $email = $this->input->post('email');
        $user = $this->m_model->get_user_by_email($email);

        if (!$user) {
            $response = [
                'status' => 'error',
                'message' => 'User not found.',
            ];
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }

        $token = bin2hex(random_bytes(32));
        $this->m_model->set_reset_token($user['id_user'], $token);

        try {
            require 'vendor/autoload.php'; // Load PHPMailer library

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mingave11@gmail.com'; // Ganti dengan alamat email Anda
            $mail->Password = 'loqg vjnb kotu ekye'; // Ganti dengan kata sandi email Anda
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            $resetLink = base_url('auth/reset_password/' . $token);

            $mail->setFrom('mingave11@gmail.com', 'Absensi App');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Reset Password';
            $mail->Body =
                '
            <html>
            <head>
                <title>Reset Password</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 20px;
                    }
                    .container {
                        background-color: #ffffff;
                        border-radius: 5px;
                        padding: 20px;
                        box-shadow: 0 0 10px rgba(0,0,0,0.1);
                    }
                    .button {
                        border: 1px solid #7B66FF;
                        color: white;
                        padding: 10px 20px;
                        text-align: center;
                        text-decoration: none;
                        display: inline-block;
                        font-size: 16px;
                        border-radius: 5px;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h2 style="color: #000000;">Reset Your Password</h2>
                    <p>You have requested to reset your password. Click the button below to proceed:</p>
                    <a class="button" href="' .
                $resetLink .
                '">Reset Password</a>
                </div>
            </body>
            </html>
        ';

            $mail->send();

            $response = [
                'status' => 'success',
                'message' => 'Email sent successfully!',
            ];
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        } catch (Exception $e) {
            $response = [
                'status' => 'error',
                'message' => 'Failed to send email. ' . $e->getMessage(),
            ];
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }
    }

    public function reset_password($token = null)
    {
        if ($token) {
            $user = $this->m_model->get_user_by_reset_token($token);

            if ($user && strtotime($user['token_expiration']) > time()) {
                $this->load->view('auth/reset_password', ['token' => $token]);
            } else {
                echo 'Invalid or expired token';
            }
        } else {
            echo 'Invalid token';
        }
    }

    public function update_password()
    {
        $token = $this->input->post('token');
        $password_baru = $this->input->post('password_baru');
        $konfirmasi_password = $this->input->post('konfirmasi_password');

        // Validasi password dan konfirmasi password
        $this->form_validation->set_rules(
            'password_baru',
            'Password Baru',
            'required|min_length[6]'
        );
        $this->form_validation->set_rules(
            'konfirmasi_password',
            'Konfirmasi Password',
            'required|matches[password_baru]'
        );

        if ($this->form_validation->run() == false) {
            // Handle validation errors
            $response = [
                'status' => 'error',
                'message' => validation_errors(),
            ];
            echo json_encode($response);
        } else {
            $user = $this->m_model->get_user_by_reset_token($token);

            if ($user && strtotime($user['token_expiration']) > time()) {
                // Reset token expiration to invalidate the token
                $this->m_model->set_reset_token($user['id_user'], null);

                // Update password using MD5 (not recommended for production)
                $this->m_model->update_password(
                    $user['id_user'],
                    md5($password_baru)
                );

                $response = [
                    'status' => 'success',
                    'message' => 'Password updated successfully!',
                ];
                echo json_encode($response);
            } else {
                // Token is invalid or expired
                $response = [
                    'status' => 'error',
                    'message' => 'Invalid or expired token.',
                ];
                echo json_encode($response);
            }
        }
    }
}
?>