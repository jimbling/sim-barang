<?php echo view('tema/header.php'); ?>
<style>
    .table td,
    .table th {
        font-size: 13px;
    }
</style>
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

                            <table id="daftarRiwayatPeminjamanTable" class="table table-striped table-sm table-hover" style="width:100%">
                                <thead class="thead-dark" style="font-size: 13px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center; font-size: 13px;">Kode Pinjam</th>
                                        <th style="text-align: center; font-size: 13px;">Nama Peminjam</th>
                                        <th style="text-align: center; font-size: 13px;">Tanggal Pinjam</th>
                                        <th style="text-align: center; font-size: 13px;">Digunakan untuk</th>
                                        <th style="text-align: center; font-size: 13px;">Nama Barang</th>
                                        <th style="text-align: center; font-size: 13px;">Aksi</th>
                                    </tr>
                                </thead>
                                <div id="alertContainer" class="mt-3"></div>
                                <tbody>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<script src="../../assets/dist/js/jquery-3.6.4.min.js"></script>
<script>
    const baseUrl = "<?= base_url() ?>/";
</script>
<script src="<?= base_url('assets/dist/js/frontend-js/pinjamRiwayat.js') ?>"></script>


<?php echo view('tema/footer.php'); ?>