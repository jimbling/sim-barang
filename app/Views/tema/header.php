<!DOCTYPE html>

<html lang="en">
<?php

use App\Services\PengaturanService;

$pengaturanService = new PengaturanService();

// Mendapatkan nama kampus dan website
$data_pengaturan = $pengaturanService->getNamaKampus();
$nama_kampus = $data_pengaturan['nama_kampus'];
$logo = $data_pengaturan['logo'];
$favicon = $data_pengaturan['favicon'];

?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sitem Informasi Manajemen (SIM) Pengelolaan dan Penggunaan Barang Laboratorium Keperawatan Akper YKY Yogyakarta, adalah SIM untuk mengelola data peminjaman, penerimaan, dan penggunaan barang laboratorium keperawatan">
    <meta name="keywords" content="sim, akper, yky, akper yky, akper yky yogyakarta, laboratorium, keperawatan, lab, lab keperawatan, sim lab">
    <meta name="author" content="Akper YKY Yogyakarta">
    <title><?= $judul; ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="icon" href="../../assets/dist/img/ilustrasi/<?= $favicon; ?>" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/dist/css/adminlte.min.css?v=3.2.0">
    <link rel="stylesheet" href="../../assets/dist/css/style-2.css">
    <link rel="stylesheet" href="../../assets/dist/css/style.css">
    <link rel="stylesheet" href="../../assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="../../assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <link rel="stylesheet" href="../../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
        #updateButton,
        #batalButton {
            display: none;
        }
    </style>


</head>
<?php
// Mendapatkan sesi
$session = session();
// Mendapatkan nama pengguna dari sesi
$nama = $session->get('full_nama');
$username = $session->get('user_nama');
$password = $session->get('user_password');
$level = $session->get('level');
?>



