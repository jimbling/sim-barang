<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SIM Barang - Laboratorium Keperawatan</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <meta name="description" content="Sitem Informasi Manajemen (SIM) Pengelolaan dan Penggunaan Barang Laboratorium Keperawatan Akper YKY Yogyakarta, adalah SIM untuk mengelola data peminjaman, penerimaan, dan penggunaan barang laboratorium keperawatan">
  <meta name="keywords" content="sim, akper, yky, akper yky, kper yky yogyakarta, laboratorium, keperawatan, lab, lab keperawatan">
  <meta name="author" content="Akper YKY Yogyakarta">
  <!-- Google Font: Source Sans Pro -->
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../assets/dist/css/adminlte.min.css?v=3.2.0">
  <link href="../../assets/dist/login/css/login.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="../../assets/plugins/toastr/toastr.min.css">

  <!-- SweetAlert2 -->
  <style type="text/css">
    html,
    body {
      background-image: url('#'), url('../../assets/dist/login/img/back.png');
    }
  </style>
</head>
<?php

use App\Services\PengaturanService;

$pengaturanService = new PengaturanService();

// Mendapatkan nama kampus dan website
$data_pengaturan = $pengaturanService->getNamaKampus();
$nama_kampus = $data_pengaturan['nama_kampus'];
$logo = $data_pengaturan['logo'];

?>

<body>
  <div class="preloader flex-column justify-content-center align-items-center" style="display:none;">
    <div class="spinner-border" role="status"></div>
    <img class="logo" src="../../assets/dist/img/<?= $logo; ?>" alt="<?= $nama_kampus; ?> Logo" height="60" width="60">
  </div>
  <div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanMasuk')); ?>"></div><!-- Page Heading -->

  <body class="hold-transition login-page">
    <div class="login-box">


      <div class="card card-widget widget-user">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-info">

          <h6 class="widget-user-username" src="../../assets/img/logo.png">Sistem Informasi Manajemen</h6>
          <h6 class="widget-user-desc">LABORATORIUM KEPERAWATAN
          </h6>
          <h5 class="widget-user-desc"><?= $nama_kampus; ?>
          </h5>

        </div>
        <div class="widget-user-image">
          <img class="img-circle elevation-4" src="../../assets/dist/img/<?= $logo; ?>" alt="<?= $nama_kampus; ?>">
        </div>
        <div class="card-footer">
          <form method="post" action="auth/login" id="loginForm">
            <label class="form-label">Username</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Masukkan Username" name="user_nama" id="user_nama">
            </div>

            <div class="mb-3">
              <label class="form-label">Password</label>
              <div class="input-group mb-3">
                <input class="form-control" id="user_password" placeholder="Masukkan Kata Sandi" type="password" name="user_password" autocomplete="current-password">
              </div>
            </div>

            <button id="loginButton" type="submit" class="btn bg-lightblue btn-block">
              <span id="buttonText">Masuk</span>
              <span id="spinner" class="loader" style="display:none;"></span>
            </button>
          </form>
          <p class="mt-3 mb-1">
            <a href="/lupa-password"><b></b>Lupa Password</b></a>
          </p>
        </div>

      </div>


    </div>
  </body>
  <script src="../../assets/dist/js/jquery-3.6.4.min.js"></script>

  <script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
      var loginButton = document.getElementById('loginButton');
      var spinner = document.getElementById('spinner');
      var buttonText = document.getElementById('buttonText');

      // Menampilkan spinner dan menyembunyikan teks tombol
      spinner.style.display = 'inline-block';
      buttonText.style.display = 'none';

      // Menonaktifkan tombol agar tidak bisa diklik lagi selama proses loading
      loginButton.disabled = false;
    });
  </script>

  <script>
    $(document).ready(function() {
      // Ambil data flashdata
      var flashdata = $('.flash-data').data('flashdata');

      // Tampilkan SweetAlert jika ada flashdata
      if (flashdata) {
        Swal.fire({
          icon: 'error',
          title: 'Login Gagal!',
          text: flashdata,
        });
      }
    });
  </script>

  <script>
    $(document).ready(function() {
      $('#togglePassword').on('click', function() {
        var passwordInput = $('#user_password');
        var passwordFieldType = passwordInput.attr('type');

        if (passwordFieldType === 'password') {
          passwordInput.attr('type', 'text');
          $('#togglePassword').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
          passwordInput.attr('type', 'password');
          $('#togglePassword').removeClass('fa-eye-slash').addClass('fa-eye');
        }
      });
    });
  </script>
  <!-- Main Footer -->



  <!-- jQuery -->
  <script src="../../assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../assets/dist/js/adminlte.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="../../assets/dist/sweet/sweetalert2.all.min.js"></script>
  <script src="../../assets/dist/sweet/myscript.js"></script>
  <script src="../../assets/plugins/toastr/toastr.min.js"></script>

  <script>
    $(document).ready(function() {
      <?php if (session()->getFlashdata('success')) : ?>
        toastr.success('<?= session()->getFlashdata('success') ?>');
      <?php endif; ?>

      <?php if (session()->getFlashdata('error')) : ?>
        toastr.error('<?= session()->getFlashdata('error') ?>');
      <?php endif; ?>
    });
  </script>


</html>