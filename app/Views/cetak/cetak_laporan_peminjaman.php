<?php echo view('tema/header.php'); ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Rekapitulasi</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Rekapitulasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 mb-4">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Cetak Laporan <STRONG>PEMINJAMAN</STRONG> </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form method="get" action="<?= site_url('cetak/peminjaman/bulan'); ?>" target="_blank">
                                    <div class="form-group">
                                        <label for="bulanCetakKembali" class="form-label">Pilih Bulan</label>
                                        <select class="form-control" id="bulanCetakKembali" name="bulan">
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
                                            <!-- Tambahkan opsi bulan lainnya -->
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="tahunCetakKembali" class="form-label">Pilih Tahun</label>
                                        <select class="form-control" id="tahunCetakKembali" name="tahun">
                                            <?php foreach ($years as $year) : ?>
                                                <option value="<?= $year['tahun'] ?>"><?= $year['tahun'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-icon-split btn-sm mt-2" class="btn btn-secondary btn-icon-split btn-sm" id="btnCetakPinjam">
                                            <span class="icon text-white-100">
                                                <i class="fas fa-print spaced-icon"></i>
                                            </span>
                                            <span class="text">Cetak Laporan Bulanan</span>
                                        </button>

                                    </div>
                                </form>
                            </div>

                            <div class="col-md-6">
                                <form method="get" action="/cetak/peminjaman/tahun" target="_blank">
                                    <label for="tahunCetakKembali" class="form-label">Pilih Tahun</label>
                                    <select class="form-control" id="tahunCetakKembali" name="tahun">
                                        <?php foreach ($years as $year) : ?>
                                            <option value="<?= $year['tahun'] ?>"><?= $year['tahun'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="btn btn-warning btn-icon-split btn-sm mt-2" class="btn btn-secondary btn-icon-split btn-sm" id="btnCetakTahunPinjam">
                                        <span class="icon text-white-100">
                                            <i class="fas fa-print spaced-icon"></i>
                                        </span>
                                        <span class="text">Cetak Laporan Tahunan</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <span class="small"> <i>
                                <font color="blue">Silahkan memilih untuk mencetak laporan sesuai kebutuhan</font>
                            </i></span>
                    </div>
                </div>

            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Cetak Laporan <STRONG>PENGEMBALIAN</STRONG></h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form method="get" action="/cetak/pengembalian/bulan" target="_blank">
                                    <div class="form-group">
                                        <label for="bulanCetakKembali" class="form-label">Pilih Bulan</label>
                                        <select class="form-control" id="bulanCetakKembali" name="bulan">
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
                                            <!-- Tambahkan opsi bulan lainnya -->
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="tahunCetakKembali" class="form-label">Pilih Tahun</label>
                                        <select class="form-control" id="tahunCetakKembali" name="tahun">
                                            <?php foreach ($years as $year) : ?>
                                                <option value="<?= $year['tahun'] ?>"><?= $year['tahun'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-icon-split btn-sm mt-2" class="btn btn-secondary btn-icon-split btn-sm" id="btnCetakKembali">
                                            <span class="icon text-white-100">
                                                <i class="fas fa-print spaced-icon"></i>
                                            </span>
                                            <span class="text">Cetak Laporan Bulanan</span>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="col-md-6">
                                <form method="get" action="/cetak/pengembalian/tahun" target="_blank">
                                    <label for="tahunCetakKembali" class="form-label">Pilih Tahun</label>
                                    <select class="form-control" id="tahunCetakKembali" name="tahun">
                                        <?php foreach ($years as $year) : ?>
                                            <option value="<?= $year['tahun'] ?>"><?= $year['tahun'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="btn btn-warning btn-icon-split btn-sm mt-2" class="btn btn-secondary btn-icon-split btn-sm" id="btnCetakTahunKembali">
                                        <span class="icon text-white-100">
                                            <i class="fas fa-print spaced-icon"></i>
                                        </span>
                                        <span class="text">Cetak Laporan Tahunan</span>
                                    </button>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <span class="small"> <i>
                                <font color="blue">Silahkan memilih untuk mencetak laporan sesuai kebutuhan</font>
                            </i></span>
                    </div>
                </div>
            </div>

        </div>
        <!-- Akhir Laporan Peminjaman dan Pengeluaran Barang -->

        <!-- Awal laporan barang persediaan -->


    </div>
</div>

<aside class="control-sidebar control-sidebar-dark">

    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>
<?php echo view('tema/footer.php'); ?>