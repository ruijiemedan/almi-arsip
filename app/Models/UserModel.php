<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'tbl_user';
    protected $primaryKey = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama_user', 'email', 'password', 'level', 'id_dep', 'foto', 'is_active'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_user' => 'required|min_length[3]',
        'email' => 'required|valid_email|is_unique[tbl_user.email,id_user,{id_user}]',
        'level' => 'required|in_list[1,2]',
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;

    public function getUser($id = false)
    {
        if ($id === false) {
            return $this->select('tbl_user.*, tbl_dep.nama_dep')
                        ->join('tbl_dep', 'tbl_dep.id_dep = tbl_user.id_dep', 'left')
                        ->findAll();
        }
        
        return $this->select('tbl_user.*, tbl_dep.nama_dep')
                    ->join('tbl_dep', 'tbl_dep.id_dep = tbl_user.id_dep', 'left')
                    ->where(['tbl_user.id_user' => $id])
                    ->first();
    }

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function countUser()
    {
        return $this->countAll();
    }

    public function countUserActive()
    {
        return $this->where('is_active', 1)->countAllResults();
    }
}
