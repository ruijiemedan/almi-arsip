<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table = 'tbl_log';
    protected $primaryKey = 'id_log';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['id_user', 'aktivitas', 'deskripsi', 'ip_address'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = '';

    public function getLogs($limit = 100)
    {
        return $this->select('tbl_log.*, tbl_user.nama_user, tbl_user.email')
                    ->join('tbl_user', 'tbl_user.id_user = tbl_log.id_user')
                    ->orderBy('tbl_log.id_log', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function addLog($id_user, $aktivitas, $deskripsi = null)
    {
        $data = [
            'id_user' => $id_user,
            'aktivitas' => $aktivitas,
            'deskripsi' => $deskripsi,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
        ];
        return $this->insert($data);
    }

    public function countLogToday()
    {
        return $this->where('DATE(created_at)', date('Y-m-d'))->countAllResults();
    }
}
