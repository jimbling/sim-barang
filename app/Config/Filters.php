<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\PengaturanFilter;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'auth'          => \App\Filters\AuthMiddleware::class,
        'Admin'         => \App\Filters\AdminFilter::class,
        'User'          => \App\Filters\UserFIlter::class,
        'booking'       => \App\Filters\BookingMiddleware::class,

    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     */
    public array $globals = [
        'before' => [
            'booking', // Daftarkan filter di sini untuk dipanggil sebelum aksi controller
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don’t expect could bypass the filter.
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     */
    public $filters = [
        'auth' => ['before' => [
            '/dashboard', '/adminpanel', 'barang/*', 'mahasiswa/*', 'data/*',
            'kembali/*', 'pinjam/*', 'pengembalian/*', 'peminjaman/*', 'cetak/*',
            'penerimaan/*', 'get_detail/*', 'pengeluaran/*', 'pengaturan/*', 'laporan/*',
            'cetak/mutasi/*', 'pengeluaran_murni/*', 'reservasi', 'reservasi/*', 'pemeliharaan',
            '/ambil_tanggal/*', '/form_kembali/*', '/kembali/hapus_kode/*', '/backup/all', '/backup/latest',
            '/alert/getNotificationsToShow', '/upload/*', '/peminjaman/get_detail/*', '/backup/unduh/*',
            '/backup', '/get-user-by-id/*', '/profile', '/dosen_tendik/get_detail/*', '/persediaan/opname/export',
            '/kode_kembali/*'

        ]],
    ];
}
