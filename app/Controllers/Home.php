<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard'
        ];
        return view('admin/overview', $data);
        
        // echo view('layout/header');
        // echo view('layout/topbar');
        // echo view('layout/sidebar');
        // echo view('layout/footer');
    }

    public function unguided2()
    {
        return view('Tugas2/index');
    }

    // public function about($nama = null, $umur = 0)
    // {
    //     echo "Hi, nama saya adalah $nama. Usia saya $umur tahun.";
    // }
}
