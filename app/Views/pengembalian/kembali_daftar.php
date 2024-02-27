<?php echo view('tema/header.php'); ?>
<style>
    /* CSS untuk mengatur ukuran font menjadi 13px */
    .table td,
    .table th {
        font-size: 13px;
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
                            <table id="daftarRiwayatPengembalian" class="table table-striped table-responsive table-sm table-hover">
                                <thead class="thead-dark" style="font-size: 13px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center; font-size: 13px;">Kode Kembali</th>
                                        <th style="text-align: center; font-size: 13px;">Nama Peminjam</th>
                                        <th style="text-align: center; font-size: 13px;">Tanggal Pinjam</th>
                                        <th style="text-align: center; font-size: 13px;">Tanggal Kembali</th>
                                        <th style="text-align: center; font-size: 13px;">Digunakan untuk</th>
                                        <th style="text-align: center; font-size: 13px;">Nama Barang</th>
                                        <th style="text-align: center; font-size: 13px;">AKSI</th>
                                    </tr>
                                </thead>
                                <div id="alertContainer" class="mt-3"></div>
                                <tbody>

                                </tbody>

                            </table>
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


<aside class="control-sidebar control-sidebar-dark">

    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>


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

<script src="../../assets/dist/js/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#daftarRiwayatPengembalian').DataTable({
            "processing": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "ajax": {
                "url": "<?= base_url('pengembalian/fetchData') ?>",
                "type": "POST",
                "data": function(d) {
                    d.tahun = $('#tahun').val(); // Mengirim data filter ke server
                }
            },
            "columns": [{
                    "data": "no"
                },
                {
                    "data": "kode_kembali"
                },
                {
                    "data": "nama_peminjam"
                },
                {
                    "data": "tanggal_pinjam",
                    "render": function(data, type, row) {
                        var tanggal = new Date(data);
                        var bulan = {
                            'January': 'Januari',
                            'February': 'Februari',
                            'March': 'Maret',
                            'April': 'April',
                            'May': 'Mei',
                            'June': 'Juni',
                            'July': 'Juli',
                            'August': 'Agustus',
                            'September': 'September',
                            'October': 'Oktober',
                            'November': 'November',
                            'December': 'Desember',
                        };
                        var namaBulan = bulan[tanggal.toLocaleString('en-us', {
                            month: 'long'
                        })];
                        var waktu = tanggal.getDate() + ' ' + namaBulan + ' ' + tanggal.getFullYear() + ' - ' + ('0' + tanggal.getHours()).slice(-2) + ':' + ('0' + tanggal.getMinutes()).slice(-2) + ' WIB';
                        return waktu;
                    }
                },
                {
                    "data": "tanggal_kembali",
                    "render": function(data, type, row) {
                        var tanggal = new Date(data);
                        var bulan = {
                            'January': 'Januari',
                            'February': 'Februari',
                            'March': 'Maret',
                            'April': 'April',
                            'May': 'Mei',
                            'June': 'Juni',
                            'July': 'Juli',
                            'August': 'Agustus',
                            'September': 'September',
                            'October': 'Oktober',
                            'November': 'November',
                            'December': 'Desember',
                        };
                        var namaBulan = bulan[tanggal.toLocaleString('en-us', {
                            month: 'long'
                        })];
                        var waktu = tanggal.getDate() + ' ' + namaBulan + ' ' + tanggal.getFullYear() + ' - ' + ('0' + tanggal.getHours()).slice(-2) + ':' + ('0' + tanggal.getMinutes()).slice(-2) + ' WIB';
                        return waktu;
                    }
                },
                {
                    "data": "keperluan"
                },
                {
                    "data": "nama_barang",
                    "className": "text-left",
                    "render": function(data, type, row) {
                        var barangs = data.split(',');
                        var html = '';
                        barangs.forEach(function(barang, index) {
                            html += (index + 1) + '. ' + barang + '<br>';
                        });
                        return html;
                    }
                },
                {
                    "data": null,
                    "className": "text-center",
                    "render": function(data, type, row) {
                        return '<a onclick="hapus_data(' + row.riwayat_id + ')" class="btn btn-xs btn-danger mx-auto text-white" id="button">Hapus</a>';
                    }
                }
            ],
            "rowCallback": function(row, data, index) {
                var pageInfo = table.page.info();
                $('td:eq(0)', row).html(pageInfo.start + index + 1);
            }
        });


    });
</script>

<?php echo view('tema/footer.php'); ?>