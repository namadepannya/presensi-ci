<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use App\Models\KetidakhadiranModel;
use CodeIgniter\HTTP\ResponseInterface;

class Ketidakhadiran extends BaseController
{

    function __construct()
    {
        helper(['url','form']);
    }



    public function index()
    {
        $ketidakhadiranModel = new KetidakhadiranModel();
        $id_pegawai = session()->get('id_pegawai'); 

        $data = [
            'title' => 'Ketidakhadiran',
            'ketidakhadiran' => $ketidakhadiranModel->where('id_pegawai', $id_pegawai)->findAll()
        ];
        return view('pegawai/ketidakhadiran', $data);
    }
    public function create()
{
    $data = [
        'title' => 'Ajukan Ketidakhadiran',
        'validation' => \Config\Services::validation()  // Mengirimkan objek validasi untuk ditampilkan di form
    ];
    return view('pegawai/create_ketidakhadiran', $data); // Mengarahkan ke view 'create_ketidakhadiran'
}


public function store()
{
    // Validasi input
    $rules = [
        'keterangan' => [
            'rules' => 'required',
            'errors' => [
                'required' => "Keterangan kudu diisian !"
            ],
        ],
        'tanggal' => [
            'rules' => 'required',
            'errors' => [
                'required' => "Tanggal kudu diisian !"
            ],
        ],
        'deskripsi' => [
            'rules' => 'required',
            'errors' => [
                'required' => "Deskripsi kudu diisian !"
            ],
        ],
        'file' => [
            'rules' => 'uploaded[file]|max_size[file,10240]|mime_in[file,image/png,image/jpeg,application/pdf]',
            'errors' => [
                'uploaded' => 'File kudu diunggah !',
                'max_size' => 'Ukuran file ulah leuwih ti 10MB !',
                'mime_in' => 'Jenis file diantarana PNG/JPEG/JPG atawa PDF',
            ],
        ],
    ];

    // Validasi input
    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('validation', \Config\Services::validation());
    }

    // Menangani file upload
    $file = $this->request->getFile('file');
    $fileName = null;

    if ($file->isValid() && !$file->hasMoved()) {
        // Membuat nama file acak untuk menghindari konflik nama
        $fileName = $file->getRandomName();
        
        // Menyimpan file di public/uploads
        $file->move(FCPATH . 'uploads', $fileName); 
    }

    // Membuat objek model KetidakhadiranModel
    $ketidakhadiranModel = new KetidakhadiranModel();

    // Menyimpan data ke database
    $data = [
        'id_pegawai' => $this->request->getPost('id_pegawai'),
        'keterangan' => $this->request->getPost('keterangan'),
        'tanggal' => $this->request->getPost('tanggal'),
        'deskripsi' => $this->request->getPost('deskripsi'),
        'file' => $fileName,
        'status' => 'PENDING', // Status default ke PENDING
    ];

    // Memasukkan data ke tabel ketidakhadiran
    $ketidakhadiranModel->save($data);

    return redirect()->to(base_url('pegawai/ketidakhadiran'))->with('success', 'Data ketidakhadiran berhasil disimpan');
}

public function edit($id){
    $ketidakhadiranModel = new KetidakhadiranModel();
    $data = [
        'title'=> 'Edit Ketidakhadiran',
        'ketidakhadiran' => $ketidakhadiranModel->find($id),
        'validation' => \Config\Services::validation()
    ];
    return view('pegawai/edit_ketidakhadiran', $data);
}

public function update($id)
{
    // Validasi input
    $rules = [
        'keterangan' => [
            'rules' => 'required',
            'errors' => [
                'required' => "Keterangan kudu diisian !"
            ],
        ],
        'tanggal' => [
            'rules' => 'required',
            'errors' => [
                'required' => "Tanggal kudu diisian !"
            ],
        ],
        'deskripsi' => [
            'rules' => 'required',
            'errors' => [
                'required' => "Deskripsi kudu diisian !"
            ],
        ],
        'file' => [
            'rules' => 'max_size[file,10240]|mime_in[file,image/png,image/jpeg,application/pdf]',
            'errors' => [
                'max_size' => 'Ukuran file ulah leuwih ti 10MB !',
                'mime_in' => 'Jenis file diantarana PNG/JPEG/JPG atawa PDF',
            ],
        ],
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('validation', \Config\Services::validation());
    }

    // Menangani file upload
    $file = $this->request->getFile('file');
    $fileName = $this->request->getPost('existing_file'); // File lama

    if ($file->isValid() && !$file->hasMoved()) {
        // Hapus file lama jika ada
        if (file_exists(FCPATH . 'uploads/' . $fileName)) {
            unlink(FCPATH . 'uploads/' . $fileName);
        }

        // Simpan file baru
        $fileName = $file->getRandomName();
        $file->move(FCPATH . 'uploads', $fileName);
    }

    // Update data di database
    $ketidakhadiranModel = new KetidakhadiranModel();
    $data = [
        'keterangan' => $this->request->getPost('keterangan'),
        'tanggal' => $this->request->getPost('tanggal'),
        'deskripsi' => $this->request->getPost('deskripsi'),
        'file' => $fileName,
    ];

    $ketidakhadiranModel->update($id, $data);

     // Menambahkan pesan sukses
     session()->setFlashdata('success', 'Data ketidakhadiran berhasil diperbarui.');

    return redirect()->to(base_url('pegawai/ketidakhadiran'))->with('success', 'Data ketidakhadiran berhasil diperbarui');
}

public function delete($id)
{
    $ketidakhadiranModel = new KetidakhadiranModel();

    // Hapus file dari folder uploads
    $ketidakhadiran = $ketidakhadiranModel->find($id);
    if ($ketidakhadiran && file_exists(FCPATH . 'uploads/' . $ketidakhadiran['file'])) {
        unlink(FCPATH . 'uploads/' . $ketidakhadiran['file']);
    }

    // Hapus data dari database
    $ketidakhadiranModel->delete($id);

    // Menambahkan pesan sukses
    session()->setFlashdata('success', 'Data ketidakhadiran berhasil dihapus.');

    return redirect()->to(base_url('pegawai/ketidakhadiran'))->with('success', 'Data ketidakhadiran berhasil dihapus');
}

public function approved($id)
{
    $ketidakhadiranModel = new KetidakhadiranModel();
    $data = ['status' => 'APPROVED'];

    $ketidakhadiranModel->update($id, $data);  // Update status di database

    // Menambahkan pesan sukses
    session()->setFlashdata('success', 'Status ketidakhadiran berhasil disetujui.');

    return redirect()->to(base_url('pegawai/ketidakhadiran'));
}

    
}