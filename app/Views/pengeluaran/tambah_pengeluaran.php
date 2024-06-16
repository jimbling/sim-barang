<?php echo view('tema/header.php'); ?>
<style>
    #modalPilihBarang .btn {
        margin: 2px;
        /* Tambahkan jarak atas, bawah, kanan, dan kiri sebesar 5px */
    }
</style>
<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('errorMessages')); ?>"></div>
    <div class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Form Pengeluaran Barang Persediaan</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <div class="col-md-12 col-12">
                            <a href="/pengeluaran/daftar" class="btn btn-danger btn-sm"> <i class='fas fa-undo-alt spaced-icon'></i>Kembali</a>
                            </a>
                        </div>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <form action="/pengeluaran/simpan" method="post" id="formTambahPeneriman">
                <div class="row">
                    <div class="col-md-7 col-12">

                        <div class="card card-primary card-outline shadow-lg">

                            <div class="card-body">

                                <input type="hidden" id="peminjaman_id_hidden" name="peminjaman_id" value="">

                                <div class="row">
                                    <div class="col-sm">
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#pilihKodePinjam">
                                            <i class='fas fa-search spaced-icon'></i> Pilih Kode Pinjam
                                        </button>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Id </label>
                                            <input type="text" id="peminjaman_id_display" class="form-control form-control-sm" placeholder="ID" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Nama Peminjam</label>
                                            <input type="text" id="nama_peminjam" name="nama_peminjam" class="form-control form-control-sm" placeholder="Nama Peminjam" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Nama Ruangan</label>
                                            <input type="text" id="nama_ruangan" name="nama_ruangan" class="form-control form-control-sm" placeholder="Nama Ruangan" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Penggunaan</label>
                                            <input type="text" id="penggunaan" name="penggunaan" class="form-control form-control-sm" placeholder="Penggunaan" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Tanggal Pinjam</label>
                                            <input type="text" id="tanggal_pinjam" name="tanggal_pinjam" class="form-control form-control-sm" placeholder="Tanggal Pinjam" readonly>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-12">
                        <div class="card card-primary shadow-lg">
                            <div class="card-header bg-danger">
                                <h6>Tambah Barang</h6>
                            </div>
                            <div class="card-body">
                                <div class="container">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="barang_id">Barang</label>
                                                <div class="input-group">
                                                    <input type="text" id="barang_display" class="form-control form-control-sm" placeholder="Pilih Barang" readonly>
                                                    <input type="hidden" id="barang_id[]" name="barang_id[]">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalPilihBarang">
                                                            Pilih Barang
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ambil_barang">Ambil Barang</label>
                                                <input type="text" id="ambil_barang" name="ambil_barang[]" class="form-control form-control-sm" placeholder="Ambil Barang">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ambil_barang">Maksimal Ambil</label>
                                                <input type="text" id="jumlah_barang" name="jumlah_barang[]" class="form-control form-control-sm" placeholder="Jumlah Barang" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="display:none">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="harga_satuan">Harga Satuan</label>
                                                <input type="text" id="harga_satuan" name="harga_satuan[]" class="form-control form-control-sm" placeholder="Harga Satuan" readonly>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row" style="display:none">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="jumlah_harga">Jumlah Harga</label>
                                                <input type="text" id="jumlah_harga" name="jumlah_harga[]" class="form-control form-control-sm" placeholder="Jumlah Harga" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm" id="btnSimpan">
                                        <span id="btnText">Simpan</span>
                                        <span id="btnSpinner" style="display: none;">
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="card card-primary card-outline shadow-lg">
                <div class="card-body">
                    <!-- Tabel untuk menampilkan data barang yang terpilih -->
                    <table id="daftarBarangPersediaan" class="table table-striped table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Barang</th>
                                <th>Jumlah Barang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
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

