<?php

namespace App\Controllers;

use \App\Models\KomikModel;
use \App\Models\KomikCategoryModel;

class Komik extends BaseController
{
    private $komikModel, $KomikcatModel;
    public function __construct()
    {
        $this->komikModel = new KomikModel();
        $this->KomikcatModel = new KomikCategoryModel();
    }

    public function index()
    {
        $dataKomik = $this->komikModel->getKomik();
        $data = [
            'title' => 'Data Komik',
            'result' => $dataKomik
        ];
        return view('komik/index', $data);
    }

    public function detail($slug)
    {
        $dataKomik = $this->komikModel->getKomik($slug);
        $data = [
            'title' => 'Detail Komik',
            'result' => $dataKomik
        ];
        return view('komik/detail', $data);
    }

    public function create()
    {
        session();
        $data = [
            'title' => 'Tambah komik',
            'category' => $this->KomikcatModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('komik/create', $data);
    }

    public function save()
    {
        //Validasi Input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'label' => 'Judul',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} hanya sudah ada'
                ]
            ],
            'penulis' => 'required',
            'tahun_rilis' => 'required|integer',
            'harga' => 'required|numeric',
            'diskon' => 'permit_empty|decimal',
            'stok' => 'required|integer',
        ])) {
            return redirect()->to('/komik/create')->withInput();
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'penulis' => $this->request->getVar('penulis'),
            'tahun_rilis' => $this->request->getVar('tahun_rilis'),
            'harga' => $this->request->getVar('harga'),
            'diskon' => $this->request->getVar('diskon'),
            'stok' => $this->request->getVar('stok'),
            'komik_category_id' => $this->request->getVar('komik_category_id'),
            'slug' => $slug,
        ]);

        session()->setFlashdata("msg", "Data berhasil ditambahkan");
        return redirect()->to('/komik');
    }
}