<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $dataUser = $this->userModel->getUsers();
        $data = [
            'title'     => 'Data User',
            'result'    => $dataUser
        ];
        return view('user/index', $data);
    }

    public function create()
    {
        session();
        $data = [
            'title'     => 'Tambah User',
            // 'validation' => \Config\Services::validation()
        ];
        return view('user/create', $data);
    }

    public function save()
    {
        //Validasi Input
        // if (!$this->validate([
        //     'firstname' => [
        //         'rules' => 'required|is_unique[pengguna.firstname]',
        //         'label' => 'Nama Depan',
        //         'errors' => [
        //             'required' => '{field} harus diisi',
        //             'is_unique' => '{field} hanya sudah ada'
        //         ]
        //     ],
        //     'lastname' => [
        //         'rules' => 'required|is_unique[pengguna.lastname]',
        //         'label' => 'Nama Belakang',
        //         'errors' => [
        //             'required' => '{field} harus diisi',
        //             'is_unique' => '{field} hanya sudah ada'
        //         ]
        //     ],
        //     'user_name' => [
        //         'rules' => 'required|is_unique[pengguna.user_name]',
        //         'label' => 'Username',
        //         'errors' => [
        //             'required' => '{field} harus diisi',
        //             'is_unique' => '{field} hanya sudah ada'
        //         ]
        //     ],
        //     'user_email' => [
        //         'rules' => 'required|is_unique[pengguna.user_email]',
        //         'label' => 'Email',
        //         'errors' => [
        //             'required' => '{field} harus diisi',
        //             'is_unique' => '{field} hanya sudah ada'
        //         ]
        //     ],
        //     'user_password' => [
        //         'rules' => 'required|is_unique[pengguna.user_password]',
        //         'label' => 'Password',
        //         'errors' => [
        //             'required' => '{field} harus diisi',
        //             'is_unique' => '{field} hanya sudah ada'
        //         ]
        //     ]
        // ])) {
        //     return redirect()->to('/user/create')->withInput();
        // }

        $user_myth = new UserModel();
        $user_myth->save([
            'firstname'     => $this->request->getVar('firstname'),
            'user_name'     => $this->request->getVar('user_name'),
            'user_address'    => $this->request->getVar('user_address'),
            'user_phone'    => $this->request->getVar('user_phone'),
            'user_role'          => $this->request->getVar('user_role'),
            'user_password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ]);

        session()->setFlashdata("msg", "Data berhasil ditambahkan");
        return redirect()->to('/user');
    }

    public function edit($id)
    {
        $dataUser = $this->userModel->getUsers($id);
        $data = [
            'title'     => 'Ubah User',
            'validation' => \Config\Services::validation(),
            'result'    => $dataUser
        ];
        return view('user/edit', $data);
    }

    public function update($id)
    {
        $user_myth = new UserModel();
        $user_myth->save([
            'id'            => $id,
            'firstname'     => $this->request->getVar('firstname'),
            'user_address'    => $this->request->getVar('address'),
            'user_phone'    => $this->request->getVar('phone'),
            'user_name'     => $this->request->getVar('username'),
            'user_role'          => $this->request->getVar('role'),
        ]);

        session()->setFlashdata('msg', 'Berhasil memperbaharui user');
        return redirect()->to('/user');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata("msg", "Data berhasil dihapus!");
        return redirect()->to('/user');
    }
}