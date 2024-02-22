<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Daftar Barang Rusak</h4>
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
                <div class="col-md-8 col-12">
                    <div class="card card-danger card-outline shadow-lg">
                        <!-- <div class="card-header">
                            <div class="row">

                                <div class="col-md-12 col-12">
                                    <div class="input-group input-group">
                                        <input type="text" class="form-control" id="searchInput" placeholder="Masukkan nama barang..." onkeydown="searchOnEnter(event)">
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-info btn-flat" onclick="searchPosts()">Cari Barang</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="card-body">
                            <table id="daftarBarangTable" class="table table-striped table-responsive table-sm">
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
                                    <?php $userLevel = session()->get('level'); ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($data_barang_rusak as $barang_rusak) : ?>
                                        <tr class="searchable-row">
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;"><?= $i++; ?></th>
                                            <td width='20%' style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $barang_rusak['kode_barang']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $barang_rusak['nama_barang']; ?></td>
                                            <td width='20%' style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $barang_rusak['total_jumlah']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;">
                                                <?php if ($userLevel == 'Admin') : ?>
                                                    <button type="button" class="btn btn-info btn-xs edit-btn" style="vertical-align: middle;" onclick="openEditModal(<?= $barang_rusak['id']; ?>)">Edit</button>
                                                <?php else : ?>
                                                    <button type="button" class="btn btn-info btn-xs" style="vertical-align: middle;" onclick="showAccessAlert()">Edit</button>
                                                <?php endif; ?>
                                            </td>

                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="detailModal<?= $barang_rusak['nama_barang']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title" id="exampleModalLabel">Detail Barang - <?= $barang_rusak['nama_barang']; ?></h6>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <!-- Isi form detail barang sebelum dikelompokkan -->
                                                        <?php
                                                        if (isset($detailBarang[$barang_rusak['nama_barang']])) {
                                                            foreach ($detailBarang[$barang_rusak['nama_barang']] as $detail) {

                                                                echo '<p>Kode Barang: ' . $detail['kode_barang'] . ', Jumlah: ' . $detail['total_jumlah'] . '</p>';
                                                            }
                                                        }
                                                        ?>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="card card-danger card-outline shadow-lg">
                        <div class="card-body">
                            <p class="lead">
                                <i class='fas fa-bullhorn spaced-icon'></i>Informasi
                            </p>
                            <p>
                                Daftar barang yang tampil pada halaman ini adalah nama-nama barang dengan <strong>Kondisi Rusak</strong>.
                            </p>
                            <p>Barang yang ada pada halaman ini, tidak ditampilkan pada Daftar Barang yang dapat dipinjam.
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
        // Set nilai input hidden dengan ID yang diambil dari tombol edit
        document.getElementById('edit_id').value = id;

        // Perbarui aksi formulir sesuai dengan ID
        document.getElementById('formEditBarang').action = "/barang/update/" + id;
        // Fetch data using AJAX
        $.ajax({
            url: '/barang/get_detail/' + id,
            method: 'GET',
            success: function(data) {
                console.log(data); // Periksa data yang diterima di konsol browser
                // Populate the modal with the fetched data
                $('#editBarang').modal('show');
                populateEditModal(data);

                // Set nilai input tersembunyi dengan nilai 'id'
                $('#editId').val(id);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function populateEditModal(data) {
        // Populate the form fields with the fetched data
        $('#nama_barang_edit').val(data.nama_barang);
        $('#jumlah_barang_edit').val(data.jumlah_barang);
        $('#kondisi_barang_edit').val(data.kondisi_barang);

    }
</script>

<aside class="control-sidebar control-sidebar-dark">

    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>




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
        table = document.getElementById("daftarBarangTable"); // Gantilah dengan ID tabel sebenarnya Anda
        tr = table.getElementsByClassName("searchable-row");
        found = false;

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1]; // Mengambil kolom ke-3 (indeks 2) untuk mencari nama_barang
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

        // Menampilkan notifikasi dalam alert danger di bawah head table
        var alertContainer = document.getElementById("alertContainer");
        if (!found) {
            alertContainer.innerHTML = '<div class="alert alert-danger" role="alert">Barang yang dicari tidak ditemukan.</div>';
        } else {
            alertContainer.innerHTML = ''; // Menghapus alert jika data ditemukan
        }
    }
</script>


<script>
    function showAccessAlert() {
        Swal.fire({
            icon: 'error',
            title: 'Akses Ditolak',
            text: 'Maaf Anda tidak memiliki Akses',
        });
    }
</script>

<?php echo view('tema/footer.php'); ?>