//Bootstrap Duallistbox
$('.duallistbox').bootstrapDualListbox();

$(function() {
    $('[data-toggle="tooltip"]').tooltip();
});

$(function() {
    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });
});

$(function() {
    // Summernote
    $('#summernote').summernote({
        tabsize: 2,
        height: 600
    });
});

$(document).ready(function() {
    $('.nav-items').click(function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin keluar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            backdrop: 'static',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/auth/keluar';
            }
        });
    });
});
