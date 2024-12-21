<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PresensiModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RekapPresensi extends BaseController
{
    public function rekap_harian()
    {
        $presensi_model = new PresensiModel();
        $filter_tanggal = $this->request->getVar('filter_tanggal');

        if($filter_tanggal){
            if(isset($_GET['excel'])){
                $rekap_harian = $presensi_model->rekap_harian_filter($filter_tanggal); 
                $spreadsheet = new Spreadsheet();
                $activeWorksheet = $spreadsheet->getActiveSheet();
                
                $spreadsheet->getActiveSheet()->mergeCells('A1:C1');
                $spreadsheet->getActiveSheet()->mergeCells('A3:B3');
                $spreadsheet->getActiveSheet()->mergeCells('C3:E3');

                $activeWorksheet->setCellValue('A1', 'REKAP PRESENSI HARIAN');
                $activeWorksheet->setCellValue('A3', 'Tanggal : ');
                $activeWorksheet->setCellValue('C3', $filter_tanggal);

                $activeWorksheet->setCellValue('A4', 'NO');
                $activeWorksheet->setCellValue('B4', 'NAMA PEGAWAI');
                $activeWorksheet->setCellValue('C4', 'TANGGAL MASUK');
                $activeWorksheet->setCellValue('D4', 'JAM MASUK');
                $activeWorksheet->setCellValue('E4', 'TANGGAL KELUAR');
                $activeWorksheet->setCellValue('F4', 'JAM KELUAR');
                $activeWorksheet->setCellValue('G4', 'TOTAL JAM KERJA');
                $activeWorksheet->setCellValue('H4', 'TOTAL KETERLAMBATAN');    
                
                $rows = 5;
                $no = 1;
                foreach($rekap_harian as $rekap){

                    //menghitung jumlah jam kerja
        $timestamp_jam_masuk = strtotime($rekap['tanggal_masuk'].$rekap['jam_masuk']);
        $timestamp_jam_keluar = strtotime($rekap['tanggal_keluar'].$rekap['jam_keluar']);
        $selisih = $timestamp_jam_keluar - $timestamp_jam_masuk;
        $jam = floor($selisih / 3600);
        $selisih -= $jam * 3600;
        $menit = floor($selisih / 60);
    //menghitung total keterlambatan
        $jam_masuk_real = strtotime($rekap['jam_masuk']);
        $jam_masuk_kantor = strtotime($rekap['jam_masuk_kantor']);
        $selisih_terlambat =$jam_masuk_real - $jam_masuk_kantor;
        $jam_terlambat = floor($selisih_terlambat / 3600);
        $selisih_terlambat -= $jam_terlambat * 3600;
        $menit_terlambat = floor($selisih_terlambat / 60);

                    $activeWorksheet->setCellValue('A'.$rows, $no++);
                    $activeWorksheet->setCellValue('B'.$rows, $rekap['nama']);
                    $activeWorksheet->setCellValue('C'.$rows, date('d F Y', strtotime($rekap['tanggal_masuk'])));
                    $activeWorksheet->setCellValue('D'.$rows, $rekap['jam_masuk']);
                    $activeWorksheet->setCellValue('E'.$rows, date('d F Y', strtotime($rekap['tanggal_keluar'])));
                    $activeWorksheet->setCellValue('F'.$rows, $rekap['jam_keluar']);
                    $activeWorksheet->setCellValue('G'.$rows, $jam. ' Jam ' . $menit . ' Menit');
                    $activeWorksheet->setCellValue('H'.$rows, $jam_terlambat . ' Jam ' . $menit_terlambat . ' Menit');
                    $rows++;
                }

                // redirect output to client browser
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="rekap_presensi_harian.xlsx"');
                header('Cache-Control: max-age=0');

                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            }else{
            $rekap_harian = $presensi_model->rekap_harian_filter($filter_tanggal); 
            }
        }else{
            $rekap_harian = $presensi_model->rekap_harian();
        }

        $data = [
            'title' => 'Rekap Harian',
            'tanggal' => $filter_tanggal,
            'rekap_harian' => $rekap_harian
        ];

        return view('admin/rekap_presensi/rekap_harian', $data);

    }

    public function rekap_bulanan()
    {
        $presensi_model = new PresensiModel();
        $filter_bulan = $this->request->getVar('filter_bulan');
        $filter_tahun = $this->request->getVar('filter_tahun');

        if($filter_bulan){

            if(isset($_GET['excel'])){
                $rekap_bulanan = $presensi_model->rekap_bulanan_filter($filter_bulan, $filter_tahun);
                
                $spreadsheet = new Spreadsheet();
                $activeWorksheet = $spreadsheet->getActiveSheet();
                
                $spreadsheet->getActiveSheet()->mergeCells('A1:C1');
                $spreadsheet->getActiveSheet()->mergeCells('A3:B3');
                $spreadsheet->getActiveSheet()->mergeCells('C3:E3');

                $activeWorksheet->setCellValue('A1', 'REKAP PRESENSI BULANAN');
                $activeWorksheet->setCellValue('A3', 'BULAN : ');
                $activeWorksheet->setCellValue('C3', $filter_bulan . ' /' . $filter_tahun);
                $activeWorksheet->setCellValue('A4', 'NO');
                $activeWorksheet->setCellValue('B4', 'NAMA PEGAWAI');
                $activeWorksheet->setCellValue('C4', 'TANGGAL MASUK');
                $activeWorksheet->setCellValue('D4', 'JAM MASUK');
                $activeWorksheet->setCellValue('E4', 'TANGGAL KELUAR');
                $activeWorksheet->setCellValue('F4', 'JAM KELUAR');
                $activeWorksheet->setCellValue('G4', 'TOTAL JAM KERJA');
                $activeWorksheet->setCellValue('H4', 'TOTAL KETERLAMBATAN');    
                
                $rows = 5;
                $no = 1;
                foreach($rekap_bulanan as $rekap){

                    //menghitung jumlah jam kerja
        $timestamp_jam_masuk = strtotime($rekap['tanggal_masuk'].$rekap['jam_masuk']);
        $timestamp_jam_keluar = strtotime($rekap['tanggal_keluar'].$rekap['jam_keluar']);
        $selisih = $timestamp_jam_keluar - $timestamp_jam_masuk;
        $jam = floor($selisih / 3600);
        $selisih -= $jam * 3600;
        $menit = floor($selisih / 60);
    //menghitung total keterlambatan
        $jam_masuk_real = strtotime($rekap['jam_masuk']);
        $jam_masuk_kantor = strtotime($rekap['jam_masuk_kantor']);
        $selisih_terlambat =$jam_masuk_real - $jam_masuk_kantor;
        $jam_terlambat = floor($selisih_terlambat / 3600);
        $selisih_terlambat -= $jam_terlambat * 3600;
        $menit_terlambat = floor($selisih_terlambat / 60);

                    $activeWorksheet->setCellValue('A'.$rows, $no++);
                    $activeWorksheet->setCellValue('B'.$rows, $rekap['nama']);
                    $activeWorksheet->setCellValue('C'.$rows, date('d F Y', strtotime($rekap['tanggal_masuk'])));
                    $activeWorksheet->setCellValue('D'.$rows, $rekap['jam_masuk']);
                    $activeWorksheet->setCellValue('E'.$rows, date('d F Y', strtotime($rekap['tanggal_keluar'])));
                    $activeWorksheet->setCellValue('F'.$rows, $rekap['jam_keluar']);
                    $activeWorksheet->setCellValue('G'.$rows, $jam. ' Jam ' . $menit . ' Menit');
                    $activeWorksheet->setCellValue('H'.$rows, $jam_terlambat . ' Jam ' . $menit_terlambat . ' Menit');
                    $rows++;
                }

                // redirect output to client browser
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="rekap_presensi_bulanan.xlsx"');
                header('Cache-Control: max-age=0');

                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            }else{
                $rekap_bulanan = $presensi_model->rekap_bulanan_filter($filter_bulan, $filter_tahun);
            }
        }else{
            $rekap_bulanan = $presensi_model->rekap_bulanan();
        }

        $data = [
            'title' => 'Rekap bulanan',
            'bulan' => $filter_bulan,
            'tahun' => $filter_tahun,
            'rekap_bulanan' => $rekap_bulanan
        ];

        return view('admin/rekap_presensi/rekap_bulanan', $data);

    }
}