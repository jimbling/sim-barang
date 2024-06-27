<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanHapusSatuan')); ?>"></div><!-- Page Heading -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Daftar Satuan Barang</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Daftar Satuan</li>
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
                            <table id="dataSatuanBarang" class="table table-striped table-responsive table-sm">
                                <thead class="thead-grey" style="font-size: 14px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center;">Nama Satuan</th>
                                        <th width='10%' style="text-align: center;">
                                            <input type="checkbox" id="select-all-checkbox">
                                        </th> <!-- Checkbox master -->

                                    </tr>
                                </thead>
                                <div id="alertContainer" class="mt-3"></div>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($data_satuan as $satuanBarang) : ?>
                                        <tr>
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;"><?= $i++; ?></th>
                                            <td width='20%' style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $satuanBarang['nama_satuan']; ?></td>
                                            <td style="text-align: center;">
                                                <input type="checkbox" class="checkbox-item" data-id="<?= $satuanBarang['id']; ?>">
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
                            Tambah Data Satuan Barang
                        </div>
                        <div class="card-body">
                            <form action="/barang/satuan/tambah" method="post">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">
                                <div class="form-group">
                                    <label for="nim">Nama Satuan:</label>
                                    <input type="text" class="form-control" id="nama_satuan" name="nama_satuan" placeholder="Masukkan Nama Satuan Barang" required>
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





<script>
    document.getElementById('select-all-checkbox').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('.checkbox-item');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = document.getElementById('select-all-checkbox').checked;
        });
    });
</script>




<script>
    function deleteSelectedItems() {
        var selectedIds = [];


        $('.checkbox-item:checked').each(function() {
            selectedIds.push($(this).data('id'));
        });


        if (selectedIds.length > 0) {

            Swal.fire({
                title: 'Anda yakin?',
                text: 'Data yang dipilih akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();

                    $.ajax({
                        url: '/barang/satuan/hapus',
                        method: 'POST',
                        data: {
                            ids: selectedIds
                        },
                        success: function(response) {
                            hideLoading();

                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Data berhasil dihapus.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(() => {

                                window.location.replace("/barang/satuan");
                            });
                        },
                        error: function(error) {
                            hideLoading();

                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                icon: 'error',
                            });
                        }
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Pilih setidaknya satu data satuan untuk dihapus.'
            });
        }
    }
</script>


<?php echo view('tema/footer.php'); ?>