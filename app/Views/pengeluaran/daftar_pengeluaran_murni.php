<?php echo view('tema/header.php'); ?>
<?php
// Mendapatkan sesi
$session = session();
// Mendapatkan nama pengguna dari sesi
$nama = $session->get('full_nama');
?>
<div class="custom-error-message" data-customerrormessage="<?= (session()->getFlashData('custom_error_message')); ?>"></div>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h6 class="m-0">Daftar Permintaan Barang Habis Pakai Tanpa Peminjaman</h6>
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
            <div class="callout callout-info" style="font-size: 13px;">
                <h5><i class="fas fa-info"></i> Catatan:</h5>
                <p>Pada menu Tambah Barang BHP ini, digunakan apabila ingin meminta/menggunakan Barang Habis Pakai namun tanpa melakukan peminjaman barang laboratoirum keperawatan.
                    Menu Tambah Barang dari Data permintaan yang sudah lebih dari 24 Jam tidak dapat diakses oleh User. Hubungi Laboran untuk koreksi data.
            </div>
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="card card-primary card-outline shadow-lg">
                        <div class="card-header">
                            <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group" role="group" aria-label="First group">
                                    <div class="col-md-12 col-12">
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahPermintaan"> <i class='fas fa-cart-arrow-down spaced-icon'></i>Tambah Permintaan</a>
                                        </button>
                                    </div>

                                </div>
                                <div class="btn-toolbar">
                                    <div class="col-md-12 col-12">

                                        </button>
                                    </div>
                                </div>
                                <div class="btn-toolbar">

                                </div>
                            </div>

                        </div>
                        <div class="card-body">

                            <table id="daftarPengeluaranMurniTable" class="table table-striped table-responsive">
                                <thead class="thead bg-danger table-bordered" style="font-size: 14px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center;">Nama Pengguna</th>
                                        <th style="text-align: center;">Tanggal Permintaan</th>
                                        <th style="text-align: center;">Keperluan</th>
                                        <th style="text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($data_pengeluaran_murni as $dataPengeluaranMurni) : ?>
                                        <tr>
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;"><?= $i++; ?></th>
                                            <td style="text-align: left; vertical-align: middle; font-size: 14px;"><?= $dataPengeluaranMurni['nama_pengguna_barang']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;">
                                                <?php
                                                $tanggal_penggunaan = \CodeIgniter\I18n\Time::parse($dataPengeluaranMurni['tanggal_penggunaan'])
                                                    ->setTimezone('Asia/Jakarta');

                                                $nama_bulan = [
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
                                                    'December' => 'Desember',
                                                ];

                                                $bulan = $nama_bulan[$tanggal_penggunaan->format('F')];

                                                echo $tanggal_penggunaan->format('d ') . $bulan . $tanggal_penggunaan->format(' Y');
                                                ?>
                                            </td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $dataPengeluaranMurni['keperluan']; ?></td>



                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;">
                                                <a href="<?= base_url('pengeluaran/bhp') . '/' . $dataPengeluaranMurni['id']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Tambah Barang">
                                                    <i class='fas fa-dolly-flatbed'></i>
                                                </a>
                                                <button class="btn btn-warning btn-sm btn-detail" data-toggle="modal" data-penerimaan-id="<?= $dataPengeluaranMurni['id']; ?>">
                                                    <i class='fas fa-eye' data-toggle="tooltip" data-placement="top" title="Lihat Detail"></i>
                                                </button>
                                                <a href="<?= base_url('cetak_bhp') . '/' . $dataPengeluaranMurni['id']; ?>" class="btn btn-info btn-sm" target="_blank">
                                                    <i class='fas fa-print' data-toggle="tooltip" data-placement="top" title="Cetak Form"></i>
                                                </a>

                                                <a onclick=" hapus_data('<?= $dataPengeluaranMurni['id']; ?>')" class="btn btn-sm btn-danger mx-auto text-white" id="button" data-toggle="tooltip" data-placement="top" title="Hapus"> <i class='fas fa-trash'></i></a>
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

<!-- Modal -->
<div class="modal fade" id="tambahPermintaan" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modalContent">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPermintaan">Tambah Permintaan Barang Habis Pakai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/permintaan/simpan" method="post" id="formTambahPermintaan">
                    <input type="hidden" name="edit_id" id="edit_id" value="">
                    <div class="modal-body">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= $csrfToken ?>">

                        <div class="form-group row">
                            <label for="nama_pengguna_barang" class="col-sm-4 col-form-label">Nama Pengguna</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nama_pengguna_barang" id="nama_pengguna_barang" placeholder="Isikan nama pengguna barang" value="<?php echo $nama; ?>" readonly>
                            </div>


                        </div>
                        <div class="form-group row">
                            <label for="tanggal_penggunaan" class="col-sm-4 col-form-label">Tanggal</label>
                            <div class="col-sm-8">
                                <div class="input-group date" id="tanggalPenggunaan" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#tanggalPenggunaan" name="tanggal_penggunaan" placeholder="Isikan tanggal penggunaan" required />
                                    <div class="input-group-append" data-target="#tanggalPenggunaan" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="keperluan" class="col-sm-4 col-form-label">Keperluan</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="keperluan" id="keperluan" placeholder="Isikan keperluan penggunaan barang"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary btn-sm" id="btnSimpan">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="detailMurni" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">Detail Permintaan Barang Persediaan</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="detailContentPengeluaranMurni"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
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

