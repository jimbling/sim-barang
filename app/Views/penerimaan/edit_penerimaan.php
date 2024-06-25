<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('errorMessages')); ?>"></div>
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Form Edit Penerimaan Barang</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Tambah Penerimaan</li>
                    </ol>
                </div>
            </div>


        </div>
    </div>


    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="card card-primary card-outline shadow-lg">

                        <?php
                        $prevPenerimaanId = null; // Untuk melacak ID penerimaan sebelumnya
                        foreach ($dataPenerimaan as $penerimaan) : ?>
                            <?php if ($prevPenerimaanId !== $penerimaan['penerimaan_id']) : ?>

                                <?php $prevPenerimaanId = $penerimaan['penerimaan_id']; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <form action="/penerimaan/update" method="post" id="formEditPenerimaan">
                            <div class="card-body">

                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">
                                <input type="hidden" name="id_penerimaan" value="<?php echo $penerimaan['penerimaan_id']; ?>">
                                <input type="hidden" id="barang_dihapus" name="barang_dihapus" value="">

                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="tanggal_penerimaan">Tanggal Penerimaan</label>
                                        <div class="col-12">
                                            <div class="input-group date" id="tanggalPenerimaan" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input" data-target="#tanggalPenerimaan" name="tanggal_penerimaan" value="<?= date('m-d-Y', strtotime($penerimaan['tanggal_penerimaan'])) ?>" required />
                                                <div class="input-group-append" data-target="#tanggalPenerimaan" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="jenis_perolehan">Jenis Penerimaan</label>
                                        <select id="jenis_perolehan" name="jenis_perolehan" class="custom-select">
                                            <!-- Menambahkan nilai dari database sebagai opsi default -->
                                            <?php if (!empty($penerimaan['jenis_perolehan'])) : ?>
                                                <option value="<?= htmlspecialchars($penerimaan['jenis_perolehan'], ENT_QUOTES, 'UTF-8'); ?>" selected>
                                                    <?= htmlspecialchars($penerimaan['jenis_perolehan'], ENT_QUOTES, 'UTF-8'); ?>
                                                </option>
                                            <?php endif; ?>

                                            <!-- Opsi lainnya yang tersedia -->
                                            <option value="-">Pilih penerimaan ...</option>
                                            <option value="Pembelian">Pembelian</option>
                                            <option value="Hibah">Hibah</option>
                                            <option value="Migrasi Data">Migrasi Data</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="petugas">Nama Petugas</label>
                                        <select class="form-control select2bs4" name="petugas" required>
                                            <?php foreach ($dosen_tendik as $dataDosenTendik) : ?>
                                                <option value="<?= $dataDosenTendik['nama_lengkap'] ?>" <?= ($penerimaan['petugas'] == $dataDosenTendik['nama_lengkap']) ? 'selected' : '' ?>>
                                                    <?= $dataDosenTendik['nama_lengkap'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                </div>


                                <div id="formPembelian" class="form-row" style="display: none;">
                                    <div class="form-group col-md-12">
                                        <label for="detail_pembelian">Detail Pembelian</label>
                                        <textarea id="detail_pembelian" name="detail_pembelian" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>


                                <?php foreach ($daftar_barang as $index => $barang) : ?>
                                    <div class="form-row barang-item">
                                        <div class="form-group col-md-5">
                                            <label for="barang_id[]">Barang:</label>
                                            <select class="form-control select2bs4" name="barang_id[]" required>
                                                <?php foreach ($barang_persediaan as $item) : ?>
                                                    <option value="<?= $item['id'] ?>" <?= $barang['barang_id'] == $item['id'] ? 'selected' : '' ?>>
                                                        <?= $item['nama_barang'] ?>
                                                        <?php if ($item['harga_satuan'] != 0) : ?>
                                                            - Harga Satuan: <?= $item['harga_satuan'] ?>
                                                        <?php endif; ?>
                                                        <?php
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
                                            <input type="number" class="form-control jumlah_barang" name="jumlah_barang[]" value="<?= $barang['jumlah_barang'] ?>" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="harga_satuan[]">Harga Satuan:</label>
                                            <input type="number" class="form-control harga_satuan" name="harga_satuan[]" value="<?= $barang['harga_satuan'] ?>" required>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="jumlah_harga[]">Jumlah Harga:</label>
                                            <input type="number" class="form-control jumlah_harga" name="jumlah_harga[]" value="<?= $barang['jumlah_harga'] ?>" readonly>
                                        </div>
                                        <div class="form-group col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm ml-1" onclick="hapusBarang(this.parentNode, <?= $barang['id'] ?>)">
                                                <i class="fas fa-times spaced-icon"></i>
                                            </button>
                                        </div>

                                    </div>
                                <?php endforeach; ?>

                                <div class="form-row barang-item" id="barang-container">
                                    <div class="form-group col-md-5">
                                        <label for="barang_id[]">Barang:</label>
                                        <select class="form-control select2bs4" name="barang_id[]" required>
                                            <option value="-" selected>Pilih penerimaan ...</option>
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
                                    <div class="form-group col-md-1 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger btn-sm ml-1" onclick="hapusBarang(this.parentNode, <?= $barang['id'] ?>)">
                                            <i class="	fas fa-times spaced-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-primary btn-sm mt-4" onclick="tambahBarang()">
                                            <i class="fas fa-plus spaced-icon"></i>Tambah Barang
                                        </button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" class="btn btn-danger btn-sm mt-4" onclick="window.location.href='/penerimaan/daftar'">
                                            <i class="fas fa-reply spaced-icon"></i>Batal
                                        </button>
                                        <button type="submit" class="btn btn-success btn-sm mt-4 ml-2">
                                            <i class="fas fa-save spaced-icon"></i>Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>






        </div>
    </div>

</div>

<div id="template-barang" style="display: none;">
    <div class="form-group col-md-5">
        <label for="barang_id[]">Barang:</label>
        <select class="form-control penerimaan" name="barang_id[]" required>
            <option value="-" selected>Pilih penerimaan ...</option>
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
        deleteButton.innerHTML = '<i class="fas fa-times spaced-icon"></i>';
        deleteButton.className = 'btn btn-danger btn-sm ml-1';
        deleteButton.onclick = function() {
            hapusBarang(newItem);
        };
        newItem.appendChild(deleteButton);

        container.appendChild(newItem);
        var buttonContainer = document.createElement('div');
        buttonContainer.className = 'form-group col-md-1 d-flex align-items-end';
        buttonContainer.appendChild(deleteButton);
        newItem.appendChild(buttonContainer);

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

<script>
    document.addEventListener('DOMContentLoaded', function() {

        var jenisPerolehanSelect = document.getElementById('jenis_perolehan');
        var formPembelian = document.getElementById('formPembelian');


        jenisPerolehanSelect.addEventListener('change', function() {

            if (jenisPerolehanSelect.value === 'Pembelian') {
                formPembelian.style.display = 'flex'; // 'flex' karena form-row biasanya menggunakan flexbox
            } else {
                formPembelian.style.display = 'none';
            }
        });
    });
</script>

<script>
    function hapusBarang(button) {
        // Cari elemen barang-item terdekat dari tombol yang diklik
        var barangItem = button.closest('.barang-item');
        if (!barangItem) {
            console.log("Tidak dapat menemukan elemen barang-item.");
            return;
        }

        // Ambil ID barang dari elemen <select> atau input yang menyimpan ID barang
        var barangSelect = barangItem.querySelector('select[name="barang_id[]"]');
        var idBarang = barangSelect ? barangSelect.value : null;

        // Ambil nilai jumlah_barang dari elemen input di dalam barang-item
        var jumlahBarangInput = barangItem.querySelector('.jumlah_barang');
        var jumlahBarang = jumlahBarangInput ? jumlahBarangInput.value : null;

        if (idBarang) {
            // Tambahkan ID barang dan jumlah barang ke input hidden "barang_dihapus"
            var barangDihapusInput = document.getElementById('barang_dihapus');
            var barangDihapus = JSON.parse(barangDihapusInput.value || '[]');

            // Tambahkan objek dengan id dan jumlah ke array barangDihapus
            barangDihapus.push({
                id: idBarang,
                jumlah: jumlahBarang
            });

            // Simpan array sebagai string JSON ke input hidden
            barangDihapusInput.value = JSON.stringify(barangDihapus);

            // Log ID barang dan jumlah_barang yang akan dihapus ke console
            console.log("Barang dengan ID:", idBarang, "dan Jumlah:", jumlahBarang, "akan dihapus.");
        }

        // Hapus elemen barang-item dari form
        barangItem.remove();
    }
</script>
<?php echo view('tema/footer.php'); ?>