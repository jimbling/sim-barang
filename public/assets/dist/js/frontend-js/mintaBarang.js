
    $(document).ready(function() {
        var id_pengeluaran = $('#id_hidden').val();
        var dataBarangTerpilih = [];

        $('#formTambahPeneriman').submit(function(e) {
            e.preventDefault();


            var valid = true;

            $('input[name="ambil_barang_murni[]"]').each(function() {
                var value = $(this).val();

                if (value === '' || parseFloat(value) <= 0) {
                    toastr.error('Ambil Barang tidak boleh kosong atau 0. Silakan isi dengan nilai yang valid.');
                    valid = false;
                    return false;
                }
            });

            if (!valid) {
                return;
            }


            $('#btnText').hide();
            $('#btnSpinner').show();


            $.ajax({
                type: 'POST',
                url: '/pengeluaran/bhp/simpan',
                data: $(this).serialize() + '&id_pengeluaran=' + id_pengeluaran,
                success: function(response) {

                    $.each(response, function(index, data) {

                        if (!dataBarangTerpilih.some(item => item.id === data.id)) {

                            dataBarangTerpilih.push(data);


                            $('#tabelBarangBody').append(`
                            <tr>
                                <td>${data.id}</td>
                                <td>${data.nama_barang}</td>
                                <td>${data.ambil_barang_murni}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm btnHapusBarang" data-id="${data.id}">Hapus</button>
                                </td>
                            </tr>
                        `);
                        }
                    });


                    $('#formTambahPeneriman')[0].reset();


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
                    toastr.success('Data berhasil disimpan.');


                    $('#btnText').show();
                    $('#btnSpinner').hide();
                },
                error: function(error) {
                    console.log('Error:', error);
                    toastr.error('Terjadi kesalahan. Data tidak dapat disimpan.');


                    $('#btnText').show();
                    $('#btnSpinner').hide();
                }
            });
        });
    });



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
                url: '/pengeluaran/barang_bhp/hapus/' + idBarang,
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
                        alert('Gagal menghapus barang');
                    }
                },
                error: function(error) {
                    console.log('Error:', error);
                    alert('Gagal menghapus barang');
                }
            });
        }
    });

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
        var jumlahBarangInput = document.getElementById("ambil_barang_murni");


        var hargaSatuan = parseFloat(hargaSatuanInput.value);
        var jumlahBarang = parseFloat(jumlahBarangInput.value);
        var totalHarga = isNaN(hargaSatuan) || isNaN(jumlahBarang) ? '' : hargaSatuan * jumlahBarang;
        jumlahHargaInput.value = totalHarga;
    }


    document.querySelector("input[name='barang_id[]']").addEventListener("change", getBarangDetails);


    document.getElementById("ambil_barang_murni").addEventListener("input", getBarangDetails);




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

        $('#ambil_barang_murni').blur(function() {

            var ambilBarang = parseInt($('#ambil_barang_murni').val()) || 0;
            var jumlahBarang = parseInt($('#jumlah_barang').val()) || 0;


            if (ambilBarang > jumlahBarang) {

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Nilai Ambil Barang tidak boleh lebih besar dari Jumlah Barang!',
                });

                $('#ambil_barang_murni').val('');
            }

        });


    });
