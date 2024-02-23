<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MahasiswaModel;
use App\Models\DosenTendikModel;


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
}
