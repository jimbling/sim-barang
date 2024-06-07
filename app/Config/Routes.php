<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/keluar', 'Auth::keluar');

$routes->get('/adminpanel', 'Home::adminpanel');
$routes->get('/dashboard', 'Home::dashboard_user');
$routes->get('/pinjam/tambah', 'Peminjaman::addPinjam');
$routes->get('/pinjam/daftar', 'Peminjaman::index');
$routes->get('/pinjam/riwayat', 'Peminjaman::riwayat');
$routes->get('/pinjam/edit/(:num)', 'Peminjaman::edit/$1');

$routes->get('/kembali/riwayat', 'Pengembalian::riwayat');
$routes->get('/kembali/tambah', 'Pengembalian::addKembali');
$routes->post('pengembalian/proses', 'Pengembalian::prosesPengembalian');
$routes->post('/kembali/hapus/(:num)', 'Pengembalian::hapus/$1');

$routes->get('/barang/daftar', 'Barang::daftarBarang');
$routes->get('/barang/master', 'Barang::masterBarang');
$routes->post('/barang/hapus', 'Barang::delete');
$routes->post('/barang/tambah', 'Barang::addBarang');
$routes->get('barang/get_detail/(:num)', 'Barang::get_detail/$1');
$routes->post('/barang/update/(:num)', 'Barang::edit/$1');
$routes->post('/barang/importData', 'Barang::importData');
$routes->get('/barang/rusak', 'Barang::daftarBarangRusak');
$routes->get('/barang/disewakan', 'Barang::daftarBarangDisewakan');

$routes->get('/data/mahasiswa', 'Mahasiswa::index');
$routes->post('/data/mahasiswa/tambah', 'Mahasiswa::addMhs');
$routes->get('mahasiswa/get_detail/(:num)', 'Mahasiswa::get_detail/$1');
$routes->post('/data/mahasiswa/update/(:num)', 'Mahasiswa::edit/$1');
$routes->post('/mahasiswa/hapus', 'Mahasiswa::delete');
$routes->post('/mahasiswa/importData', 'Mahasiswa::importData');
$routes->post('mahasiswa/cari', 'Mahasiswa::cari');
$routes->post('/data/mahasiswa/akun', 'Mahasiswa::buatAkun');

$routes->post('peminjaman/proses', 'Peminjaman::prosesPeminjaman');
$routes->post('/pinjam/hapus/(:num)', 'Peminjaman::hapus/$1');
$routes->post('/pinjam/hapus_riwayat/(:num)', 'Peminjaman::hapusRiwayat/$1');
$routes->get('cetak_pinjam/(:num)', 'Peminjaman::cetakPinjamPersediaan/$1');
$routes->get('peminjaman/hps/(:num)', 'Pengembalian::hapusPeminjaman/$1');


$routes->get('/reservasi', 'Reservasi::index');
$routes->get('/reservasi/tambah', 'Reservasi::addReservasi');
$routes->post('reservasi/simpan', 'Reservasi::simpanReservasi');
$routes->post('/reservasi/hapus/(:num)', 'Reservasi::hapus/$1');
$routes->post('/reservasi/pindah/(:num)', 'Reservasi::moveDataById/$1');
$routes->get('cetak_reservasi/(:num)', 'Reservasi::cetakReservasi/$1');



$routes->get('/penerimaan/daftar', 'Penerimaan::daftarPenerimaan');
$routes->get('/penerimaan/tambahBaru', 'Penerimaan::addPenerimaan');
$routes->post('/penerimaan/simpan', 'Penerimaan::ProsesTambahPenerimaan');
$routes->get('/get_detail/(:num)', 'Penerimaan::get_detail/$1');
$routes->post('/penerimaan/hapus/(:num)', 'Penerimaan::hapusPenerimaan/$1');
$routes->post('/penerimaan/validateHargaSatuan', 'Penerimaan::validateHargaSatuan');

$routes->get('/barang/persediaan/master', 'BarangPersediaan::masterBarang');
$routes->post('/barang/persediaan/importData', 'BarangPersediaan::importData');
$routes->post('/barang/persediaan/hapus', 'BarangPersediaan::delete');
$routes->post('/barang/persediaan/tambah', 'BarangPersediaan::addBarang');


$routes->get('/barang/satuan', 'Satuan::index');
$routes->post('/barang/satuan/hapus', 'Satuan::delete');
$routes->post('/barang/satuan/tambah', 'Satuan::addSatuan');

$routes->get('/persediaan/opname', 'BarangPersediaan::stokOpname');
$routes->get('/persediaan/opname/export', 'BarangPersediaan::exportToExcel');

