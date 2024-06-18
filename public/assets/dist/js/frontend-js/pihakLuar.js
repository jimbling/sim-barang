        $('.duallistbox').bootstrapDualListbox()

        $(function() {

            $('#tanggalPinjam').datetimepicker({
                format: 'L'
            });
            $('#tanggalKembali').datetimepicker({
                format: 'L'
            });

        })

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

        document.addEventListener("DOMContentLoaded", function() {
          const fileInput = document.querySelector("input[name='surat_permohonan_alat']");
          const submitButton = document.querySelector("button[type='submit']");
          const selectedFileName = document.querySelector("#selectedFileName");
          const previewImage = document.querySelector("#previewImage");

          // Pengecekan elemen sebelum menggunakan
          if (fileInput) {
              fileInput.addEventListener("change", function() {
                  const allowedExtensions = ['pdf', 'jpg', 'png', 'jpeg'];
                  const maxSize = 5 * 1024 * 1024; // 5MB
                  const file = this.files[0];
                  const fileName = file.name;
                  const fileSize = file.size;
                  const fileExtension = fileName.split('.').pop().toLowerCase();

                  if (allowedExtensions.includes(fileExtension) && fileSize <= maxSize) {
                      selectedFileName.textContent = fileName;
                      previewImage.style.display = "block";
                      previewImage.src = URL.createObjectURL(this.files[0]);
                      submitButton.disabled = false;
                  } else {
                      Swal.fire({
                          icon: "error",
                          title: "Jenis File atau Ukuran Tidak Diijinkan!",
                          text: "Anda hanya dapat mengimpor file dengan ekstensi .pdf, .jpg, .png, .jpeg dan ukuran maksimum 5MB"
                      });
                      this.value = '';
                      selectedFileName.textContent = "Pilih File Surat Permohonan Alat (.pdf, .jpg, .png, .jpeg)";
                      previewImage.style.display = "none";
                      submitButton.disabled = true;
                  }
              });
          } else {
              console.warn("Element input[name='surat_permohonan_alat'] tidak ditemukan di halaman.");
          }
      });


        function submitForm() {

            var form = document.getElementById('tambahPinjamPihakLuar');
            if (!form.checkValidity()) {

                hideLoading();
                Swal.fire({
                    icon: 'error',
                    title: 'Mohon lengkapi formulir dengan benar!',
                    showConfirmButton: false,
                    timer: 1500
                });
                return;
            }


            showLoading();
            setTimeout(() => {

                hideLoading();
                Swal.fire({
                    icon: 'success',
                    title: 'Peminjaman berhasil diajukan!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }, 2000);
        }
