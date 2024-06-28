<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MahasiswaModel;
use App\Models\DosenTendikModel;
use CodeIgniter\I18n\Time;
use Config\Services;


class Auth extends BaseController
{
    protected $userModel;
    protected $mahasiswaModel;
    protected $dosenTendikModel;

    public function __construct()
    {

        $this->userModel = new UserModel();
        $this->mahasiswaModel = new MahasiswaModel();
        $this->dosenTendikModel = new DosenTendik();
    }

    public function index()
    {


        session();
        // $password = "2822020"; // Ganti dengan kata sandi yang ingin Anda hash
        // // Membuat hash dari kata sandi
        // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // // Output hash kata sandi
        // echo "Hashed Password: " . $hashedPassword;
        $csrfToken = csrf_hash();
        $data = [
            'judul' => 'SIM Laboratorium Keperawatan',
            'csrfToken' => $csrfToken  // Sertakan token CSRF dalam data
        ];

        // Kirim data berita ke view atau lakukan hal lain sesuai kebutuhan
        return view('masuk', $data);
    }

    public function login()
    {
        $userModel = new UserModel();

        $username = $this->request->getPost('user_nama');
        $password = $this->request->getPost('user_password');
        $ipAddress = $this->request->getIPAddress(); // Dapatkan alamat IP pengguna

        // Periksa autentikasi dengan username dan password pada tabel tbl_user
        $cek = $userModel->get_data($username, $password);

        if ($cek !== null) {
            // Autentikasi berhasil, lanjutkan dengan menyimpan session dan mengarahkan pengguna ke dashboard
            // Simpan alamat IP ke dalam database
            $userModel->updateUser($cek['id'], ['ip_address' => $ipAddress]);

            // Set session data
            $session = session();
            $session->set('user_nama', $cek['user_nama']);
            $session->set('id', $cek['id']);
            $session->set('full_nama', $cek['full_nama']);
            $session->set('level', $cek['level']);
            $session->set('last_activity', time());
            $session->set('expiration', 3600);

            // SweetAlert untuk memberitahu login berhasil
            $session->setFlashdata('pesanMasuk', 'Login berhasil! Selamat datang, ' . $cek['full_nama']);

            // Redirect ke dashboard sesuai level
            if ($cek['level'] == 'Admin') {
                // Jika admin, arahkan ke /adminpanel
                return redirect()->to('/adminpanel');
            } else {
                // Jika bukan admin, arahkan ke /dashboard
                return redirect()->to('/dashboard');
            }
        } else {
            // Autentikasi gagal dengan username dan password
            // Set pesan kesalahan
            $session = session();
            $session->setFlashdata('pesanMasuk', 'Login gagal. Periksa Username dan Password anda.');
            return redirect()->to('/');
        }
    }





    public function keluar()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function forgotPasswordForm()
    {
        return view('lupa_password'); // Nama file view untuk form lupa password
    }

    public function sendResetLink()
    {
        // Validasi input email
        if (!$this->validate(['email' => 'required|valid_email'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan.');
        }

        // Generate token reset dan simpan ke database
        $token = bin2hex(random_bytes(32));
        $userModel->update($user['id'], [
            'reset_token' => $token,
            'reset_token_expiry' => Time::now()->addMinutes(5)->toDateTimeString() // Token expires in 2 minutes
        ]);

        // Kirim email reset password
        $resetLink = base_url("lupa-password/reset/{$token}");
        $message = "
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;'>
        <h2 style='color: #333;'>Reset Password Anda</h2>
        <p>Anda telah meminta untuk mereset password akun Anda di SIM Laboratorium Akper YKY. Klik tombol di bawah ini untuk melanjutkan proses reset password:</p>
        <p style='text-align: center;'>
            <a href='{$resetLink}' style='display: inline-block; padding: 10px 20px; color: #fff; background-color: #007bff; border-radius: 5px; text-decoration: none;'>Reset Password</a>
        </p>
         <p>Token diatas .</p>
        <p>Jika Anda tidak meminta reset password ini, Anda dapat mengabaikan email ini.</p>
        <p>Terima kasih,</p>
        <p>Tim SIM Lab YKY</p>
    </div>";

        // Gunakan layanan email dari CodeIgniter
        $emailService = Services::email();
        $emailService->setTo($email);
        $emailService->setFrom('notifikasi@jimbling.my.id', 'Reset Password SIM Lab YKY');
        $emailService->setSubject('Reset Password');
        $emailService->setMessage($message);
        $emailService->setMailType('html'); // Set tipe pesan ke HTML

        if ($emailService->send()) {
            return redirect()->back()->with('success', 'Email reset password telah dikirim.');
        } else {
            return redirect()->back()->with('error', 'Gagal mengirim email. Silakan coba lagi.');
        }
    }



    // Menampilkan form untuk memasukkan password baru
    public function resetPassword($token)
    {
        $userModel = new UserModel();
        $user = $userModel->where('reset_token', $token)
            ->where('reset_token_expiry >', Time::now()->toDateTimeString())
            ->first();

        if (!$user) {
            return redirect()->to('/lupa-password')->with('error', 'Token tidak valid atau telah kedaluwarsa.');
        }

        return view('recovery_password', ['token' => $token]);
    }

    // Memproses dan menyimpan password baru
    public function processResetPassword()
    {
        // Definisikan aturan validasi
        $validationRules = [
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[8]|max_length[20]|regex_match[/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,20}$/]',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                    'min_length' => 'Password minimal terdiri dari 8 karakter.',
                    'max_length' => 'Password maksimal terdiri dari 20 karakter.',
                    'regex_match' => 'Password harus mengandung setidaknya satu huruf besar, satu huruf kecil, dan satu angka.'
                ]
            ],
            'confirm_password' => [
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password wajib diisi.',
                    'matches' => 'Konfirmasi password tidak cocok dengan password.'
                ]
            ],
            'token' => [
                'label' => 'Token',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Token reset password tidak valid atau telah kedaluwarsa.'
                ]
            ]
        ];

        // Lakukan validasi
        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil data dari form
        $password = $this->request->getPost('password');
        $token = $this->request->getPost('token');

        $userModel = new UserModel();
        $user = $userModel->where('reset_token', $token)
            ->where('reset_token_expiry >', Time::now()->toDateTimeString())
            ->first();

        if (!$user) {
            return redirect()->to('/user/forgotPassword')->with('error', 'Token tidak valid atau telah kedaluwarsa.');
        }

        // Perbarui password pengguna
        $userModel->update($user['id'], [
            'user_password' => password_hash($password, PASSWORD_DEFAULT),
            'reset_token' => null,
            'reset_token_expiry' => null
        ]);

        return redirect()->to('/')->with('success', 'Password Anda telah berhasil direset. Silakan login dengan password baru Anda.');
    }
}
