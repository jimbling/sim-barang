
    document.getElementById('select-all-checkbox').addEventListener('change', function() {
        var checkboxes = document.querySelectorAll('.checkbox-item');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = document.getElementById('select-all-checkbox').checked;
        });
    });




    function deleteSelectedItems() {
        var selectedIds = [];


        $('.checkbox-item:checked').each(function() {
            selectedIds.push($(this).data('id'));
        });


        if (selectedIds.length > 0) {

            Swal.fire({
                title: 'Anda yakin?',
                text: 'Data yang dipilih akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoading();

                    $.ajax({
                        url: '/data/pembelajaran/hapus',
                        method: 'POST',
                        data: {
                            ids: selectedIds
                        },
                        success: function(response) {
                            hideLoading();

                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Data berhasil dihapus.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false,
                            }).then(() => {

                                window.location.replace("/data/pembelajaran");
                            });
                        },
                        error: function(error) {
                            hideLoading();

                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                icon: 'error',
                            });
                        }
                    });
                }
            });
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Pilih setidaknya satu data pembelajaran untuk dihapus.'
            });
        }
    }

    $(document).ready(function() {
        // Tangani submit form
        $('#pembelajaranForm').submit(function(e) {
            e.preventDefault(); // Mencegah pengiriman form secara default

            // Hapus pesan toastr sebelumnya agar tidak berulang
            toastr.clear();

            $.ajax({
                url: '/data/pembelajaran/tambah', // Ganti dengan URL yang sesuai untuk mengarahkan ke metode controller Anda
                method: 'POST',
                dataType: 'json', // Pastikan data tipe yang dikembalikan adalah JSON
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        // Bersihkan form jika berhasil
                        $('#pembelajaranForm')[0].reset();
                    } else {
                        // Tampilkan pesan kesalahan
                        $.each(response.errors, function(key, value) {
                            toastr.error(value);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error('Terjadi kesalahan pada server: ' + error);
                }
            });
        });
    });

    $(document).ready(function() {
      // Ambil elemen dengan ID 'flashdata'
      var flashdataElement = $('#flashdata');

      // Ambil pesan sukses dari atribut data
      var successMessage = flashdataElement.data('success');
      if (successMessage) {
          toastr.success(successMessage);
      }

      // Ambil pesan kesalahan dari atribut data
      var errorMessages = flashdataElement.data('errors');
      if (errorMessages) {
          // Parsing string JSON menjadi objek JavaScript
          errorMessages = JSON.parse(errorMessages);
          // Tampilkan setiap pesan kesalahan dengan ToastR
          $.each(errorMessages, function(index, error) {
              toastr.error(error);
          });
      }
  });
