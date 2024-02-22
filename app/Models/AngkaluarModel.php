<?php

namespace App\Models;

use CodeIgniter\Model;

class AngkaluarModel extends Model
{
    protected $table = 'tbl_angka_pihakluar';
    protected $primaryKey = 'id_angka';
    protected $allowedFields = ['id_angka'];


    public function getLastIdFromAngka()
    {
        $query = $this->db->query("SELECT id_angka FROM tbl_angka_pihakluar ORDER BY id_angka DESC LIMIT 1");
        $row = $query->getRow();

        if ($row) {
            return $row->id_angka;
        }

        return 0; // Jika tabel kosong
    }
}
