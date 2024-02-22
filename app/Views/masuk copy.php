<!DOCTYPE html>
<html class="login-page">

<head>
  <meta charset="UTF-8">
  <title>SIM Barang - Laboratorium Keperawatan</title>
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <meta name="description" content="Sitem Informasi Manajemen (SIM) Pengelolaan dan Penggunaan Barang Laboratorium Keperawatan Akper YKY Yogyakarta, adalah SIM untuk mengelola data peminjaman, penerimaan, dan penggunaan barang laboratorium keperawatan">
  <meta name="keywords" content="sim, akper, yky, akper yky, kper yky yogyakarta, laboratorium, keperawatan, lab, lab keperawatan">
  <meta name="author" content="Akper YKY Yogyakarta">
  <!-- bootstrap 3.0.2 -->
  <link href="../../assets/dist/login/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <!-- font Awesome -->
  <link href="../../assets/dist/login/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
  <link href="../../assets/dist/login/css/style.css" rel="stylesheet" type="text/css" />
  <link href="../../assets/dist/login/css/app.css" rel="stylesheet" type="text/css" />
  <link href="../../assets/dist/login/css/login.css" rel="stylesheet" type="text/css" />
  <link href="../../assets/dist/login/css/style_menu.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


  <style type="text/css">
    html,
    body {
      background-image: url('#'), url('../../assets/dist/login/img/back.png');
    }
  </style>
</head>
<div class="flash-data" data-flashdata="<?= (session()->getFlashData('pesanMasuk')); ?>"></div><!-- Page Heading -->

<body>
  <div id="main_cont">
    <div class="form-box" id="login-box">
      <div class="header company-pattern">
        <img src="../../assets/dist/login/img/logo-yky.png" height="120"><br />
        Sistem Informasi Manajemen <p> <b>LABORATORIUM KEPERAWATAN</b> </p>
        <P>AKPER "YKY" YOGYAKARTA

      </div>


      <form method="post" action="auth/login">
        <div class="body bg-gray">
          <div class="form-group">
            <input type="text" name="user_nama" id="user_nama" class="form-control" placeholder="Username" />
          </div>
          <div class="form-group">
            <input type="password" name="user_password" class="form-control" placeholder="Password" />
          </div>
          <div class="form-group">
            <div class="checkbox" style="margin-left:20px">
              <label>
                <input type="checkbox" name="remember_me" value="1" /> Ingat saya
              </label>
            </div>
          </div>
        </div>
        <div class="footer">
          <button type="submit" class="btn btn-brand btn-block">Masuk Aplikasi</button>

        </div>
      </form>
    </div>
  </div>


  <!-- jQuery 2.0.2 -->
  <script src="../../assets/dist/login/js/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../../assets/dist/login/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="../../assets/dist/sweet/sweetalert2.all.min.js"></script>

  <!-- Script untuk menampilkan SweetAlert jika login gagal -->
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

</body>

</html>