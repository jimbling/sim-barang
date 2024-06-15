<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Stok Bulanan</title>
    <link href="../../assets/dist/css/cetak-laporan-stok.css" rel="stylesheet" type="text/css">
    <style>
        /* Styling khusus untuk mode cetak */
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>



    <!-- Tombol kembali -->
    <button class="no-print" onclick="window.close()">Tutup</button>
    <div id="dataPengaturan" class="kop-surat">
        <!-- Tempat untuk kop surat akan diisi oleh JavaScript -->
    </div>
    <!-- Area untuk menampilkan data -->
    <div id="dataStok">
        <!-- Tabel akan diisi oleh JavaScript -->
    </div>

    <div class="container page-break">
        <table class="table table-no-border text-center">
            <thead>
                <tr>
                    <td style="width: 50%;">

                        <p><?php echo $dataPengaturan['ttd_3'] ?></p>
                        <br></br>

                        <p class="underlined-text"><b> <?php echo $dataPengaturan['nama_ttd_3'] ?></b></p>
                        <p>NIK. <?php echo $dataPengaturan['id_ttd_3'] ?>
                    </td>
                    <td style="width: 50%;">
                        <p><?php echo $dataPengaturan['ttd_2'] ?>
                            <br></br>

                        <p class="underlined-text"><b> <?php echo $dataPengaturan['nama_laboran'] ?></b></p>
                        <p>NIK. <?php echo $dataPengaturan['nik_laboran'] ?>
                    </td>
                </tr>
            </thead>
            <tbody>
                <!-- Isi tabel sesuai kebutuhan -->
            </tbody>
        </table>




        <table class="table table-no-border text-center">
            <thead>
                <tr>
                    <td style="width: 100%;">
                        <p>Mengetahui
                        <p><?php echo $dataPengaturan['ttd_4'] ?>
                            <br></br>

                        <p class="underlined-text"><b> <?php echo $dataPengaturan['nama_ttd_4'] ?></b>
                        <p>NIK. <?php echo $dataPengaturan['id_ttd_4'] ?></p>
                    </td>
                </tr>
            </thead>
            <tbody>
                <!-- Isi tabel sesuai kebutuhan -->
            </tbody>
        </table>
    </div>

    <script>
        // Ambil parameter bulan dan tahun dari URL
        const baseUrl = "<?php echo $base_url; ?>";
        const urlParams = new URLSearchParams(window.location.search);
        const bulan = urlParams.get('bulan');
        const tahun = urlParams.get('tahun');

        // Fetch data dari API dengan parameter bulan dan tahun
        fetch(`/api/data-stok?bulan=${bulan}&tahun=${tahun}`)
            .then(response => response.json())
            .then(data => {
                // Panggil fungsi untuk render data ke HTML
                renderDataStok(data);

                // Tunda eksekusi cetak untuk memastikan semua konten dimuat
                setTimeout(() => {
                    window.print();
                }, 2000);

            })
            .catch(error => console.error('Error fetching data:', error));

        function renderDataStok(data) {


            // Ambil elemen div untuk menampilkan data pengaturan
            const dataPengaturanDiv = document.getElementById('dataPengaturan');
            // Tampilkan gambar kop surat
            let pengaturanHTML = `
                <div class="text-center">
                                    <img src="${baseUrl}/assets/dist/img/${data.dataPengaturan.kop_surat}" alt="Kop Surat" width="450px">
                </div>
                  <h2>
            <center><b>L A P O R A N

            </h2>
            <h2>
                <center><b> REKAP MUTASI BARANG HABIS PAKAI LABORATORIUM KEPERAWATAN
                        <P> Bulan:  Tahun: 
                    </b></CENTER>
            </h2>

            <div class="gradient-line"></div>
            <br>
            `;
            const dataDiv = document.getElementById('dataStok');
            dataPengaturanDiv.innerHTML = pengaturanHTML;
            // Ambil elemen div untuk menampilkan data

            // Buat tabel untuk menampilkan data
            let table = '<table class="table  table-border">';
            table += '<thead><tr>';
            table += '<th>No</th>';
            table += '<th>Nama Barang</th>';
            table += '<th>Harga Satuan</th>';
            table += '<th>Sisa Stok</th>';
            table += '<th>Satuan</th>';
            table += '</tr></thead>';
            table += '<tbody>';

            // Iterasi melalui data barang dan tambahkan ke tabel
            data.barangList.forEach((item, index) => {
                table += '<tr>';
                table += `<td>${index + 1}</td>`; // Tambahkan 1 karena index dimulai dari 0
                table += `<td>${item.nama_barang}</td>`;
                table += `<td>${item.harga_satuan}</td>`;
                table += `<td>${item.sisa_stok}</td>`;
                table += `<td>${item.satuan}</td>`;
                table += '</tr>';
            });

            table += '</tbody></table>';

            // Set tabel ke div data
            dataDiv.innerHTML = table;
        }
    </script>
</body>

</html>