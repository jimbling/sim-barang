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
            <?php if (session('validation')) : ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session('validation')->getErrors() as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h6 class="m-0">Form Pengeluaran Barang Persediaan Tanpa Peminjaman</h6>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <div class="col-md-12 col-12">
                            <a href="/pengeluaran/bhp" class="btn btn-danger btn-sm"> <i class='fas fa-undo-alt spaced-icon'></i>Kembali</a>
                            </a>
                        </div>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <form action="/pengeluaran/bhp/simpan" method="post" id="formTambahPeneriman">
                <div class="row">
                    <div class="col-md-7 col-12">

                        <div class="card card-primary card-outline shadow-lg">

                            <div class="card-body">
                                <input type="hidden" id="id_hidden" name="id" value="<?= $data_pengeluaran_murni['id'] ?? ''; ?>">
                                <div class="row mt-2">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Nama Pengguna</label>
                                            <input type="text" id="nama_pengguna_barang" name="nama_pengguna_barang" class="form-control form-control-sm" placeholder="Nama Peminjam" readonly value="<?= $data_pengeluaran_murni['nama_pengguna_barang'] ?? ''; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Tanggal</label>
                                            <input type="text" id="tanggal_penggunaan" name="tanggal_penggunaan" class="form-control form-control-sm" placeholder="Nama Ruangan" readonly value="<?= $data_pengeluaran_murni['tanggal_penggunaan'] ?? ''; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Keperluan</label>
                                            <textarea id="keperluan" name="keperluan" class="form-control form-control-sm" placeholder="Penggunaan" readonly><?= $data_pengeluaran_murni['keperluan'] ?? ''; ?></textarea>
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
                                                <label for="ambil_barang_murni">Ambil Barang</label>
                                                <input type="text" id="ambil_barang_murni" name="ambil_barang_murni[]" class="form-control form-control-sm" placeholder="Ambil Barang">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="ambil_barang_murni">Maksimal Ambil</label>
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
                        <tbody id="tabelBarangBody">
                            <?php foreach ($data_barang_terpilih as $barang) : ?>
                                <tr>
                                    <td><?= $barang['id'] ?></td>
                                    <td><?= $barang['nama_barang'] ?></td>
                                    <td><?= $barang['jumlah_barang'] ?></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm btnHapusBarang" data-id="<?= $barang['id'] ?>">Hapus</button>
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


<aside class="control-sidebar control-sidebar-dark">

    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>


