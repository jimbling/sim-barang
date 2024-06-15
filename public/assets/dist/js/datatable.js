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

  if (window.location.pathname === '/kembali/riwayat') {

    $('#daftarRiwayatPengembalian').DataTable({
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

if (window.location.pathname === '/pinjam/user/riwayat') {

  $('#daftarRiwayatPeminjamanUser').DataTable({
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

if (window.location.pathname === '/laporan/lihat-mutasi') {

  $('#tableStokBulanan').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "serverSide": false,

  });
}
});

