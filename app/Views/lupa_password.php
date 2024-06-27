<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIM Barang YKY | Lupa Password</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/dist/css/adminlte.min.css?v=3.2.0">
    <link rel="stylesheet" href="../../assets/plugins/toastr/toastr.min.css">
    <link href="../../assets/dist/login/css/login.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        html,
        body {
            background-image: url('#'), url('../../assets/dist/login/img/back.png');
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">


        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Anda lupa password Anda? <br>Silahkan mengajukan reset password.</p>
                <form action="/sendResetLink" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Minta Password Baru</button>
                        </div>

                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="/"><b></b>Login SIM</b></a>
                </p>

            </div>

        </div>
    </div>


    <script src="../../assets/plugins/jquery/jquery.min.js"></script>
    <script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/dist/js/adminlte.min.js?v=3.2.0"></script>
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
</body>

</html>