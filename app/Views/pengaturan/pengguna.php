<?php echo view('tema/header.php'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanAkun')); ?>"></div><!-- Page Heading -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5>Data Pengguna</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                            <li class="breadcrumb-item active">Data Pengguna</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">

                    <div class="card-body">

                        <button type="button" class="btn btn-danger btn-sm float-right ml-2 mb-2" onclick="deleteSelectedItems()">
                            <span class="icon text-white-100">
                                <i class="fas fa-trash-alt"></i>
                            </span>
                            <span class="text">Hapus Akun Pengguna</span>
                        </button>
                        <form action="<?= base_url('data/pengguna') ?>" method="get" class="form-inline" id="filterForm">
                            <label class="my-1 mr-2" for="type">Pilih Type Pengguna</label>
                            <select class="custom-select my-1 mr-sm-2 custom-select-sm" name="type" id="type">
                                <option value="Mahasiswa">Mahasiswa</option>
                                <option value="Dosen_Tendik">Dosen/Tendik</option>
                            </select>
                            <button type="submit" class="btn btn-primary my-1 btn-sm" id="filterButton">Filter</button>
                        </form>
                        <div class="table-responsive">

                            <table class="table table-sm table-striped text-gray-900" id="penggunaTabel" width="100%" cellspacing="0">

                                <thead class="text-gray-900">
                                    <tr>
                                        <th>Nama Pengguna</th>
                                        <th>Username</th>
                                        <th>Level</th>
                                        <th>Type</th>
                                        <th style="text-align: center;">
                                            <input type="checkbox" id="select-all-checkbox">
                                        </th> <!-- Checkbox master -->
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($data_pengguna as $akun) : ?>
                                        <tr>
                                            <td class="text-left"><?= $akun['full_nama']; ?></td>
                                            <td><?= $akun['user_nama']; ?></td>
                                            <td><?= $akun['level']; ?></td>
                                            <td><?= $akun['type']; ?></td>
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="checkbox-item" data-id="<?= $akun['id']; ?>">
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);" class="btn btn-xs btn-primary mx-auto text-white" id="edit-button-<?= $akun['id']; ?>" data-toggle="modal" data-target="#editModal<?= $akun['id']; ?>" data-id="<?= $akun['id']; ?>"><i class="fas fa-edit"></i> Edit</a>
                                                <!-- Tambah modal untuk edit di sini -->
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
    </div>
</div>

<?php foreach ($data_pengguna as $akun) : ?>
    <div class="modal fade" id="editModal<?= $akun['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?= $akun['id']; ?>" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel<?= $akun['id']; ?>">Edit Akun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editAkun" method="post" action="/data/akun/update">
                        <div class="form-group row">
                            <label for="editNama" class="col-sm-4 col-form-label">Nama</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="editNama" name="fullName" value="<?= $akun['full_nama']; ?>" readonly> <!-- Menggunakan alias fullName -->
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="editUserNama" class="col-sm-4 col-form-label">Username</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="editUserNama" name="username" value="<?= $akun['user_nama']; ?>"> <!-- Menggunakan alias username -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="editUserPass" class="col-sm-4 col-form-label">Password</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="editUserPass" name="password"> <!-- Menggunakan alias password -->
                            </div>
                        </div>
                        <input type="hidden" id="akunId" name="id" value="<?= $akun['id']; ?>">
                        <button type="submit" class="btn btn-primary btn-sm" onclick="simpan_editAkun()">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>



<?php echo view('tema/footer.php'); ?>

<script>
    const baseUrl = "<?= base_url() ?>/";
</script>

<script src="<?= base_url('assets/dist/js/frontend-js/pengguna.js') ?>"></script>