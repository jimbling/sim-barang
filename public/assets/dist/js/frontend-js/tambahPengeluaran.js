var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Atau ambil token dari hidden input
    $('#tabelBarangBody').on('click', '.btnHapusBarang', function() {
      var idBarang = $(this).data('id');
      var deletedRow = $(this).closest('tr');
      var created_at = $('#id').data('created_at');
      var currentTime = new Date();
      var createdAtTime = new Date(created_at);
      var timeDifference = currentTime - createdAtTime;
      var hoursDifference = timeDifference / (1000 * 60 * 60);


      if (hoursDifference > 24) {
          toastr.error('Tidak dapat menghapus barang karena sudah melebihi 24 jam.');
      } else {

          $.ajax({
              type: 'POST',
              url: '/pengeluaran/hapusData'+'/' + idBarang,
              success: function(response) {
                  if (response.status === 'success') {

                      deletedRow.remove();


                      toastr.options = {
                          "closeButton": false,
                          "debug": false,
                          "newestOnTop": false,
                          "progressBar": true,
                          "positionClass": "toast-bottom-right",
                          "preventDuplicates": false,
                          "onclick": null,
                          "showDuration": "1800",
                          "hideDuration": "1800",
                          "timeOut": "5000",
                          "extendedTimeOut": "1800",
                          "showEasing": "swing",
                          "hideEasing": "linear",
                          "showMethod": "fadeIn",
                          "hideMethod": "fadeOut"
                      };

                      toastr.success('Barang berhasil dihapus dari daftar.');
                  } else {
                    toastr.error('Gagal menghapus sdasdasdasd barang');
                  }
              },
              error: function(error) {
                  console.log('Error:', error);
                  toastr.error('Gagal menghapus barang');
              }
          });
      }
  });


    function updateTable(data) {

        $('#daftarBarangPersediaan tbody').empty();
        $.each(data, function(index, item) {
            var row = '<tr>' +
                '<td>' + item.barang_id + '</td>' +
                '<td>' + item.nama_barang + '</td>' +
                '<td>' + item.ambil_barang + '</td>' +
                '<td>' +
                '<button class="btn btn-danger btn-xs" onclick="hapusData(' + item.id + ')">Hapus</button>' +
                '</td>' +
                '</tr>';

            $('#daftarBarangPersediaan tbody').append(row);
        });

    }

    function pilihBarang(barangId, namaBarang, hargaSatuan, jumlahBarang) {

        document.getElementById("barang_display").value = namaBarang;
        document.getElementById("barang_id[]").value = barangId;
        document.getElementById("harga_satuan").value = hargaSatuan;
        document.getElementById("jumlah_barang").value = jumlahBarang;

        $('#modalPilihBarang').modal('hide');
    }

    function getBarangDetails() {
        var hargaSatuanInput = document.getElementById("harga_satuan");
        var jumlahHargaInput = document.getElementById("jumlah_harga");
        var jumlahBarangInput = document.getElementById("ambil_barang");

        var hargaSatuan = parseFloat(hargaSatuanInput.value);
        var jumlahBarang = parseFloat(jumlahBarangInput.value);
        var totalHarga = isNaN(hargaSatuan) || isNaN(jumlahBarang) ? '' : hargaSatuan * jumlahBarang;

        jumlahHargaInput.value = totalHarga;

    }


    document.querySelector("input[name='barang_id[]']").addEventListener("change", getBarangDetails);
    document.getElementById("ambil_barang").addEventListener("input", getBarangDetails);

    function cariBarang() {
        var inputPencarian = document.getElementById('inputPencarianBarang');
        var filter = inputPencarian.value.toUpperCase();
        var buttons = document.querySelectorAll('#modalPilihBarang .btn');

        buttons.forEach(function(button) {
            var txtValue = button.textContent || button.innerText;
            button.style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? 'block' : 'none';
        });
    }


    document.getElementById('inputPencarianBarang').addEventListener('input', cariBarang);





    $(document).ready(function() {
      $('#formTambahPeneriman').submit(function(e) {
          e.preventDefault();

          var ambilBarangValues = $('input[name="ambil_barang[]"]').map(function() {
              return $(this).val();
          }).get();

          if (ambilBarangValues.includes("0") || ambilBarangValues.includes("")) {
              toastr.error('Ambil Barang tidak boleh kosong atau 0. Silakan isi dengan nilai yang valid.');
              return;
          }

          $('#btnText').hide();
          $('#btnSpinner').show();

          $.ajax({
              type: 'POST',
              url: '/pengeluaran/simpan',
              data: $('#formTambahPeneriman').serialize(),
              dataType: 'json',
              success: function(response) {
                  updateTable(response.data);

                  toastr.options = {
                      "closeButton": false,
                      "debug": false,
                      "newestOnTop": false,
                      "progressBar": true,
                      "positionClass": "toast-bottom-right",
                      "preventDuplicates": false,
                      "onclick": null,
                      "showDuration": "1800",
                      "hideDuration": "1800",
                      "timeOut": "5000",
                      "extendedTimeOut": "1800",
                      "showEasing": "swing",
                      "hideEasing": "linear",
                      "showMethod": "fadeIn",
                      "hideMethod": "fadeOut"
                  };

                  toastr.success('Berhasil menambahkan barang persediaan.');

                  $('#btnText').show();
                  $('#btnSpinner').hide();
              },
              error: function(error) {
                  console.error('Error saving data:', error);

                  $('#btnText').show();
                  $('#btnSpinner').hide();
              }
          });
      });

      function updateTable(data) {
          $('#daftarBarangPersediaan tbody').empty();

          $.each(data, function(index, item) {
              var row = '<tr>' +
                  '<td>' + item.barang_id + '</td>' +
                  '<td>' + item.nama_barang + '</td>' +
                  '<td>' + item.ambil_barang + '</td>' +
                  '<td>' +
                  '<button class="btn btn-danger btn-xs" onclick="hapusData(' + item.id + ')">Hapus</button>' +
                  '</td>' +
                  '</tr>';

              $('#daftarBarangPersediaan tbody').append(row);
          });
      }
  });


    $(document).ready(function() {

        $('#ambil_barang').blur(function() {

            var ambilBarang = parseInt($('#ambil_barang').val()) || 0;
            var jumlahBarang = parseInt($('#jumlah_barang').val()) || 0;


            if (ambilBarang > jumlahBarang) {

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Nilai Ambil Barang tidak boleh lebih besar dari Jumlah Barang!',
                });

                $('#ambil_barang').val('');
            }

        });


    });


    // $(document).ready(function() {

    //     $('#peminjaman_id').on('change', function() {
    //         var peminjamanId = $(this).val();

    //         if (peminjamanId !== '') {
    //             tampilkanData(peminjamanId);
    //         }
    //     });


    //     function tampilkanData(peminjamanId) {

    //         $.ajax({
    //             url: '/pengeluaran/getDataByPeminjamanId/' + peminjamanId,
    //             method: 'GET',
    //             success: function(response) {
    //                 console.log('Response from server:', response);

    //                 $('#tabelBarang').html(response);
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error(xhr.responseText);
    //             }
    //         });
    //     }
    // });



    // var selectedPeminjamanId;

    // function pilihData(peminjamanId, barangId, kodePinjam, namaPeminjam, namaRuangan, penggunaan, tanggalPinjam, namaBarang) {
    //     document.getElementById('peminjaman_id_hidden').value = peminjamanId;
    //     document.getElementById('peminjaman_id_display').value = peminjamanId;
    //     document.getElementById('nama_peminjam').value = namaPeminjam;
    //     document.getElementById('nama_ruangan').value = namaRuangan;
    //     document.getElementById('penggunaan').value = penggunaan;
    //     document.getElementById('tanggal_pinjam').value = tanggalPinjam;


    //     selectedPeminjamanId = peminjamanId;
    //     $('#pilihKodePinjam').modal('hide');


    //     $.ajax({
    //         type: "GET",
    //         url: "/pengeluaran/getDataByPeminjamanId/" + peminjamanId,
    //         success: function(response) {

    //             var data = JSON.parse(response);
    //             $('#daftarBarangPersediaan tbody').empty();
    //             updateTable(data);
    //             console.log("Success Response:", data);
    //         },
    //         error: function(error) {
    //             console.error('Error fetching data:', error);
    //         }
    //     });
    // }