$routes->get('/data/dosen_tendik', 'DosenTendik::index');
$routes->post('/data/dosen_tendik/tambah', 'DosenTendik::addDosenTendik');
$routes->post('/data/dosen_tendik/hapus', 'DosenTendik::delete');
$routes->post('/data/dosen_tendik/importData', 'DosenTendik::importData');
$routes->post('/data/dosen_tendik/copy', 'DosenTendik::buatAkun');
$routes->post('/data/dosen_tendik/update/(:num)', 'DosenTendik::edit/$1');
$routes->get('/dosen_tendik/get_detail/(:num)', 'DosenTendik::get_detail/$1');
$routes->post('/data/akun/update', 'Pengaturan::update');


$routes->get('/pengeluaran/daftar', 'Pengeluaran::daftarPengeluaran');
$routes->get('/pengeluaran/tambahBaru', 'Pengeluaran::addPengeluaran');
$routes->get('/pengeluaran/getDataPeminjaman/(:segment)', 'Pengeluaran::getDataPeminjaman/$1');
$routes->post('/pengeluaran/simpan', 'Pengeluaran::ProsesTambahPengeluaran');

$routes->post('/permintaan/simpan', 'PengeluaranMurni::simpanPermintaan');
$routes->get('/pengeluaran/bhp/(:num)', 'PengeluaranMurni::addPengeluaranTanpaPeminjaman/$1');
$routes->get('/pengeluaran/bhp', 'PengeluaranMurni::daftarPengeluaranMurni');
$routes->post('/pengeluaran/bhp/simpan', 'PengeluaranMurni::ProsesTambahPengeluaranMurni');
$routes->post('/pengeluaran/bhp/hapus/(:num)', 'PengeluaranMurni::hapusPengeluaranMurni/$1');
$routes->post('/pengeluaran/barang_bhp/hapus/(:num)', 'PengeluaranMurni::hapusDataBarangMurni/$1');
$routes->get('pengeluaran/getDataByPenggunaId/(:num)', 'PengeluaranMurni::getDataByPenggunaId/$1');
$routes->get('pengeluaran/getPengeluaranByPenggunaId/(:num)', 'PengeluaranMurni::getDataByPenggunaId/$1');
$routes->get('pengeluaran_bhp/get_detail/(:num)', 'PengeluaranMurni::get_detail/$1');
$routes->get('cetak_bhp/(:num)', 'PengeluaranMurni::cetakPengeluaranMurni/$1');
$routes->get('/pengeluaran/get_created_at/(:num)', 'PengeluaranMurni::getCreatedAt/$1');


$routes->get('pengeluaran/getDataByPeminjamanId/(:num)', 'Pengeluaran::getDataByPeminjamanId/$1');
$routes->post('pengeluaran/hapusData/(:num)', 'Pengeluaran::hapusData/$1');
$routes->get('pengeluaran/get_detail/(:num)', 'Peminjaman::get_detail/$1');
$routes->post('pengeluaran/hapus/(:num)', 'Pengeluaran::hapusDataByPeminjaman/$1');

$routes->get('/data/pengaturan', 'Pengaturan::index');
$routes->get('/data/pengguna', 'Pengaturan::pengguna');
$routes->post('/pengguna/hapus', 'Pengaturan::delete');
$routes->post('/pengaturan/update', 'Pengaturan::updateData');
$routes->get('/laporan/peminjaman', 'Laporan::laporanPeminjaman');
$routes->get('/laporan/persediaan', 'Laporan::laporanPersediaan');
$routes->get('/laporan/stock', 'Laporan::laporanStockOpname');

$routes->get('/profile', 'Pengaturan::settingUser');
$routes->get('/get-user-by-id/(:num)', 'Pengaturan::getUserById/$1');
$routes->post('/update-user', 'Pengaturan::updateUser');

$routes->get('/cetak/peminjaman/bulan', 'Laporan::cetakPinjamBulanTahun');
$routes->get('/cetak/peminjaman/tahun', 'Laporan::cetakPinjamTahun');
$routes->get('/cetak/pengembalian/bulan', 'Laporan::cetakKembaliBulanTahun');
$routes->get('/cetak/pengembalian/tahun', 'Laporan::cetakKembaliTahun');

