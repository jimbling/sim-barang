<?php echo view('tema/header.php'); ?>
<style>
    /* CSS untuk mengatur ukuran font menjadi 13px */
    .table td,
    .table th {
        font-size: 13px;
    }

    #printButton {
        display: none;
        /* Sembunyikan tombol secara default */
    }
</style>
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Cetak Stock Opname</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Stock Opname BHP</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Cetak <STRONG>STOCK OPNAME TAHUNAN </STRONG></h6>
                        </div>
                        <div class="card-body">
                            <form method="get" action="/cetak/stock/tahun" target="_blank">
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <thead>
                                            <th style="text-align: left;">Pilih Tahun</th>
                                            <th></th>
                                        </thead>

                                        <tr>
                                            <td>
                                                <select class="form-control form-control-sm" id="tahunCetakKembali" name="tahun">
                                                    <?php foreach ($years as $year) : ?>
                                                        <option value="<?= $year ?>"><?= $year ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <button type="submit" class="btn btn-warning btn-sm" id="btnCetakTahunKembali">
                                                    <i class="fas fa-print spaced-icon"></i>
                                                    <span class="text">Cetak</span>
                                                </button>
                                            </td>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>


                            </form>

                        </div>

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Cetak <STRONG>DAFTAR MUTASI BHP </STRONG></h6>
                        </div>
                        <div class="card-body">
                            <form id="formLihatMutasi" method="get" action="<?= site_url('/laporan/lihat-mutasi'); ?>" target="_self">
                                <table class="table table-borderless table-sm">
                                    <tbody>
                                        <thead>
                                            <th style="text-align: left;">Pilih Bulan</th>
                                            <th style="text-align: left;">Pilih Tahun</th>
                                            <th></th>
                                            <th></th> <!-- Kolom tambahan untuk tombol Cetak -->
                                        </thead>
                                        <tr>
                                            <td>
                                                <select class="form-control form-control-sm" id="bulanLihatMutasi" name="bulan">
                                                    <option value="01">Januari</option>
                                                    <option value="02">Februari</option>
                                                    <option value="03">Maret</option>
                                                    <option value="04">April</option>
                                                    <option value="05">Mei</option>
                                                    <option value="06">Juni</option>
                                                    <option value="07">Juli</option>
                                                    <option value="08">Agustus</option>
                                                    <option value="09">September</option>
                                                    <option value="10">Oktober</option>
                                                    <option value="11">November</option>
                                                    <option value="12">Desember</option>
                                                    <!-- Tambahkan opsi bulan lainnya jika diperlukan -->
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control form-control-sm" id="tahunLihatMutasi" name="tahun">
                                                    <?php foreach ($years as $year) : ?>
                                                        <option value="<?= $year ?>"><?= $year ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <span class="icon text-white-100">
                                                        <i class="fas fa-print spaced-icon"></i>
                                                    </span>
                                                    <span class="text">Lihat Mutasi</span>
                                                </button>
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <!-- Tombol Cetak -->
                                                <button id="btnCetakMutasi" class="btn btn-success btn-sm">
                                                    <span class="icon text-white-100">
                                                        <i class="fas fa-print spaced-icon"></i>
                                                    </span>
                                                    <span class="text">Cetak</span>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="card card-primary card-outline shadow-lg">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Cetak <STRONG>STOCK OPNAME BULANAN </STRONG></h6>
                        </div>
                        <div class="card-body">


                            <!-- Form untuk memilih bulan dan tahun -->
                            <form id="filterForm" class="form-inline mb-2">
                                <div class="form-group mr-2">
                                    <label for="bulan" class="mr-2">Bulan:</label>
                                    <select class="form-control form-control-sm" id="bulan" name="bulan">
                                        <!-- Tambahkan opsi bulan -->
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>

                                <div class="form-group mr-2">
                                    <label for="tahun" class="mr-2">Tahun:</label>
                                    <select class="form-control form-control-sm" id="tahun" name="tahun">
                                        <!-- Tambahkan opsi tahun mulai dari 2023 hingga tahun saat ini -->
                                        <?php foreach (range(2023, date('Y')) as $year) : ?>
                                            <option value="<?= $year ?>"><?= $year ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-sm btn-primary">Tampilkan Data</button>
                            </form>

                            <!-- Area untuk menampilkan data -->
                            <div id="dataStok">
                                <!-- Tabel akan diisi oleh JavaScript -->
                            </div>

                            <!-- Tombol cetak -->
                            <button id="printButton" class="print-btn btn btn-sm btn-success" onclick="redirectToPrintPage()" style="display:none;"><i class='fas fa-print'></i> Cetak Stock Opname</button>


                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>

