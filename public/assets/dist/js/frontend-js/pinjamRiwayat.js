
    $(document).ready(function() {
        var table = $('#daftarRiwayatPeminjamanTable').DataTable({
            "processing": true,

            "ordering": false,
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
            "ajax": {

                "url": `${baseUrl}peminjaman/fetchData`,
                "type": "POST",
                "data": function(d) {
                    d.tahun = $('#tahun').val();
                }
            },
            "columns": [{
                    "data": "no",
                    "className": "text-center",
                    "orderable": false
                },
                {
                    "data": "kode_pinjam"
                },
                {
                    "data": "nama_peminjam",
                    "width": "80px"
                },
                {
                    "data": "tanggal_pinjam",
                    "width": "100px",
                    "render": function(data, type, row) {
                        var tanggal = new Date(data);
                        var bulan = {
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
                            'December': 'Desember',
                        };
                        var namaBulan = bulan[tanggal.toLocaleString('en-us', {
                            month: 'long'
                        })];
                        var waktu = tanggal.getDate() + ' ' + namaBulan + ' ' + tanggal.getFullYear() + ' - ' + ('0' + tanggal.getHours()).slice(-2) + ':' + ('0' + tanggal.getMinutes()).slice(-2) + ' WIB';
                        return waktu;
                    }
                },
                {
                    "data": "keperluan",
                    "width": "150px"
                },
                {
                    "data": "barang_dipinjam",
                    "className": "text-left",
                    "render": function(data, type, row) {
                        var barangs = data.split(',');
                        var html = '';
                        barangs.forEach(function(barang, index) {
                            html += (index + 1) + '. ' + barang + '<br>';
                        });
                        return html;
                    }
                },
                {
                    "data": null,
                    "width": "150px",
                    "render": function(data, type, row) {
                        return `
                        <button type="button" class="btn btn-primary btn-xs detailBtn mt-1" data-kodepinjam="${row.kode_pinjam}">Detail</button>
                        <button type="button" class="btn btn-danger btn-xs hapusBtn mt-1" data-id="${row.peminjaman_id}">Hapus</button>
                        <a class="btn btn-xs btn-success mx-auto text-white kembaliBtn mt-1" href="${baseUrl}form_kembali/riwayat/${row.peminjaman_id}" target="_blank">F. Kembali</a>
                    `;
                    }
                }
            ]
        });


        table.on('order.dt search.dt', function() {
            table.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();


        $('#daftarRiwayatPeminjamanTable').on('click', '.detailBtn', function() {
            var kode_pinjam = $(this).data('kodepinjam');
            console.log('Detail untuk kode pinjam:', kode_pinjam);
        });


        $('#daftarRiwayatPeminjamanTable').on('click', '.hapusBtn', function() {
            var data_id = $(this).data('id');
            hapus_data(data_id);
        });


        $('#daftarRiwayatPeminjamanTable').on('click', '.kembaliBtn', function() {
            var data_id = $(this).data('id');

            console.log('F. Kembali untuk ID:', data_id);
        });


        function hapus_data(data_id) {
            console.log('Hapus data dengan ID:', data_id);

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
                        url: '/pinjam/hapus_riwayat/' + data_id,
                        success: function(response) {

                            hideLoading();


                            if (response.status === 'success') {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false,
                                }).then(() => {

                                    window.location.replace("/pinjam/riwayat");
                                });
                            } else {

                                if (response.message.includes('Kode Pinjam:')) {

                                    let kodePinjam = response.message.split('Kode Pinjam: ')[1].trim();

                                    kodePinjam = kodePinjam.replace(/\.$/, '');

                                    Swal.fire({
                                        title: 'Gagal!',
                                        html: response.message + '<br><br><button id="copyKodePinjam" class="btn btn-primary">Copy</button>',
                                        icon: 'error',
                                        showConfirmButton: false
                                    });


                                    $(document).on('click', '#copyKodePinjam', function() {
                                        navigator.clipboard.writeText(kodePinjam)
                                            .then(() => {
                                                Swal.fire({
                                                    title: 'Copied!',
                                                    text: 'Kode Pinjam berhasil disalin.',
                                                    icon: 'success',
                                                    timer: 2000,
                                                    showConfirmButton: false
                                                }).then(() => {
                                                    Swal.close();
                                                });
                                            })
                                            .catch((err) => {
                                                Swal.fire({
                                                    title: 'Error!',
                                                    text: 'Gagal menyalin Kode Pinjam.',
                                                    icon: 'error'
                                                });
                                                console.error('Could not copy text: ', err);
                                            });
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: response.message,
                                        icon: 'error',
                                    });
                                }
                            }
                        },
                        error: function(xhr, status, error) {

                            hideLoading();

                            let errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan saat menghapus data.';
                            Swal.fire({
                                title: 'Gagal!',
                                text: errorMessage,
                                icon: 'error',
                            });
                            console.log('AJAX Error:', xhr);
                            console.log('Status:', status);
                            console.log('Error:', error);
                        }
                    });
                }
            });
        }


        function showLoading() {
            let timerInterval;
            Swal.fire({
                title: 'Sedang memproses data ....',
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }


        function hideLoading() {
            Swal.close();
        }
    });



    $(document).on('click', '.detailBtn', function() {
        var kodePinjam = $(this).data('kodepinjam');
        window.location.href = "/kode_kembali/detail/" + kodePinjam;
    });
