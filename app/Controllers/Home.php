<?php

namespace App\Controllers;

use App\Models\ArsipModel;
use App\Models\KategoriModel;
use App\Models\DepartemenModel;
use App\Models\UserModel;

class Home extends BaseController
{
    protected $arsipModel;
    protected $kategoriModel;
    protected $departemenModel;
    protected $userModel;

    public function __construct()
    {
        $this->arsipModel = new ArsipModel();
        $this->kategoriModel = new KategoriModel();
        $this->departemenModel = new DepartemenModel();
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $data = [
            'title' => 'Dashboard - E-Arsip',
            'total_arsip' => $this->arsipModel->countArsip(),
            'total_kategori' => $this->kategoriModel->countKategori(),
            'total_departemen' => $this->departemenModel->countDepartemen(),
            'total_user' => $this->userModel->countUser(),
        ];

        return view('home/index', $data);
    }
}
