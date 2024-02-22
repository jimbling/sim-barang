<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter  implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Periksa apakah pengguna memiliki level Admin
        if ($session->get('level') !== 'Admin') {
            // Redirect atau lakukan tindakan lain sesuai kebijakan keamanan Anda
            return redirect()->to('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu melakukan sesuatu setelah request
    }
}
