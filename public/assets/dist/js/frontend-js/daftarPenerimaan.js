
    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(amount);
    }

    function convertToIndonesianMonth(month) {
        const monthNames = {
            'January': 'Januari',
            'February': 'Februari',
            'March': 'Maret',
            'April': 'April',
            'May': 'Mei',
            'June': 'Juni',
            'July': 'Juli',
            'August': 'Agustus',
            'September': 'September',
            'October': 'Oktober',
            'November': 'November',
            'December': 'Desember'
        };

        return monthNames[month];
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const formattedDate = date.getDate() + ' ' + convertToIndonesianMonth(date.toLocaleDateString('en-US', {
            month: 'long'
        })) + ' ' + date.getFullYear();
        return formattedDate;
    }



    function buildTable(data) {
        var tableHtml = '<table class="table table-sm table-bordered"><thead class="bg-secondary" style="text-align: center; vertical-align: middle; font-size: 14px;"><tr><th>No</th><th>Nama Barang</th><th>Jumlah Barang</th><th>Satuan</th><th>Harga Satuan</th><th>Jumlah Harga</th><th>Tanggal Penerimaan</th><th>Petugas</th></tr></thead><tbody>';

        $.each(data.detail, function(index, row) {
            tableHtml += '<tr>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + (index + 1) + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + row.nama_barang + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + row.jumlah_barang + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + row.satuan + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + formatCurrency(row.harga_satuan) + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + formatCurrency(row.jumlah_harga) + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + formatDate(row.tanggal_penerimaan) + '</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px;">' + row.petugas + '</td>';
            tableHtml += '</tr>';
        });


        if (data.hasOwnProperty('total_harga') && !isNaN(data.total_harga)) {
            tableHtml += '<tr>';
            tableHtml += '<td colspan="5" style="text-align: center; font-size: 14px; font-weight: bold;">TOTAL HARGA PENERIMAAN</td>';
            tableHtml += '<td style="text-align: center; font-size: 14px; font-weight: bold;">' + formatCurrency(data.total_harga) + '</td>';
            tableHtml += '<td colspan="3"></td>';
            tableHtml += '</tr>';
        }

        tableHtml += '</tbody></table>';
        return tableHtml;
    }

    $(document).ready(function() {
        $(".btn-detail").on("click", function() {
            var penerimaanId = $(this).data("penerimaan-id");
            showLoading();
            $.ajax({
              url: `${baseUrl}get_detail/${penerimaanId}`,
                method: "GET",
                dataType: "json",
                success: function(data) {
                    var tableHtml = buildTable(data);
                    $("#detailContent").html(tableHtml);
                    hideLoading();
                    $("#detailModal").modal("show");
                },
                error: function() {
                    alert("Error fetching details");
                }
            });
        });
    });

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

    function hapus_data(data_id) {

        Swal.fire({
            title: 'HAPUS?',
            text: "Yakin akan menghapus data ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {

                showLoading();

                $.ajax({
                    type: 'POST',
                    url: '/penerimaan/hapus/' + data_id,
                    success: function(response) {

                        hideLoading();
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil dihapus.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        }).then(() => {

                            window.location.replace("/penerimaan/daftar");
                        });
                    },
                    error: function(xhr, status, error) {

                        hideLoading();

                        console.log(error);
                    }
                });
            }
        });
    }