<script src="../../assets/dist/js/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        var id_pengeluaran = $('#id_hidden').val();
        var dataBarangTerpilih = [];

        $('#formTambahPeneriman').submit(function(e) {
            e.preventDefault();

            // Validasi ambil_barang_murni tidak boleh kosong atau kurang dari 0
            var valid = true;

            $('input[name="ambil_barang_murni[]"]').each(function() {
                var value = $(this).val();

                if (value === '' || parseFloat(value) <= 0) {
                    toastr.error('Ambil Barang tidak boleh kosong atau 0. Silakan isi dengan nilai yang valid.');
                    valid = false;
                    return false; // Berhenti iterasi jika ada nilai yang tidak valid
                }
            });

            if (!valid) {
                return;
            }

            // Menyembunyikan teks "Simpan" dan menampilkan ikon spinner
            $('#btnText').hide();
            $('#btnSpinner').show();

            // Mengirimkan data ke server menggunakan Ajax
            $.ajax({
                type: 'POST',
                url: '/pengeluaran/bhp/simpan',
                data: $(this).serialize() + '&id_pengeluaran=' + id_pengeluaran,
                success: function(response) {
                    // Iterate over the response data
                    $.each(response, function(index, data) {
                        // Check if the data is not already present in dataBarangTerpilih
                        if (!dataBarangTerpilih.some(item => item.id === data.id)) {
                            // Push the new data to the array
                            dataBarangTerpilih.push(data);

                            // Append the new row to the table
                            $('#tabelBarangBody').append(`
                            <tr>
                                <td>${data.id}</td>
                                <td>${data.nama_barang}</td>
                                <td>${data.ambil_barang_murni}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm btnHapusBarang" data-id="${data.id}">Hapus</button>
                                </td>
                            </tr>
                        `);
                        }
                    });

                    // Clear form or perform other actions as needed
                    $('#formTambahPeneriman')[0].reset();

                    // Tampilkan pesan sukses menggunakan toastr dengan progress bar
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
                    }; // Show success toast using toastr
                    toastr.success('Data berhasil disimpan.');

                    // Setelah AJAX request selesai, tampilkan kembali teks "Simpan" dan sembunyikan ikon spinner
                    $('#btnText').show();
                    $('#btnSpinner').hide();
                },
                error: function(error) {
                    console.log('Error:', error);
                    toastr.error('Terjadi kesalahan. Data tidak dapat disimpan.');

                    // Setelah AJAX request selesai dengan kesalahan, tampilkan kembali teks "Simpan" dan sembunyikan ikon spinner
                    $('#btnText').show();
                    $('#btnSpinner').hide();
                }
            });
        });
    });


    // Tambahkan event listener untuk tombol hapus
    $('#tabelBarangBody').on('click', '.btnHapusBarang', function() {
        var idBarang = $(this).data('id'); // Ubah data-id menjadi data-idbarang

        // Tambahkan console log untuk menampilkan ID yang dipilih
        console.log("ID yang dipilih untuk dihapus:", idBarang);

        // Simpan referensi ke baris tabel yang akan dihapus
        var deletedRow = $(this).closest('tr');

        // Ambil created_at dari id_pengeluaran
        var created_at = $('#id').data('created_at');

        // Hitung selisih waktu dengan saat ini
        var currentTime = new Date();
        var createdAtTime = new Date(created_at);
        var timeDifference = currentTime - createdAtTime;
        var hoursDifference = timeDifference / (1000 * 60 * 60);

        // Jika selisih waktu lebih dari 24 jam, tampilkan pesan toast
        if (hoursDifference > 24) {
            toastr.error('Tidak dapat menghapus barang karena sudah melebihi 24 jam.');
        } else {
            // Kirim permintaan AJAX untuk menghapus data
            $.ajax({
                type: 'POST',
                url: '/pengeluaran/barang_bhp/hapus/' + idBarang,
                success: function(response) {
                    if (response.status === 'success') {
                        // Hapus baris dari tabel setelah berhasil menghapus dari database
                        deletedRow.remove();

                        // Tampilkan pesan sukses menggunakan toastr dengan progress bar
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
                    } else {
                        alert('Gagal menghapus barang');
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                    alert('Gagal menghapus barang');
                }
            });
        }
    });
</script>


<script>
    function pilihBarang(barangId, namaBarang, hargaSatuan, jumlahBarang) {
        // Mengatur nilai pada input teks readonly
        document.getElementById("barang_display").value = namaBarang;

        // Mengatur nilai pada input hidden
        document.getElementById("barang_id[]").value = barangId;

        // Mengatur nilai harga_satuan pada input readonly
        document.getElementById("harga_satuan").value = hargaSatuan;

        // Mengatur nilai jumlah_barang pada input readonly
        document.getElementById("jumlah_barang").value = jumlahBarang;

        // Menampilkan detail data barang di konsol
        console.log("ID Barang: " + barangId);
        console.log("Nama Barang: " + namaBarang);
        console.log("Harga Satuan: " + hargaSatuan);
        console.log("Jumlah Barang: " + jumlahBarang);

        // Menutup modal
        $('#modalPilihBarang').modal('hide');
    }

    function getBarangDetails() {
        var hargaSatuanInput = document.getElementById("harga_satuan");
        var jumlahHargaInput = document.getElementById("jumlah_harga");
        var jumlahBarangInput = document.getElementById("ambil_barang_murni");

        // Mengambil nilai harga_satuan dari input readonly
        var hargaSatuan = parseFloat(hargaSatuanInput.value);

        // Menghitung jumlah harga berdasarkan jumlah barang (jika ambil_barang_murni sudah diisi)
        var jumlahBarang = parseFloat(jumlahBarangInput.value);
        var totalHarga = isNaN(hargaSatuan) || isNaN(jumlahBarang) ? '' : hargaSatuan * jumlahBarang;

        // Menetapkan nilai jumlah harga
        jumlahHargaInput.value = totalHarga;
    }

    // Memanggil fungsi getBarangDetails() saat dropdown berubah
    document.querySelector("input[name='barang_id[]']").addEventListener("change", getBarangDetails);

    // Memanggil fungsi getBarangDetails() saat ambil_barang_murni berubah
    document.getElementById("ambil_barang_murni").addEventListener("input", getBarangDetails);
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
        // Fungsi yang dipanggil saat elemen #ambil_barang kehilangan fokus (blur)
        $('#ambil_barang_murni').blur(function() {
            // Dapatkan nilai ambil_barang dan jumlah_barang
            var ambilBarang = parseInt($('#ambil_barang_murni').val()) || 0;
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
                $('#ambil_barang_murni').val('');
            }
            // Validasi terpenuhi atau tidak, lanjutkan dengan proses yang diperlukan
        });

        // Anda dapat menambahkan event blur untuk input lainnya jika diperlukan
    });
</script>







<?php echo view('tema/footer.php'); ?>