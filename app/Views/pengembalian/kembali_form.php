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
                                <form action="<?= base_url('pengembalian/proses') ?>" method="post">
                                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">
                                    <input type="hidden" name="kode_kembali" value="<?= $kode_kembali ?>">
                                    <input type="hidden" id="peminjaman_id" name="peminjaman_id" value="">
                                    <input type="hidden" id="barang_id" name="barang_id[]" value="">
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

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Nama Barang</label>
                                                <textarea id="nama_barang" name="nama_barang" class="form-control form-control-sm" placeholder="Nama Barang" readonly></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Keterangan/Catatan Pengembalian</label>
                                                <textarea id="keterangan" name="keterangan" class="form-control form-control-sm" placeholder="Keterangan/Catatan Pengembalian"></textarea>
                                            </div>
                                        </div>
                                    </div>





                                    <div class="form-group row mt-1">
                                        <div class="col">
                                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                                <div class="btn-group mr-2" role="group" aria-label="First group">
                                                    <a class="btn btn-danger" href="/kembali/riwayat" role="button"><i class='fas fa-reply-all spaced-icon'></i>Batal</a>
                                                </div>
                                                <div class="btn-group mr-2" role="group" aria-label="Second group">
                                                    <button id="kembalikanBtn" type="submit" class="btn btn-primary">
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



<aside class="control-sidebar control-sidebar-dark">

    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>


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
        document.getElementById('nama_barang').value = namaBarang;
        document.getElementById('barang_id').value = barangId;
        // Menutup modal
        $('#pilihKodePinjam').modal('hide');
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('kembalikanBtn').addEventListener('click', function(event) {
            // Mengambil nilai peminjaman_id
            var peminjamanId = document.getElementById('peminjaman_id').value;

            // Mengecek apakah nilai peminjaman_id sudah diisi atau belum
            if (peminjamanId === '') {
                // Menampilkan SweetAlert peringatan
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Isi dahulu Kode Pinjam!',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });

                // Mencegah form untuk di-submit
                event.preventDefault();
            } else {
                // Menampilkan loading
                showLoading();
            }
        });
    });

    function showLoading() {
        Swal.fire({
            title: 'Sedang memproses data ....',
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    function hideLoading() {
        Swal.close();
    }

    <?php if (session()->has('pesanAddPengembalian')) : ?>
        // Tampilkan pesan flash data sebagai alert berhasil
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '<?php echo session('pesanAddPengembalian'); ?>',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        }).then((result) => {
            // Jika alert berhasil ditutup, sembunyikan loading
            if (result.isConfirmed || result.isDismissed) {
                hideLoading();
            }
        });
    <?php endif; ?>
</script>





<?php echo view('tema/footer.php'); ?>