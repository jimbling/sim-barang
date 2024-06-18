// masterBarang.js

function openEditModal(id) {
  document.getElementById('edit_id').value = id;

  // Menggunakan baseUrl untuk membangun URL dinamis
  document.getElementById('formEditBarang').action = `${baseUrl}barang/update/${id}`;

  $.ajax({
      url: `${baseUrl}barang/get_detail/${id}`,
      method: 'GET',
      success: function(data) {
          console.log(data);
          $('#editBarang').modal('show');
          populateEditModal(data);

          $('#editId').val(id);
      },
      error: function(xhr, status, error) {
          console.error(error);
      }
  });
}

function populateEditModal(data) {
  $('#nama_barang_edit').val(data.nama_barang);
  $('#jumlah_barang_edit').val(data.jumlah_barang);
  $('#kondisi_barang_edit').val(data.kondisi_barang);
  $('#disewakan_edit').val(data.disewakan);
  $('#harga_sewa_edit').val(data.harga_sewa);
}

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
                  url: `${baseUrl}barang/hapus`,
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
                          window.location.replace(`${baseUrl}barang/master`);
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
          text: 'Pilih setidaknya satu data barang untuk dihapus.'
      });
  }
}

function validateNumberInput(input) {
  var inputValue = input.value.trim();
  var errorMessage = document.getElementById('jumlah_barang_error');

  if (/^\d+$/.test(inputValue)) {
      errorMessage.textContent = '';
  } else {
      errorMessage.textContent = 'Harap masukkan hanya angka.';
  }
}

document.addEventListener("DOMContentLoaded", function() {
  const fileInput = document.getElementById("excel_file");
  const importButton = document.getElementById("importButton");
  const loading = document.getElementById("loading");
  const processText = document.getElementById("processText");
  const fileNameDisplay = document.getElementById("file_name_display");

  fileInput.addEventListener("change", function() {
      if (fileInput.files.length > 0) {
          fileNameDisplay.textContent = `File terpilih: ${fileInput.files[0].name}`;
      } else {
          fileNameDisplay.textContent = "";
      }
  });

  importButton.addEventListener("click", function() {
      if (fileInput.files.length > 0) {
          const allowedFileTypes = ["application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"];
          const selectedFileType = fileInput.files[0].type;

          if (allowedFileTypes.includes(selectedFileType)) {
              loading.style.display = "inline-block";
              processText.style.display = "inline-block";

              const formData = new FormData();
              formData.append("excel_file", fileInput.files[0]);

              const fileNameDisplay = document.getElementById("excel_file");
              fileNameDisplay.textContent = `File terpilih: ${fileInput.files[0].name}`;

              fetch(`${baseUrl}barang/importData`, {
                      method: "POST",
                      body: formData,
                  })
                  .then(response => response.json())
                  .then(data => {
                      console.log(data);
                      loading.style.display = "none";
                      processText.style.display = "none";

                      if (data.status === "success") {
                          Swal.fire({
                              icon: "success",
                              title: "File Berhasil Diimpor!",
                              text: data.message,
                              timer: 5000,
                              showConfirmButton: false,
                          }).then(() => {
                              location.reload();
                          });
                      } else {
                          Swal.fire({
                              icon: "error",
                              title: "Gagal Impor File!",
                              text: data.message,
                              timer: 5000,
                              showConfirmButton: false,
                          });
                      }
                  })
                  .catch(error => {
                      loading.style.display = "none";
                      processText.style.display = "none";
                      console.error(error);

                      Swal.fire({
                          icon: "error",
                          title: "Terjadi Kesalahan!",
                          text: "Terjadi kesalahan saat mengimpor file. Pastikan file yang Anda unggah adalah file Excel yang valid.",
                      });
                  });

          } else {
              Swal.fire({
                  icon: "error",
                  title: "Jenis File Tidak Diijinkan!",
                  text: "Anda hanya dapat mengimpor file dengan format XLS atau XLSX.",
              });
          }
      } else {
          Swal.fire({
              icon: "error",
              title: "File Belum Dipilih!",
              text: "Anda harus memilih file terlebih dahulu sebelum mengimpor.",
          });
      }
  });
});

$(document).ready(function() {
  $('#dataBarangTable').DataTable({
      "processing": true,
      "ajax": {
          "url": `${baseUrl}barang/fetchData`,
          "type": "POST"
      },
      "columns": [{
              "data": null,
              "className": "text-center",
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
              "orderable": false,
              "render": function(data, type, row, meta) {
                  return meta.row + meta.settings._iDisplayStart + 1;
              }
          },
          {
              "data": "kode_barang",
              "className": "text-center"
          },
          {
              "data": "nama_barang",
              "className": "text-center"
          },
          {
              "data": "jumlah_barang",
              "className": "text-center"
          },
          {
              "data": "kondisi_barang",
              "className": "text-center"
          },
          {
              "data": "disewakan",
              "className": "text-center"
          },
          {
              "data": null,
              "className": "text-center",
              "orderable": false,
              "render": function(data, type, row) {
                  var checkbox = '<input type="checkbox" class="checkbox-item" data-id="' + row.id + '">';
                  return checkbox;
              }
          },
          {
              "data": null,
              "className": "text-center",
              "orderable": false,
              "render": function(data, type, row) {
                  var editButton = '<button type="button" class="btn btn-info btn-xs edit-btn" style="vertical-align: middle;" onclick="openEditModal(' + row.id + ')">Edit</button>';
                  return editButton;
              }
          }
      ],
      "responsive": true
  });

  $('.checkbox-item').change(function() {
      if (!$(this).prop('checked')) {
          $('#select-all-checkbox').prop('checked', false);
      }
  });
});
