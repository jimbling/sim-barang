<?php echo view('tema/header.php'); ?>
<div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanAddPengembalian')); ?>"></div><!-- Page Heading -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Form Pengembalian Barang</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Form Kembali</li>
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
                        <div class="container">

                            <div class="card-body">
                                <form id="formPengembalian" action="<?= base_url('pengembalian/proses') ?>" method="post">
                                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">
                                    <input type="hidden" name="kode_kembali" value="<?= $kode_kembali ?>">
                                    <input type="hidden" id="peminjaman_id" name="peminjaman_id" value="">

                                    <div class="row">
                                        <div class="col-sm">
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#pilihKodePinjam">
                                                <i class='fas fa-search spaced-icon'></i> Pilih Kode Pinjam
                                            </button>
                                        </div>

                                    </div>
                                    <div class="row mt-2">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Nama Peminjam</label>
                                                <input type="text" id="nama_peminjam" name="nama_peminjam" class="form-control form-control-sm" placeholder="Nama Peminjam" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
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


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Barang-barang Terkait</label>
                                            <table id="daftarBarang" class="table table-striped table-sm">
                                                <thead class="thead-grey" style="font-size: 14px;">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Barang</th>
                                                        <th>ID Barang</th>
                                                        <th>Pilih</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Daftar barang akan ditampilkan di sini -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Keterangan/Catatan Pengembalian</label>
                                            <textarea id="keterangan" name="keterangan" class="form-control form-control-sm" placeholder="Keterangan/Catatan Pengembalian"></textarea>
                                        </div>
                                    </div>







                                    <div class="form-group row mt-1">
                                        <div class="col">
                                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                    <a class="btn btn-danger" href="/kembali/riwayat" role="button"><i class='fas fa-reply-all spaced-icon'></i>Batal</a>
                                                </div>
                                                <div class="btn-group mr-2" role="group" aria-label="Second group">
                                                    <!-- Menambahkan id="kembalikanBtn" untuk referensi dalam JavaScript -->
                                                    <button id="kembalikanBtn" type="button" class="btn btn-primary">
                                                        <i class='fas fa-paper-plane spaced-icon'></i>Kembalikan Barang
                                                    </button>
                                                </div>
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
    </div>
</div>




<div class="modal fade" id="pilihKodePinjam" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Kode Pinjam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="daftarKodePinjam" class="table table-striped table-responsive table-sm">
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


<script>
    function pilihData(peminjamanId, barangId, kodePinjam, namaPeminjam, namaRuangan, penggunaan, tanggalPinjam, namaBarang) {
        console.log("Peminjaman ID:", peminjamanId);
        console.log("Kode Pinjam:", kodePinjam);
        console.log("Nama Peminjam:", namaPeminjam);
        console.log("Nama Ruangan:", namaRuangan);
        console.log("Penggunaan:", penggunaan);
        console.log("Tanggal Pinjam:", tanggalPinjam);
        console.log("Nama Barang:", namaBarang);
        console.log("ID Barang:", barangId);

        // Mengisi nilai input dengan data yang dipilih
        document.getElementById('peminjaman_id').value = peminjamanId;
        document.getElementById('nama_peminjam').value = namaPeminjam;
        document.getElementById('nama_ruangan').value = namaRuangan;
        document.getElementById('penggunaan').value = penggunaan;
        document.getElementById('tanggal_pinjam').value = tanggalPinjam;

        // Mengosongkan dan menutup modal
        $('#pilihKodePinjam').modal('hide');

        // Mendapatkan referensi tbody untuk mengisi daftar barang
        var tbody = document.querySelector('#daftarBarang tbody');
        tbody.innerHTML = ''; // Mengosongkan isi tbody

        // Membuat daftar barang dengan checkbox
        var barangArray = namaBarang.split(','); // Membagi nama barang menjadi array
        var idBarangArray = barangId.split(','); // Membagi id barang menjadi array

        for (var i = 0; i < barangArray.length; i++) {
            var tr = document.createElement('tr');

            var tdNo = document.createElement('td');
            tdNo.textContent = i + 1;
            tr.appendChild(tdNo);

            var tdNamaBarang = document.createElement('td');
            tdNamaBarang.textContent = barangArray[i];
            tr.appendChild(tdNamaBarang);

            var tdIdBarang = document.createElement('td');
            tdIdBarang.textContent = idBarangArray[i];
            tr.appendChild(tdIdBarang);

            var tdCheckbox = document.createElement('td');
            var checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = 'barang_id[]';
            checkbox.value = idBarangArray[i];
            tdCheckbox.appendChild(checkbox);
            tr.appendChild(tdCheckbox);

            tbody.appendChild(tr);
        }
    }


    var warningShown = false; // Tambahkan variabel ini di luar fungsi

    function kembalikanBarang() {
        // Memeriksa apakah ada peminjaman ID yang dipilih
        var peminjamanId = document.getElementById('peminjaman_id').value;
        if (!peminjamanId) {
            toastr.error('Pilih terlebih dahulu peminjaman untuk mengembalikan barang.');
            return;
        }

        // Mendapatkan referensi checkbox-barang
        var checkboxes = document.querySelectorAll('input[name="barang_id[]"]:checked');
        var selectedBarangIds = [];

        // Memeriksa apakah ada barang yang dipilih
        if (checkboxes.length === 0) {
            if (!warningShown) {
                toastr.error('Pilih setidaknya satu barang untuk dikembalikan.');
                warningShown = true;
            }
            return; // Menghentikan proses jika tidak ada barang yang dipilih
        }

        // Mendapatkan id barang yang terpilih
        checkboxes.forEach(function(checkbox) {
            selectedBarangIds.push(checkbox.value);
        });

        // Menyiapkan data untuk dikirimkan melalui AJAX
        var formData = {
            peminjaman_id: peminjamanId,
            keterangan: document.getElementById('keterangan').value,
            barang_ids: selectedBarangIds // Mengirimkan id barang yang terpilih
        };


    }

    // Event listener untuk tombol "Kembalikan Barang"
    document.getElementById('kembalikanBtn').addEventListener('click', function(event) {
        // Memeriksa apakah ada peminjaman ID yang dipilih
        var peminjamanId = document.getElementById('peminjaman_id').value;
        if (!peminjamanId) {
            toastr.error('Pilih terlebih dahulu peminjaman untuk mengembalikan barang.');
            return; // Menghentikan proses jika peminjaman belum dipilih
        }

        // Memeriksa apakah setidaknya satu barang telah dipilih
        var checkboxes = document.querySelectorAll('input[name="barang_id[]"]:checked');
        if (checkboxes.length === 0) {
            toastr.error('Pilih setidaknya satu barang untuk dikembalikan.');
            return; // Menghentikan proses jika tidak ada barang yang dipilih
        }

        // Mencegah perilaku default dari tombol
        event.preventDefault();

        // Memanggil fungsi untuk mengembalikan barang
        kembalikanBarang();

        // Mendapatkan referensi form
        var formPengembalian = document.getElementById('formPengembalian');

        // Memastikan elemen form ditemukan sebelum mencoba untuk memanggil metode submit()
        if (formPengembalian) {
            formPengembalian.submit(); // Submit form setelah proses pengembalian barang selesai
        } else {
            console.error('Form tidak ditemukan.');
        }
    });
</script>

<?php echo view('tema/footer.php'); ?>