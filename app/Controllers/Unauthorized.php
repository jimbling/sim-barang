<?php

namespace App\Controllers;

class Unauthorized extends BaseController
{
    public function index()
    {

        $currentYear = date('Y');

        $data = [
            'judul' => 'Bukan Hak Akses | Akper "YKY" Yogyakarta',
            'currentYear' => $currentYear,
        ];

        return view('unauthorized', $data);
    }
}
