<?php

namespace App\Controllers;

use App\Models\DepartemenModel;

class Departemen extends BaseController
{
    protected $departemenModel;

    public function __construct()
    {
        $this->departemenModel = new DepartemenModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        // Cek login dan harus admin
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses!');
            return redirect()->to('/home');
        }

        $data = [
            'title' => 'Data Departemen',
            'departemen' => $this->departemenModel->getDepartemen()
        ];

        return view('departemen/index', $data);
    }

    public function add()
    {
        // Cek login dan harus admin
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            return redirect()->to('/home');
        }

        $data = [
            'title' => 'Tambah Departemen',
            'validation' => \Config\Services::validation()
        ];

        return view('departemen/add', $data);
    }

    public function save()
    {
        // Cek login dan harus admin
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            return redirect()->to('/home');
        }

        // Validasi
        $rules = [
            'nama_dep' => 'required|min_length[3]|is_unique[tbl_dep.nama_dep]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan data
        $data = [
            'nama_dep' => $this->request->getPost('nama_dep')
        ];

        $this->departemenModel->save($data);
        session()->setFlashdata('success', 'Data departemen berhasil ditambahkan!');
        return redirect()->to('/departemen');
    }

    public function edit($id)
    {
        // Cek login dan harus admin
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            return redirect()->to('/home');
        }

        $data = [
            'title' => 'Edit Departemen',
            'departemen' => $this->departemenModel->getDepartemen($id),
            'validation' => \Config\Services::validation()
        ];

        return view('departemen/edit', $data);
    }

    public function update($id)
    {
        // Cek login dan harus admin
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            return redirect()->to('/home');
        }

        // Validasi
        $rules = [
            'nama_dep' => 'required|min_length[3]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update data
        $data = [
            'nama_dep' => $this->request->getPost('nama_dep')
        ];

        $this->departemenModel->update($id, $data);
        session()->setFlashdata('success', 'Data departemen berhasil diupdate!');
        return redirect()->to('/departemen');
    }

    public function delete($id)
    {
        // Cek login dan harus admin
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            return redirect()->to('/home');
        }

        $this->departemenModel->delete($id);
        session()->setFlashdata('success', 'Data departemen berhasil dihapus!');
        return redirect()->to('/departemen');
    }
}
