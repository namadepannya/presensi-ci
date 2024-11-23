<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\JabatanModel;
use CodeIgniter\HTTP\RedirectResponse;

class Jabatan extends BaseController
{
    public function index()
    {
        $jabatanModel = new JabatanModel();
        $data = [
            'title' => 'Data Jabatan',
            'jabatan' => $jabatanModel->findAll()
        ] ;

        return view('admin/jabatan/jabatan', $data);
    }

    public function create(){
        $data = [
            'title'=> 'Tambah Jabatan',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/jabatan/create', $data);
    }

    public function store(){
        $rules = [
            'jabatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Isi Jabatanna Heula Atuh !"
                ],
            ],
        ];

        if(!$this->validate($rules)){
            $data = [
                'title'=> 'Tambah Jabatan',
                'validation' => \Config\Services::validation()
            ];
            echo view('admin/jabatan/create', $data);
        } else {
            $jabatanModel = new JabatanModel();
            $jabatanModel->insert([
                'jabatan' => $this->request->getPost('jabatan') 
                ]);

                session()->setFlashdata('berhasil', 'Sip Jabatanna Tos Ka Input!');

            return redirect()->to(base_url('admin/jabatan'));

        }
    }

    public function edit($id){

        $jabatanModel = new JabatanModel();
        $data = [
            'title'=> 'Edit Jabatan',
            'jabatan' => $jabatanModel->find($id),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/jabatan/edit', $data);
    }

    public function update($id){
        $rules = [
            'jabatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Isi Jabatanna Heula Atuh !"
                ],
            ],
        ];

        if(!$this->validate($rules)){
            $jabatanModel = new JabatanModel();
            $data = [
                'title'=> 'Edit Jabatan',
                'jabatan' => $jabatanModel->find($id),
                'validation' => \Config\Services::validation()
            ];
            echo view('admin/jabatan/edit', $data);
        } else {
            $jabatanModel = new JabatanModel();
            $jabatanModel->update( $id, [
                'jabatan' => $this->request->getPost('jabatan') 
                ]);

                session()->setFlashdata('berhasil', 'Sip Jabatanna Tos Ka Update!');

            return redirect()->to(base_url('admin/jabatan'));

        }
    }

    public function delete($id){
        $jabatanModel = new JabatanModel();

        $jabatan = $jabatanModel->find($id);
        if($jabatan){
            $jabatanModel->delete($id);
            session()->setFlashdata('berhasil', 'Sip Jabatanna Tos Ka Apus!');

            return redirect()->to(base_url('admin/jabatan'));

        }

    }
}