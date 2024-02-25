<?php echo view('tema/header.php'); ?>
<style>
    /* CSS untuk mengatur ukuran font menjadi 13px */
    .table td,
    .table th {
        font-size: 13px;
    }
</style>
<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanAddPeminjaman')); ?>"></div><!-- Page Heading -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Riwayat Peminjaman Barang</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Riwayat Pinjam</li>
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

                        <div class="card-body">

                            <form action="<?= base_url('pinjam/riwayat') ?>" method="get" class="form-inline">
                                <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Pilih Tahun</label>
                                <select class="custom-select my-1 mr-sm-2 custom-select-sm" name="tahun" id="tahun">
                                    <?php foreach ($availableYears as $year) : ?>
                                        <option value="<?= $year ?>" <?= $year == $selectedYear ? 'selected' : '' ?>><?= $year ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-primary my-1 btn-sm">Filter</button>
                                </select>
                            </form>

                            <table id="daftarRiwayatPeminjamanTable" class="table table-striped table-responsive table-sm table-hover">
                                <thead class="thead-dark" style="font-size: 13px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center; font-size: 13px;">Kode Pinjam</th>
                                        <th style="text-align: center; font-size: 13px;">Nama Peminjam</th>
                                        <th style="text-align: center; font-size: 13px;">Tanggal Pinjam</th>
                                        <th style="text-align: center; font-size: 13px;">Digunakan di</th>
                                        <th style="text-align: center; font-size: 13px;">Digunakan untuk</th>
                                        <th style="text-align: center; font-size: 13px;">Nama Barang</th>

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
        console.log('Data ID yang akan dihapus:', data_id); // Tambahkan baris ini
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
                // Tampilkan pesan loading saat permintaan sedang dijalankan
                showLoading();
                // Lakukan permintaan penghapusan ke server, misalnya dengan AJAX.
                // Jika penghapusan berhasil, maka lakukan redirect ke halaman /siswa.
                // Contoh penggunaan jQuery untuk permintaan penghapusan:
                $.ajax({
                    type: 'POST',
                    url: '/pinjam/hapus/' + data_id, // Ganti URL sesuai dengan URL yang benar
                    success: function(response) {
                        // Sembunyikan pesan loading saat permintaan selesai
                        hideLoading();
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil dihapus.',
                            icon: 'success',
                            timer: 2000, // Durasi tampilan dalam milidetik (misalnya, 5000 milidetik = 5 detik)
                            showConfirmButton: false, // Sembunyikan tombol OK (jika tidak diinginkan)
                        }).then(() => {
                            // Arahkan pengguna ke halaman baru setelah SweetAlert ditutup
                            window.location.replace("/pinjam/daftar");
                        });
                    },
                    error: function(xhr, status, error) {
                        // Sembunyikan pesan loading saat ada kesalahan dalam penghapusan
                        hideLoading();
                        // Handle error here, jika ada kesalahan dalam penghapusan
                        console.log(error);
                    }
                });
            }
        });
    }
</script>
<script src="../../assets/dist/js/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#daftarRiwayatPeminjamanTable').DataTable({
            "processing": true,
            "ajax": {
                "url": "<?= base_url('peminjaman/fetchData') ?>",
                "type": "POST",
                "data": function(d) {
                    d.tahun = $('#tahun').val(); // Mengirim data filter ke server
                }
            },
            "columns": [{
                    "data": "no",
                    "className": "text-center",
                    "orderable": false
                },
                {
                    "data": "kode_pinjam"
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
                    "data": "nama_ruangan"
                },
                {
                    "data": "keperluan"
                },
                {
                    "data": "barang_dipinjam",
                    "className": "text-left",
                    "render": function(data, type, row) {
                        var barangs = data.split(',');
                        var html = '';
                        barangs.forEach(function(barang, index) {
                            html += (index + 1) + '. ' + barang + '<br>';
                        });
                        return html;
                    }
                }
            ]
        });

        // Mengatur nomor urut di kolom pertama
        table.on('order.dt search.dt', function() {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });
</script>
<?php echo view('tema/footer.php'); ?>