<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class UserFIlter  implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Periksa apakah pengguna memiliki level Admin atau User
        $userLevel = $session->get('level');
        if ($userLevel !== 'Admin' && $userLevel !== 'User') {
            // Redirect atau lakukan tindakan lain sesuai kebijakan keamanan Anda
            return redirect()->to('/');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu melakukan sesuatu setelah request
    }
}