<div class="modal fade" id="pilihKodePinjam" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Kode Pinjam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="daftarKodePinjamPersed" class="table table-striped table-responsive table-sm">
                    <thead class="thead-grey" style="font-size: 14px;">
                        <tr>
                            <th width='3%'>No</th>
                            <th style="text-align: center;">Kode Pinjam</th>
                            <th style="text-align: center;">Nama Peminjam</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($data_peminjaman as $ambil_kode) : ?>
                            <tr>
                                <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;"><?= $i++; ?></th>
                                <td style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $ambil_kode['kode_pinjam']; ?></td>
                                <td style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $ambil_kode['nama_peminjam']; ?></td>
                                <td style="text-align: center; vertical-align: middle; font-size: 14px;">
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onclick="pilihData('<?= $ambil_kode['peminjaman_id']; ?>','<?= $ambil_kode['barang_ids']; ?>','<?= $ambil_kode['kode_pinjam']; ?>', '<?= $ambil_kode['nama_peminjam']; ?>', '<?= $ambil_kode['nama_ruangan']; ?>', '<?= $ambil_kode['keperluan']; ?>', '<?= $ambil_kode['tanggal_pinjam']; ?>', '<?= $ambil_kode['barang_dipinjam']; ?>')">Pilih</button>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Modal Pilih Barang -->
<div class="modal fade" id="modalPilihBarang" tabindex="-1" role="dialog" aria-labelledby="modalPilihBarangLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPilihBarangLabel">Pilih Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Tambahkan input pencarian -->
                <input type="text" class="form-control mb-2" id="inputPencarianBarang" placeholder="Cari Barang">

                <!-- Loop through your barang data and populate options -->
                <?php foreach ($barang_persediaan as $barang) : ?>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="pilihBarang('<?= $barang->barang_id ?>', '<?= $barang->nama_barang ?>', '<?= $barang->harga_satuan ?>', '<?= $barang->stok ?>')">
                        <?= $barang->nama_barang ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>


