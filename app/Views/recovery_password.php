<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIM Barang YKY | Reset Password</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/dist/css/adminlte.min.css?v=3.2.0">
    <link rel="stylesheet" href="../../assets/plugins/toastr/toastr.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>Reset Password</b></a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>
                <form action="/lupa-password/atur-ulang" method="post">
                    <input type="hidden" name="token" value="<?= $token ?>">
                    <div class="input-group mb-3">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Simpan Password</button>
                        </div>

                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="login.html">Login</a>
                </p>
            </div>

        </div>
    </div>


    <script src="../../assets/plugins/jquery/jquery.min.js"></script>
    <script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/dist/js/adminlte.min.js?v=3.2.0"></script>
    <script src="../../assets/plugins/toastr/toastr.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (session()->getFlashdata('errors')) : ?>
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    toastr.error('<?= $error ?>');
                <?php endforeach; ?>
            <?php endif; ?>

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