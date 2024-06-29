<?php

namespace App\Controllers;
use App\Models\BerandaModel;

class Home extends BaseController
{
    private $beranda;
    public function __construct()
    {
        $this->beranda = new BerandaModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Beranda'
        ];
        return view('beranda', $data);
    }

    public function showChartTransaksi()
    {
        $tahun = $this->request->getVar('tahun');
        $reportTrans = $this->beranda->reportTransaksi($tahun);
        $response = [
            'status'    => false,
            'data'      => $reportTrans
        ];
        echo json_encode($response);
    }

    public function showChartPembelian()
    {
        $tahun = $this->request->getVar('tahun');
        $reportPem = $this->beranda->reportPembelian($tahun);
        $response = [
            'status'    => false,
            'data'      => $reportPem
        ];
        echo json_encode($response);
    }

    public function showChartCustomer()
    {
        $tahun = $this->request->getVar('tahun');
        $reportCust = $this->beranda->reportCustomer($tahun);
        $response = [
            'status'    => false,
            'data'      => $reportCust
        ];
        echo json_encode($response);
    }

    public function showChartSupplier()
    {
        $tahun = $this->request->getVar('tahun');
        $reportSup = $this->beranda->reportSupplier($tahun);
        $response = [
            'status'    => false,
            'data'      => $reportSup
        ];
        echo json_encode($response);
    }

    public function unguided2()
    {
        $data = [
            'title' => 'Tugas 2'
        ];
        return view('Tugas2/index', $data);
    }

    // public function about($nama = null, $umur = 0)
    // {
    //     echo "Hi, nama saya adalah $nama. Usia saya $umur tahun.";
    // }
}
