<?php echo view('tema/header.php'); ?>
<style>
    /* CSS untuk mengatur ukuran font menjadi 13px */
    .table td,
    .table th {
        font-size: 13px;
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
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Cetak Laporan <STRONG>STOCK OPNAME TAHUNAN </STRONG></h6>
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

                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><STRONG>Informasi </STRONG></h6>
                        </div>
                        <div class="card-body">
                            <dl class="row">

                                <dt class="col-sm-3">Cetak Stock Tahunan</dt>
                                <dd class="col-sm-9">Untuk mencetak Stock BHP sesuai Tahun yang dipilih</dd>

                                <dt class="col-sm-3 text-truncate">Cetak Stock Bulanan</dt>
                                <dd class="col-sm-9">Untuk melihat dan mencetak sisa BHP pada Bulan dan Tahun Terpilih</dd>


                            </dl>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="card card-primary card-outline shadow-lg">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Cetak Laporan <STRONG>STOCK OPNAME BULANAN </STRONG></h6>
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
                                        <!-- Tambahkan opsi tahun -->
                                        <?php foreach (range(date('Y'), date('Y') - 10) as $year) : ?>
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
                            <button class="print-btn btn btn-sm btn-info" onclick="redirectToPrintPage()">Cetak</button>


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

        // Ambil nilai bulan dan tahun dari form
        const bulan = document.getElementById('bulan').value;
        const tahun = document.getElementById('tahun').value;

        // Panggil API dengan parameter bulan dan tahun
        fetch(`/api/data-stok?bulan=${bulan}&tahun=${tahun}`)
            .then(response => response.json())
            .then(data => {
                // Panggil fungsi untuk render data ke HTML dengan DataTables
                renderDataStok(data);
            })
            .catch(error => console.error('Error fetching data:', error));
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
    }

    function redirectToPrintPage() {
        // Ambil nilai bulan dan tahun dari form
        const bulan = document.getElementById('bulan').value;
        const tahun = document.getElementById('tahun').value;

        // Redirect ke halaman cetak dengan query parameters
        window.open(`/cetak/cetak_stok?bulan=${bulan}&tahun=${tahun}`, '_blank');
    }
</script>