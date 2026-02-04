<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'tbl_kategori';
    protected $primaryKey = 'id_kategori';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['nama_kategori'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_kategori' => 'required|min_length[3]|is_unique[tbl_kategori.nama_kategori,id_kategori,{id_kategori}]'
    ];

    public function getKategori($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }
        return $this->find($id);
    }

    public function countKategori()
    {
        return $this->countAll();
    }
}