<script>
    var selectedPeminjamanId; // Deklarasikan variabel global untuk menyimpan kode pinjam yang dipilih

    function pilihData(peminjamanId, barangId, kodePinjam, namaPeminjam, namaRuangan, penggunaan, tanggalPinjam, namaBarang) {


        // Set the value of the peminjaman_id_hidden hidden input field
        document.getElementById('peminjaman_id_hidden').value = peminjamanId;

        // Set the value of the peminjaman_id_display input field for display
        document.getElementById('peminjaman_id_display').value = peminjamanId;

        // Set other values as needed
        document.getElementById('nama_peminjam').value = namaPeminjam;
        document.getElementById('nama_ruangan').value = namaRuangan;
        document.getElementById('penggunaan').value = penggunaan;
        document.getElementById('tanggal_pinjam').value = tanggalPinjam;

        // Set the selected peminjamanId
        selectedPeminjamanId = peminjamanId;

        // Close the modal
        $('#pilihKodePinjam').modal('hide');

        // Fetch data from controller based on peminjaman_id
        $.ajax({
            type: "GET",
            url: "/pengeluaran/getDataByPeminjamanId/" + peminjamanId,
            success: function(response) {
                // Parse the JSON response
                var data = JSON.parse(response);

                // Clear existing table rows
                $('#daftarBarangPersediaan tbody').empty();

                // Update table with new data
                updateTable(data);

            },
            error: function(error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // Move the hapusData function outside of the pilihData function
    function hapusData(id) {
        // Delete data directly without confirmation
        $.ajax({
            type: 'POST',
            url: '/pengeluaran/hapusData/' + id,
            success: function(response) {
                // Update the table after successful deletion
                updateTable(response.data);

                // Set the new data to the table and stay on the same page
                $('#daftarBarangPersediaan tbody').html(response.html);

                // Check if there was a previously selected peminjamanId
                if (selectedPeminjamanId) {
                    // Fetch new data based on the previously selected peminjamanId
                    $.ajax({
                        type: "GET",
                        url: "/pengeluaran/getDataByPeminjamanId/" + selectedPeminjamanId,
                        success: function(response) {
                            // Parse the JSON response
                            var data = JSON.parse(response);

                            // Clear existing table rows
                            $('#daftarBarangPersediaan tbody').empty();

                            // Update the table with new data
                            updateTable(data);
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": true,
                                "positionClass": "toast-bottom-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "1800",
                                "hideDuration": "1800",
                                "timeOut": "5000",
                                "extendedTimeOut": "1800",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            };

                            toastr.success('Barang berhasil dihapus dari daftar.');
                        },
                        error: function(error) {
                            console.error('Error fetching data:', error);
                        }
                    });
                }
            },
            error: function(error) {
                console.error('Error deleting data:', error);
            }
        });
    }

    // Move the updateTable function outside of the pilihData function
    function updateTable(data) {
        // Clear the table
        $('#daftarBarangPersediaan tbody').empty();

        // Update the table with new data
        $.each(data, function(index, item) {
            var row = '<tr>' +
                '<td>' + item.barang_id + '</td>' +
                '<td>' + item.nama_barang + '</td>' +
                '<td>' + item.ambil_barang + '</td>' +
                '<td>' +
                '<button class="btn btn-danger btn-xs" onclick="hapusData(' + item.id + ')">Hapus</button>' +
                '</td>' +
                '</tr>';

            $('#daftarBarangPersediaan tbody').append(row);
        });

    }
</script>


<script src="../../assets/dist/js/jquery-3.6.4.min.js"></script>
<script>
    function pilihBarang(barangId, namaBarang, hargaSatuan, jumlahBarang) {
        // Mengatur nilai pada input teks readonly
        document.getElementById("barang_display").value = namaBarang;

        // Mengatur nilai pada input hidden
        document.getElementById("barang_id[]").value = barangId;

        // Mengatur nilai harga_satuan pada input readonly
        document.getElementById("harga_satuan").value = hargaSatuan;
        // Mengatur nilai harga_satuan pada input readonly
        document.getElementById("jumlah_barang").value = jumlahBarang;

        // Menutup modal
        $('#modalPilihBarang').modal('hide');
    }

    function getBarangDetails() {
        var hargaSatuanInput = document.getElementById("harga_satuan");
        var jumlahHargaInput = document.getElementById("jumlah_harga");
        var jumlahBarangInput = document.getElementById("ambil_barang");



        // Mengambil nilai harga_satuan dari input readonly
        var hargaSatuan = parseFloat(hargaSatuanInput.value);

        // Menghitung jumlah harga berdasarkan jumlah barang (jika ambil_barang sudah diisi)
        var jumlahBarang = parseFloat(jumlahBarangInput.value);
        var totalHarga = isNaN(hargaSatuan) || isNaN(jumlahBarang) ? '' : hargaSatuan * jumlahBarang;

        // Menetapkan nilai jumlah harga
        jumlahHargaInput.value = totalHarga;

    }

    // Memanggil fungsi getBarangDetails() saat dropdown berubah
    document.querySelector("input[name='barang_id[]']").addEventListener("change", getBarangDetails);

    // Memanggil fungsi getBarangDetails() saat ambil_barang berubah
    document.getElementById("ambil_barang").addEventListener("input", getBarangDetails);
</script>

<script>
    // Fungsi untuk melakukan pencarian
    function cariBarang() {
        var inputPencarian = document.getElementById('inputPencarianBarang');
        var filter = inputPencarian.value.toUpperCase();
        var buttons = document.querySelectorAll('#modalPilihBarang .btn');

        buttons.forEach(function(button) {
            var txtValue = button.textContent || button.innerText;
            button.style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? 'block' : 'none';
        });
    }

    // Memanggil fungsi cariBarang() saat input pencarian berubah
    document.getElementById('inputPencarianBarang').addEventListener('input', cariBarang);
</script>


<script>
    $(document).ready(function() {
        // Menangkap perubahan pada input hidden peminjaman_id
        $('#peminjaman_id').on('change', function() {
            var peminjamanId = $(this).val();


            if (peminjamanId !== '') {
                tampilkanData(peminjamanId);
            }
        });

        // Fungsi untuk menampilkan data terkait berdasarkan peminjaman_id
        function tampilkanData(peminjamanId) {


            $.ajax({
                url: '/pengeluaran/getDataByPeminjamanId/' + peminjamanId,
                method: 'GET',
                success: function(response) {
                    console.log('Response from server:', response);
                    // Mengisi tabel dengan data yang diterima dari server
                    $('#tabelBarang').html(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('#formTambahPeneriman').submit(function(e) {
            e.preventDefault();
            // Validasi ambil_barang tidak boleh kosong (0)
            var ambilBarangValues = $('input[name="ambil_barang[]"]').map(function() {
                return $(this).val();
            }).get();

            if (ambilBarangValues.includes("0") || ambilBarangValues.includes("")) {
                toastr.error('Ambil Barang tidak boleh kosong atau 0. Silakan isi dengan nilai yang valid.');
                return;
            }

            // Menyembunyikan teks "Simpan" dan menampilkan ikon spinner
            $('#btnText').hide();
            $('#btnSpinner').show();
            // Lakukan AJAX untuk menyimpan data
            $.ajax({
                type: 'POST',
                url: '/pengeluaran/simpan',
                data: $('#formTambahPeneriman').serialize(),
                dataType: 'json',
                success: function(response) {
                    // Perbarui tabel dengan data baru
                    updateTable(response.data);

                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-bottom-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "1800",
                        "hideDuration": "1800",
                        "timeOut": "5000",
                        "extendedTimeOut": "1800",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };

                    toastr.success('Berhasil menambahkan barang persediaan.');
                    // Setelah AJAX request selesai, tampilkan kembali teks "Simpan" dan sembunyikan ikon spinner
                    $('#btnText').show();
                    $('#btnSpinner').hide();
                },
                error: function(error) {
                    console.error('Error saving data:', error);
                    // Setelah AJAX request selesai dengan kesalahan, tampilkan kembali teks "Simpan" dan sembunyikan ikon spinner
                    $('#btnText').show();
                    $('#btnSpinner').hide();
                }
            });
        });

        function updateTable(data) {
            // Bersihkan tabel
            $('#daftarBarangPersediaan tbody').empty();

            // Perbarui tabel dengan data baru
            $.each(data, function(index, item) {
                var row = '<tr>' +
                    '<td>' + item.barang_id + '</td>' +
                    '<td>' + item.nama_barang + '</td>' +
                    '<td>' + item.ambil_barang + '</td>' +
                    '<td>' +
                    '<button class="btn btn-danger btn-xs" onclick="hapusData(' + item.id + ')">Hapus</button>' +
                    '</td>' +
                    '</tr>';

                $('#daftarBarangPersediaan tbody').append(row);
            });
        }
    });
</script>

<script>
    $(document).ready(function() {
        // Fungsi yang dipanggil saat elemen #ambil_barang kehilangan fokus (blur)
        $('#ambil_barang').blur(function() {
            // Dapatkan nilai ambil_barang dan jumlah_barang
            var ambilBarang = parseInt($('#ambil_barang').val()) || 0;
            var jumlahBarang = parseInt($('#jumlah_barang').val()) || 0;

            // Lakukan validasi
            if (ambilBarang > jumlahBarang) {
                // Tampilkan SweetAlert jika ambil_barang lebih besar dari jumlah_barang
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Nilai Ambil Barang tidak boleh lebih besar dari Jumlah Barang!',
                });
                // Bersihkan nilai input agar pengguna harus memasukkan ulang
                $('#ambil_barang').val('');
            }
            // Validasi terpenuhi atau tidak, lanjutkan dengan proses yang diperlukan
        });

        // Anda dapat menambahkan event blur untuk input lainnya jika diperlukan
    });
</script>

<?php echo view('tema/footer.php'); ?>