<?php

namespace App\Controllers;

use App\Models\ArsipModel;
use App\Models\KategoriModel;
use App\Models\DepartemenModel;

class Arsip extends BaseController
{
    protected $arsipModel;
    protected $kategoriModel;
    protected $departemenModel;

    public function __construct()
    {
        $this->arsipModel = new ArsipModel();
        $this->kategoriModel = new KategoriModel();
        $this->departemenModel = new DepartemenModel();
        helper(['form', 'url', 'filesystem']);
    }

    public function index()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        // Jika user biasa, hanya tampilkan arsip miliknya
        if (session()->get('level') == 2) {
            $arsip = $this->arsipModel->getArsipByUser(session()->get('id_user'));
        } else {
            $arsip = $this->arsipModel->getArsip();
        }

        $data = [
            'title' => 'Data Arsip',
            'arsip' => $arsip
        ];

        return view('arsip/index', $data);
    }

    public function add()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $data = [
            'title' => 'Tambah Arsip',
            'kategori' => $this->kategoriModel->getKategori(),
            'departemen' => $this->departemenModel->getDepartemen(),
            'validation' => \Config\Services::validation()
        ];

        return view('arsip/add', $data);
    }

    public function save()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        // Validasi
        $rules = [
            'id_kategori' => 'required',
            'nama_file' => 'required',
            'file_arsip' => [
                'rules' => 'uploaded[file_arsip]|max_size[file_arsip,5120]|ext_in[file_arsip,pdf]',
                'errors' => [
                    'uploaded' => 'File arsip harus diupload',
                    'max_size' => 'Ukuran file maksimal 5MB',
                    'ext_in' => 'File harus berformat PDF'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload file
        $file = $this->request->getFile('file_arsip');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = time() . '_' . $file->getName();
            $file->move(WRITEPATH . '../public/uploads', $newName);

            // Generate nomor arsip
            $no_arsip = $this->arsipModel->generateNoArsip();

            // Simpan data
            $data = [
                'id_kategori' => $this->request->getPost('id_kategori'),
                'no_arsip' => $no_arsip,
                'nama_file' => $this->request->getPost('nama_file'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'tgl_upload' => date('Y-m-d'),
                'tgl_update' => date('Y-m-d'),
                'file_arsip' => $newName,
                'id_user' => session()->get('id_user'),
                'id_dep' => session()->get('id_dep')
            ];

            $this->arsipModel->save($data);
            session()->setFlashdata('success', 'Data arsip berhasil ditambahkan!');
            return redirect()->to('/arsip');
        }

        session()->setFlashdata('error', 'Gagal mengupload file!');
        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $arsip = $this->arsipModel->getArsip($id);

        // Cek akses user biasa hanya bisa edit arsip miliknya
        if (session()->get('level') == 2 && $arsip['id_user'] != session()->get('id_user')) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses untuk mengedit arsip ini!');
            return redirect()->to('/arsip');
        }

        $data = [
            'title' => 'Edit Arsip',
            'arsip' => $arsip,
            'kategori' => $this->kategoriModel->getKategori(),
            'departemen' => $this->departemenModel->getDepartemen(),
            'validation' => \Config\Services::validation()
        ];

        return view('arsip/edit', $data);
    }

    public function update($id)
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $arsip = $this->arsipModel->getArsip($id);

        // Cek akses user biasa hanya bisa update arsip miliknya
        if (session()->get('level') == 2 && $arsip['id_user'] != session()->get('id_user')) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses untuk mengupdate arsip ini!');
            return redirect()->to('/arsip');
        }

        // Validasi
        $rules = [
            'id_kategori' => 'required',
            'nama_file' => 'required',
        ];

        // Jika ada file baru
        $file = $this->request->getFile('file_arsip');
        if ($file && $file->getName() != '') {
            $rules['file_arsip'] = [
                'rules' => 'uploaded[file_arsip]|max_size[file_arsip,5120]|ext_in[file_arsip,pdf]',
                'errors' => [
                    'uploaded' => 'File arsip harus diupload',
                    'max_size' => 'Ukuran file maksimal 5MB',
                    'ext_in' => 'File harus berformat PDF'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update data
        $data = [
            'id_kategori' => $this->request->getPost('id_kategori'),
            'nama_file' => $this->request->getPost('nama_file'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'tgl_update' => date('Y-m-d'),
        ];

        // Jika ada file baru
        if ($file && $file->getName() != '' && $file->isValid() && !$file->hasMoved()) {
            // Hapus file lama
            $oldFile = WRITEPATH . '../public/uploads/' . $arsip['file_arsip'];
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }

            // Upload file baru
            $newName = time() . '_' . $file->getName();
            $file->move(WRITEPATH . '../public/uploads', $newName);
            $data['file_arsip'] = $newName;
        }

        $this->arsipModel->update($id, $data);
        session()->setFlashdata('success', 'Data arsip berhasil diupdate!');
        return redirect()->to('/arsip');
    }

    public function delete($id)
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $arsip = $this->arsipModel->getArsip($id);

        // Cek akses - admin bisa hapus semua, user hanya arsip miliknya
        if (session()->get('level') == 2 && $arsip['id_user'] != session()->get('id_user')) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses untuk menghapus arsip ini!');
            return redirect()->to('/arsip');
        }

        // Hapus file
        $file = WRITEPATH . '../public/uploads/' . $arsip['file_arsip'];
        if (file_exists($file)) {
            unlink($file);
        }

        // Hapus data
        $this->arsipModel->delete($id);
        session()->setFlashdata('success', 'Data arsip berhasil dihapus!');
        return redirect()->to('/arsip');
    }

    public function view($id)
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth');
        }

        $arsip = $this->arsipModel->getArsip($id);

        // Cek akses user biasa hanya bisa view arsip miliknya
        if (session()->get('level') == 2 && $arsip['id_user'] != session()->get('id_user')) {
            session()->setFlashdata('error', 'Anda tidak memiliki akses untuk melihat arsip ini!');
            return redirect()->to('/arsip');
        }

        $data = [
            'title' => 'Detail Arsip',
            'arsip' => $arsip
        ];

        return view('arsip/view', $data);
    }
}
