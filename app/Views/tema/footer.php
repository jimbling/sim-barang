<?php

use App\Services\PengaturanService;

$pengaturanService = new PengaturanService();

// Mendapatkan nama kampus dan website
$data_pengaturan = $pengaturanService->getNamaKampus();
$nama_kampus = $data_pengaturan['nama_kampus'];
$website = $data_pengaturan['website'];
?>

<footer class="main-footer">
    <strong>Copyright &copy; <?= date('Y'); ?>-<?= $currentYear; ?>
        <a href="<?= $website; ?>"><?= $nama_kampus; ?></a>.</strong>
    SIM Peminjaman Alat Laboratorium Keperawatan
</footer>


<script src="../../assets/plugins/jquery/jquery.min.js"></script>

<!-- Untuk Memunculkan Tooltips -->
<script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="../../assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="../../assets/dist/js/adminlte.min.js?v=3.2.0"></script>
<script src="../../assets/dist/sweet/sweetalert2.all.min.js"></script>
<script src="../../assets/plugins/summernote/summernote-bs4.min.js"></script>
<script src="../../assets/dist/sweet/myscript.js"></script>
<script src="../../assets/plugins/select2/js/select2.full.min.js"></script>
<script src="../../assets/plugins/select2/js/select2.min.js"></script>
<script src="../../assets/plugins/moment/moment.min.js"></script>
<script src="../../assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="../../assets/plugins/toastr/toastr.min.js"></script>
<script src="../../assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<script src="../../assets/plugins/chart.js/Chart.min.js"></script>
<script src="../../assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<script src="../../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="../../assets/dist/js/datatable.js"></script>
<script src="../../assets/dist/js/dateTime.js"></script>


<script>
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
</script>

<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

    })
</script>

<script>
    $(function() {
        // Summernote
        $('#summernote').summernote({
            tabsize: 2,
            height: 600
        });
    })
</script>



<script>
    $(document).ready(function() {
        // Tangkap klik pada ikon power-off
        $('.nav-items').click(function(e) {
            e.preventDefault(); // Menghentikan tindakan default link

            // Tampilkan SweetAlert konfirmasi
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin keluar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                backdrop: 'static', // Set backdrop to static
                allowOutsideClick: false // Set allowOutsideClick to false
            }).then((result) => {
                // Jika pengguna menekan tombol 'Ya', arahkan ke link keluar
                if (result.isConfirmed) {
                    window.location.href = '/auth/keluar';
                }
            });
        });
    });
</script>




</body>

</html>