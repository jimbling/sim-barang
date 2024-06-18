
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

function simpan_editAkun() {
  var id = document.getElementById('akunId').value;
  var fullName = document.getElementById('editNama').value;
  var username = document.getElementById('editUserNama').value;
  var password = document.getElementById('editUserPass').value;
  showLoading();

  $.ajax({
      type: "POST",
      url: baseURL + '/data/akun/update',
      data: {
          id: id,
          full_nama: full_nama,
          user_nama: user_nama,
          user_password: user_password
      },
      success: function(response) {
          hideLoading();
          if (response.status === 'success') {
              Swal.fire({
                  icon: 'success',
                  title: 'Sukses',
                  text: response.message,
              }).then(() => {
                  window.location.href = '/data/pengguna';
              });
          } else {
              Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: response.message,
              });
          }
      },
      error: function(xhr, textStatus, errorThrown) {
          hideLoading();
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Terjadi kesalahan saat mengirim permintaan.',
          });
      }
  });

  return false;
}

    var selectAllCheckbox = document.getElementById('select-all-checkbox');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('.checkbox-item');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });
    }

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
                        url: '/pengguna/hapus',
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
                                window.location.replace("/data/pengguna");
                            });
                        },
                        error: function(error) {
                            hideLoading();
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
                text: 'Pilih setidaknya satu data mahasiswa untuk dihapus.'
            });
        }
    }

    $(document).ready(function() {
        $('#filterForm').on('submit', function(e) {
            Swal.fire({
                title: 'Sedang Mengambil Data',
                icon: 'info',
                showConfirmButton: false,
                allowOutsideClick: false,
                timerProgressBar: true,
                timer: 2000
            });
        });
    });

