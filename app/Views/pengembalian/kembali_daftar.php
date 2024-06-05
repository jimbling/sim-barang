<?php echo view('tema/header.php'); ?>
<style>
    /* CSS untuk mengatur ukuran font menjadi 13px */
    .table td,
    .table th {
        font-size: 14px;
    }
</style>
<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanAddPengembalian')); ?>"></div><!-- Page Heading -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Riwayat Pengembalian Barang</h5>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Kembali</li>
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
                        <div class="card-header">
                            <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">
                                    <div class="col-md-12 col-12">
                                        <a class="btn btn-success btn-sm" href="/kembali/tambah" role="button"> <i class='fas fa-truck-loading spaced-icon'></i>Isi Form Pengembalian Barang</a>
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div class="row">



                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            // Di bagian atas file atau tempat yang sesuai
                            $level = session()->get('level');
                            ?>
                            <?php if ($level === 'Admin') : ?>
                                <form action="<?= base_url('kembali/riwayat') ?>" method="get" class="form-inline">
                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Pilih Tahun</label>
                                    <select class="custom-select my-1 mr-sm-2 custom-select-sm" name="tahun" id="tahun">
                                        <?php foreach ($availableYears as $year) : ?>
                                            <option value="<?= $year ?>" <?= $year == $selectedYear ? 'selected' : '' ?>><?= $year ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="submit" class="btn btn-primary my-1 btn-sm">Filter</button>
                                    </select>
                                </form>
                            <?php endif; ?>
                            <table id="daftarRiwayatPengembalian" class="table table-striped table-sm table-hover">
                                <thead class="thead-dark" style="font-size: 14px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center; font-size: 13px;">Kode Kembali</th>
                                        <th style="text-align: center; font-size: 13px;">Nama Peminjam</th>
                                        <th style="text-align: center; font-size: 13px;">Tanggal</th>
                                        <th style="text-align: center; font-size: 13px;">Digunakan untuk</th>
                                        <th style="text-align: center; font-size: 13px;">Nama Barang</th>
                                        <th style="text-align: center; font-size: 13px;">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $counter = 1;
                                    $bulanIndonesia = array(
                                        'January' => 'Januari',
                                        'February' => 'Februari',
                                        'March' => 'Maret',
                                        'April' => 'April',
                                        'May' => 'Mei',
                                        'June' => 'Juni',
                                        'July' => 'Juli',
                                        'August' => 'Agustus',
                                        'September' => 'September',
                                        'October' => 'Oktober',
                                        'November' => 'November',
                                        'December' => 'Desember'
                                    );
                                    ?>
                                    <?php foreach ($groupedRiwayatPengembalian as $kodeKembali => $riwayat) : ?>
                                        <?php $counterRow = 1; ?>
                                        <tr>
                                            <td><?= $counter++ ?></td>
                                            <td><?= $riwayat['kode_kembali'] ?></td>
                                            <td><?= explode('-', $riwayat['nama_peminjam'])[1] ?></td>
                                            <td width='10%'>
                                                <div class="badge bg-olive">Pinjam:<br><?= date('d', strtotime($riwayat['tanggal_pinjam'])) ?> <?= $bulanIndonesia[date('F', strtotime($riwayat['tanggal_pinjam']))] ?> <?= date('Y - H:i', strtotime($riwayat['tanggal_pinjam'])) ?> WIB</div><br>
                                                <div class="badge bg-orange"> Kembali:<br><?= date('d', strtotime($riwayat['tanggal_kembali'])) ?> <?= $bulanIndonesia[date('F', strtotime($riwayat['tanggal_kembali']))] ?> <?= date('Y - H:i', strtotime($riwayat['tanggal_kembali'])) ?> WIB</div>
                                            </td>
                                            <td width='20%'><?= $riwayat['keperluan'] ?></td>
                                            <td style="text-align: left; vertical-align: middle;">
                                                <?php foreach ($riwayat['riwayat'] as $barang) : ?>
                                                    <div><?= $counterRow++ ?>. <?= $barang['nama_barang'] ?> - <?= $barang['kode_barang'] ?></div>
                                                <?php endforeach; ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('kembali/hapus_kode/' . $riwayat['kode_kembali']) ?>" class="btn btn-xs btn-danger mx-auto text-white" id="hapusButton">Hapus</a>
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
    </div>

</div>





<script>
    function showLoading() {
        let timerInterval
        Swal.fire({
            title: 'Sedang memproses data ....',
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft()
                }, 100)
            }
        });
    }

    function hideLoading() {
        Swal.close();
    }

    function hapus_data(data_id) {
        console.log('Data ID yang akan dihapus:', data_id);

        // Pemeriksaan level pengguna di sisi klien
        let userLevel = '<?= session()->get("level") ?>';
        if (userLevel === 'User') {
            Swal.fire({
                title: 'Gagal!',
                text: 'Anda tidak memiliki izin untuk menghapus data.',
                icon: 'error',
            });
            return; // Berhenti di sini jika level pengguna bukan 'Admin'
        }

        Swal.fire({
            title: 'HAPUS?',
            text: "Yakin akan menghapus data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();

                // Lakukan permintaan penghapusan ke server, misalnya dengan AJAX.
                $.ajax({
                    type: 'POST',
                    url: '/kembali/hapus/' + data_id,
                    success: function(response) {
                        hideLoading();
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil dihapus.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {
                            window.location.replace("/kembali/riwayat");
                        });
                    },
                    error: function(xhr, status, error) {
                        hideLoading();
                        console.log(error);
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal menghapus data. Silakan coba lagi.',
                            icon: 'error',
                        });
                    }
                });
            }
        });
    }
</script>



<?php echo view('tema/footer.php'); ?>