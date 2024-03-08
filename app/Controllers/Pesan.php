<?php

namespace App\Controllers;

use App\Helpers\ServiceInjector;

use App\Controllers\BaseController;

class Pesan extends BaseController
{
    protected $settingsService;

    public function __construct()
    {

        $this->settingsService = ServiceInjector::getSettingsService(); // Menggunakan ServiceInjector
    }


    public function index()
    {
        session();
        $csrfToken = csrf_hash();
        $currentYear = date('Y');
        $namaKampus = $this->settingsService->getNamaKampus();

        $data = [
            'judul' => "Form Pengembalian | $namaKampus",
            'currentYear' => $currentYear,
            'csrfToken' => $csrfToken,  // Sertakan token CSRF dalam data

        ];

        return view('pesan', $data);
    }

    public function send()
    {
        $session = session();

        $tujuan = $this->request->getPost('tujuan');
        $message = urlencode($this->request->getPost('message'));

        // Use curl to send an HTTP POST request
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://localhost:5000/msg",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "number=" . $tujuan . "&message=" . $message,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            // If there's an error in the curl request
            $session->setFlashdata('message', 'Gagal kirim pesan: ' . $err);
        } else {
            // If successful
            $session->setFlashdata('message', 'Berhasil kirim pesan');
            // Dump the response
            var_dump($response);
        }

        // Redirect to the dashboard page
        return redirect()->to('/dashboard');
    }
}