$routes->get('/cetak/penerimaan/bulan', 'Laporan::cetakPenerimaanBulanTahun');
$routes->get('/cetak/penerimaan/tahun', 'Laporan::cetakPenerimaanTahun');
$routes->get('/cetak/pengeluaran/bulan', 'Laporan::cetakPengeluaranBulanTahun');
$routes->get('/cetak/pengeluaran/tahun', 'Laporan::cetakPengeluaranTahun');
$routes->get('/cetak/pengeluaran_murni/bulan', 'Laporan::cetakPengeluaranMurniBT');
$routes->get('/cetak/pengeluaran_murni/tahun', 'Laporan::cetakPengeluaranMurniT');

$routes->get('/cetak/stock/bulan', 'Laporan::laporanStockOpnameBulan');
$routes->get('/cetak/stock/tahun', 'Laporan::laporanStockOpnameTahun');
$routes->get('/cetak/stock/rekap', 'Laporan::laporanStockRekapOpname');
$routes->get('/cetak/mutasi/bulan', 'Laporan::laporanMutasiBulan');

$routes->get('/unauthorized', 'Unauthorized::index');

$routes->get('/backup', 'Pemeliharaan::backup');
$routes->get('/backup/unduh/(:segment)', 'Pemeliharaan::unduh/$1');
$routes->post('/hapus/backup', 'Pemeliharaan::deleteExpiredBackups');

$routes->get('/pihakluar', 'Pihakluar::index');
$routes->post('/pihakluar/simpan', 'Pihakluar::prosesPeminjaman');
$routes->get('/pihakluar/invoice/(:num)', 'Pihakluar::invoice/$1');
$routes->get('/cetak/invoice/(:num)', 'Pihakluar::cetakInvoice/$1');
$routes->get('/pinjam/pihakluar/riwayat', 'Pihakluar::riwayatpinjamLuar');
$routes->get('/pinjam/pihakluar', 'Pihakluar::daftarpinjamLuar');
$routes->post('/pihakluar/kembalikan/(:num)', 'Pihakluar::kembalikan/$1');
$routes->post('/pihakluar/hapus/(:num)', 'Pihakluar::hapus/$1');
$routes->post('/pihakluar/riwayatpinjam/hapus/(:num)', 'Pihakluar::hapusriwayat/$1');

$routes->post('mahasiswa/fetchData', 'Mahasiswa::getDataMahasiswa');
$routes->post('dosentendik/fetchData', 'DosenTendik::getDataDosenTendik');
$routes->post('peminjaman/fetchData', 'Peminjaman::getRiwayatPeminjaman');
$routes->post('pengembalian/fetchData', 'Pengembalian::getRiwayatPengembalianBarang');
$routes->post('barang/fetchData', 'Barang::getDataBarang');

$routes->get('/peminjaman/get_detail/(:num)', 'Home::get_data_peminjaman/$1');
$routes->post('/data/peminjaman/update/(:num)', 'Peminjaman::perpanjang/$1');
$routes->post('update_tanggal_kembali/(:num)', 'Home::update_tanggal_kembali/$1');
$routes->post('notification/getUserNotifications', 'Reservasi::getUserNotifications');
$routes->post('notification/markAsRead', 'Reservasi::markAsRead');

$routes->get('/pesan', 'Pesan::index');
$routes->post('/pesan/kirim', 'Pesan::send');
$routes->get('/pemeliharaan', 'Pemeliharaan::index');
$routes->post('upload/kopsurat', 'Pengaturan::kopsurat');
$routes->post('upload/logo', 'Pengaturan::logo');
$routes->post('upload/favicon', 'Pengaturan::favicon');
$routes->post('upload/logobank', 'Pengaturan::uploadLogoBank');
$routes->get('/alert/getNotificationsToShow', 'Alert::getNotificationsToShow');
$routes->post('/alert/updateAlertHiddenStatus/(:num)', 'Alert::updateAlertHiddenStatus/$1');
$routes->post('/generate-kode-pinjam', 'Pengaturan::generateKodePinjam');

$routes->get('backup/all', 'Pemeliharaan::getAllBackups');
$routes->get('backup/latest', 'Pemeliharaan::getLatestBackups');


$routes->get('form_kembali/(:num)', 'Peminjaman::cetakFormPengembalian/$1');
$routes->get('/ambil_tanggal/(:num)', 'Home::get_data_peminjaman/$1');
$routes->get('/kode_kembali/detail/(:segment)', 'Peminjaman::riwayatKodePinjam/$1');
$routes->get('cetak/detail_pinjam/(:segment)', 'Peminjaman::cetakDetailPinjam/$1');
$routes->get('/kembali/hapus_kode/(:segment)', 'Pengembalian::penghapusanKodeKembali/$1');
$routes->post('/pengembalian/batal', 'Pengembalian::batal');








/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
