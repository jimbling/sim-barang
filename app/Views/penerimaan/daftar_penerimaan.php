<?php echo view('tema/header.php'); ?>

<div class="content-wrapper">
    <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanHapusPosts')); ?>"></div><!-- Page Heading -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 class="m-0">Daftar Penerimaan Barang Persediaan</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Data Barang</li>
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
                                        <a class="btn btn-success btn-sm" href="/penerimaan/tambahBaru" role="button"> <i class='fas fa-cart-arrow-down spaced-icon'></i>Tambah Penerimaan</a>
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="daftarPenerimaanPersediaanTable" class="table table-striped table-responsive">
                                <thead class="thead bg-info" style="font-size: 14px;">
                                    <tr>
                                        <th width='3%'>No</th>
                                        <th style="text-align: center;">Jurusan/Prodi</th>
                                        <th style="text-align: center;">Kelompok Barang</th>
                                        <th style="text-align: center;">Jumlah Harga Penerimaan</th>
                                        <th style="text-align: center;">Jenis Penerimaan</th>
                                        <th style="text-align: center;">Tanggal Penerimaan</th>
                                        <th style="text-align: center;">Petugas</th>
                                        <th style="text-align: center;">Detail</th>
                                    </tr>
                                </thead>
                                <div id="alertContainer" class="mt-3"></div>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($data_penerimaan as $dataPenerimaan) : ?>
                                        <tr>
                                            <th class="text-center" scope="row" style="vertical-align: middle; font-size: 14px;"><?= $i++; ?></th>
                                            <td style="text-align: left; vertical-align: middle; font-size: 14px;"><?= $dataPenerimaan['prodi']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $dataPenerimaan['kelompok_barang']; ?></td>


                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;">
                                                <?= 'Rp. ' . number_format($dataPenerimaan['total_jumlah_harga'], 0, ',', '.'); ?>
                                            </td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $dataPenerimaan['jenis_perolehan']; ?></td>
                                            <td style="text-align: center; vertical-align: middle; font-size: 14px;">
                                                <?php
                                                $tanggal_penerimaan = \CodeIgniter\I18n\Time::parse($dataPenerimaan['tanggal_penerimaan'])
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

                                                $bulan = $nama_bulan[$tanggal_penerimaan->format('F')];

                                                echo $tanggal_penerimaan->format('d ') . $bulan . $tanggal_penerimaan->format(' Y');
                                                ?>
                                            </td>


                                            <td width='15%' style="text-align: center; vertical-align: middle; font-size: 14px;"><?= $dataPenerimaan['petugas']; ?></td>
                                            <td width='10%' style="text-align: center; vertical-align: middle; font-size: 14px;">
                                                <button type="button" class="btn btn-warning btn-xs btn-detail" data-toggle="tooltip" data-placement="left" title="Detail" data-toggle="modal" data-penerimaan-id="<?= $dataPenerimaan['penerimaan_id']; ?>">
                                                    <i class='fas fa-eye'></i>
                                                </button>

                                                <a onclick=" hapus_data('<?= $dataPenerimaan['penerimaan_id']; ?>')" class="btn btn-xs btn-danger mx-auto text-white" id="button" data-toggle="tooltip" data-placement="top" title="Hapus"> <i class='fas fa-trash'></i></a>
                                            </td>

                                        </tr>
                                        <!-- Modal -->

                                        <!-- End Modal -->
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Modal -->
            <div class="modal fade" id="detailModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                    <div class="modal-content modal-static">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Detail Penerimaan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="detailContent"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->






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



    function buildTable(data) {
        var tableHtml = '<table class="table table-sm table-bordered"><thead class="bg-secondary" style="text-align: center; vertical-align: middle; font-size: 14px;"><tr><th>No</th><th>Nama Barang</th><th>Jumlah Barang</th><th>Satuan</th><th>Harga Satuan</th><th>Jumlah Harga</th><th>Tanggal Penerimaan</th><th>Petugas</th></tr></thead><tbody>';

        $.each(data.detail, function(index, row) {
            tableHtml += '<tr>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + (index + 1) + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + row.nama_barang + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + row.jumlah_barang + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + row.satuan + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + formatCurrency(row.harga_satuan) + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + formatCurrency(row.jumlah_harga) + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + formatDate(row.tanggal_penerimaan) + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + row.petugas + '</td>';
            tableHtml += '</tr>';
        });

        // Menambahkan baris total_harga hanya jika total_harga ada dan memiliki nilai yang valid
        if (data.hasOwnProperty('total_harga') && !isNaN(data.total_harga)) {
            tableHtml += '<tr>';
            tableHtml += '<td colspan="5" style="text-align: center; font-size: 14px; font-weight: bold;">TOTAL HARGA PENERIMAAN</td>'; // Membuat sel kosong untuk kolom No hingga Harga Satuan
            tableHtml += '<td style="text-align: center; font-size: 14px; font-weight: bold;">' + formatCurrency(data.total_harga) + '</td>'; // Menampilkan total_harga
            tableHtml += '<td colspan="3"></td>'; // Membuat sel kosong untuk kolom Kondisi Barang hingga Petugas
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
                url: "<?php echo base_url('/get_detail'); ?>/" + penerimaanId,
                method: "GET",
                dataType: "json",
                success: function(data) {
                    var tableHtml = buildTable(data);
                    $("#detailContent").html(tableHtml);
                    hideLoading(); // Sembunyikan loading setelah data selesai dimuat
                    $("#detailModal").modal("show");
                },
                error: function() {
                    alert("Error fetching details");
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
                // Lakukan permintaan penghapusan ke server, misalnya dengan AJAX.
                // Jika penghapusan berhasil, maka lakukan redirect ke halaman /siswa.
                // Contoh penggunaan jQuery untuk permintaan penghapusan:
                $.ajax({
                    type: 'POST',
                    url: '/penerimaan/hapus/' + data_id, // Ganti URL sesuai dengan URL yang benar
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
                            window.location.replace("/penerimaan/daftar");
                        });
                    },
                    error: function(xhr, status, error) {
                        // Sembunyikan pesan loading saat ada kesalahan dalam penghapusan
                        hideLoading();
                        // Handle error here, jika ada kesalahan dalam penghapusan

                    }
                });
            }
        });
    }
</script>




<?php echo view('tema/footer.php'); ?>