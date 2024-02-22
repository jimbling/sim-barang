<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanAddPeminjaman')); ?>"></div><!-- Page Heading -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Riwayat Peminjaman Barang</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Riwayat Pinjam</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="card card-primary card-outline shadow-lg">

                        <div class="card-body">

                            <form action="<?= base_url('pinjam/riwayat') ?>" method="get" class="form-inline">
                                <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Pilih Tahun</label>
                                <select class="custom-select my-1 mr-sm-2 custom-select-sm" name="tahun" id="tahun">
                                    <?php foreach ($availableYears as $year) : ?>
                                        <option value="<?= $year ?>" <?= $year == $selectedYear ? 'selected' : '' ?>><?= $year ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-primary my-1 btn-sm">Filter</button>
                                </select>
                            </form>

                            <table id="daftarRiwayatPeminjamanTable" class="table table-striped table-responsive table-sm table-hover">
                                <thead class="thead-dark" style="font-size: 13px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center; font-size: 13px;">Kode Pinjam</th>
                                        <th style="text-align: center; font-size: 13px;">Nama Peminjam</th>
                                        <th style="text-align: center; font-size: 13px;">Tanggal Pinjam</th>
                                        <th style="text-align: center; font-size: 13px;">Digunakan di</th>
                                        <th style="text-align: center; font-size: 13px;">Digunakan untuk</th>
                                        <th style="text-align: center; font-size: 13px;">Nama Barang</th>

                                    </tr>
                                </thead>
                                <div id="alertContainer" class="mt-3"></div>
                                <tbody>
                                    <?php $i = 1; // Deklarasi di luar loop foreach 
                                    ?>
                                    <?php foreach ($data_riwayat_pinjam as $dataPinjam) : ?>
                                        <tr class="searchable-row">
                                            <!-- Kolom yang lain tetap seperti sebelumnya -->
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 13px;"><?= $i++; ?></th>
                                            <td style="text-align: left; vertical-align: middle; font-size: 13px;"><?= $dataPinjam['kode_pinjam']; ?></td>
                                            <td style="text-align: left; vertical-align: middle; font-size: 13px;"><?= $dataPinjam['nama_peminjam']; ?></td>
                                            <td width='11%' style="text-align: left; vertical-align: middle; font-size: 13px;">
                                                <?php
                                                $tanggal_pinjam = \CodeIgniter\I18n\Time::parse($dataPinjam['tanggal_pinjam'])
                                                    ->setTimezone('Asia/Jakarta');

                                                $nama_bulan = [
                                                    'January' => 'Januari',
                                                    'February' => 'Februari',
                                                    'March' => 'Maret',
                                                    'April' => 'April',
                                                    'May' => 'Mei',
                                                    'June' => 'Juni',
                                                    'July' => 'Juli',
                                                    'August' => 'Agustus',
                                                    'September' => 'September',
                                                    'October' => 'Oktober',
                                                    'November' => 'November',
                                                    'December' => 'Desember',
                                                ];

                                                $bulan = $nama_bulan[$tanggal_pinjam->format('F')];

                                                echo $tanggal_pinjam->format('d ') . $bulan . $tanggal_pinjam->format(' Y - H:i') . ' WIB';
                                                ?>
                                            </td>
                                            <td style="text-align: left; vertical-align: middle; font-size: 13px;"><?= $dataPinjam['nama_ruangan']; ?></td>
                                            <td width='15%' style="text-align: left; vertical-align: middle; font-size: 13px;"><?= $dataPinjam['keperluan']; ?></td>
                                            <td style="text-align: left; vertical-align: middle; font-size: 13px;">
                                                <?php
                                                $barang_dipinjam = explode(',', $dataPinjam['barang_dipinjam']);
                                                $no_urut_barang = 1; // Reset nomor urut pada setiap baris barang
                                                foreach ($barang_dipinjam as $barang) {
                                                    echo $no_urut_barang . '. ' . $barang . '<br>';
                                                    $no_urut_barang++; // Increment nomor urut barang
                                                }
                                                ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<aside class="control-sidebar control-sidebar-dark">

    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>


<aside class="control-sidebar control-sidebar-dark">

    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>


<script>
    function showLoading() {
        let timerInterval
        Swal.fire({
            title: 'Sedang memproses data ....',
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft()
                }, 100)
            }
        });
    }

    function hideLoading() {
        Swal.close();
    }

    function hapus_data(data_id) {
        console.log('Data ID yang akan dihapus:', data_id); // Tambahkan baris ini
        Swal.fire({
            title: 'HAPUS?',
            text: "Yakin akan menghapus data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan pesan loading saat permintaan sedang dijalankan
                showLoading();
                // Lakukan permintaan penghapusan ke server, misalnya dengan AJAX.
                // Jika penghapusan berhasil, maka lakukan redirect ke halaman /siswa.
                // Contoh penggunaan jQuery untuk permintaan penghapusan:
                $.ajax({
                    type: 'POST',
                    url: '/pinjam/hapus/' + data_id, // Ganti URL sesuai dengan URL yang benar
                    success: function(response) {
                        // Sembunyikan pesan loading saat permintaan selesai
                        hideLoading();
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil dihapus.',
                            icon: 'success',
                            timer: 2000, // Durasi tampilan dalam milidetik (misalnya, 5000 milidetik = 5 detik)
                            showConfirmButton: false, // Sembunyikan tombol OK (jika tidak diinginkan)
                        }).then(() => {
                            // Arahkan pengguna ke halaman baru setelah SweetAlert ditutup
                            window.location.replace("/pinjam/daftar");
                        });
                    },
                    error: function(xhr, status, error) {
                        // Sembunyikan pesan loading saat ada kesalahan dalam penghapusan
                        hideLoading();
                        // Handle error here, jika ada kesalahan dalam penghapusan
                        console.log(error);
                    }
                });
            }
        });
    }
</script>
<?php echo view('tema/footer.php'); ?>