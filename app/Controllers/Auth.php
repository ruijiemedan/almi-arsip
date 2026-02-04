<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\LogModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $logModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->logModel = new LogModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        // Jika sudah login, redirect ke home
        if (session()->get('logged_in')) {
            return redirect()->to('/home');
        }

        $data = [
            'title' => 'Login - E-Arsip Kantor',
            'validation' => \Config\Services::validation()
        ];

        return view('auth/login', $data);
    }

    public function login()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[4]'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Email dan Password wajib diisi dengan benar!');
            return redirect()->back()->withInput();
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->getUserByEmail($email);

        if ($user) {
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Set session
                $sessionData = [
                    'id_user' => $user['id_user'],
                    'nama_user' => $user['nama_user'],
                    'email' => $user['email'],
                    'level' => $user['level'],
                    'id_dep' => $user['id_dep'],
                    'logged_in' => true
                ];
                session()->set($sessionData);

                // Log aktivitas
                $this->logModel->addLog($user['id_user'], 'Login', 'Login ke sistem');

                session()->setFlashdata('success', 'Login berhasil! Selamat datang ' . $user['nama_user']);
                return redirect()->to('/home');
            } else {
                session()->setFlashdata('error', 'Password salah!');
                return redirect()->back()->withInput();
            }
        } else {
            session()->setFlashdata('error', 'Email tidak ditemukan!');
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('success', 'Anda telah logout!');
        return redirect()->to('/auth');
    }
}
