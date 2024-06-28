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
            <?php if (session('validation')) : ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session('validation')->getErrors() as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h6 class="m-0">Form Pengeluaran Barang Persediaan Tanpa Peminjaman</h6>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <div class="col-md-12 col-12">
                            <a href="/pengeluaran/bhp" class="btn btn-danger btn-sm"> <i class='fas fa-undo-alt spaced-icon'></i>Kembali</a>
                            </a>
                        </div>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <form action="/pengeluaran/bhp/simpan" method="post" id="formTambahPeneriman">
                <div class="row">
                    <div class="col-md-7 col-12">

                        <div class="card card-primary card-outline shadow-lg">

                            <div class="card-body">
                                <input type="hidden" id="id_hidden" name="id" value="<?= $data_pengeluaran_murni['id'] ?? ''; ?>">
                                <div class="row mt-2">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Nama Pengguna</label>
                                            <input type="text" id="nama_pengguna_barang" name="nama_pengguna_barang" class="form-control form-control-sm" placeholder="Nama Peminjam" readonly value="<?= $data_pengeluaran_murni['nama_pengguna_barang'] ?? ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Tanggal</label>
                                            <input type="text" id="tanggal_penggunaan" name="tanggal_penggunaan" class="form-control form-control-sm" placeholder="Nama Ruangan" readonly value="<?= $data_pengeluaran_murni['tanggal_penggunaan'] ?? ''; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Keperluan</label>
                                            <textarea id="keperluan" name="keperluan" class="form-control form-control-sm" placeholder="Penggunaan" readonly><?= $data_pengeluaran_murni['keperluan'] ?? ''; ?></textarea>
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
                                                <label for="ambil_barang_murni">Ambil Barang</label>
                                                <input type="text" id="ambil_barang_murni" name="ambil_barang_murni[]" class="form-control form-control-sm" placeholder="Ambil Barang">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ambil_barang_murni">Maksimal Ambil</label>
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
                                    <td><?= $barang['jumlah_barang'] ?></td>
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
<script src="<?= base_url('assets/dist/js/frontend-js/mintaBarang.js') ?>"></script>

<?php echo view('tema/footer.php'); ?>