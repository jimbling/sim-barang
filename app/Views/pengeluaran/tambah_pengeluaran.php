<?php echo view('tema/header.php'); ?>
<style>
    #modalPilihBarang .btn {
        margin: 2px;
    }
</style>
<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('errorMessages')); ?>"></div>
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Form Pengeluaran Barang Persediaan</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <div class="col-md-12 col-12">
                            <a href="/pengeluaran/daftar" class="btn btn-danger btn-sm"> <i class='fas fa-undo-alt spaced-icon'></i>Kembali</a>
                            </a>
                        </div>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <form action="/pengeluaran/simpan" method="post" id="formTambahPeneriman">
                <div class="row">
                    <div class="col-md-7 col-12">

                        <div class="card card-primary card-outline shadow-lg">

                            <div class="card-body">

                                <input type="hidden" id="peminjaman_id_hidden" name="peminjaman_id" value="">

                                <div class="row">
                                    <div class="col-sm">
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#pilihKodePinjam">
                                            <i class='fas fa-search spaced-icon'></i> Pilih Kode Pinjam
                                        </button>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Id </label>
                                            <input type="text" id="peminjaman_id_display" class="form-control form-control-sm" placeholder="ID" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Nama Peminjam</label>
                                            <input type="text" id="nama_peminjam" name="nama_peminjam" class="form-control form-control-sm" placeholder="Nama Peminjam" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Nama Ruangan</label>
                                            <input type="text" id="nama_ruangan" name="nama_ruangan" class="form-control form-control-sm" placeholder="Nama Ruangan" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Penggunaan</label>
                                            <input type="text" id="penggunaan" name="penggunaan" class="form-control form-control-sm" placeholder="Penggunaan" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Tanggal Pinjam</label>
                                            <input type="text" id="tanggal_pinjam" name="tanggal_pinjam" class="form-control form-control-sm" placeholder="Tanggal Pinjam" readonly>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-12">
                        <div class="card card-primary shadow-lg">
                            <div class="card-header bg-danger">
                                <h6>Tambah Barang</h6>
                            </div>
                            <div class="card-body">
                                <div class="container">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="barang_id">Barang</label>
                                                <div class="input-group">
                                                    <input type="text" id="barang_display" class="form-control form-control-sm" placeholder="Pilih Barang" readonly>
                                                    <input type="hidden" id="barang_id[]" name="barang_id[]">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalPilihBarang">
                                                            Pilih Barang
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ambil_barang">Ambil Barang</label>
                                                <input type="text" id="ambil_barang" name="ambil_barang[]" class="form-control form-control-sm" placeholder="Ambil Barang">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ambil_barang">Maksimal Ambil</label>
                                                <input type="text" id="jumlah_barang" name="jumlah_barang[]" class="form-control form-control-sm" placeholder="Jumlah Barang" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="display:none">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="harga_satuan">Harga Satuan</label>
                                                <input type="text" id="harga_satuan" name="harga_satuan[]" class="form-control form-control-sm" placeholder="Harga Satuan" readonly>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row" style="display:none">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="jumlah_harga">Jumlah Harga</label>
                                                <input type="text" id="jumlah_harga" name="jumlah_harga[]" class="form-control form-control-sm" placeholder="Jumlah Harga" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm" id="btnSimpan">
                                        <span id="btnText">Simpan</span>
                                        <span id="btnSpinner" style="display: none;">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="card card-primary card-outline shadow-lg">
                <div class="card-body">
                    <!-- Tabel untuk menampilkan data barang yang terpilih -->
                    <table id="daftarBarangPersediaan" class="table table-striped table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Barang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
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

<div class="modal fade" id="pilihKodePinjam" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Kode Pinjam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="daftarKodePinjamPersed" class="table table-striped table-responsive table-sm">
                    <thead class="thead-grey" style="font-size: 14px;">
                        <tr>
                            <th width='3%'>No</th>
                            <th style="text-align: center;">Kode Pinjam</th>
                            <th style="text-align: center;">Nama Peminjam</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($data_peminjaman as $ambil_kode) : ?>
                            <tr>
                                <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;"><?= $i++; ?></th>
                                <td style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $ambil_kode['kode_pinjam']; ?></td>
                                <td style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $ambil_kode['nama_peminjam']; ?></td>
                                <td style="text-align: center; vertical-align: middle; font-size: 14px;">
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="pilihData('<?= $ambil_kode['peminjaman_id']; ?>','<?= $ambil_kode['barang_ids']; ?>','<?= $ambil_kode['kode_pinjam']; ?>', '<?= $ambil_kode['nama_peminjam']; ?>', '<?= $ambil_kode['nama_ruangan']; ?>', '<?= $ambil_kode['keperluan']; ?>', '<?= $ambil_kode['tanggal_pinjam']; ?>', '<?= $ambil_kode['barang_dipinjam']; ?>')">Pilih</button>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal Pilih Barang -->
<div class="modal fade" id="modalPilihBarang" tabindex="-1" role="dialog" aria-labelledby="modalPilihBarangLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPilihBarangLabel">Pilih Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="text" class="form-control mb-2" id="inputPencarianBarang" placeholder="Cari Barang">

                <?php if (empty($barang_persediaan)) : ?>
                    <div class="alert alert-danger" role="alert">
                        Data Barang Belum Ada Karena Belum Tutup Buku, Silahkan lakukan tutup buku terlebih dahulu.
                    </div>
                <?php else : ?>
                    <?php foreach ($barang_persediaan as $barang) : ?>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="pilihBarang('<?= $barang->barang_id ?>', '<?= $barang->nama_barang ?>', '<?= $barang->harga_satuan ?>', '<?= $barang->sisa_stok ?>')">
                            <?= $barang->nama_barang ?>
                        </button>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>



<script>
    const baseUrl = "<?= base_url() ?>/";
</script>
<script src="../../assets/dist/js/jquery-3.6.4.min.js"></script>
<script src="<?= base_url('assets/dist/js/frontend-js/tambahPengeluaran.js') ?>"></script>

<?php echo view('tema/footer.php'); ?>