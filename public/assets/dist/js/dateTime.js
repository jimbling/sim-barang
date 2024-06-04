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

  //Date and time picker
  $('#reservationkembali').datetimepicker({
      icons: {
          time: 'far fa-clock'
      }
  });
  //Date and time picker
  $('#editTanggalKembali').datetimepicker({
      icons: {
          time: 'far fa-clock'
      },
  });

})
