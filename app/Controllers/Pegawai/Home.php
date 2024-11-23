<?php

namespace App\Controllers\Pegawai;

use App\Controllers\BaseController;
use App\Database\Migrations\Presensi;
use App\Models\PegawaiModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LokasiPresensiModel;
use App\Models\PresensiModel;

class Home extends BaseController
{

    public function index()
    {
        $lokasi_presensi = new LokasiPresensiModel();
        $pegawai_model = new PegawaiModel();
        $presensi_model = new PresensiModel();
        $id_pegawai = session()->get('id_pegawai');
        $pegawai = $pegawai_model->where('id', $id_pegawai)->first();   
        $data = [
            'title' => 'Absensi Pegawai',
            'lokasi_presensi' => $lokasi_presensi->where('id', $pegawai['lokasi_presensi'])->first(),
            'cek_presensi' => $presensi_model->where('id_pegawai', $id_pegawai)->where('tanggal_masuk', date('Y-m-d'))->countAllResults(),
            'cek_presensi_keluar' => $presensi_model->where('id_pegawai', $id_pegawai)->where('tanggal_masuk', date('Y-m-d'))->where('tanggal_keluar !=', '000-00-00')->countAllResults(),
            'ambil_presensi_masuk' => $presensi_model->where('id_pegawai', $id_pegawai)->where('tanggal_masuk', date('Y-m-d'))->first()
        ];
        return view('pegawai/home', $data);
    }

    public function presensi_masuk()
    {
        $latitude_pegawai = (float) $this->request->getPost('latitude_pegawai');
        $latitude_kantor = (float) $this->request->getPost('latitude_kantor');
        $radius = $this->request->getPost('radius');

        $jarak = sin(deg2rad($latitude_pegawai)) * sin(deg2rad($latitude_kantor)) + cos(deg2rad($latitude_pegawai)) * cos(deg2rad($latitude_kantor)) ;
        $jarak = acos($jarak);
        $jarak = rad2deg($jarak);
        $mil = $jarak * 60 * 1.1515;
        $km = $mil * 1.609344;
        $jarak_meter = floor($km * 1000);
        if ($jarak_meter > $radius) {
            session()->setFlashdata('gagal','Presensi Masuk Gagal, Lokasi Anjeun Berada Diluar Radius Kantor !');
            return redirect()->to(base_url('pegawai/home'));
        }else{
            $data = [
                'title' => "Cik Geura Selfie Heula",
                'id_pegawai' => $this->request->getPost('id_pegawai'),
                'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
                'jam_masuk' => $this->request->getPost('jam_masuk'),
            ];
            return view('pegawai/ambil_foto', $data);
        }
    }

    public function presensi_masuk_aksi(){
        $request = \Config\Services::request();

        // dd($request->getPost());
        
        $id_pegawai = $request->getPost('id_pegawai');
        $tanggal_masuk = $request->getPost('tanggal_masuk');
        $jam_masuk = $request->getPost('jam_masuk');
        $foto_masuk = $request->getPost('foto_masuk');

        $foto_masuk= str_replace('data:image/jpeg;base64,','', $foto_masuk);
        $foto_masuk = base64_decode($foto_masuk);

        $foto_dir = 'uploads/'.$id_pegawai . '_' . time().'.jpg';
        $nama_foto = $id_pegawai . '_' . time().'.jpg';
        file_put_contents($foto_dir, $foto_masuk);  

        $presensi_model = new PresensiModel();
        $presensi_model->insert([
            'id_pegawai' => $id_pegawai,
            'tanggal_masuk' => $tanggal_masuk,
            'jam_masuk' => $jam_masuk,
            'foto_masuk' => $nama_foto
            ]);

            session()->setFlashdata('berhasil', 'Presensi Masuk Tos Ka Input!');

        return redirect()->to(base_url('pegawai/home'));
        
    }

    public function presensi_keluar($id)
    {
        $latitude_pegawai = (float) $this->request->getPost('latitude_pegawai');
        $latitude_kantor = (float) $this->request->getPost('latitude_kantor');
        $radius = $this->request->getPost('radius');

        $jarak = sin(deg2rad($latitude_pegawai)) * sin(deg2rad($latitude_kantor)) + cos(deg2rad($latitude_pegawai)) * cos(deg2rad($latitude_kantor)) ;
        $jarak = acos($jarak);
        $jarak = rad2deg($jarak);
        $mil = $jarak * 60 * 1.1515;
        $km = $mil * 1.609344;
        $jarak_meter = floor($km * 1000);

        if ($jarak_meter > $radius) {
            session()->setFlashdata('gagal','Presensi keluar Gagal, Lokasi Anjeun Berada Diluar Radius Kantor !');
            return redirect()->to(base_url('pegawai/home'));
        }else{
            $data = [
                'title' => "Cik Geura Selfie Heula",
                'id_presensi' => $id,
                'tanggal_keluar' => $this->request->getPost('tanggal_keluar'),
                'jam_keluar' => $this->request->getPost('jam_keluar'),
            ];
            return view('pegawai/ambil_foto_keluar', $data);
        }
    }

    public function presensi_keluar_aksi($id){
        $request = \Config\Services::request();
        // dd($request->getPost());
        $tanggal_keluar = $request->getPost('tanggal_keluar');
        $jam_keluar = $request->getPost('jam_keluar');
        $foto_keluar = $request->getPost('foto_keluar');

        $foto_keluar= str_replace('data:image/jpeg;base64,','', $foto_keluar);
        $foto_keluar = base64_decode($foto_keluar);

        $foto_dir = 'uploads/' . $id . '_' . time().'.jpg';
        $nama_foto = $id . '_' . time().'.jpg';
        file_put_contents($foto_dir, $foto_keluar);  

        $presensi_model = new PresensiModel();
        $presensi_model->update($id, [
            'tanggal_keluar' => $tanggal_keluar,
            'jam_keluar' => $jam_keluar,
            'foto_keluar' => $nama_foto
            ]);

            session()->setFlashdata('berhasil', 'Presensi Kaluar Tos Ka Input!');

        return redirect()->to(base_url('pegawai/home'));
        
    }
} 