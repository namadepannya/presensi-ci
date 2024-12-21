<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KetidakhadiranModel;
use CodeIgniter\HTTP\ResponseInterface;

class Ketidakhadiran extends BaseController
{
    public function index()
    {
        $ketidakhadiranModel = new KetidakhadiranModel();
        $data = [
            'title' => 'Ketidakhadiran',
            'ketidakhadiran' => $ketidakhadiranModel->findAll() //rekap mengambil keseluruhan ketidakhadiran
        ];
        return view('admin/ketidakhadiran', $data);
    }

    public function approved($id)
{
    // Update data di database
    $ketidakhadiranModel = new KetidakhadiranModel();
    $data = [
        'status' => 'Approved'
    ];

    $ketidakhadiranModel->update($id, $data);

     // Menambahkan pesan sukses
     session()->setFlashdata('success', 'Status Hoream Asup tos di ACC.');

     return redirect()->to(base_url('admin/ketidakhadiran'))->with('success', 'Status Ketidakhadiran berhasil di ACC');
}

}