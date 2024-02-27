<?php

namespace App\Models;

use CodeIgniter\Model;

class AngkakembaliModel extends Model
{
    protected $table = 'tbl_angka_kembali';
    protected $primaryKey = 'id_angka';
    protected $allowedFields = ['id_angka'];


    public function getLastIdFromAngka()
    {
        $query = $this->db->query("SELECT id_angka FROM tbl_angka_kembali ORDER BY id_angka DESC LIMIT 1");
        $row = $query->getRow();

        if ($row) {
            return $row->id_angka;
        }

        return 0; // Jika tabel kosong
    }
}
