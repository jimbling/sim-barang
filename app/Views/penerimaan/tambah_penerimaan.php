<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('errorMessages')); ?>"></div>
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Form Penerimaan Barang</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Tambah Penerimaan</li>
                    </ol>
                </div>
            </div>
            <div class="alert alert-danger" style="font-size: 14px;" role="alert">
                <strong> Informasi!</strong>
                <p>Harap perhatikan harga satuan pada nama barang yang akan dimasukkan, jika nama barang sama namun harga satuan berbeda, harap tambahkan dahulu data barang baru tersebut.
                    Data barang yang baru dimasukkan, akan memiliki keterangan (Barang Baru), yang tampil selama kurang lebih 5 menit.
                    <a class="btn btn-info btn-sm" href="/barang/persediaan/master" role="button" style="text-decoration: none;">
                        <i class='fas fa-external-link-alt spaced-icon'></i>Input Barang Persediaan
                    </a>
                <p> Jika dari beberapa barang yang dimasukkan lalu ada <strong>Alert Gagal</strong>, maka periksa daftar penerimaan, karena data barang lain yang valid sudah tersimpan. Hapus saja daftar tersebut, kemudian entrikan ulang, dengan catatan data barang baru untuk harga satuan baru sudah dibuat.
                    <a class="btn btn-success btn-sm" href="/penerimaan/daftar" role="button" style="text-decoration: none;">
                        <i class='fas fa-external-link-alt spaced-icon'></i>Daftar Penerimaan Persediaan
                    </a>
            </div>

        </div>
    </div>


    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="card card-primary card-outline shadow-lg">
                        <form action="/penerimaan/simpan" method="post" id="formTambahPeneriman">
                            <div class="card-body">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">

                                <!-- Form Tambah Penerimaan -->

                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="tanggal_penerimaan">Tanggal Penerimaan</label>
                                        <div class="col-12">
                                            <div class="input-group date" id="tanggalPenerimaan" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input" data-target="#tanggalPenerimaan" name="tanggal_penerimaan" required />
                                                <div class="input-group-append" data-target="#tanggalPenerimaan" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="jenis_perolehan">Jenis Penerimaan</label>
                                        <div class="col-12">
                                            <select id="jenis_perolehan" name="jenis_perolehan" class="custom-select">
                                                <option value="Pembelian">Pembelian</option>
                                                <option value="Hibah">Hibah</option>
                                                <option value="Migrasi Data">Migrasi Data</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="petugas">Nama Petugas</label>
                                        <div class="col-12">
                                            <select class="form-control select2bs4" name="petugas" required>
                                                <?php foreach ($dosen_tendik as $dataDosenTendik) : ?>
                                                    <option value="<?= $dataDosenTendik['nama_lengkap'] ?>"><?= $dataDosenTendik['nama_lengkap'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Formulir untuk banyak barang -->
                                <div class="form-row barang-item" id="barang-container">
                                    <div class="form-group col-md-6">
                                        <label for="barang_id[]">Barang:</label>
                                        <select class="form-control select2bs4" name="barang_id[]" required>
                                            <?php foreach ($barang_persediaan as $item) : ?>
                                                <option value="<?= $item['id'] ?>">
                                                    <?= $item['nama_barang'] ?>
                                                    <?php

                                                    if ($item['harga_satuan'] != 0) {
                                                        echo " - Harga Satuan: " . $item['harga_satuan'];
                                                    }


                                                    $createdTime = strtotime($item['created_at']);
                                                    $currentTime = time();
                                                    $timeDifference = $currentTime - $createdTime;


                                                    if ($timeDifference <= 300) {
                                                        echo " - (Barang Baru)";
                                                    }
                                                    ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>

                                    </div>

                                    <div class="form-group col-md-2">
                                        <label for="jumlah_barang[]">Jumlah Barang:</label>
                                        <input type="number" class="form-control jumlah_barang" name="jumlah_barang[]" required>
                                    </div>
                                    <div class="form-group col-md-2">

                                        <label for="harga_satuan[]">Harga Satuan:</label>
                                        <input type="number" class="form-control harga_satuan" name="harga_satuan[]" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="jumlah_harga[]">Jumlah Harga:</label>
                                        <input type="number" class="form-control jumlah_harga" name="jumlah_harga[]" readonly>
                                    </div>

                                </div>


                                <button type="button" class="btn btn-danger btn-sm mt-4" onclick="tambahBarang()"><i class='fas fa-caret-square-down spaced-icon'></i>Tambah Barang</button>
                                <button type="submit" class="btn btn-success btn-sm mt-4">Simpan</button>

                            </div>

                        </form>
                    </div>
                </div>
            </div>






        </div>
    </div>

</div>


<div id="template-barang" style="display: none;">
    <div class="form-group col-md-6">
        <label for="barang_id[]">Barang:</label>
        <select class="form-control penerimaan" name="barang_id[]" required>
            <?php foreach ($barang_persediaan as $item) : ?>
                <option value="<?= $item['id'] ?>">
                    <?= $item['nama_barang'] ?>
                    <?php

                    if ($item['harga_satuan'] != 0) {
                        echo " - Harga Satuan: " . $item['harga_satuan'];
                    }


                    $createdTime = strtotime($item['created_at']);
                    $currentTime = time();
                    $timeDifference = $currentTime - $createdTime;


                    if ($timeDifference <= 300) {
                        echo " - (Barang Baru)";
                    }
                    ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group col-md-2">
        <label for="jumlah_barang[]">Jumlah Barang:</label>
        <input type="number" class="form-control jumlah_barang" name="jumlah_barang[]" required>
    </div>
    <div class="form-group col-md-2">
        <label for="harga_satuan[]">Harga Satuan:</label>
        <input type="number" class="form-control harga_satuan" name="harga_satuan[]" required>
    </div>
    <div class="form-group col-md-2">
        <label for="jumlah_harga[]">Jumlah Harga:</label>
        <input type="number" class="form-control jumlah_harga" name="jumlah_harga[]" readonly>
    </div>
</div>



<script>
    function hapusBarang(element) {
        element.remove();
    }


    function tambahBarang() {
        var container = document.getElementById('barang-container');
        var newItem = document.createElement('div');
        newItem.className = 'form-row barang-item';

        var randomNumber = Math.floor(Math.random() * 1000);
        newItem.innerHTML = document.getElementById('template-barang').innerHTML.replace(/\[]/g, '[' + randomNumber + ']');


        var deleteButton = document.createElement('button');
        deleteButton.innerHTML = 'Hapus';
        deleteButton.className = 'btn btn-danger btn-sm ml-2';
        deleteButton.onclick = function() {
            hapusBarang(newItem);
        };
        newItem.appendChild(deleteButton);

        container.appendChild(newItem);


        $(newItem).find('.penerimaan').select2({
            theme: 'bootstrap4'
        });


        $(newItem).find('.harga_satuan, .jumlah_barang').on('input', function() {
            updateJumlahHarga(newItem);
        });
    }


    function updateJumlahHarga(row) {
        var jumlahBarangInput = row.querySelector('.jumlah_barang');
        var hargaSatuanInput = row.querySelector('.harga_satuan');
        var jumlahHargaInput = row.querySelector('.jumlah_harga');


        var jumlahBarang = parseFloat(jumlahBarangInput.value) || 0;
        var hargaSatuan = parseFloat(hargaSatuanInput.value) || 0;


        var jumlahHarga = jumlahBarang * hargaSatuan;


        jumlahHargaInput.value = isNaN(jumlahHarga) ? '' : jumlahHarga.toFixed(2);
    }


    document.querySelectorAll('.harga_satuan, .jumlah_barang').forEach(function(element) {
        element.addEventListener('input', function() {
            updateJumlahHarga(element.closest('.barang-item'));
        });
    });
</script>



<?php echo view('tema/footer.php'); ?>