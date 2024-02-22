<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanHapusPosts')); ?>"></div><!-- Page Heading -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0">Daftar Barang</h4>
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
                    <div class="card card-primary card-outline shadow-lg">
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
                            <table id="daftarBarangTable" class="table table-striped table-bordered table-responsive table-sm">
                                <thead class="thead-grey" style="font-size: 14px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center;">Kode Barang</th>
                                        <th style="text-align: center;">Nama Barang</th>
                                        <th style="text-align: center;">Jumlah Barang</th>
                                        <th style="text-align: center;">Aksi</th>


                                    </tr>
                                </thead>
                                <div id="alertContainer" class="mt-3"></div>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($grupBarang as $dataBarang) : ?>
                                        <tr class="searchable-row">
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;"><?= $i++; ?></th>
                                            <td style="text-align: left; vertical-align: middle; font-size: 14px;"><?= $dataBarang['kode_barang']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $dataBarang['nama_barang']; ?></td>
                                            <td width='20%' style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $dataBarang['total_jumlah']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;">
                                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#detailModal<?= $dataBarang['slug']; ?>">
                                                    <i class='fas fa-eye' data-toggle="tooltip" data-placement="left" title="Detail"></i>
                                                </button>
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
                <?php foreach ($grupBarang as $dataBarang) : ?>
                    <div class="modal fade" id="detailModal<?= $dataBarang['slug']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title" id="exampleModalLabel">Detail Barang - <?= $dataBarang['nama_barang']; ?></h6>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-sm">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th scope=" col" style="text-align: center; font-size: 12px;">No</th>
                                                <th scope="col" style="text-align: center; font-size: 12px;">Kode Barang</th>
                                                <th scope="col" style="text-align: center; font-size: 12px;">Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $nomorUrut = 1;
                                            if (isset($detailBarang[$dataBarang['nama_barang']])) {
                                                foreach ($detailBarang[$dataBarang['nama_barang']] as $detail) {
                                                    echo '<tr>';
                                                    echo '<td style="text-align: center; vertical-align: middle; font-size: 12px;">' . $nomorUrut . '</td>';
                                                    echo '<td style="text-align: center; vertical-align: middle; font-size: 12px;">' . $detail['kode_barang'] . '</td>';
                                                    echo '<td style="text-align: center; vertical-align: middle; font-size: 12px;">' . $detail['jumlah_barang'] . '</td>';
                                                    echo '</tr>';
                                                    $nomorUrut++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="col-md-4 col-12">
                    <div class="card card-warning card-outline shadow-lg">
                        <div class="card-body">
                            <p class="lead">
                                <i class='fas fa-bullhorn spaced-icon'></i>Informasi
                            </p>
                            <p>
                                Daftar barang yang tampil pada halaman ini adalah nama-nama barang yang masih memiliki stock, dan dengan kondisi Baik.
                            </p>
                            <p>Barang yang sedang <strong>Dipinjam, dan/ Kondisi Rusak,</strong> tidak ditampilkan pada Daftar Ini.
                            <div class="row">
                                <div class="col">
                                    <a class="btn btn-danger btn-sm" href="/barang/rusak" role="button"><i class='fas fa-cookie-bite spaced-icon'></i>Barang Rusak</a>
                                </div>
                                <div class="col">
                                    <a class="btn btn-info btn-sm" href="/barang/disewakan" role="button"><i class='fas fa-shipping-fast spaced-icon'></i>Brg Disewakan</a>
                                </div>

                            </div>

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




<?php echo view('tema/footer.php'); ?>