<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    function get_data_login($table, $where)
    {
        $builder = $this->db->table($table);
        $builder->where($where);
        return $builder->get()->getResult();
    }
}
