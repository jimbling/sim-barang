<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class BookingMiddleware implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Lakukan operasi sebelum aksi controller dipanggil
        $reservasibarangModel = new \App\Models\ReservasibarangModel();
        $dataBooking = $reservasibarangModel->hitungJumlahBooking();

        // Tambahkan data ke session
        session()->set('jumlah_booking', $dataBooking);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Lakukan operasi setelah aksi controller dipanggil
    }
}
