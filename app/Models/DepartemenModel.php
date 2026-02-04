<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartemenModel extends Model
{
    protected $table = 'tbl_dep';
    protected $primaryKey = 'id_dep';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['nama_dep'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_dep' => 'required|min_length[3]|is_unique[tbl_dep.nama_dep,id_dep,{id_dep}]'
    ];

    public function getDepartemen($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }
        return $this->find($id);
    }

    public function countDepartemen()
    {
        return $this->countAll();
    }
}
