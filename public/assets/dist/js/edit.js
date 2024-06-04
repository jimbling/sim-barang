
    // Fungsi yang dijalankan saat halaman diload
    window.addEventListener('load', function() {
        // Sembunyikan tombol Update dan Batal saat halaman diload
        document.getElementById('updateButton').style.display = 'none';
        document.getElementById('batalButton').style.display = 'none';
    });

    document.getElementById('editButton').addEventListener('click', function() {
        event.preventDefault(); // Menghentikan default behavior dari tombol submit
        // Hapus atribut readonly dari elemen input yang diinginkan
        document.getElementById('nama_kampus').removeAttribute('readonly');
        document.getElementById('website').removeAttribute('readonly');
        document.getElementById('alamat').removeAttribute('readonly');
        document.getElementById('no_telp').removeAttribute('readonly');
        document.getElementById('email').removeAttribute('readonly');
        document.getElementById('nama_bank').removeAttribute('readonly');
        document.getElementById('no_rekening').removeAttribute('readonly');
        document.getElementById('atas_nama').removeAttribute('readonly');
        document.getElementById('no_hp').removeAttribute('readonly');
        document.getElementById('nilai_kode_reservasi').removeAttribute('readonly');
        document.getElementById('nilai_kode_pinjam').removeAttribute('readonly');
        document.getElementById('nilai_kode_kembali').removeAttribute('readonly');

        document.getElementById('nama_direktur').removeAttribute('readonly');
        document.getElementById('ttd_1').removeAttribute('readonly');
        document.getElementById('nik_dir').removeAttribute('readonly');

        document.getElementById('ttd_4').removeAttribute('readonly');
        document.getElementById('nama_ttd_4').removeAttribute('readonly');
        document.getElementById('id_ttd_4').removeAttribute('readonly');

        document.getElementById('ttd_3').removeAttribute('readonly');
        document.getElementById('nama_ttd_3').removeAttribute('readonly');
        document.getElementById('id_ttd_3').removeAttribute('readonly');

        document.getElementById('ttd_2').removeAttribute('readonly');
        document.getElementById('nama_laboran').removeAttribute('readonly');
        document.getElementById('nik_laboran').removeAttribute('readonly');


        // (Tambahkan kode serupa untuk elemen input lainnya)

        // Tampilkan tombol Batal dan Update
        document.getElementById('batalButton').style.display = 'block';
        document.getElementById('updateButton').style.display = 'block';
        // Sembunyikan tombol Edit
        this.style.display = 'none';
    });

    document.getElementById('batalButton').addEventListener('click', function() {
        // Tambahkan atribut readonly ke elemen input yang diinginkan
        document.getElementById('nama_kampus').setAttribute('readonly', true);
        document.getElementById('website').setAttribute('readonly', true);
        document.getElementById('alamat').setAttribute('readonly', true);
        document.getElementById('no_telp').setAttribute('readonly', true);
        document.getElementById('email').setAttribute('readonly', true);
        document.getElementById('nama_bank').setAttribute('readonly', true);
        document.getElementById('no_rekening').setAttribute('readonly', true);
        document.getElementById('atas_nama').setAttribute('readonly', true);
        document.getElementById('no_hp').setAttribute('readonly', true);
        document.getElementById('nilai_kode_reservasi').setAttribute('readonly', true);
        document.getElementById('nilai_kode_pinjam').setAttribute('readonly', true);
        document.getElementById('nilai_kode_kembali').setAttribute('readonly', true);

        document.getElementById('nama_direktur').setAttribute('readonly', true);
        document.getElementById('ttd_1').setAttribute('readonly', true);
        document.getElementById('nik_dir').setAttribute('readonly', true);

        document.getElementById('ttd_4').setAttribute('readonly', true);
        document.getElementById('nama_ttd_4').setAttribute('readonly', true);
        document.getElementById('id_ttd_4').setAttribute('readonly', true);

        document.getElementById('ttd_3').setAttribute('readonly', true);
        document.getElementById('nama_ttd_3').setAttribute('readonly', true);
        document.getElementById('id_ttd_3').setAttribute('readonly', true);

        document.getElementById('ttd_2').setAttribute('readonly', true);
        document.getElementById('nama_laboran').setAttribute('readonly', true);
        document.getElementById('nik_laboran').setAttribute('readonly', true);


        // (Tambahkan kode serupa untuk elemen input lainnya)

        // Tampilkan tombol Edit
        document.getElementById('editButton').style.display = 'block';
        // Sembunyikan tombol Update dan Batal
        document.getElementById('updateButton').style.display = 'none';
        this.style.display = 'none';
    });

    document.getElementById('updateButton').addEventListener('click', function() {
        // Tambahkan atribut readonly ke elemen input yang diinginkan
        document.getElementById('nama_kampus').setAttribute('readonly', true);
        document.getElementById('website').setAttribute('readonly', true);
        document.getElementById('alamat').setAttribute('readonly', true);
        document.getElementById('no_telp').setAttribute('readonly', true);
        document.getElementById('email').setAttribute('readonly', true);
        document.getElementById('nama_bank').setAttribute('readonly', true);
        document.getElementById('no_rekening').setAttribute('readonly', true);
        document.getElementById('atas_nama').setAttribute('readonly', true);
        document.getElementById('no_hp').setAttribute('readonly', true);
        document.getElementById('nilai_kode_reservasi').setAttribute('readonly', true);
        document.getElementById('nilai_kode_pinjam').setAttribute('readonly', true);
        document.getElementById('nilai_kode_kembali').setAttribute('readonly', true);

        document.getElementById('nama_direktur').setAttribute('readonly', true);
        document.getElementById('ttd_1').setAttribute('readonly', true);
        document.getElementById('nik_dir').setAttribute('readonly', true);

        document.getElementById('ttd_4').setAttribute('readonly', true);
        document.getElementById('nama_ttd_4').setAttribute('readonly', true);
        document.getElementById('id_ttd_4').setAttribute('readonly', true);

        document.getElementById('ttd_3').setAttribute('readonly', true);
        document.getElementById('nama_ttd_3').setAttribute('readonly', true);
        document.getElementById('id_ttd_3').setAttribute('readonly', true);

        document.getElementById('ttd_2').setAttribute('readonly', true);
        document.getElementById('nama_laboran').setAttribute('readonly', true);
        document.getElementById('nik_laboran').setAttribute('readonly', true);


        // (Tambahkan kode serupa untuk elemen input lainnya)

        // Tampilkan tombol Edit
        document.getElementById('editButton').style.display = 'block';
        // Sembunyikan tombol Update dan Batal
        document.getElementById('updateButton').style.display = 'none';
        document.getElementById('batalButton').style.display = 'none';
    });



    document.getElementById('updateButton').addEventListener('click', function() {
        // Ambil data dari formulir
        var nama_kampus = document.getElementById('nama_kampus').value;
        var website = document.getElementById('website').value;
        var alamat = document.getElementById('alamat').value;
        var no_telp = document.getElementById('no_telp').value;
        var email = document.getElementById('email').value;
        var nama_bank = document.getElementById('nama_bank').value;
        var no_rekening = document.getElementById('no_rekening').value;
        var atas_nama = document.getElementById('atas_nama').value;
        var no_hp = document.getElementById('no_hp').value;
        var nilai_kode_reservasi = document.getElementById('nilai_kode_reservasi').value;
        var nilai_kode_pinjam = document.getElementById('nilai_kode_pinjam').value;
        var nilai_kode_kembali = document.getElementById('nilai_kode_kembali').value;

        var nama_direktur = document.getElementById('nama_direktur').value;
        var nik_dir = document.getElementById('nik_dir').value;
        var ttd_1 = document.getElementById('ttd_1').value;

        var ttd_2 = document.getElementById('ttd_2').value;
        var nama_laboran = document.getElementById('nama_laboran').value;
        var nik_laboran = document.getElementById('nik_laboran').value;

        var ttd_4 = document.getElementById('ttd_4').value;
        var nama_ttd_4 = document.getElementById('nama_ttd_4').value;
        var id_ttd_4 = document.getElementById('id_ttd_4').value;

        var ttd_3 = document.getElementById('ttd_3').value;
        var nama_ttd_3 = document.getElementById('nama_ttd_3').value;
        var id_ttd_3 = document.getElementById('id_ttd_3').value;






        // Buat objek data yang akan dikirimkan melalui AJAX
        var data = {
            nama_kampus: nama_kampus,
            website: website,
            alamat: alamat,
            no_telp: no_telp,
            email: email,
            nama_bank: nama_bank,
            no_rekening: no_rekening,
            atas_nama: atas_nama,
            no_hp: no_hp,
            nilai_kode_reservasi: nilai_kode_reservasi,
            nilai_kode_pinjam: nilai_kode_pinjam,
            nilai_kode_kembali: nilai_kode_kembali,

            nama_direktur: nama_direktur,
            nik_dir: nik_dir,
            ttd_1: ttd_1,

            nama_laboran: nama_laboran,
            ttd_2: ttd_2,
            nik_laboran: nik_laboran,

            ttd_4: ttd_4,
            nama_ttd_4: nama_ttd_4,
            id_ttd_4: id_ttd_4,

            ttd_3: ttd_3,
            nama_ttd_3: nama_ttd_3,
            id_ttd_3: id_ttd_3,
        };
        // Tampilkan loading sebelum mengirimkan data
        showLoadingProses();

        fetch(updateUrl, {
          method: 'POST',
          body: JSON.stringify(data),
          headers: {
              'Content-Type': 'application/json',
          }
      })
      .then(response => response.json())
      .then(data => {
          // Sembunyikan loading setelah mendapatkan respons dari server
          hideLoading();

          // Handle respons dari server jika diperlukan
          console.log('Respons dari server:', data);

          // Tampilkan SweetAlert sukses dengan timer 5000 milidetik (5 detik)
          Swal.fire({
              title: 'Berhasil!',
              text: 'Data berhasil dirubah.',
              icon: 'success',
              timer: 3000, // Durasi tampilan dalam milidetik (misalnya, 5000 milidetik = 5 detik)
              showConfirmButton: false, // Sembunyikan tombol OK (jika tidak diinginkan)
          }).then(() => {
              // Arahkan pengguna ke halaman baru setelah SweetAlert ditutup
              window.location.replace("/data/pengaturan");
          });
      })
      .catch(error => {
          // Sembunyikan loading jika terjadi kesalahan
          hideLoading();

          console.error('Error:', error);

          // Tampilkan SweetAlert sukses dengan jeda waktu 2000 milidetik (2 detik)
          setTimeout(function() {
              Swal.fire({
                  icon: 'success',
                  title: 'Sukses',
                  text: 'Data berhasil diperbarui',
              });
          }, 2000);
      });
    });

