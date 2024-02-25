<footer class="main-footer">
    <strong>Copyright &copy; 2023-<?= $currentYear; ?> <a href="https://www.akperykyjogja.ac.id/home">Akper "YKY" Yogyakarta</a>.</strong> SIM Peminjaman Alat Laboratorium Keperawatan
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
    $(function() {

        if (window.location.pathname === '/barang/daftar') {
            $('#daftarBarangTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        }

        if (window.location.pathname === '/pinjam/daftar') {

            $('#daftarPeminjamanTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "serverSide": false,
            });
        }

        if (window.location.pathname === '/kembali/tambah') {
            $('#daftarKodePinjam').DataTable({
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        }

        // if (window.location.pathname === '/kembali/riwayat') {
        //     $('#daftarRiwayatPengembalian').DataTable({
        //         "paging": true,
        //         "lengthChange": true,
        //         "searching": true,
        //         "ordering": false,
        //         "info": true,
        //         "autoWidth": false,
        //         "responsive": true,
        //     });
        // }
        if (window.location.pathname === '/penerimaan/daftar') {
            $('#daftarPenerimaanPersediaanTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        }

        if (window.location.pathname === '/barang/persediaan/master') {
            $('#masterBarangPersediaan').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        }

        if (window.location.pathname === '/barang/satuan') {
            $('#dataSatuanBarang').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        }

        if (window.location.pathname === '/persediaan/opname') {
            $('#opnameBarangPersediaan').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        }

        if (window.location.pathname === '/pengeluaran/tambahBaru') {
            $('#daftarKodePinjamPersed').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        }
        if (window.location.pathname === '/pengeluaran/daftar') {
            $('#daftarPengeluaranPersediaanTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        }

        if (window.location.pathname === '/pinjam/pihakluar') {
            $('#daftarPinjamLuar').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#daftarPinjamLuar_wrapper .col-md-6:eq(0)');
        }

        if (window.location.pathname === '/barang/disewakan') {
            $('#daftarBarangDisewakan').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        }

        if (window.location.pathname === '/pinjam/pihakluar/riwayat') {
            $('#riwayatdaftarPinjamLuar').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        }
        if (window.location.pathname === '/pengeluaran/bhp') {
            $('#daftarPengeluaranMurniTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        }
        if (window.location.pathname === '/reservasi') {
            $('#daftarReservasi').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        }
        if (window.location.pathname === '/data/pengguna') {
            $('#penggunaTabel').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        }

    });
</script>
<script>
    $(function() {
        //Date picker
        $('#tanggalPenerimaan').datetimepicker({
            format: 'L'
        });
        $('#tanggalLahir').datetimepicker({
            format: 'L'
        });
        $('#tanggalLahir_edit').datetimepicker({
            format: 'L'
        });
        $('#tanggalSk_edit').datetimepicker({
            format: 'L'
        });
        $('#tanggalPermintaan').datetimepicker({
            format: 'L'
        });
        $('#tanggalPenggunaan').datetimepicker({
            format: 'L'
        });

        //Date and time picker
        $('#created_at_edit').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });
        //Date and time picker
        $('#reservationdatetime').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
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