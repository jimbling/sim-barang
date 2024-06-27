

    window.addEventListener('load', function() {

      document.getElementById('updateButton').style.display = 'none';
      document.getElementById('batalButton').style.display = 'none';
  });

  document.getElementById('editButton').addEventListener('click', function() {
      event.preventDefault();

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



      document.getElementById('batalButton').style.display = 'block';
      document.getElementById('updateButton').style.display = 'block';

      this.style.display = 'none';
  });

  document.getElementById('batalButton').addEventListener('click', function() {

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



      document.getElementById('editButton').style.display = 'block';

      document.getElementById('updateButton').style.display = 'none';
      this.style.display = 'none';
  });

  document.getElementById('updateButton').addEventListener('click', function() {

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



      document.getElementById('editButton').style.display = 'block';

      document.getElementById('updateButton').style.display = 'none';
      document.getElementById('batalButton').style.display = 'none';
  });



  document.getElementById('updateButton').addEventListener('click', function() {

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

        hideLoading();


        console.log('Respons dari server:', data);


        Swal.fire({
            title: 'Berhasil!',
            text: 'Data berhasil dirubah.',
            icon: 'success',
            timer: 3000,
            showConfirmButton: false,
        }).then(() => {

            window.location.replace("/data/pengaturan");
        });
    })
    .catch(error => {

        hideLoading();

        console.error('Error:', error);


        setTimeout(function() {
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: 'Data berhasil diperbarui',
            });
        }, 2000);
    });
  });

  // KOP SURAT
 function showPreviewImage(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function(e) {
              $('#previewImage').attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
      }


      var fileName = input.files[0].name;
      $('#selectedFileName').text(fileName);
  }


  $('#customFile').change(function() {
      showPreviewImage(this);
  });

  const customFileInput = document.querySelector("#customFile");
  const previewImage = document.querySelector("#previewImage");

  customFileInput.addEventListener("change", function() {
      if (this.files.length > 0) {
          previewImage.style.display = "block";
      } else {
          previewImage.style.display = "none";
      }
  });





  function showLoading() {
      let timerInterval
      Swal.fire({
          title: 'Memproses upload...',
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

  document.addEventListener("DOMContentLoaded", function() {
      const fileInput = document.querySelector("input[name='kop_surat']");
      const submitButton = document.querySelector("button[type='submit']");
      const selectedFileName = document.querySelector("#selectedFileName");
      const previewImage = document.querySelector("#previewImage");

      fileInput.addEventListener("change", function() {
          const allowedExtensions = ['jpg', 'jpeg', 'png', 'svg'];
          const fileName = this.files[0].name;
          const fileExtension = fileName.split('.').pop().toLowerCase();

          if (allowedExtensions.includes(fileExtension)) {
              selectedFileName.textContent = fileName;
              previewImage.style.display = "block";
              previewImage.src = URL.createObjectURL(this.files[0]);
              submitButton.disabled = false;
          } else {
              Swal.fire({
                  icon: "error",
                  title: "Jenis File Tidak Diijinkan!",
                  text: "Anda hanya dapat mengimpor file dengan ekstensi .jpg, .jpeg, .png, atau .svg."
              });
              this.value = '';
              selectedFileName.textContent = "Pilih File Foto";
              previewImage.style.display = "none";
              submitButton.disabled = true;
          }
      });


      submitButton.addEventListener("click", function(event) {
          event.preventDefault();
          if (!fileInput.files || !fileInput.files.length) {
              return;
          }
          const fileName = fileInput.files[0].name;
          const allowedExtensions = ['jpg', 'jpeg', 'png', 'svg'];
          const fileExtension = fileName.split('.').pop().toLowerCase();

          if (allowedExtensions.includes(fileExtension)) {
              showLoading();
              setTimeout(function() {
                  submitButton.form.submit();
              }, 2000);
          }
      });
  });
// END KOP SURAT

// UPLOAD LOGO

     function showPreviewLogo(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function(e) {
              $('#previewLogo').attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
      }


      var fileName = input.files[0].name;
      $('#selectedFileLogo').text(fileName);
  }


  $('#customFile').change(function() {
      showPreviewImage(this);
  });

  const customFileLogo = document.querySelector("#customFile");
  const previewLogo = document.querySelector("#previewLogo");

  customFileInput.addEventListener("change", function() {
      if (this.files.length > 0) {
          previewImage.style.display = "block";
      } else {
          previewImage.style.display = "none";
      }
  });


  function showLoading() {
      let timerInterval
      Swal.fire({
          title: 'Memproses upload...',
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

  document.addEventListener("DOMContentLoaded", function() {
      const fileInput = document.querySelector("input[name='logo']");
      const submitButton = document.querySelector("button[type='submit']");
      const selectedFileLogo = document.querySelector("#selectedFileLogo");
      const previewImage = document.querySelector("#previewLogo");

      fileInput.addEventListener("change", function() {
          const allowedExtensions = ['jpg', 'jpeg', 'png', 'svg'];
          const fileName = this.files[0].name;
          const fileExtension = fileName.split('.').pop().toLowerCase();

          if (allowedExtensions.includes(fileExtension)) {
              selectedFileLogo.textContent = fileName;
              previewImage.style.display = "block";
              previewImage.src = URL.createObjectURL(this.files[0]);
              submitButton.disabled = false;
          } else {
              Swal.fire({
                  icon: "error",
                  title: "Jenis File Tidak Diijinkan!",
                  text: "Anda hanya dapat mengimpor file dengan ekstensi .jpg, .jpeg, .png, atau .svg."
              });
              this.value = '';
              selectedFileLogo.textContent = "Pilih File Foto";
              previewImage.style.display = "none";
              submitButton.disabled = true;
          }
      });


      submitButton.addEventListener("click", function(event) {
          event.preventDefault();
          if (!fileInput.files || !fileInput.files.length) {
              return;
          }
          const fileName = fileInput.files[0].name;
          const allowedExtensions = ['jpg', 'jpeg', 'png', 'svg'];
          const fileExtension = fileName.split('.').pop().toLowerCase();

          if (allowedExtensions.includes(fileExtension)) {
              showLoading();

              setTimeout(function() {
                  submitButton.form.submit();
              }, 2000);
          }
      });
  });

// END UPLOAD LOGO

// UPLOAD FAVICON


  function showPreviewLogo(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function(e) {
              $('#previewFavicon').attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
      }


      var fileName = input.files[0].name;
      $('#selectedFileFavicon').text(fileName);
  }


  $('#customFile').change(function() {
      showPreviewImage(this);
  });

  const customFileFavicon = document.querySelector("#customFile");
  const previewFavicon = document.querySelector("#previewFavicon");

  customFileInput.addEventListener("change", function() {
      if (this.files.length > 0) {
          previewImage.style.display = "block";
      } else {
          previewImage.style.display = "none";
      }
  });


  function showLoading() {
      let timerInterval
      Swal.fire({
          title: 'Memproses upload...',
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

  document.addEventListener("DOMContentLoaded", function() {
      const fileInput = document.querySelector("input[name='favicon']");
      const submitButton = document.querySelector("button[type='submit']");
      const selectedFileFavicon = document.querySelector("#selectedFileFavicon");
      const previewImage = document.querySelector("#previewFavicon");

      fileInput.addEventListener("change", function() {
          const allowedExtensions = ['ico'];
          const fileName = this.files[0].name;
          const fileExtension = fileName.split('.').pop().toLowerCase();

          if (allowedExtensions.includes(fileExtension)) {
              selectedFileFavicon.textContent = fileName;
              previewImage.style.display = "block";
              previewImage.src = URL.createObjectURL(this.files[0]);
              submitButton.disabled = false;
          } else {
              Swal.fire({
                  icon: "error",
                  title: "Jenis File Tidak Diijinkan!",
                  text: "Anda hanya dapat mengimpor file dengan ekstensi .ico"
              });
              this.value = '';
              selectedFileFavicon.textContent = "Pilih File Favicon";
              previewImage.style.display = "none";
              submitButton.disabled = true;
          }
      });


      submitButton.addEventListener("click", function(event) {
          event.preventDefault();
          if (!fileInput.files || !fileInput.files.length) {
              return;
          }
          const fileName = fileInput.files[0].name;
          const allowedExtensions = ['ico'];
          const fileExtension = fileName.split('.').pop().toLowerCase();

          if (allowedExtensions.includes(fileExtension)) {
              showLoading();
              setTimeout(function() {
                  submitButton.form.submit();
              }, 2000);
          }
      });
  });

// END UPLOAD FAVICON

// UPLOAD LOGO BAN


  function showPreviewBank(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function(e) {
              $('#previewBank').attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
      }


      var fileName = input.files[0].name;
      $('#selectedFileBank').text(fileName);
  }


  $('#customFile').change(function() {
      showPreviewImage(this);
  });

  const customFileBank = document.querySelector("#customFile");
  const previewBank = document.querySelector("#previewBank");

  customFileInput.addEventListener("change", function() {
      if (this.files.length > 0) {
          previewImage.style.display = "block";
      } else {
          previewImage.style.display = "none";
      }
  });


  function showLoading() {
      let timerInterval
      Swal.fire({
          title: 'Memproses upload...',
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

  document.addEventListener("DOMContentLoaded", function() {
      const fileInput = document.querySelector("input[name='logo_bank']");
      const submitButton = document.querySelector("button[type='submit']");
      const selectedFileBank = document.querySelector("#selectedFileBank");
      const previewImage = document.querySelector("#previewBank");

      fileInput.addEventListener("change", function() {
          const allowedExtensions = ['jpg', 'jpeg', 'png', 'svg'];
          const fileName = this.files[0].name;
          const fileExtension = fileName.split('.').pop().toLowerCase();

          if (allowedExtensions.includes(fileExtension)) {
              selectedFileBank.textContent = fileName;
              previewImage.style.display = "block";
              previewImage.src = URL.createObjectURL(this.files[0]);
              submitButton.disabled = false;
          } else {
              Swal.fire({
                  icon: "error",
                  title: "Jenis File Tidak Diijinkan!",
                  text: "Anda hanya dapat mengimpor file dengan ekstensi .jpg, .jpeg, .png, atau .svg."
              });
              this.value = '';
              selectedFileBank.textContent = "Pilih Logo Bank";
              previewImage.style.display = "none";
              submitButton.disabled = true;
          }
      });


      submitButton.addEventListener("click", function(event) {
          event.preventDefault();
          if (!fileInput.files || !fileInput.files.length) {
              return;
          }
          const fileName = fileInput.files[0].name;
          const allowedExtensions = ['jpg', 'jpeg', 'png', 'svg'];
          const fileExtension = fileName.split('.').pop().toLowerCase();

          if (allowedExtensions.includes(fileExtension)) {
              showLoading();

              setTimeout(function() {
                  submitButton.form.submit();
              }, 2000);
          }
      });
  });

// END UPLOAD LOGO BANK



