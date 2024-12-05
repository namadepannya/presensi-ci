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

    
}