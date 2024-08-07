<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanEditMhs')); ?>"></div><!-- Page Heading -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Data Mahasiswa</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Mahasiswa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8 col-12">
                    <div class="card card-primary card-outline shadow-lg">

                        <div class="card-header">
                            <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#importMhsModal">
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
                            <table id="dataMhsTable" class="table table-striped table-responsive table-sm">
                                <thead class="thead-grey" style="font-size: 14px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center;">NIM</th>
                                        <th style="text-align: center;">Nama Lengkap</th>
                                        <th width='10%' style="text-align: center;">
                                            <input type="checkbox" id="select-all-checkbox">
                                        </th> <!-- Checkbox master -->
                                        <th style="text-align: center;">AKSI</th>
                                    </tr>
                                </thead>
                                <div id="alertContainer" class="mt-3"></div>
                                <tbody></tbody> <!-- Remove the PHP loop here -->
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="card card-danger card-outline shadow-lg">
                        <div class="card-header">
                            Tambah Mahasiswa Baru
                        </div>
                        <div class="card-body">
                            <form id="form-mahasiswa" action="/data/mahasiswa/tambah" method="post">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">
                                <div class="form-group">
                                    <label for="nim">NIM:</label>
                                    <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan Nomor Induk Mahasiswa">
                                </div>
                                <div class="form-group">
                                    <label for="nama_lengkao">Nama Lengkap:</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap Mahasiswa" id="form-mahasiswa">
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary btn-sm"><i class='fas fa-sign-in-alt spaced-icon'></i>Tambah</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card card-warning card-outline shadow-lg">
                        <div class="card-header">
                            <strong>Buat Akun Mahasiswa</strong>
                        </div>
                        <div class="card-body">
                            <p>
                                Untuk membuat Akun Login Mahasiswa, silahkan pilih data Mahasiswa dengan Checkbox yang akan dibuatkan Akun Login, kemudian tekan tombol Buat Akun dibawah ini.
                            </p>
                            <div class="btn-toolbar">
                                <td style="text-align: center;">
                                    <button type="button" class="btn bg-indigo btn-sm" onclick="copySelectedItems()"><i class='fas fa-user-shield spaced-icon'></i>Buat Akun</button>
                                </td>
                            </div>
                        </div>
                    </div>

                </div>
            </div>




        </div>
    </div>

</div>



<!-- Modal untuk import data barang -->
<div class="modal fade" id="importMhsModal" tabindex="-1" aria-labelledby="importMhsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importMhsModalLabel">Import Data Mahasiswa</h5>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form action="#" method="post" enctype="multipart/form-data" id="uploadForm">
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
<div class="modal fade" id="editMhs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Mahasiswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/data/mahasiswa/update" method="post" id="formEditMhs">
                <input type="hidden" name="edit_id" id="edit_id" value="">
                <div class="modal-body">
                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">

                    <div class="form-group row">
                        <label for="nim_edit" class="col-sm-4 col-form-label">NIM</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nim_edit" id="nim_edit">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_lengkap_edit" class="col-sm-4 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama_lengkap_edit" id="nama_lengkap_edit">
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
<script src="<?= base_url('assets/dist/js/frontend-js/daftarMahasiswa.js') ?>"></script>


<?php echo view('tema/footer.php'); ?>