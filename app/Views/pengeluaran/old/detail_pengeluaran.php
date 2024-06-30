<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Daftar Barang Rusak</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Barang</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8 col-12">
                    <div class="card card-danger card-outline shadow-lg">

                        <div class="card-body">
                            <table id="daftarBarangTable" class="table table-striped table-responsive table-sm">
                                <thead class="thead-grey" style="font-size: 14px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center;">Kode Barang</th>
                                        <th style="text-align: center;">Nama Barang</th>
                                        <th style="text-align: center;">Jumlah Barang</th>
                                        <th style="text-align: center;">AKSI</th>
                                    </tr>
                                </thead>
                                <div id="alertContainer" class="mt-3"></div>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($data_barang_rusak as $barang_rusak) : ?>
                                        <tr class="searchable-row">
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;"><?= $i++; ?></th>
                                            <td width='20%' style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $barang_rusak['kode_barang']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $barang_rusak['nama_barang']; ?></td>
                                            <td width='20%' style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $barang_rusak['total_jumlah']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#detailModal<?= $barang_rusak['nama_barang']; ?>">
                                                    <i class='fas fa-eye'></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="detailModal<?= $barang_rusak['nama_barang']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title" id="exampleModalLabel">Detail Barang - <?= $barang_rusak['nama_barang']; ?></h6>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">


                                                        <?php
                                                        if (isset($detailBarang[$barang_rusak['nama_barang']])) {
                                                            foreach ($detailBarang[$barang_rusak['nama_barang']] as $detail) {

                                                                echo '<p>Kode Barang: ' . $detail['kode_barang'] . ', Jumlah: ' . $detail['total_jumlah'] . '</p>';
                                                            }
                                                        }
                                                        ?>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="card card-danger card-outline shadow-lg">
                        <div class="card-body">
                            <p class="lead">
                                <i class='fas fa-bullhorn spaced-icon'></i>Informasi
                            </p>
                            <p>
                                Daftar barang yang tampil pada halaman ini adalah nama-nama barang dengan <strong>Kondisi Rusak</strong>.
                            </p>
                            <p>Barang yang ada pada halaman ini, tidak ditampilkan pada Daftar Barang yang dapat dipinjam.
                        </div>
                    </div>
                </div>
            </div>




        </div>
    </div>

</div>


<?php echo view('tema/footer.php'); ?>