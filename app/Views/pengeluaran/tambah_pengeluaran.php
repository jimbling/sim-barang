<?php echo view('tema/header.php'); ?>
<style>
    #modalPilihBarang .btn {
        margin: 2px;
    }
</style>
<?php

$session = session();

$nama = $session->get('full_nama');
$username = $session->get('user_nama');
$password = $session->get('user_password');
$level = $session->get('level');
?>
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
                            <?php
                            $userLevel = session('level'); // Asumsikan session('level') menyimpan level pengguna

                            $linkUrl = ($userLevel == 'User') ? '/pinjam/daftar' : '/pengeluaran/daftar';
                            ?>
                            <a href="<?= $linkUrl ?>" class="btn btn-danger btn-sm">
                                <i class='fas fa-undo-alt spaced-icon'></i>Kembali
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

                                <input type="hidden" id="peminjaman_id_hidden" name="peminjaman_id" value="<?= $data_peminjaman['id'] ?? ''; ?>">
                                <div class="row mt-2">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Id </label>
                                            <input type="text" id="peminjaman_id_display" class="form-control form-control-sm" placeholder="ID" readonly name="" value="<?= $data_peminjaman['id'] ?? ''; ?>">
                                        </div>
                                    </div>
                                    <div class=" col-md-5">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Nama Peminjam</label>
                                            <input type="text" id="nama_peminjam" name="nama_peminjam" class="form-control form-control-sm" placeholder="Nama Peminjam" readonly name="nama_peminjam" value="<?= $data_peminjaman['nama_peminjam'] ?? ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Nama Ruangan</label>
                                            <input type="text" id="nama_ruangan" name="nama_ruangan" class="form-control form-control-sm" placeholder="Nama Ruangan" readonly name="nama_ruangan" value="<?= $data_peminjaman['nama_ruangan'] ?? ''; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Penggunaan</label>
                                            <input type="text" id="penggunaan" name="penggunaan" class="form-control form-control-sm" placeholder="Penggunaan" readonly name="keperluan" value="<?= $data_peminjaman['keperluan'] ?? ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Tanggal Pinjam</label>
                                            <input type="text" id="tanggal_pinjam" name="tanggal_pinjam" class="form-control form-control-sm" placeholder="Tanggal Pinjam" name="tanggal_pinjam" readonly value="<?= $data_peminjaman['tanggal_pinjam'] ?? ''; ?>">
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
                        <tbody id="tabelBarangBody">
                            <?php foreach ($data_barang_terpilih as $barang) : ?>
                                <tr>
                                    <td><?= $barang['id'] ?></td>
                                    <td><?= $barang['nama_barang'] ?></td>
                                    <td><?= $barang['ambil_barang'] ?></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm btnHapusBarang" data-id="<?= $barang['id'] ?>">Hapus</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>


    </div>
</div>








<!-- Modal Pilih Barang -->
<div class="modal fade" id="modalPilihBarang" tabindex="-1" role="dialog" aria-labelledby="modalPilihBarangLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPilihBarangLabel">Pilih Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <input type="text" class="form-control mb-2" id="inputPencarianBarang" placeholder="Cari Barang">

                <?php foreach ($barang_persediaan as $barang) : ?>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="pilihBarang('<?= $barang->barang_id ?>', '<?= $barang->nama_barang ?>', '<?= $barang->harga_satuan ?>', '<?= $barang->stok ?>')">
                        <?= $barang->nama_barang ?>
                    </button>
                <?php endforeach; ?>
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