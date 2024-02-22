<?php echo view('tema/header.php'); ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h6 class="m-0">Laporan Stock Opname Barang Habis Pakai Laboratorium Keperawatan</h6>
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
            <div class="col-md-6">

                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Cetak Laporan <STRONG>STOCK OPNAME BULANAN</STRONG> </h6>
                    </div>
                    <div class="card-body">
                        <form method="get" action="<?= site_url('/cetak/stock/bulan'); ?>" target="_blank">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <thead>
                                        <th style="text-align: left;">Pilih Bulan</th>
                                        <th style="text-align: left;">Pilih Tahun</th>
                                        <th></th>
                                    </thead>
                                    <tr>

                                        <td>
                                            <select class="form-control form-control-sm" id="bulanCetakKembali" name="bulan">
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
                                        </td>
                                        <td>
                                            <select class="form-control form-control-sm" id="tahunCetakKembali" name="tahun">
                                                <?php foreach ($years as $year) : ?>
                                                    <option value="<?= $year['tahun'] ?>"><?= $year['tahun'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <button type="submit" class="btn btn-primary btn-sm" id="btnCetakPinjam">
                                                <span class="icon text-white-100">
                                                    <i class="fas fa-print spaced-icon"></i>
                                                </span>
                                                <span class="text">Cetak Opname</span>
                                            </button>
                                            <button type="submit" formaction="<?= site_url('/cetak/mutasi/bulan'); ?>" class="btn btn-success btn-sm" id="btnCetakTahunKembali">
                                                <i class="fas fa-print spaced-icon"></i>
                                                <span class="text">Rekap Mutasi</span>
                                            </button>
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
                                                    <option value="<?= $year['tahun'] ?>"><?= $year['tahun'] ?></option>
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

        </div>


        <div class="row">
            <div class="col-md-6" style="font-size: 14px;">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Cetak Laporan <STRONG>REKAP OPNAME </STRONG></h6>
                    </div>
                    <div class="card-body">
                        <form method="get" action="/cetak/stock/rekap" target="_blank">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <thead>
                                        <th style="text-align: left;">Pilih Tahun</th>
                                        <th></th>
                                    </thead>

                                    <tr>
                                        <td>
                                            <select class="form-control form-control-sm" id="btnCetakRekapOpname" name="tahun">
                                                <?php foreach ($years as $year) : ?>
                                                    <option value="<?= $year['tahun'] ?>"><?= $year['tahun'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <button type="submit" class="btn btn-warning btn-sm" id="btnCetakRekapOpname">
                                                <i class="fas fa-print spaced-icon"></i>
                                                <span class="text">Cetak Rekap</span>
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
                    <div class="card-body bg-success">
                        <dl class="row" style="font-size: 13px;">
                            <dt class="col-sm-3">Opname Bulanan</dt>
                            <dd class="col-sm-9">Mencetak laporan stok opname perbulan berdasarkan data penerimaan dan pengeluaran pada Bulan dan Tahun yang dipilih</dd>

                            <dt class="col-sm-3">Opname Tahunan</dt>
                            <dd class="col-sm-9">
                                Mencetak laporan stok opname berdasarkan data penerimaan dan pengeluaran pada Tahun yang dipilih
                            </dd>
                            <dt class="col-sm-3">Rekap Stock</dt>
                            <dd class="col-sm-9">
                                Mencetak laporan Rekapitulasi Stock Opname Barang Persediaan, sampai keadaan tahun berjalan.
                            </dd>
                        </dl>
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
<?php echo view('tema/footer.php'); ?>