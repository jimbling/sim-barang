<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthMiddleware implements FilterInterface
{
    const UNAUTHORIZED_URL = '/unauthorized';
    const LOGIN_URL = '/'; // Ganti dengan URL halaman login Anda

    public function before(RequestInterface $request, $arguments = null)
    {
        $role = session()->get('level');

        // Pengecekan sesi
        if ($this->isSessionExpired()) {
            return redirect()->to(self::LOGIN_URL);
        }

        // Daftar halaman yang hanya boleh diakses oleh 'Admin'
        $adminOnlyPages = [
            'adminpanel', 'barang/master', 'mahasiswa/*', 'data/*', 'kembali/*',
            'pinjam/*', 'pengembalian/*', 'peminjaman/*', 'pengeluaran/*', 'cetak/*', 'cetak_invoice/*', 'barang/disewakan',
            'pengaturan/*', 'laporan/*'
        ];

        // Periksa apakah pengguna adalah 'User' dan mencoba mengakses halaman yang terbatas
        if ($role === 'User') {
            foreach ($adminOnlyPages as $adminPage) {
                if ($this->checkUri($request->uri->getPath(), $adminPage)) {
                    return redirect()->to(self::UNAUTHORIZED_URL);
                }
            }

            // Tambahan: Memeriksa apakah pengguna mencoba mengakses rute yang dimulai dengan 'cetak/', 'data/', atau 'laporan/'
            $restrictedRoutes = ['data/', 'laporan/', 'penerimaan/', 'barang/master', '/pengaturan', 'adminpanel', 'cetak', 'cetak_invoice', 'pinjam/pihakluar', 'pinjam/pihakluar/riwayat', 'barang/disewakan', 'pinjam/tambah', 'pinjam/riwayat', 'cetak_pinjam'];
            foreach ($restrictedRoutes as $restrictedRoute) {
                if (strpos($request->uri->getPath(), $restrictedRoute) === 0) {
                    return redirect()->to(self::UNAUTHORIZED_URL);
                }
            }
        }

        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Logika setelah proses request
    }

    private function isSessionExpired()
    {
        $session = session();

        // Periksa apakah sesi telah habis
        if (!$session->has('user_nama') || (time() - $session->get('last_activity')) > $session->get('expiration')) {
            $session->destroy(); // Hancurkan sesi jika telah habis
            return true;
        }

        // Perbarui waktu aktivitas terakhir
        $session->set('last_activity', time());

        return false;
    }

    private function checkUri($uri, $allowedPage)
    {
        if (strpos($allowedPage, '*') !== false) {
            // Gunakan wildcard untuk mencocokkan subpath
            $pattern = str_replace('*', '.*', preg_quote($allowedPage, '/'));
            return (bool) preg_match('/^' . $pattern . '$/', $uri);
        } else {
            // Cocokkan secara langsung
            return $uri === $allowedPage;
        }
    }
}
