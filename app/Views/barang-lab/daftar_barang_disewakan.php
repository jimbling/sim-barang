<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Daftar Barang Disewakan</h4>
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
                <div class="col-md-12 col-12">
                    <div class="card card-danger card-outline shadow-lg">

                        <div class="card-body">
                            <table id="daftarBarangDisewakan" class="table table-striped table-responsive ">
                                <thead class="thead-grey" style="font-size: 14px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center;">Kode Barang</th>
                                        <th style="text-align: center;">Nama Barang</th>
                                        <th style="text-align: center;">Jumlah Barang</th>
                                        <th style="text-align: center;">AKSI</th>
                                    </tr>
                                </thead>
                                <div id="alertContainer" class="mt-3"></div>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($data_barang_disewakan as $barang_disewakan) : ?>
                                        <tr class="searchable-row">
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;"><?= $i++; ?></th>
                                            <td style="text-align: left; vertical-align: middle; font-size: 14px;"><?= $barang_disewakan['kode_barang']; ?></td>
                                            <td style="text-align: left; vertical-align: middle; font-size: 14px;"><?= $barang_disewakan['nama_barang']; ?></td>
                                            <td width='20%' style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $barang_disewakan['jumlah_barang']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;">
                                                <button type="button" class="btn btn-info btn-xs edit-btn" style="vertical-align: middle;" onclick="openEditModal(<?= $barang_disewakan['id']; ?>)">Edit</button>
                                            </td>

                                        </tr>
                                        <!-- Modal -->

                                        <!-- End Modal -->
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
    function openEditModal(id) {

        document.getElementById('edit_id').value = id;


        document.getElementById('formEditBarang').action = "/barang/update/" + id;

        $.ajax({
            url: '/barang/get_detail/' + id,
            method: 'GET',
            success: function(data) {
                console.log(data);

                $('#editBarang').modal('show');
                populateEditModal(data);


                $('#editId').val(id);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function populateEditModal(data) {

        $('#nama_barang_edit').val(data.nama_barang);
        $('#jumlah_barang_edit').val(data.jumlah_barang);
        $('#kondisi_barang_edit').val(data.kondisi_barang);
        $('#disewakan_edit').val(data.disewakan);
        $('#harga_sewa_edit').val(data.harga_sewa);

    }
</script>

<script>
    function searchOnEnter(event) {
        if (event.key === "Enter") {
            searchPosts();
        }
    }

    function searchPosts() {
        var input, filter, table, tr, td, i, txtValue, found;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("daftarBarangTable");
        tr = table.getElementsByClassName("searchable-row");
        found = false;

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    found = true;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }


        var alertContainer = document.getElementById("alertContainer");
        if (!found) {
            alertContainer.innerHTML = '<div class="alert alert-danger" role="alert">Barang yang dicari tidak ditemukan.</div>';
        } else {
            alertContainer.innerHTML = '';
        }
    }
</script>




<?php echo view('tema/footer.php'); ?>