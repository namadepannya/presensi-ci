<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PegawaiModel;
use App\Models\UserModel;
use App\Models\LokasiPresensiModel;
use App\Models\JabatanModel;


class DataPegawai extends BaseController
{

    function __construct()
    {
        helper(['url','form']);
    }

    public function index()
    {
        $pegawaiModel = new PegawaiModel();
        $data = [
            'title' => 'Data Pegawai',
            'pegawai' => $pegawaiModel->findAll()
        ] ;

        return view('admin/data_pegawai/data_pegawai', $data);
    }

    public function detail($id){

        $pegawaiModel = new PegawaiModel();
        $data = [
            'title'=> 'Detail Data Pegawai',
            'pegawai' => $pegawaiModel->detailPegawai($id),
        ];
        return view('admin/data_pegawai/detail', $data) ;
    }

    public function create(){
        $lokasi_presensi = new LokasiPresensiModel();
        $jabatan_model = new JabatanModel();
        $data = [
            'title'=> 'Tambah Pegawai',
            'lokasi_presensi' => $lokasi_presensi->findAll(),
            'jabatan' => $jabatan_model->orderBy('jabatan', 'ASC')->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/data_pegawai/create', $data);
    }

    public function generateNIP()
    {
        $pegawaiModel = new PegawaiModel();
        $pegawaiTerakhir = $pegawaiModel->select('nip')->orderBy('id', 'DESC')->first();
        $nipTerakhir = $pegawaiTerakhir ? $pegawaiTerakhir['nip'] : 'PEG-0000';
        $angkaNIP = (int) substr($nipTerakhir, 4);
        $angkaNIP++;
        return 'PEG-' .str_pad($angkaNIP,4, '0', STR_PAD_LEFT);
    }

    public function store(){
        $rules = [
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Ngaran kudu diisian !"
                ],
            ],
            'jenis_kelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Jenis Kelamin kudu diisian !"
                ],
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Alamat kudu diisian !"
                ],
            ],
            'no_telepon' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "No HP kudu diisian !"
                ],
            ],
            'jabatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Jabatan kudu diisian !"
                ],
            ],
            'lokasi_presensi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Lokasi Presensi kudu diisian !"
                ],
            ],
            'foto' => [
                'rules' => 'uploaded[foto]|max_size[foto, 10240]|mime_in[foto,image/png,image/jpeg]',
                'errors' => [
                    'uploaded' => 'Foto Kudu diunggah !',
                    'max_size' => "Ukuran potona ulah leuwih ti 10MB !",
                    'mime_in' => "Jenis Filena Diantarana PNG atawa JPEG"
                ],
            ],
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Username kudu diisian !"
                ],
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Password kudu diisian !"
                ],
            ],

            'konfirmasi_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => "Konfirmasi Password kudu diisian !",
                    'matches' => "Konfirmasi Passwordna Teu Cocok"
                ],
            ],

            'role' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Role kudu diisian !"
                ],
            ],
        ];

        if(!$this->validate($rules)){
        $lokasi_presensi = new LokasiPresensiModel();
        $jabatan_model = new JabatanModel();
        $data = [
            'title'=> 'Tambah Pegawai',
            'lokasi_presensi' => $lokasi_presensi->findAll(),
            'jabatan' => $jabatan_model->orderBy('jabatan', 'ASC')->findAll(),
            'validation' => \Config\Services::validation()
        ];
            echo view('admin/data_pegawai/create', $data);
        } else {
            $pegawaiModel = new PegawaiModel();
            $nipBaru = $this->generateNIP();
            

            $foto = $this->request->getfile('foto');

            if($foto->getError() == 4){
                $nama_foto = '';
            }else {
                $nama_foto = $foto->getRandomName();
                $foto->move('profile',$nama_foto);
            }

            $pegawaiModel = new PegawaiModel();
            $pegawaiModel->insert([
                'nip' => $nipBaru,
                'nama' => $this->request->getPost('nama'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'), 
                'alamat' => $this->request->getPost('alamat'), 
                'no_telepon' => $this->request->getPost('no_telepon'), 
                'jabatan' => $this->request->getPost('jabatan'), 
                'lokasi_presensi' => $this->request->getPost('lokasi_presensi'), 
                'foto' => $nama_foto, 
                ]);

                $id_pegawai = $pegawaiModel->insertID();
                $userModel = new userModel();
                $userModel->insert([
                    'id_pegawai' => $id_pegawai,
                    'username' => $this->request->getPost('username'), 
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), 
                    'status' => 'Aktif', 
                    'role' => $this->request->getPost('role')
                    ]);

                session()->setFlashdata('berhasil', 'Sip Data Pegawai Tos Ka Input!');

            return redirect()->to(base_url('admin/data_pegawai'));

        }
    }

    public function edit($id){
        $pegawaiModel = new PegawaiModel();
        $lokasi_presensi = new LokasiPresensiModel();
        $jabatan_model = new JabatanModel();
        $data = [
            'title'=> 'Tambah Pegawai',
            'pegawai' => $pegawaiModel->editpegawai($id),
            'lokasi_presensi' => $lokasi_presensi->findAll(),
            'jabatan' => $jabatan_model->orderBy('jabatan', 'ASC')->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/data_pegawai/edit', $data);
    }

    public function update($id){
        $rules = [
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Ngaran kudu diisian !"
                ],
            ],
            'jenis_kelamin' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Jenis Kelamin kudu diisian !"
                ],
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Alamat kudu diisian !"
                ],
            ],
            'no_telepon' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "No HP kudu diisian !"
                ],
            ],
            'jabatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Jabatan kudu diisian !"
                ],
            ],
            'lokasi_presensi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Lokasi Presensi kudu diisian !"
                ],
            ],
            'foto' => [
                'rules' => 'max_size[foto, 10240]|mime_in[foto,image/png,image/jpeg]',
                'errors' => [
                    // 'uploaded' => 'Foto Kudu diunggah !',
                    // 'required' => "Foto kudu diisian !",
                    'max_size' => "Ukuran potona ulah leuwih ti 10MB !",
                    'mime_in' => "Jenis Filena Diantarana PNG atawa JPEG"
                ],
            ],
            'username' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Username kudu diisian !"
                ],
            ],

            'role' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Role kudu diisian !"
                ],
            ],
        ];

        if(!$this->validate($rules)){
        $pegawaiModel = new PegawaiModel();
        $lokasi_presensi = new LokasiPresensiModel();
        $jabatan_model = new JabatanModel();
        $data = [
            'title'=> 'Tambah Pegawai',
            'pegawai' => $pegawaiModel->editpegawai($id),
            'lokasi_presensi' => $lokasi_presensi->findAll(),
            'jabatan' => $jabatan_model->orderBy('jabatan', 'ASC')->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/data_pegawai/edit', $data);
        } else {
            $pegawaiModel = new PegawaiModel();
            $userModel = new UserModel();
            $foto = $this->request->getFile('foto');
            if($foto->getError() == 4){
                $nama_foto = $this->request->getPost('foto_lama');
            }else {
                $nama_foto = $foto->getRandomName();
                $foto->move('profile',$nama_foto);
            }
            $pegawaiModel->update( $id, [
                'nama' => $this->request->getPost('nama'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'), 
                'alamat' => $this->request->getPost('alamat'), 
                'no_telepon' => $this->request->getPost('no_telepon'), 
                'jabatan' => $this->request->getPost('jabatan'), 
                'lokasi_presensi' => $this->request->getPost('lokasi_presensi'), 
                'foto' => $nama_foto, 
                ]);

                if($this->request->getPost('password') == ''){
                    $password = $this->request->getPost('password_lama');
                }else{
                    $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
                }
                
                $userModel
                ->where('id_pegawai', $id)
                ->set([
                    'username' => $this->request->getPost('username'),
                    'password' => $password,
                    'status' => $this->request->getPost('status'),
                    'role' => $this->request->getPost('role'),
                    ])
                ->update();


                session()->setFlashdata('berhasil', 'Sip Data Pegawaina Tos Ka Update!');

            return redirect()->to(base_url('admin/data_pegawai'));

        }
    }

    public function delete($id){
        $pegawaiModel = new PegawaiModel();
        $userModel= new UserModel();
        $pegawai = $pegawaiModel->find($id);
        if($pegawai){
            $userModel->where('id_pegawai', $id)->delete();  
            $pegawaiModel->delete($id);
            session()->setFlashdata('berhasil', 'Sip Data Pegawai Tos Ka Apus!');
            return redirect()->to(base_url('admin/data_pegawai'));

        }

    }
}