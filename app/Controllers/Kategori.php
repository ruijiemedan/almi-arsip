<?php

namespace App\Controllers;

use App\Models\KategoriModel;

class Kategori extends BaseController
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
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
            'title' => 'Data Kategori',
            'kategori' => $this->kategoriModel->getKategori()
        ];

        return view('kategori/index', $data);
    }

    public function add()
    {
        // Cek login dan harus admin
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses!');
            return redirect()->to('/home');
        }

        $data = [
            'title' => 'Tambah Kategori',
            'validation' => \Config\Services::validation()
        ];

        return view('kategori/add', $data);
    }

    public function save()
    {
        // Cek login dan harus admin
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            return redirect()->to('/home');
        }

        // Validasi
        $rules = [
            'nama_kategori' => 'required|min_length[3]|is_unique[tbl_kategori.nama_kategori]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan data
        $data = [
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ];

        $this->kategoriModel->save($data);
        session()->setFlashdata('success', 'Data kategori berhasil ditambahkan!');
        return redirect()->to('/kategori');
    }

    public function edit($id)
    {
        // Cek login dan harus admin
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            return redirect()->to('/home');
        }

        $data = [
            'title' => 'Edit Kategori',
            'kategori' => $this->kategoriModel->getKategori($id),
            'validation' => \Config\Services::validation()
        ];

        return view('kategori/edit', $data);
    }

    public function update($id)
    {
        // Cek login dan harus admin
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            return redirect()->to('/home');
        }

        // Validasi
        $rules = [
            'nama_kategori' => 'required|min_length[3]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update data
        $data = [
            'nama_kategori' => $this->request->getPost('nama_kategori')
        ];

        $this->kategoriModel->update($id, $data);
        session()->setFlashdata('success', 'Data kategori berhasil diupdate!');
        return redirect()->to('/kategori');
    }

    public function delete($id)
    {
        // Cek login dan harus admin
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            return redirect()->to('/home');
        }

        $this->kategoriModel->delete($id);
        session()->setFlashdata('success', 'Data kategori berhasil dihapus!');
        return redirect()->to('/kategori');
    }
}
