<?php echo view('tema/header.php'); ?>
<div class="content-wrapper">
    <div class="container-fluid">
        <form action="<?= base_url('pesan/kirim') ?>" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">NO Tujuan</label>
                <input type="number" class="form-control" id="exampleInputEmail1" name="tujuan" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Pesan</label>
                <input type="text" class="form-control" id="exampleInputPassword1" name="message">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<?php echo view('tema/footer.php'); ?>