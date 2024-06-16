<?php echo view('tema/header.php'); ?>
<style>
    /* CSS untuk mengatur ukuran font menjadi 13px */
    .table td,
    .table th {
        font-size: 13px;
    }
</style>
<div class="content-wrapper">

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

                            <table id="daftarRiwayatPeminjamanTable" class="table table-striped table-sm table-hover" width="100%">
                                <thead class="thead-dark" style="font-size: 13px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center; font-size: 13px;">Kode Pinjam</th>
                                        <th style="text-align: center; font-size: 13px;">Nama Peminjam</th>
                                        <th style="text-align: center; font-size: 13px;">Tanggal Pinjam</th>
                                        <th style="text-align: center; font-size: 13px;">Digunakan untuk</th>
                                        <th style="text-align: center; font-size: 13px;">Nama Barang</th>
                                        <th style="text-align: center; font-size: 13px;">Aksi</th>
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






<script src="../../assets/dist/js/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#daftarRiwayatPeminjamanTable').DataTable({
            "processing": true,
            "ordering": false,
            "responsive": {
                "breakpoints": [{
                        "name": 'bigdesktop',
                        "width": Infinity
                    },
                    {
                        "name": 'desktop',
                        "width": 1280
                    },
                    {
                        "name": 'tablet',
                        "width": 1024
                    },
                    {
                        "name": 'fablet',
                        "width": 768
                    },
                    {
                        "name": 'phone',
                        "width": 480
                    }
                ]
            },
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
                    "data": "nama_peminjam",
                    "width": "80px"
                },
                {
                    "data": "tanggal_pinjam",
                    "width": "100px",
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
                    "data": "keperluan",
                    "width": "150px"
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
                },
                {
                    "data": null,
                    "width": "150px",
                    "render": function(data, type, row) {
                        return `
                        <button type="button" class="btn btn-primary btn-xs detailBtn mt-1" data-kodepinjam="${row.kode_pinjam}">Detail</button>
                        <button type="button" class="btn btn-danger btn-xs hapusBtn mt-1" data-id="${row.peminjaman_id}">Hapus</button>
                        <a class="btn btn-xs btn-success mx-auto text-white kembaliBtn mt-1" href="<?= base_url('form_kembali/riwayat') ?>/${row.peminjaman_id}" target="_blank">F. Kembali</a>
                    `;
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

        // Event listener untuk tombol Detail
        $('#daftarRiwayatPeminjamanTable').on('click', '.detailBtn', function() {
            var kode_pinjam = $(this).data('kodepinjam');

        });

        // Event listener untuk tombol Hapus
        $('#daftarRiwayatPeminjamanTable').on('click', '.hapusBtn', function() {
            var data_id = $(this).data('id');
            hapus_data(data_id);
        });

        // Event listener untuk tombol F. Kembali jika ada fungsi tambahan
        $('#daftarRiwayatPeminjamanTable').on('click', '.kembaliBtn', function() {
            var data_id = $(this).data('id');
            // Tambahkan logika tambahan di sini jika diperlukan

        });

        // Function to handle the deletion process
        function hapus_data(data_id) {


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

                    // Lakukan permintaan penghapusan ke server
                    $.ajax({
                        type: 'POST',
                        url: '/pinjam/hapus_riwayat/' + data_id, // Ganti URL sesuai dengan URL yang benar
                        success: function(response) {
                            // Sembunyikan pesan loading saat permintaan selesai
                            hideLoading();

                            // Periksa respon dari server
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 2000, // Durasi tampilan dalam milidetik
                                    showConfirmButton: false, // Sembunyikan tombol OK
                                }).then(() => {
                                    // Arahkan pengguna ke halaman baru setelah SweetAlert ditutup
                                    window.location.replace("/pinjam/riwayat");
                                });
                            } else {
                                // Periksa apakah pesan error mengandung kode_pinjam untuk ditampilkan dengan tombol Copy
                                if (response.message.includes('Kode Pinjam:')) {
                                    // Ekstrak kode pinjam dan bersihkan dari karakter tidak diinginkan
                                    let kodePinjam = response.message.split('Kode Pinjam: ')[1].trim();
                                    // Hilangkan titik di akhir jika ada
                                    kodePinjam = kodePinjam.replace(/\.$/, '');

                                    Swal.fire({
                                        title: 'Gagal!',
                                        html: response.message + '<br><br><button id="copyKodePinjam" class="btn btn-primary">Copy</button>',
                                        icon: 'error',
                                        showConfirmButton: false // Sembunyikan tombol OK
                                    });

                                    // Event listener untuk tombol Copy
                                    $(document).on('click', '#copyKodePinjam', function() {
                                        navigator.clipboard.writeText(kodePinjam)
                                            .then(() => {
                                                Swal.fire({
                                                    title: 'Copied!',
                                                    text: 'Kode Pinjam berhasil disalin.',
                                                    icon: 'success',
                                                    timer: 2000,
                                                    showConfirmButton: false
                                                }).then(() => {
                                                    Swal.close(); // Tutup SweetAlert setelah menyalin
                                                });
                                            })
                                            .catch((err) => {
                                                Swal.fire({
                                                    title: 'Error!',
                                                    text: 'Gagal menyalin Kode Pinjam.',
                                                    icon: 'error'
                                                });
                                                console.error('Could not copy text: ', err);
                                            });
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: response.message,
                                        icon: 'error',
                                    });
                                }
                            }
                        },
                        error: function(xhr, status, error) {
                            // Sembunyikan pesan loading saat ada kesalahan dalam penghapusan
                            hideLoading();
                            // Tampilkan pesan error yang diterima dari server
                            let errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan saat menghapus data.';
                            Swal.fire({
                                title: 'Gagal!',
                                text: errorMessage,
                                icon: 'error',
                            });

                        }
                    });
                }
            });
        }

        // Fungsi untuk menampilkan pesan loading
        function showLoading() {
            let timerInterval;
            Swal.fire({
                title: 'Sedang memproses data ....',
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        // Fungsi untuk menyembunyikan pesan loading
        function hideLoading() {
            Swal.close();
        }
    });
</script>







<script>
    $(document).on('click', '.detailBtn', function() {
        var kodePinjam = $(this).data('kodepinjam');
        window.location.href = "http://localhost:8080/kode_kembali/detail/" + kodePinjam;
    });
</script>


<?php echo view('tema/footer.php'); ?>