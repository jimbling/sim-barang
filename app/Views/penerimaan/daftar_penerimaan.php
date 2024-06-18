<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanHapusPosts')); ?>"></div><!-- Page Heading -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Daftar Penerimaan Barang Persediaan</h5>
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
                <div class="col-md-12 col-12">
                    <div class="card card-primary card-outline shadow-lg">
                        <div class="card-header">
                            <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">
                                    <div class="col-md-12 col-12">
                                        <a class="btn btn-success btn-sm" href="/penerimaan/tambahBaru" role="button"> <i class='fas fa-cart-arrow-down spaced-icon'></i>Tambah Penerimaan</a>
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="daftarPenerimaanPersediaanTable" class="table table-striped table-responsive">
                                <thead class="thead bg-info" style="font-size: 14px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center;">Jurusan/Prodi</th>
                                        <th style="text-align: center;">Kelompok Barang</th>
                                        <th style="text-align: center;">Jumlah Harga Penerimaan</th>
                                        <th style="text-align: center;">Jenis Penerimaan</th>
                                        <th style="text-align: center;">Tanggal Penerimaan</th>
                                        <th style="text-align: center;">Petugas</th>
                                        <th style="text-align: center;">Detail</th>
                                    </tr>
                                </thead>
                                <div id="alertContainer" class="mt-3"></div>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($data_penerimaan as $dataPenerimaan) : ?>
                                        <tr>
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;"><?= $i++; ?></th>
                                            <td style="text-align: left; vertical-align: middle; font-size: 14px;"><?= $dataPenerimaan['prodi']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $dataPenerimaan['kelompok_barang']; ?></td>


                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;">
                                                <?= 'Rp. ' . number_format($dataPenerimaan['total_jumlah_harga'], 0, ',', '.'); ?>
                                            </td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $dataPenerimaan['jenis_perolehan']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;">
                                                <?php
                                                $tanggal_penerimaan = \CodeIgniter\I18n\Time::parse($dataPenerimaan['tanggal_penerimaan'])
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

                                                $bulan = $nama_bulan[$tanggal_penerimaan->format('F')];

                                                echo $tanggal_penerimaan->format('d ') . $bulan . $tanggal_penerimaan->format(' Y');
                                                ?>
                                            </td>


                                            <td width='15%' style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $dataPenerimaan['petugas']; ?></td>
                                            <td width='10%' style="text-align: center; vertical-align: middle; font-size: 14px;">
                                                <button type="button" class="btn btn-warning btn-xs btn-detail" data-toggle="tooltip" data-placement="left" title="Detail" data-toggle="modal" data-penerimaan-id="<?= $dataPenerimaan['penerimaan_id']; ?>">
                                                    <i class='fas fa-eye'></i>
                                                </button>

                                                <a onclick=" hapus_data('<?= $dataPenerimaan['penerimaan_id']; ?>')" class="btn btn-xs btn-danger mx-auto text-white" id="button" data-toggle="tooltip" data-placement="top" title="Hapus"> <i class='fas fa-trash'></i></a>
                                            </td>

                                        </tr>
                                        <!-- Modal -->

                                        <!-- End Modal -->
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Modal -->
            <div class="modal fade" id="detailModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                    <div class="modal-content modal-static">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Detail Penerimaan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="detailContent"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->






        </div>
    </div>

</div>





<script src="../../assets/dist/js/jquery-3.6.4.min.js"></script>
<script>
    const baseUrl = "<?= base_url() ?>/";
</script>
<script src="<?= base_url('assets/dist/js/frontend-js/daftarPenerimaan.js') ?>"></script>




<?php echo view('tema/footer.php'); ?>