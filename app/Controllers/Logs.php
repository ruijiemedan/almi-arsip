<?php

namespace App\Controllers;

use App\Models\LogModel;

class Logs extends BaseController
{
    protected $logModel;

    public function __construct()
    {
        $this->logModel = new LogModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses!');
            return redirect()->to('/home');
        }

        $data = [
            'title' => 'Activity Logs',
            'logs' => $this->logModel->getLogs(200)
        ];

        return view('logs/index', $data);
    }

    public function delete($id)
    {
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            return redirect()->to('/home');
        }

        $this->logModel->delete($id);
        session()->setFlashdata('success', 'Log berhasil dihapus!');
        return redirect()->to('/logs');
    }

    public function clear()
    {
        if (!session()->get('logged_in') || session()->get('level') != 1) {
            return redirect()->to('/home');
        }

        $this->logModel->truncate();
        session()->setFlashdata('success', 'Semua log berhasil dibersihkan!');
        return redirect()->to('/logs');
    }
}