</div>

<?php echo view('tema/footer.php'); ?>

<script>
    document.getElementById('filterForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah form submit secara default

        // Tampilkan SweetAlert loading
        Swal.fire({
            title: 'Mohon tunggu...',
            text: 'Sedang mengambil data...',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        // Ambil nilai bulan dan tahun dari form
        const bulan = document.getElementById('bulan').value;
        const tahun = document.getElementById('tahun').value;

        // Panggil API dengan parameter bulan dan tahun
        fetch(`/api/data-stok?bulan=${bulan}&tahun=${tahun}`)
            .then(response => response.json())
            .then(data => {
                // Panggil fungsi untuk render data ke HTML dengan DataTables
                renderDataStok(data);
                // Tutup SweetAlert setelah data berhasil dimuat
                Swal.close();
            })
            .catch(error => {
                // Tampilkan SweetAlert kesalahan jika terjadi error
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan',
                    text: 'Gagal mengambil data. Silakan coba lagi.',
                });
                console.error('Error fetching data:', error);
            });
    });

    function renderDataStok(data) {
        // Ambil elemen div untuk menampilkan data
        const dataDiv = document.getElementById('dataStok');

        // Buat tabel untuk menampilkan data dengan DataTables
        let table = '<table id="dataTable" class="table table-striped table-bordered table-sm">';
        table += '<thead><tr>';
        table += '<th>Barang ID</th>';
        table += '<th>Nama Barang</th>';
        table += '<th>Harga Satuan</th>';
        table += '<th>Sisa Stok</th>';
        table += '<th>Satuan</th>';
        table += '</tr></thead>';
        table += '<tbody>';

        // Iterasi melalui data barang dan tambahkan ke tabel
        data.barangList.forEach(item => {
            table += '<tr>';
            table += `<td>${item.barang_id}</td>`;
            table += `<td>${item.nama_barang}</td>`;
            table += `<td>${item.harga_satuan}</td>`;
            table += `<td>${item.sisa_stok}</td>`;
            table += `<td>${item.satuan}</td>`;
            table += '</tr>';
        });

        table += '</tbody></table>';

        // Set tabel ke div data
        dataDiv.innerHTML = table;

        // Inisialisasi DataTables
        $(document).ready(function() {
            $('#dataTable').DataTable({
                responsive: true // Mengaktifkan responsif untuk tampilan pada perangkat mobile
            });
        });

        // Tampilkan tombol cetak setelah data diisi
        document.getElementById('printButton').style.display = 'block';
    }

    function redirectToPrintPage() {
        // Ambil nilai bulan dan tahun dari form
        const bulan = document.getElementById('bulan').value;
        const tahun = document.getElementById('tahun').value;

        // Redirect ke halaman cetak dengan query parameters
        window.open(`/cetak/cetak_stok?bulan=${bulan}&tahun=${tahun}`, '_blank');
    }
</script>

<script>
    // Ambil nilai bulan dan tahun saat form disubmit untuk tombol Lihat Mutasi
    document.getElementById('formLihatMutasi').addEventListener('submit', function(e) {
        e.preventDefault(); // Hentikan proses submit sementara

        var bulan = document.getElementById('bulanLihatMutasi').value;
        var tahun = document.getElementById('tahunLihatMutasi').value;

        var url = "<?= site_url('/laporan/lihat-mutasi') ?>?bulan=" + bulan + "&tahun=" + tahun;

        // Redirect ke halaman lihat-mutasi dengan parameter bulan dan tahun
        window.location.href = url;
    });

    // Tambahkan event listener untuk tombol Cetak
    document.getElementById('btnCetakMutasi').addEventListener('click', function(e) {
        e.preventDefault(); // Hentikan default action dari tombol

        var bulan = document.getElementById('bulanLihatMutasi').value;
        var tahun = document.getElementById('tahunLihatMutasi').value;

        var url = "<?= site_url('/cetak/daftar-mutasi-bhp') ?>?bulan=" + bulan + "&tahun=" + tahun;

        // Buka halaman cetak di tab baru
        window.open(url, '_blank');
    });
</script>