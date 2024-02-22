<?php echo view('tema/header.php'); ?>
<style>
    .content-wrapper {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 80vh;
        /* Menggunakan tinggi 100% dari viewport height */
    }

    .text-center {
        position: relative;
        margin-bottom: 20px;
        /* Jarak antara gambar dan tombol */
    }

    .img-center {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-back-to-dashboard {
        position: absolute;
        top: 80%;
        /* Posisikan tombol di tengah tinggi gambar */
        left: 60%;
        /* Posisikan tombol di tengah lebar gambar */
        transform: translate(-50%, -50%);
        /* Pusatkan tombol tepat di tengah gambar */
        background-color: #dc3545;
        /* Warna merah yang sesuai dengan bg-danger */
        color: #fff;
        /* Warna teks putih */
        padding: 10px 20px;
        /* Padding pada tombol */
        text-decoration: none;
        /* Hilangkan garis bawah pada tautan */
        font-size: 16px;
        border-radius: 5px;
        /* Membuat sudut tombol agak melengkung */
        display: inline-block;
        /* Membuat tombol menjadi inline block */
    }
</style>
<div class="content-wrapper">
    <div class="text-center">
        <img src="../../assets/dist/img/ilustrasi/no_akses.svg" class="img-fluid img-center" width="700px" height="600px">
    </div>
    <a href="/dashboard" class="btn btn-back-to-dashboard">Kembali ke Dashboard</a>
</div>

<aside class="control-sidebar control-sidebar-dark">

    <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
    </div>
</aside>
<?php echo view('tema/footer.php'); ?>