<?php echo view('tema/footer.php'); ?>

<script>
    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(amount);
    }

    function convertToIndonesianMonth(month) {
        const monthNames = {
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
            'December': 'Desember'
        };

        return monthNames[month];
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const formattedDate = date.getDate() + ' ' + convertToIndonesianMonth(date.toLocaleDateString('en-US', {
            month: 'long'
        })) + ' ' + date.getFullYear();
        return formattedDate;
    }

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

    function buildTable(data) {
        var tableHtml = '<table class="table table-sm table-bordered"><thead class="bg-secondary" style="text-align: center; vertical-align: middle; font-size: 14px;"><tr><th>No</th><th>Nama Barang</th><th>Jumlah Barang</th><th>Satuan</th><th>Harga Satuan</th><th>Jumlah Harga</th><th>Tanggal Penerimaan</th><th>Pengguna</th></tr></thead><tbody>';

        var totalJumlahBarang = 0;

        $.each(data.detail, function(index, row) {
            tableHtml += '<tr>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + (index + 1) + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + row.nama_barang + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + row.ambil_barang_murni + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + row.satuan + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + formatCurrency(row.harga_satuan) + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + formatCurrency(row.jumlah_harga) + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + formatDate(row.tanggal_penggunaan) + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + row.nama_pengguna_barang + '</td>';
            tableHtml += '</tr>';

            totalJumlahBarang += parseInt(row.ambil_barang_murni);
        });

        if (data.hasOwnProperty('total_harga') && !isNaN(data.total_harga)) {
            tableHtml += '<tr>';
            tableHtml += '<td colspan="2" style="text-align: center; font-size: 14px; font-weight: bold;">TOTAL</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px; font-weight: bold;">' + totalJumlahBarang + '</td>';
            tableHtml += '<td colspan="3" style="text-align: center; font-size: 14px; font-weight: bold;"> ' + formatCurrency(data.total_harga) + '</td>';
            tableHtml += '</tr>';
        }

        tableHtml += '</tbody></table>';
        return tableHtml;
    }

    $(document).ready(function() {
        $(".btn-detail").on("click", function() {
            var penerimaanId = $(this).data("penerimaan-id");

            showLoading(); // Tampilkan loading sebelum mengirim permintaan AJAX

            $.ajax({
                url: "<?php echo base_url('/pengeluaran_bhp/get_detail'); ?>/" + penerimaanId,
                method: "GET",
                dataType: "json",
                success: function(data) {
                    var tableHtml = buildTable(data);
                    $("#detailContentPengeluaranMurni").html(tableHtml);
                    hideLoading(); // Sembunyikan loading setelah data selesai dimuat
                    $("#detailMurni").modal("show");
                },
                error: function() {
                    alert("Error fetching details");
                    hideLoading(); // Sembunyikan loading jika terjadi kesalahan
                }
            });
        });
    });
</script>


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

                $.ajax({
                    type: 'POST',
                    url: '/pengeluaran/bhp/hapus/' + data_id, // Ganti URL sesuai dengan URL yang benar
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
                            window.location.replace("/pengeluaran/bhp");
                        });
                    },
                    error: function(xhr, status, error) {
                        // Sembunyikan pesan loading saat ada kesalahan dalam penghapusan
                        hideLoading();

                        // Tambahkan pesan error di sini
                        var errorMessage = '<div style="text-align: center;">' +
                            '<p style="margin-bottom: 5px;">Masih ada barang pada data Permintaan.</p>' +
                            '<p style="margin-bottom: 5px;">Harap hapus data barang terlebih dahulu.</p>' +
                            '</div>';

                        // Jika status 403, berarti pengguna tidak diizinkan menghapus data
                        if (xhr.status === 403) {
                            errorMessage = 'Anda tidak diizinkan untuk menghapus data.';
                        }

                        // Jika status 404, berarti data yang akan dihapus tidak ditemukan
                        if (xhr.status === 404) {
                            errorMessage = 'Data tidak ditemukan.';
                        }

                        // Tampilkan pesan error menggunakan SweetAlert
                        Swal.fire({
                            title: 'Gagal!',
                            html: errorMessage,
                            icon: 'error',
                            showConfirmButton: true,
                        });


                    }
                });
            }
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil elemen dengan kelas 'flash-data'
        var flashDataElement = document.querySelector('.flash-data');

        // Ambil data flash dari elemen tersebut
        var flashData = flashDataElement.dataset.flashdata;

        // Periksa apakah ada data flash
        if (flashData) {
            // Parse JSON dari data flash
            var flashMessage = JSON.parse(flashData);

            // Tampilkan pesan dengan ikon error
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: flashMessage,
            });
        }
    });
</script>

<script>
    $(document).ready(function() {
        <?php if (session()->has('validation')) : ?>
            <?php foreach (session('validation')->getErrors() as $error) : ?>
                toastr.error('<?= esc($error) ?>');
            <?php endforeach; ?>
        <?php endif; ?>
    });
</script>

<script>