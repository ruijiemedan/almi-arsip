<?php

namespace App\Models;

use CodeIgniter\Model;

class ArsipModel extends Model
{
    protected $table = 'tbl_arsip';
    protected $primaryKey = 'id_arsip';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'id_kategori', 'no_arsip', 'nama_file', 'deskripsi', 
        'tgl_upload', 'tgl_update', 'file_arsip', 'ukuran_file',
        'id_user', 'id_dep'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'id_kategori' => 'required|integer',
        'nama_file' => 'required|min_length[3]|max_length[255]',
        'id_user' => 'required|integer',
        'id_dep' => 'required|integer',
    ];

    protected $validationMessages = [
        'id_kategori' => [
            'required' => 'Kategori harus dipilih',
        ],
        'nama_file' => [
            'required' => 'Nama file harus diisi',
            'min_length' => 'Nama file minimal 3 karakter',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get arsip dengan join table lain
     */
    public function getArsip($id = false)
    {
        if ($id === false) {
            return $this->select('tbl_arsip.*, tbl_kategori.nama_kategori, tbl_user.nama_user, tbl_dep.nama_dep')
                        ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_arsip.id_kategori')
                        ->join('tbl_user', 'tbl_user.id_user = tbl_arsip.id_user')
                        ->join('tbl_dep', 'tbl_dep.id_dep = tbl_arsip.id_dep')
                        ->orderBy('tbl_arsip.id_arsip', 'DESC')
                        ->findAll();
        }
        
        return $this->select('tbl_arsip.*, tbl_kategori.nama_kategori, tbl_user.nama_user, tbl_dep.nama_dep')
                    ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_arsip.id_kategori')
                    ->join('tbl_user', 'tbl_user.id_user = tbl_arsip.id_user')
                    ->join('tbl_dep', 'tbl_dep.id_dep = tbl_arsip.id_dep')
                    ->where(['tbl_arsip.id_arsip' => $id])
                    ->first();
    }

    /**
     * Get arsip berdasarkan user
     */
    public function getArsipByUser($id_user)
    {
        return $this->select('tbl_arsip.*, tbl_kategori.nama_kategori, tbl_user.nama_user, tbl_dep.nama_dep')
                    ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_arsip.id_kategori')
                    ->join('tbl_user', 'tbl_user.id_user = tbl_arsip.id_user')
                    ->join('tbl_dep', 'tbl_dep.id_dep = tbl_arsip.id_dep')
                    ->where(['tbl_arsip.id_user' => $id_user])
                    ->orderBy('tbl_arsip.id_arsip', 'DESC')
                    ->findAll();
    }

    /**
     * Get arsip berdasarkan departemen
     */
    public function getArsipByDepartemen($id_dep)
    {
        return $this->select('tbl_arsip.*, tbl_kategori.nama_kategori, tbl_user.nama_user, tbl_dep.nama_dep')
                    ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_arsip.id_kategori')
                    ->join('tbl_user', 'tbl_user.id_user = tbl_arsip.id_user')
                    ->join('tbl_dep', 'tbl_dep.id_dep = tbl_arsip.id_dep')
                    ->where(['tbl_arsip.id_dep' => $id_dep])
                    ->orderBy('tbl_arsip.id_arsip', 'DESC')
                    ->findAll();
    }

    /**
     * Get arsip berdasarkan kategori
     */
    public function getArsipByKategori($id_kategori)
    {
        return $this->select('tbl_arsip.*, tbl_kategori.nama_kategori, tbl_user.nama_user, tbl_dep.nama_dep')
                    ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_arsip.id_kategori')
                    ->join('tbl_user', 'tbl_user.id_user = tbl_arsip.id_user')
                    ->join('tbl_dep', 'tbl_dep.id_dep = tbl_arsip.id_dep')
                    ->where(['tbl_arsip.id_kategori' => $id_kategori])
                    ->orderBy('tbl_arsip.id_arsip', 'DESC')
                    ->findAll();
    }

    /**
     * Search arsip
     */
    public function searchArsip($keyword)
    {
        return $this->select('tbl_arsip.*, tbl_kategori.nama_kategori, tbl_user.nama_user, tbl_dep.nama_dep')
                    ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_arsip.id_kategori')
                    ->join('tbl_user', 'tbl_user.id_user = tbl_arsip.id_user')
                    ->join('tbl_dep', 'tbl_dep.id_dep = tbl_arsip.id_dep')
                    ->like('tbl_arsip.nama_file', $keyword)
                    ->orLike('tbl_arsip.no_arsip', $keyword)
                    ->orLike('tbl_arsip.deskripsi', $keyword)
                    ->orderBy('tbl_arsip.id_arsip', 'DESC')
                    ->findAll();
    }

    /**
     * Count total arsip
     */
    public function countArsip()
    {
        return $this->countAll();
    }

    /**
     * Count arsip by user
     */
    public function countArsipByUser($id_user)
    {
        return $this->where('id_user', $id_user)->countAllResults();
    }

    /**
     * Generate nomor arsip unik
     */
    public function generateNoArsip()
    {
        $date = date('ymd');
        $random = strtoupper(substr(md5(uniqid(rand(), true)), 0, 4));
        $no_arsip = $date . '-' . $random;
        
        // Cek apakah no_arsip sudah ada
        while ($this->where('no_arsip', $no_arsip)->first()) {
            $random = strtoupper(substr(md5(uniqid(rand(), true)), 0, 4));
            $no_arsip = $date . '-' . $random;
        }
        
        return $no_arsip;
    }

    /**
     * Get arsip terbaru
     */
    public function getArsipTerbaru($limit = 5)
    {
        return $this->select('tbl_arsip.*, tbl_kategori.nama_kategori, tbl_user.nama_user, tbl_dep.nama_dep')
                    ->join('tbl_kategori', 'tbl_kategori.id_kategori = tbl_arsip.id_kategori')
                    ->join('tbl_user', 'tbl_user.id_user = tbl_arsip.id_user')
                    ->join('tbl_dep', 'tbl_dep.id_dep = tbl_arsip.id_dep')
                    ->orderBy('tbl_arsip.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get total ukuran file
     */
    public function getTotalUkuranFile()
    {
        $result = $this->selectSum('ukuran_file')->first();
        return $result['ukuran_file'] ?? 0;
    }
}
