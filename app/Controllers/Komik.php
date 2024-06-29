<?php

namespace App\Controllers;

use \App\Models\KomikModel;
use \App\Models\KomikCategoryModel;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

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
            'cover' => [
                'rules' => 'uploaded[cover]|max_size[cover,1024]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Gambar tidak boleh lebih dari 1MB!',
                    'is_image' => 'Yang Anda pilih bukan gambar!',
                    'mime_in' => 'Yang Anda pilih bukan gambar!',
                ]
            ]
        ])) {
            return redirect()->to('/komik/create')->withInput();
        }

        //Mengambil File Cover
        $fileCover = $this->request->getFile('cover');
        if ($fileCover->getError() == 4) {
            $namaFile = $this->defaultImage;
        } else {
            // Generate Nama File
            $namaFile = $fileCover->getRandomName();
            // Pindahkan File ke folder img di public
            $fileCover->move('img', $namaFile);
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
            'cover' => $namaFile,
        ]);

        session()->setFlashdata("msg", "Data berhasil ditambahkan");
        return redirect()->to('/komik');
    }

    public function edit($slug)
    {
        $dataKomik = $this->komikModel->getKomik($slug);
        // Jika data komik kosong
        if (empty($dataKomik)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Judul komik $slug 
            tidak ditemukan!");
        }

        $data = [
            'title' => 'Ubah Komik',
            'category' => $this->KomikcatModel->findAll(),
            'validation' => \Config\Services::validation(),
            'result' => $dataKomik
        ];
        return view('komik/edit', $data);
    }

    public function update($id)
    {
        //Cek Judul
        $dataOld = $this->komikModel->getKomik($this->request->getVar('slug'));
        if ($dataOld['judul'] == $this->request->getVar('judul')) {
            $rule_title = 'required';
        } else {
            $rule_title = 'required|is_unique[komik.judul]';
        }

        //Validasi Data
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_title,
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
            'cover' => [
                'rules' => 'uploaded[cover]|max_size[cover, 1024]|is_image[cover]|mime_in[cover,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Gambar tidak boleh lebih dari 1MB!',
                    'is_image' => 'Yang Anda pilih bukan gambar!',
                    'mime_in' => 'Yang Anda pilih bukan gambar!'
                ]
            ]
        ])) {
            return redirect()->to('/komik/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $namaFileLama = $this->request->getVar('CoverLama');
        //Mengambil File Cover
        $fileCover = $this->request->getFile('cover');
        // Cek gambar, apakah masih gambar lama
        if ($fileCover->getError() == 4) {
            $namaFile = $this->defaultImage;
        } else {
            // Generate Nama File
            $namaFile = $fileCover->getRandomName();
            // Pindahkan File ke folder img di public
            $fileCover->move('img', $namaFile);

            // Jika covernya default
            if ($namaFileLama != $this->defaultImage && $namaFileLama != "") {
                // Hapus gambar
                unlink('img/' . $namaFileLama);
            }
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'komik_id' => $id,
            'judul' => $this->request->getVar('judul'),
            'penulis' => $this->request->getVar('penulis'),
            'tahun_rilis' => $this->request->getVar('tahun_rilis'),
            'harga' => $this->request->getVar('harga'),
            'diskon' => $this->request->getVar('diskon'),
            'stok' => $this->request->getVar('stok'),
            'komik_category_id' => $this->request->getVar('komik_category_id'),
            'slug' => $slug,
            'cover' => $namaFile
        ]);

        session()->setFlashdata("msg", "Data berhasil diubah!");

        return redirect()->to('/komik');
    }

    public function delete($id)
    {
        // Cari gambar by ID
        $dataKomik = $this->komikModel->find($id);
        $this->komikModel->delete($id);

        // Jika cover default
        if ($dataKomik['cover'] != $this->defaultImage) {
            // Hapus gambar
            unlink('img/' . $dataKomik['cover']);
        }
        session()->setFlashdata("msg", "Data berhasil dihapus!");
        return redirect()->to('/komik');
    }

    public function importData()
    {
        $file = $this->request->getFile("file");
        $ext = $file->getExtension();
        if ($ext == "xls") 
            $reader = new Xls();
        else 
            $reader = new Xlsx();
    
        $spreadsheet = $reader->load($file);
        $sheet = $spreadsheet->getActiveSheet()->toArray();

        foreach ($sheet as $key => $value) {
            if ($key == 0) continue;

            $namaFile = $this->defaultImage;
            $slug = url_title($value[1], '-', true);

            // Cek Judul
            $dataOld = $this->komikModel->getKomik($slug);
            if ($dataOld['judul'] != $value[1]) {
                $this->komikModel->save([
                    'judul' => $value[1],
                    'penulis' => $value[2],
                    'tahun_rilis' => $value[3],
                    'harga' => $value[4],
                    'dsikon' => $value[5] ?? 0,
                    'stok' => $value[6],
                    'komik_category_id' => $value[7],
                    'slug' => $slug,
                    'cover' => $namaFile
                ]);
            }
        }
        session()->setFlashdata("msg", "Data berhasil diimport!");

        return redirect()->to('/komik');
    }
}