<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\DepartemenModel;

class Profile extends BaseController
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
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $data = [
            'title' => 'Profile - E-Arsip',
            'user' => $this->userModel->getUser(session()->get('id_user')),
            'departemen' => $this->departemenModel->getDepartemen(),
            'validation' => \Config\Services::validation()
        ];

        return view('profile/index', $data);
    }

    public function update()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $id_user = session()->get('id_user');
        $user = $this->userModel->find($id_user);

        $rules = [
            'nama_user' => 'required|min_length[3]',
            'id_dep' => 'required'
        ];

        if ($this->request->getPost('email') != $user['email']) {
            $rules['email'] = 'required|valid_email|is_unique[tbl_user.email]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_user' => $this->request->getPost('nama_user'),
            'email' => $this->request->getPost('email'),
            'id_dep' => $this->request->getPost('id_dep')
        ];

        $this->userModel->update($id_user, $data);
        
        // Update session
        session()->set('nama_user', $data['nama_user']);
        session()->set('id_dep', $data['id_dep']);

        session()->setFlashdata('success', 'Profile berhasil diupdate!');
        return redirect()->to('/profile');
    }

    public function changePassword()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $rules = [
            'password_lama' => 'required',
            'password_baru' => 'required|min_length[4]',
            'konfirmasi_password' => 'required|matches[password_baru]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $id_user = session()->get('id_user');
        $user = $this->userModel->find($id_user);

        // Verify old password
        if (!password_verify($this->request->getPost('password_lama'), $user['password'])) {
            session()->setFlashdata('error', 'Password lama tidak sesuai!');
            return redirect()->back();
        }

        // Update password
        $data = [
            'password' => password_hash($this->request->getPost('password_baru'), PASSWORD_DEFAULT)
        ];

        $this->userModel->update($id_user, $data);
        session()->setFlashdata('success', 'Password berhasil diubah!');
        return redirect()->to('/profile');
    }
}
