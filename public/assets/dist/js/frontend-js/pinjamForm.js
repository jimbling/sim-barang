
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

    $(document).ready(function() {

        $("form").submit(function(event) {
            event.preventDefault();


            var namaPeminjam = $("#pinjam_nama_peminjam").val();
            if (namaPeminjam === '') {
                toastr.error('Nama Peminjam harus diisi!');
                return;
            }


            var namaRuangan = $("#pinjam_nama_ruangan").val();
            if (namaRuangan === '') {
                toastr.error('Nama Ruangan harus diisi!');
                return;
            }


            var keperluan = $("#pinjam_keperluan").val();
            if (keperluan === '') {
                toastr.error('Penggunaan/Keperluan harus diisi!');
                return;
                l
            }


            var selectedBarang = $("select[name='barang[]']").val();
            if (selectedBarang === null || selectedBarang.length === 0) {
                toastr.error('Tambahkan minimal satu barang!');
                return;
            }

            showLoading();


            $.ajax({
                type: "POST",
                url: $(this).attr("action"),
                data: $(this).serialize(),
                success: function(response) {

                    hideLoading();


                    Swal.fire({
                        icon: 'success',
                        title: 'Peminjaman berhasil dilakukan!',
                        showConfirmButton: false,
                        timer: 1500,
                        willClose: () => {

                            window.location.href = "/pinjam/daftar";
                        }
                    });
                },
                error: function(error) {
                    hideLoading();

                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var selectPeminjam = document.getElementById('pinjam_nama_peminjam');
        var hiddenInputNimNik = document.getElementById('nim_nik');


        selectPeminjam.addEventListener('change', function() {

            var selectedOption = selectPeminjam.options[selectPeminjam.selectedIndex].value;
            var selectedValues = selectedOption.split('-');
            hiddenInputNimNik.value = selectedValues[1];

        });
    });

