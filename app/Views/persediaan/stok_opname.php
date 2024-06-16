<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanAddBarangSatuan')); ?>"></div>
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Stok Opname</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Stok Opname</li>
                    </ol>
                </div>
            </div>
            <div class="callout callout-info" style="font-size: 13px;">
                <h5><i class="fas fa-info"></i> Catatan:</h5>
                Stock Opname Barang Persediaan ditampilkan berdasarkan Stock Terbanyak. Barang yang memiliki stock dibawah 3 atau 0 (habis) akan berwarna Merah.
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="card card-primary card-outline shadow-lg">


                        <div class="card-body">
                            <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">

                                </div>
                                <div class="btn-group" role="group" aria-label="First group">
                                    <div class="col-md-12 col-12">
                                        <a class="btn btn-success btn-sm" href="/persediaan/opname/export" role="button"> <i class='fas fa-file-excel spaced-icon'></i>Export Excel</a>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <table id="opnameBarangPersediaan" class="table table-striped table-responsive">
                                <thead class="thead-grey" style="font-size: 13px;">
                                    <tr>
                                        <th width='3%' style="text-align: center; vertical-align: middle; font-size: 13px;">No</th>
                                        <th style="text-align: center; vertical-align: middle; font-size: 13px;">Prodi/Jursan</th>
                                        <th style="text-align: center; vertical-align: middle; font-size: 13px;">Kelompok Barang</th>
                                        <th style="text-align: center; vertical-align: middle; font-size: 13px;">Kode Barang</th>
                                        <th style="text-align: center; vertical-align: middle; font-size: 13px;">Nama Barang</th>
                                        <th style="text-align: center; vertical-align: middle; font-size: 13px;">Harga Satuan</th>
                                        <th style="text-align: center; vertical-align: middle; font-size: 13px;">Satuan</th>
                                        <th style="text-align: center; vertical-align: middle; font-size: 13px;">Stok</th>
                                    </tr>
                                </thead>
                                <div id="alertContainer" class="mt-3"></div>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($data_barang_persediaan as $brgPersediaan) : ?>
                                        <tr>
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 13px;"><?= $i++; ?></th>
                                            <td style="text-align: center; vertical-align: middle; font-size: 13px;"><?= $brgPersediaan['prodi']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 13px;"><?= $brgPersediaan['kelompok_barang']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 13px;"><?= $brgPersediaan['kode_barang']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 13px;<?= ($brgPersediaan['stok'] < 3) ? 'color: red;' : ''; ?>"><?= $brgPersediaan['nama_barang']; ?></td>
                                            <td width='10%' style="text-align: right; vertical-align: middle; font-size: 13px;">
                                                <?= 'Rp. ' . number_format($brgPersediaan['harga_satuan'], 0, ',', '.'); ?>
                                            </td>
                                            <td width='10%' style="text-align: center; vertical-align: middle; font-size: 13px;"><?= $brgPersediaan['satuan']; ?></td>
                                            <td width='10%' style="text-align: center; vertical-align: middle; font-size: 13px;<?= ($brgPersediaan['stok'] < 3)  ? 'color: red;' : ''; ?>"><?= $brgPersediaan['stok']; ?></td>
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







<?php echo view('tema/footer.php'); ?>