<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <div class="spinner-border" role="status">
            </div>
            <img class="logo" src="../../assets/dist/login/img/logo-yky.png" alt="Akper YKY Logo" height="60" width="60">
        </div> -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <ul class="navbar-nav">
                    <li class="nav-link">
                        <div class="animate__animated animate__rubberBand">Selamat Datang, <?php echo $nama; ?></div>

                    </li>
                </ul>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user-cog"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="../../assets/dist/img/<?= $logo; ?>" alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center"><?php echo $nama; ?></h3>
                            <ul class="list-group list-group-unbordered mb-3 text-center">
                                <?php if ($level === 'Admin') : ?>
                                    <p>Anda Login sebagai : <b><?php echo $level; ?></b></p>
                                    <p>Anda Memiliki semua Hak Akses SIM Barang</p>
                                <?php elseif ($level === 'User') : ?>
                                    <p>Anda Login sebagai : <b><?php echo $level; ?></b></p>
                                    <p>Anda Memiliki akses terbatas</p>
                                <?php endif; ?>
                            </ul>
                        </div>



                    </div>
                </li>
                <li class="nav-items dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class='fas fa-power-off' style='color:red'></i>
                    </a>

                </li>

            </ul>
        </nav>


        <aside class="main-sidebar sidebar-light-primary elevation-4 ">

            <a href="<?php echo ($level === 'Admin') ? '/adminpanel' : '/dashboard'; ?>" class="brand-link bg-olive">
                <img src="../../assets/dist/img/<?= $logo; ?>" alt="<?= $nama_kampus; ?> Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">
                    <?php if ($level === 'Admin') : ?>
                        Admin Dashboard
                    <?php elseif ($level === 'User') : ?>
                        User Dashboard
                    <?php endif; ?>
                </span>
            </a>

            <div class="sidebar ">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?php if ($level == 'User') : ?>
                            <li class="nav-item menu-open">
                                <a href="/dashboard" class="nav-link <?= ($_SERVER['REQUEST_URI'] == '/dashboard') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item mt-4">
                                <a href="/reservasi/tambah" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/reservasi/tambah') !== false || $_SERVER['REQUEST_URI'] == '/tulisan/tambah' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                    <i class="fas fa-calendar-alt nav-icon"></i>
                                    <p>
                                        Booking Alat
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/pengeluaran/bhp" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/pengeluaran/bhp') !== false || $_SERVER['REQUEST_URI'] == '/tulisan/tambah' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                    <i class="far fa-list-alt nav-icon"></i>
                                    <p>
                                        Permintaan BHP
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item menu-close ">
                                <a href="#" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/pinjam/daftar') !== false || $_SERVER['REQUEST_URI'] == '/kembali/riwayat' || $_SERVER['REQUEST_URI'] == '/pengeluaran/tambahBaru' || $_SERVER['REQUEST_URI'] == '/pengeluaran/daftar' || $_SERVER['REQUEST_URI'] == '/kembali/tambah') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-people-carry"></i>
                                    <p>
                                        Sirkulasi
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>

                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="/pinjam/daftar" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/pinjam/daftar') !== false || $_SERVER['REQUEST_URI'] == '/tulisan/tambah' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                            <i class="fas fa-dolly sub-item spaced-icon"></i>
                                            <p>
                                                Peminjaman
                                            </p>
                                        </a>
                                        <a href="/kembali/riwayat" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/kembali/riwayat') !== false || $_SERVER['REQUEST_URI'] == '/tulisan/tambah' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                            <i class="fas fa-clipboard-check sub-item spaced-icon"></i>
                                            <p>
                                                Pengembalian
                                            </p>
                                        </a>


                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item menu-close">
                                <a href="#" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/barang/daftar') !== false || $_SERVER['REQUEST_URI'] == '/barang/master' || $_SERVER['REQUEST_URI'] == '/barang/rusak') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-box"></i>
                                    <p>
                                        Barang
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="/barang/daftar" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/barang/daftar') !== false || $_SERVER['REQUEST_URI'] == '/barang/daftar' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                            <i class="fas fa-dolly sub-item spaced-icon"></i>
                                            <p>
                                                Daftar Barang
                                            </p>
                                        </a>
                                    </li>
                                </ul>

                            </li>

                            <li class="nav-item">
                                <a href="/profile" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/profile') !== false || $_SERVER['REQUEST_URI'] == '/tulisan/tambah' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                    <i class="far fa-list-alt nav-icon"></i>
                                    <p>
                                        Profile
                                    </p>
                                </a>
                            </li>




                        <?php endif; ?>


                        <?php if ($level == 'Admin') : ?>
                            <li class="nav-item menu-open">
                                <a href="/adminpanel" class="nav-link <?= ($_SERVER['REQUEST_URI'] == '/adminpanel') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item mt-4">
                                <a href="/reservasi" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/reservasi') !== false || $_SERVER['REQUEST_URI'] == '/reservasi/tambah') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-calendar-check"></i>
                                    <p>
                                        Reservasi
                                    </p>
                                    <span class="right badge badge-danger"><?= session('jumlah_booking'); ?></span>
                                </a>
                            </li>
                            <li class="nav-item menu-close ">
                                <a href="#" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/pinjam/daftar') !== false || $_SERVER['REQUEST_URI'] == '/pinjam/tambah' || $_SERVER['REQUEST_URI'] == '/pinjam/riwayat' || $_SERVER['REQUEST_URI'] == '/pinjam/pihakluar' || $_SERVER['REQUEST_URI'] == '/kembali/riwayat' || $_SERVER['REQUEST_URI'] == '/pinjam/pihakluar/riwayat') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-people-carry"></i>
                                    <p>
                                        Sirkulasi
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>

                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="/pinjam/daftar" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/pinjam/daftar') !== false || $_SERVER['REQUEST_URI'] == '/tulisan/tambah' || $_SERVER['REQUEST_URI'] == '/pinjam/riwayat') ? 'active' : '' ?>">
                                            <i class="fas fa-dolly sub-item spaced-icon"></i>
                                            <p>
                                                Peminjaman
                                            </p>
                                        </a>
                                        <a href="/kembali/riwayat" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/kembali/riwayat') !== false || $_SERVER['REQUEST_URI'] == '/tulisan/tambah' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                            <i class="fas fa-clipboard-check sub-item spaced-icon"></i>
                                            <p>
                                                Pengembalian
                                            </p>
                                        </a>

                                        <a href="/pinjam/pihakluar" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/pinjam/pihakluar') !== false || $_SERVER['REQUEST_URI'] == '/tulisan/tambah' || $_SERVER['REQUEST_URI'] == '/pinjam/pihakluar') ? 'active' : '' ?>">
                                            <i class="fas fa-external-link-square-alt sub-item spaced-icon"></i>
                                            <p>
                                                Pihak Luar
                                            </p>
                                        </a>

                                    </li>

                                </ul>
                            </li>


                            <li class="nav-item menu-close">
                                <a href="#" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/barang/daftar') !== false || $_SERVER['REQUEST_URI'] == '/barang/master' || $_SERVER['REQUEST_URI'] == '/barang/rusak' || $_SERVER['REQUEST_URI'] == '/barang/disewakan') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-box"></i>
                                    <p>
                                        Barang
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="/barang/daftar" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/barang/daftar') !== false || $_SERVER['REQUEST_URI'] == '/barang/daftar' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                            <i class="fas fa-dolly sub-item spaced-icon"></i>
                                            <p>
                                                Daftar Barang
                                            </p>
                                        </a>
                                        <a href="/barang/master" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/barang/master') !== false || $_SERVER['REQUEST_URI'] == '/tulisan/tambah' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                            <i class="fas fa-clipboard-check sub-item spaced-icon"></i>
                                            <p>
                                                Master Barang
                                            </p>
                                        </a>
                                    </li>
                                </ul>

                            </li>


                            <li class="nav-item menu-close">
                                <a href="#" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/penerimaan/daftar') !== false || $_SERVER['REQUEST_URI'] == '/barang/persediaan/master' || $_SERVER['REQUEST_URI'] == '/barang/satuan' || $_SERVER['REQUEST_URI'] == '/persediaan/opname' || $_SERVER['REQUEST_URI'] == '/pengeluaran/daftar' || $_SERVER['REQUEST_URI'] == '/penerimaan/tambahBaru' || $_SERVER['REQUEST_URI'] == '/pengeluaran/tambahBaru') ? 'active' : '' ?>">
                                    <i class="nav-icon 	fas fa-warehouse"></i>
                                    <p>
                                        Persediaan
                                        <i class="right fas fa-angle-left"></i>

                                    </p>
                                    <span class="center badge badge-danger"> <?= session('bhp_baru'); ?> BHP</span>
                                </a>



                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="/persediaan/opname" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/persediaan/opname') !== false || $_SERVER['REQUEST_URI'] == '/tulisan/tambah' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                            <i class="fas fa-boxes nav-icon"></i>
                                            <p>
                                                Stock Opname
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="/penerimaan/daftar" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/penerimaan/daftar') !== false || $_SERVER['REQUEST_URI'] == '/tulisan/tambah' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                            <i class="fas fa-clipboard-list nav-icon"></i>
                                            <p>
                                                Penerimaan
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/pengeluaran/daftar" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/pengeluaran/daftar') !== false || $_SERVER['REQUEST_URI'] == '/tulisan/tambah' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                            <i class="far fa-list-alt nav-icon"></i>
                                            <p>
                                                Pengeluaran
                                            </p>
                                            <span class="center badge badge-danger"> <?= session('bhp_baru'); ?> BHP</span>
                                        </a>
                                    </li>



                                    <li class="nav-item">
                                        <a href="#" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/barang/persediaan/master') !== false || $_SERVER['REQUEST_URI'] == '/barang/satuan' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                            <i class="fas fa-info-circle nav-icon"></i>
                                            <p>
                                                Referensi
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="/barang/persediaan/master" class="nav-link <?= ($_SERVER['REQUEST_URI'] == '/barang/persediaan/master') ? 'active' : '' ?>">
                                                    <i class="far fa-dot-circle sub-item spaced-icon"></i>
                                                    <p>Input Barang</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="/barang/satuan" class="nav-link <?= ($_SERVER['REQUEST_URI'] == '/barang/satuan') ? 'active' : '' ?>">
                                                    <i class="far fa-dot-circle sub-item spaced-icon"></i>
                                                    <p>Satuan Barang</p>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>

                                </ul>
                            </li>


                            <li class="nav-item menu-close">
                                <a href="#" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/data/mahasiswa') !== false || $_SERVER['REQUEST_URI'] == '/data/dosen_tendik' || $_SERVER['REQUEST_URI'] == '/data/pengaturan' || $_SERVER['REQUEST_URI'] == '/data/pengguna' || $_SERVER['REQUEST_URI'] == '/data/pengguna?type=Dosen_Tendik' || $_SERVER['REQUEST_URI'] == '/data/pengguna?type=Mahasiswa') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-sliders-h"></i>
                                    <p>
                                        Pengaturan
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="/data/mahasiswa" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/data/mahasiswa') !== false || $_SERVER['REQUEST_URI'] == '/barang/daftar' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                            <i class="fas fa-user-graduate sub-item spaced-icon"></i>
                                            <p>
                                                Mahasiswa
                                            </p>
                                        </a>
                                        <a href="/data/dosen_tendik" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/data/dosen') !== false || $_SERVER['REQUEST_URI'] == '/tulisan/tambah' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                            <i class="fas fa-chalkboard-teacher sub-item spaced-icon"></i>
                                            <p>
                                                Dosen dan Tendik
                                            </p>
                                        </a>
                                        <a href="/data/pengaturan" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/data/pengaturan') !== false || $_SERVER['REQUEST_URI'] == '/tulisan/tambah' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                            <i class="fas fa-school sub-item spaced-icon"></i>
                                            <p>
                                                Setting
                                            </p>
                                        </a>
                                        <a href="/data/pengguna" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/data/pengguna') !== false || $_SERVER['REQUEST_URI'] == '/data/pengguna?type=Dosen_Tendik' || $_SERVER['REQUEST_URI'] == '/data/pengguna?type=Mahasiswa') ? 'active' : '' ?>">
                                            <i class="fas fa-users sub-item spaced-icon"></i>
                                            <p>
                                                Pengguna
                                            </p>
                                        </a>
                                    </li>


                                </ul>

                            </li>

                            <li class="nav-item menu-close">
                                <a href="" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/laporan/peminjaman') !== false || $_SERVER['REQUEST_URI'] == '/laporan/persediaan' || $_SERVER['REQUEST_URI'] == '/laporan/stock') ? 'active' : '' ?>">
                                    <i class="nav-icon 	fas fa-file-alt"></i>
                                    <p>
                                        Laporan
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">

                                    <li class="nav-item">
                                        <a href="/laporan/peminjaman" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/laporan/peminjaman') !== false || $_SERVER['REQUEST_URI'] == '/laporan/peminjaman' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                            <i class="fas fa-clipboard-list sub-item spaced-icon"></i>
                                            <p>
                                                Peminjaman
                                            </p>
                                        </a>
                                        <a href="/laporan/persediaan" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/laporan/persediaan') !== false || $_SERVER['REQUEST_URI'] == '/laporan/persediaan' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                            <i class="fas fa-clipboard-list sub-item spaced-icon"></i>
                                            <p>
                                                Persediaan
                                            </p>
                                        </a>
                                        <a href="/laporan/stock" class="nav-link <?= (strpos($_SERVER['REQUEST_URI'], '/laporan/stock') !== false || $_SERVER['REQUEST_URI'] == '/laporan/stock' || $_SERVER['REQUEST_URI'] == '/tulisan/kategori') ? 'active' : '' ?>">
                                            <i class="fas fa-clipboard-list sub-item spaced-icon"></i>
                                            <p>
                                                Laporan Stock
                                            </p>
                                        </a>


                                    </li>

                                </ul>
                            <li class="nav-item">
                                <a href="/pemeliharaan" class="nav-link <?= ($_SERVER['REQUEST_URI'] == '/pemeliharaan') ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-fire" style='color:red'></i>
                                    <p>
                                        Pemeliharaan
                                    </p>

                                </a>
                            </li>


                            </li>

                    </ul>
                <?php endif; ?>
                </nav>

            </div>

        </aside>