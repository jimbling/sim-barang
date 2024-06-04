<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <meta name="description" content="Sistem Informasi Managemen Pengelolaan, Penggunaan Barang Laboratorium Keperawatan.">
    <?php if (!empty($data_pinjamLuar)) : ?>
        <?php $pinjamLuar = $data_pinjamLuar[0]; ?>
        <title><?= isset($pinjamLuar['no_invoice']) ? $pinjamLuar['no_invoice'] : 'Judul Default Jika Tidak Ada No Invoice'; ?></title>
    <?php else : ?>
        <title>Judul Default Jika Tidak Ada Data</title>
    <?php endif; ?>

    <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/dist/css/adminlte.min.css?v=3.2.0">
    <link rel="stylesheet" href="../../assets/dist/css/style-2.css">
    <link rel="stylesheet" href="../../assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../../assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="../../assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="../../assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <link rel="stylesheet" href="../../assets/plugins/bs-stepper/css/bs-stepper.min.css">

    <style>
        @media print {
            .bg-danger {
                background-color: transparent !important;
                /* Menghilangkan warna latar belakang */
            }

            td.bg-danger b {
                font-weight: bold;
                color: red;
            }

        }
    </style>

</head>


<body>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="invoice p-3 mb-3">

                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <img src="../../assets/dist/img/<?php echo $data_invoice['data_logo']; ?>" width="40px" alt="<?php echo $data_invoice['data_kampus']; ?>"> <?php echo $data_invoice['data_kampus']; ?>
                                    <small class="float-right">Tanggal: <?php echo date('Y-m-d H:i:s'); ?></small>
                                </h4>
                            </div>

                        </div>

                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                Dari
                                <address>
                                    <strong><?php echo $data_invoice['data_kampus']; ?></strong><br>
                                    <?php echo $data_invoice['data_alamat']; ?>
                                    <br>Telp: <?php echo $data_invoice['data_telp']; ?>
                                    <br>Email: <?php echo $data_invoice['data_email']; ?>
                                </address>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                Kepada
                                <address>
                                    <?php if (!empty($data_pinjamLuar)) : ?>
                                        <?php $pinjamLuar = $data_pinjamLuar[0]; // Assuming the first row contains all the necessary data 
                                        ?>
                                        <strong><?= $pinjamLuar['nama_peminjam']; ?></strong><br>
                                        <?= $pinjamLuar['nama_instansi']; ?><br>
                                        <?= $pinjamLuar['alamat_instansi']; ?><br>
                                        Telp: <?= $pinjamLuar['no_telp']; ?><br>
                                        Email: <?= $pinjamLuar['email']; ?>
                                </address>
                            <?php endif; ?>
                            </div>

                            <div class="col-sm-4 invoice-col">
                                <?php if (!empty($data_pinjamLuar)) : ?>
                                    <?php $pinjamLuar = $data_pinjamLuar[0]; // Assuming the first row contains all the necessary data 
                                    ?>
                                    <b>Invoice #<?= $pinjamLuar['no_invoice']; ?></b><br>
                                    <br>
                                    <b>Kode Pinjam:</b> <?= $pinjamLuar['kode_pinjam']; ?><br>
                                    <b>Tanggal Pinjam:</b> <?php
                                                            $tanggal_pinjam = \CodeIgniter\I18n\Time::parse($pinjamLuar['tanggal_pinjam'])
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

                                                            echo $tanggal_pinjam->format('d ') . $bulan . $tanggal_pinjam->format(' Y');
                                                            ?><br>
                                    <b>Tanggal Kembali:</b> <?php
                                                            $tanggal_kembali = \CodeIgniter\I18n\Time::parse($pinjamLuar['tanggal_kembali'])
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

                                                            $bulan = $nama_bulan[$tanggal_kembali->format('F')];

                                                            echo $tanggal_kembali->format('d ') . $bulan . $tanggal_kembali->format(' Y');
                                                            ?><br>
                                <?php endif; ?>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle; font-size: 14px;">Qty</th>
                                            <th style="text-align: center; vertical-align: middle; font-size: 14px;">Nama Barang</th>
                                            <th style="text-align: center; vertical-align: middle; font-size: 14px;">Kode Barang</th>
                                            <th style="text-align: center; vertical-align: middle; font-size: 14px;">Lama Pinjam (Hari)</th>
                                            <th style="text-align: center; vertical-align: middle; font-size: 14px;">Harga Sewa</th>
                                            <th style="text-align: center; vertical-align: middle; font-size: 14px;">Jumlah Harga</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $totalSemuaHarga = 0; // Inisialisasi variabel totalSemuaHarga sebelum loop

                                        foreach ($data_pinjamLuar as $PinjamLuar) :
                                        ?>
                                            <tr>
                                                <td style="text-align: center; vertical-align: middle; font-size: 14px;">1</td>
                                                <td style="text-align: left; vertical-align: middle; font-size: 14px;">
                                                    <?= $PinjamLuar['nama_barang']; ?> <br>
                                                </td>
                                                <td style="text-align: left; vertical-align: middle; font-size: 14px;">
                                                    <?= $PinjamLuar['kode_barang']; ?> <br>
                                                </td>
                                                <td width="10%" style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $PinjamLuar['lama_pinjam']; ?></td>
                                                <td style="text-align: left; vertical-align: middle; font-size: 14px;">
                                                    <?= 'Rp. ' . number_format($PinjamLuar['harga_sewa'], 0, ',', '.'); ?>
                                                </td>
                                                <td style="text-align: center; vertical-align: middle; font-size: 14px;">
                                                    <?php
                                                    $totalHarga = $PinjamLuar['lama_pinjam'] * $PinjamLuar['harga_sewa'];
                                                    echo 'Rp. ' . number_format($totalHarga, 0, ',', '.');

                                                    // Menambahkan nilai totalHarga ke dalam totalSemuaHarga
                                                    $totalSemuaHarga += $totalHarga;
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php
                                        endforeach;

                                        // Menambahkan biaya perawatan ke dalam totalSemuaHarga di luar loop
                                        $biayaPerawatan = 20000;
                                        $totalSemuaHarga += $biayaPerawatan;
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-6">
                                <p class="lead">Pembayaran:</p>
                                <img src="../../assets/dist/img/<?php echo $data_invoice['data_logoBank']; ?>" width="300px" alt="BRI">
                                <p style="margin-top: 10px;" font-size="bold">
                                    <?php echo $data_invoice['data_bank']; ?>
                                    <br>No. Rekening : <?php echo $data_invoice['data_rek']; ?>
                                    <br> Atas Nama : <?php echo $data_invoice['data_an']; ?></br>

                            </div>

                            <div class="col-6">
                                <p class="lead">Jumlah yang harus dibayarkan</p>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td style="text-align: right;"><?php echo 'Rp. ' . number_format($totalSemuaHarga - $biayaPerawatan, 0, ',', '.'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Biaya Perawatan:</th>
                                            <td style="text-align: right;"><?php echo 'Rp. ' . number_format($biayaPerawatan, 0, ',', '.'); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-danger">Total:</th>
                                            <td class="bg-danger" style="text-align: right;"><b><?php echo 'Rp. ' . number_format($totalSemuaHarga, 0, ',', '.'); ?></b></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>


                        <div class="row no-print">
                            <div class="col-12">
                                <button onclick="window.print()" class="btn btn-success"><i class="fas fa-print spaced-icon"></i> Cetak Invoice</button>
                                <a href="/pihakluar" rel="noopener" class="btn btn-warning"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>





    <script src="../../assets/plugins/jquery/jquery.min.js"></script>
    <script src="../../assets/dist/js/form-validation.js"></script>
    <script src="../../assets/plugins/select2/js/select2.full.min.js"></script>
    <script src="../../assets/plugins/select2/js/select2.min.js"></script>
    <script src="../../assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="../../assets/plugins/moment/moment.min.js"></script>
    <script src="../../assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script>
        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()
    </script>
    <script>
        $(function() {
            //Date picker
            $('#tanggalPinjam').datetimepicker({
                format: 'L'
            });
            $('#tanggalKembali').datetimepicker({
                format: 'L'
            });

        })
    </script>


</body>

</html>