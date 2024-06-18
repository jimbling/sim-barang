<?php echo view('tema/header.php'); ?>
<style>
    .table td,
    .table th {
        font-size: 13px;
    }
</style>
<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanEditBarang')); ?>"></div><!-- Page Heading -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="alert alert-info" style="font-size: 14px;" role="alert">
                Pada halaman ini, menampilkan seluruh data barang dengan jumlah satuan, beserta dengan kode untuk masing-masing barang.
                <p><strong>Setiap barang, memiliki kode/no inventaris yang unik, meskipun nama barangnya sama.</strong>
                <p>Untuk menambahkan barang dalam jumlah banyak, disarankan menggunakan fasilitas Import Data
            </div>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Data Barang</h4>
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
                <div class="col-md-9 col-12">
                    <div class="card card-primary card-outline shadow-lg">

                        <div class="card-header">
                            <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">
                                    <button type="button" class="btn btn-warning btn-sm float-right" data-toggle="modal" data-target="#importBarangModal">
                                        <i class='fas fa-upload spaced-icon'></i>Import</a>
                                    </button>
                                </div>
                                <div class="btn-toolbar">
                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteSelectedItems()"><i class='fas fa-trash-alt spaced-icon'></i>Hapus</button>
                                    </td>
                                </div>
                            </div>
                            <div class="row">
                            </div>
                        </div>


                        <div class="card-body">
                            <table id="dataBarangTable" class="table table-striped table-responsive table-sm" width="100%">
                                <thead class=" thead-grey" style="font-size: 14px;">
                                    <tr>
                                        <th width='3%' style="text-align: center; vertical-align: middle; font-size: 14px;">No</th>
                                        <th style="text-align: center; vertical-align: middle; font-size: 14px;">Kode Barang</th>
                                        <th style="text-align: center; vertical-align: middle; font-size: 14px;">Nama Barang</th>
                                        <th style="text-align: center; vertical-align: middle; font-size: 14px;">Jumlah Barang</th>
                                        <th width='10%' style="text-align: center; vertical-align: middle; font-size: 14px;">Kondisi Barang</th>
                                        <th width='10%' style="text-align: center; vertical-align: middle; font-size: 14px;">Disewakan</th>
                                        <th width='5%' style="text-align: center; vertical-align: middle;">

                                            <input type="checkbox" id="select-all-checkbox">
                                        </th> <!-- Checkbox master -->
                                        <th style="text-align: center; vertical-align: middle;">AKSI</th>
                                    </tr>
                                </thead>

                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="card card-danger card-outline shadow-lg">
                        <div class="card-header">
                            Tambah Barang Baru
                        </div>
                        <div class="card-body">
                            <form action="/barang/tambah" method="post">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">
                                <div class="form-group">
                                    <label for="inputAddress">Kode Barang:</label>
                                    <input type="text" class="form-control" id="kode_barang" name="kode_barang" placeholder="Masukkan no. inventaris barang" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress">Nama Barang:</label>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Masukkan nama barang" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputAddress2">Jumlah Barang:</label>
                                    <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang" placeholder="Masukkan jumlah barang" oninput="validateNumberInput(this)" required>
                                    <small id="jumlah_barang_error" class="text-danger"></small>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary btn-sm"><i class='fas fa-sign-in-alt spaced-icon'></i>Tambah</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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

<!-- Modal untuk import data barang -->
<div class="modal fade" id="importBarangModal" tabindex="-1" aria-labelledby="importBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importBarangModalLabel">Import Data Barang</h5>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form action="/siswa/importData" method="post" enctype="multipart/form-data" id="uploadForm">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="excel_file" aria-describedby="excel_file" name="excel_file">
                                <label class="custom-file-label" for="excel_file">Pilih file Excel</label>
                            </div>
                        </div>
                        <span id="excel_file"></span>
                        <!-- Tambahkan elemen ini untuk menampilkan nama file -->
                        <span id="file_name_display"></span>
                    </form>

                    <div class="alert alert-info mt-3" role="alert">
                        <p><strong>Informasi</strong></p>
                        <p>Gunakan hanya file ber ekstensi <strong>.xls</strong> atau <strong>.xlsx </strong>. </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="input-group-append">
                    <style>
                        button {
                            margin-right: 10px;
                            /* Atur jarak kanan antara tombol */
                        }
                    </style>
                    <button type="button" class="btn btn-warning mt-2" data-dismiss="modal"><i class='fas fa-reply-all' style="margin-right: 5px;"></i></i>Batal</button>
                    <button class="btn btn-outline-primary mt-2" type="button" id="importButton"><i class='fas fa-upload' style="margin-right: 5px;"></i> Impor</button>
                    <div class="spinner-container">
                        <div id="loading" class="spinner-border text-primary" role="status" style="display: none;">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <span id="processText" style="display: none;">Proses kirim data...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal untuk Import Data Barang -->

<!-- Modal Edit Data Barang -->
<div class="modal fade" id="editBarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/barang/update" method="post" id="formEditBarang">
                <input type="hidden" name="edit_id" id="edit_id" value="">
                <div class="modal-body">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">

                    <div class="form-group row">
                        <label for="nama_barang_edit" class="col-sm-4 col-form-label">Nama Barang</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama_barang_edit" id="nama_barang_edit">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah_barang_edit" class="col-sm-4 col-form-label">Jumlah Barang</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="jumlah_barang_edit" id="jumlah_barang_edit">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kondisi_barang_edit" class="col-sm-4 col-form-label">Kondisi Barang</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="kondisi_barang_edit" name="kondisi_barang_edit">
                                <option value="baik">Baik</option>
                                <option value="rusak">Rusak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="disewakan_edit" class="col-sm-4 col-form-label">Disewakan</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="disewakan_edit" name="disewakan_edit">
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="harga_sewa_edit" class="col-sm-4 col-form-label">Harga Sewa</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="harga_sewa_edit" id="harga_sewa_edit">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const baseUrl = "<?= base_url() ?>/";
</script>
<script src="../../assets/dist/js/jquery-3.6.4.min.js"></script>
<script src="<?= base_url('assets/dist/js/frontend-js/masterBarang.js') ?>"></script>




<?php echo view('tema/footer.php'); ?>