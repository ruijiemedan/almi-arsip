<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\DepartemenModel;

class User extends BaseController
{
    protected $userModel;
    protected $departemenModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
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
            'title' => 'Data User',
            'users' => $this->userModel->getUser()
        ];

        return view('user/index', $data);
    }

    public function add()
    {
        // Cek login dan harus admin
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            return redirect()->to('/home');
        }

        $data = [
            'title' => 'Tambah User',
            'departemen' => $this->departemenModel->getDepartemen(),
            'validation' => \Config\Services::validation()
        ];

        return view('user/add', $data);
    }

    public function save()
    {
        // Cek login dan harus admin
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            return redirect()->to('/home');
        }

        // Validasi
        $rules = [
            'nama_user' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[tbl_user.email]',
            'password' => 'required|min_length[4]',
            'level' => 'required|in_list[1,2]',
            'id_dep' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan data
        $data = [
            'nama_user' => $this->request->getPost('nama_user'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'level' => $this->request->getPost('level'),
            'id_dep' => $this->request->getPost('id_dep')
        ];

        $this->userModel->save($data);
        session()->setFlashdata('success', 'Data user berhasil ditambahkan!');
        return redirect()->to('/user');
    }

    public function edit($id)
    {
        // Cek login dan harus admin
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            return redirect()->to('/home');
        }

        $data = [
            'title' => 'Edit User',
            'user' => $this->userModel->getUser($id),
            'departemen' => $this->departemenModel->getDepartemen(),
            'validation' => \Config\Services::validation()
        ];

        return view('user/edit', $data);
    }

    public function update($id)
    {
        // Cek login dan harus admin
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            return redirect()->to('/home');
        }

        $user = $this->userModel->getUser($id);

        // Validasi
        $rules = [
            'nama_user' => 'required|min_length[3]',
            'level' => 'required|in_list[1,2]',
            'id_dep' => 'required'
        ];

        // Cek jika email diubah
        if ($this->request->getPost('email') != $user['email']) {
            $rules['email'] = 'required|valid_email|is_unique[tbl_user.email]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update data
        $data = [
            'nama_user' => $this->request->getPost('nama_user'),
            'email' => $this->request->getPost('email'),
            'level' => $this->request->getPost('level'),
            'id_dep' => $this->request->getPost('id_dep')
        ];

        // Jika password diisi, update password
        if ($this->request->getPost('password') != '') {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);
        session()->setFlashdata('success', 'Data user berhasil diupdate!');
        return redirect()->to('/user');
    }

    public function delete($id)
    {
        // Cek login dan harus admin
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            return redirect()->to('/home');
        }

        // Tidak bisa hapus diri sendiri
        if ($id == session()->get('id_user')) {
            session()->setFlashdata('error', 'Anda tidak bisa menghapus akun sendiri!');
            return redirect()->to('/user');
        }

        $this->userModel->delete($id);
        session()->setFlashdata('success', 'Data user berhasil dihapus!');
        return redirect()->to('/user');
    }
}
