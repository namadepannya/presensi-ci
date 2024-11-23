<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LokasiPresensiModel;

class LokasiPresensi extends BaseController
{
    public function index()
    {
        $LokasiPresensiModel = new LokasiPresensiModel();
        $data = [
            'title' => 'Data Lokasi Presensi',
            'lokasi_presensi' => $LokasiPresensiModel->findAll()
        ] ;

        return view('admin/lokasi_presensi/lokasi_presensi', $data);
    }

    public function detail($id){

        $LokasiPresensiModel = new LokasiPresensiModel();
        $data = [
            'title'=> 'Detail Lokasi Presensi',
            'lokasi_presensi' => $LokasiPresensiModel->find($id),
        ];
        return view('admin/lokasi_presensi/detail', $data) ;
    }

    public function create(){
        $data = [
            'title'=> 'Tambah Lokasi Presensi',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/lokasi_presensi/create', $data);
    }

    public function store(){
        $rules = [
            'nama_lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "ngaran lokasi kudu diisian !"
                ],
            ],
            'alamat_lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "alamat lokasi kudu diisian !"
                ],
            ],
            'tipe_lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Tipe lokasi kudu diisian !"
                ],
            ],
            'latitude' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "latitude lokasi kudu diisian !"
                ],
            ],
            'longitude' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "longitude lokasi kudu diisian !"
                ],
            ],
            'radius' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "radius lokasi kudu diisian !"
                ],
            ],
            'zona_waktu' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "zona_waktu lokasi kudu diisian !"
                ],
            ],
            'jam_masuk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "jam dongkap lokasi kudu diisian !"
                ],
            ],
            'jam_pulang' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "jam uih lokasi kudu diisian !"
                ],
            ],
        ];

        if(!$this->validate($rules)){
            $data = [
                'title'=> 'Tambah Lokasi Presensi',
                'validation' => \Config\Services::validation()
            ];
            echo view('admin/lokasi_presensi/create', $data);
        } else {
            $LokasiPresensiModel = new LokasiPresensiModel();
            $LokasiPresensiModel->insert([
                'nama_lokasi' => $this->request->getPost('nama_lokasi'), 
                'alamat_lokasi' => $this->request->getPost('alamat_lokasi'), 
                'tipe_lokasi' => $this->request->getPost('tipe_lokasi'), 
                'latitude' => $this->request->getPost('latitude'), 
                'longitude' => $this->request->getPost('longitude'), 
                'radius' => $this->request->getPost('radius'), 
                'zona_waktu' => $this->request->getPost('zona_waktu'), 
                'jam_masuk' => $this->request->getPost('jam_masuk'), 
                'jam_pulang' => $this->request->getPost('jam_pulang') 
                ]);

                session()->setFlashdata('berhasil', 'Sip Data Lokasi Tos Ka Input!');

            return redirect()->to(base_url('admin/lokasi_presensi'));

        }
    }

    public function edit($id){

        $LokasiPresensiModel = new LokasiPresensiModel();
        $data = [
            'title'=> 'Edit Lokasi Presensi',
            'lokasi_presensi' => $LokasiPresensiModel->find($id),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/lokasi_presensi/edit', $data);
    }

    public function update($id){
        $rules = [
            'nama_lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "ngaran lokasi kudu diisian !"
                ],
            ],
            'alamat_lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "alamat lokasi kudu diisian !"
                ],
            ],
            'tipe_lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Tipe lokasi kudu diisian !"
                ],
            ],
            'latitude' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "latitude lokasi kudu diisian !"
                ],
            ],
            'longitude' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "longitude lokasi kudu diisian !"
                ],
            ],
            'radius' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "radius lokasi kudu diisian !"
                ],
            ],
            'zona_waktu' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "zona_waktu lokasi kudu diisian !"
                ],
            ],
            'jam_masuk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "jam dongkap lokasi kudu diisian !"
                ],
            ],
            'jam_pulang' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "jam uih lokasi kudu diisian !"
                ],
            ],
        ];

        if(!$this->validate($rules)){
            $LokasiPresensiModel = new LokasiPresensiModel();
            $data = [
                'title'=> 'Edit Lokasi Presensi',
                'lokasi_presensi' => $LokasiPresensiModel->find($id),
                'validation' => \Config\Services::validation()
            ];
            echo view('admin/lokasi_presensi/edit', $data);
        } else {
            $LokasiPresensiModel = new LokasiPresensiModel();
            $LokasiPresensiModel->update( $id, [
                'nama_lokasi' => $this->request->getPost('nama_lokasi'), 
                'alamat_lokasi' => $this->request->getPost('alamat_lokasi'), 
                'tipe_lokasi' => $this->request->getPost('tipe_lokasi'), 
                'latitude' => $this->request->getPost('latitude'), 
                'longitude' => $this->request->getPost('longitude'), 
                'radius' => $this->request->getPost('radius'), 
                'zona_waktu' => $this->request->getPost('zona_waktu'), 
                'jam_masuk' => $this->request->getPost('jam_masuk'), 
                'jam_pulang' => $this->request->getPost('jam_pulang')  
                ]);

                session()->setFlashdata('berhasil', 'Sip Data Lokasina Tos Ka Update!');

            return redirect()->to(base_url('admin/lokasi_presensi'));

        }
    }

    public function delete($id){
        $LokasiPresensiModel = new LokasiPresensiModel();

        $lokasi_presensi = $LokasiPresensiModel->find($id);
        if($lokasi_presensi){
            $LokasiPresensiModel->delete($id);
            session()->setFlashdata('berhasil', 'Sip Data Lokasi Presensina Tos Ka Apus!');

            return redirect()->to(base_url('admin/lokasi_presensi'));

        }

    }
}