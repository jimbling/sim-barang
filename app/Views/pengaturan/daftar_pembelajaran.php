<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanHapusSatuan')); ?>"></div><!-- Page Heading -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Daftar Praktek Pembelajaran</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Daftar Pembelajaran</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-7 col-12">
                    <div class="card card-primary card-outline shadow-lg">

                        <div class="card-header">
                            <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">

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
                            <table id="dataSatuanBarang" class="table table-striped table-responsive table-sm">
                                <thead class="thead-grey" style="font-size: 14px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center;">Nama Praktek Pembelajaran</th>
                                        <th width='10%' style="text-align: center;">
                                            <input type="checkbox" id="select-all-checkbox">
                                        </th> <!-- Checkbox master -->

                                    </tr>
                                </thead>
                                <div id="alertContainer" class="mt-3"></div>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($data_pembelajaran as $dataPembelajaran) : ?>
                                        <tr>
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;"><?= $i++; ?></th>
                                            <td width='20%' style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $dataPembelajaran['nama_pembelajaran']; ?></td>
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="checkbox-item" data-id="<?= $dataPembelajaran['id']; ?>">
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-12">
                    <div class="card card-danger card-outline shadow-lg">
                        <div class="card-header">
                            Tambah Data Praktek Pembelajaran
                        </div>
                        <div class="card-body">
                            <form id="pembelajaranForm">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">
                                <div class="form-group">
                                    <label for="nim">Nama Pembelajaran:</label>
                                    <input type="text" class="form-control" id="views_namaPembelajaran" name="views_namaPembelajaran" placeholder="Masukkan Nama Praktek Pembelajaran">
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

<?php echo view('tema/footer.php'); ?>
<script>
    const baseUrl = "<?= base_url() ?>/";
</script>
<script src="<?= base_url('assets/dist/js/frontend-js/daftarPembelajaran.js') ?>"></script>
<div id="flashdata" data-success="<?= session()->getFlashdata('success') ?>" data-errors='<?= json_encode(session()->getFlashdata('errors')) ?>'>
</div>