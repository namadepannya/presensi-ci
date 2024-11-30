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

    public function create(){
        
        $data = [
            'title'=> 'Ajukan Ketidakhadiran',
           
            'validation' => \Config\Services::validation()
        ];
        return view('pegawai/create_ketidakhadiran', $data);
    }

    public function store(){
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
            'Deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Deskripsi kudu diisian !"
                ],
            ],
            
            'file' => [
                'rules' => 'uploaded[file]|max_size[file, 10240]|mime_in[file,image/png,image/jpeg,application/pdf]',
                'errors' => [
                    'uploaded' => 'file Kudu diunggah !',
                    'max_size' => "Ukuran filena ulah leuwih ti 10MB !",
                    'mime_in' => "Jenis Filena Diantarana PNG/JPEG/JPG atawa PDF"
                ],
            ],
           
        ];

        if(!$this->validate($rules)){
            $data = [
                'title'=> 'Ajukan Ketidakhadiran',
               
                'validation' => \Config\Services::validation()
            ];
            return view('pegawai/create_ketidakhadiran', $data);
        } else {
            $ketidakhadiranModel = new KetidakhadiranModel();
            
            $file = $this->request->getfile('file');

            if($file->getError() == 4){
                $nama_file = '';
            }else {
                $nama_file = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads/file_ketidakhadiran', $nama_file);

            }

            $ketidakhadiranModel->insert([
                'id_pegawai' => $this->request->getPost('id_pegawai'), 
                'keterangan' => $this->request->getPost('keterangan'),
                'tanggal' => $this->request->getPost('tanggal'), 
                'deskripsi' => $this->request->getPost('deskripsi'), 
                'status' => 'pending', 
                'file' => $nama_file 
                ]);

                session()->setFlashdata('berhasil', 'Sip Ketidakhadiranna Tos di Ajukeun!');

            return redirect()->to(base_url('pegawai/ketidakhadiran'));

        }
    }
}