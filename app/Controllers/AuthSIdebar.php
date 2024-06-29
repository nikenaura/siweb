<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use \App\Models\UserModel;
use CodeIgniter\I18n\Time;

class AuthSidebar extends Controller
{
    public function indexregister()
    {
        helper(['form']);
        $data = [];

        return view('auth/register', $data);
    }

    public function saveRegister()
    {
        helper(['form']);
        //set rules validation form
        $rules = [
            'username'              => 'required|min_length[3]|max_length[20]',
            'phone'              => 'required|min_length[11]|max_length[15]',
            'password'              => 'required|min_length[6]|max_length[200]',
            'pass_confirm'          => 'matches[password]'
        ];
        
        if ($this->validate($rules)) {
            $model = new UserModel();
            $data = [
                'user_name'         => $this->request->getVar('username'),
                'user_phone'        => $this->request->getVar('phone'),
                'user_password'     => password_hash($this->request->getVar('password'),
                PASSWORD_DEFAULT),
                'user_created_at'   => Time::now('America/Chicago', 'en_US'),
            ];
            $model->save($data);
            return redirect()->to('/login');
        } else {
            $data['validation'] = $this->validator;
            echo view('auth/register', $data);
        }
    }

    public function indexlogin()
    {
        helper(['form']);
        echo view('auth/login');
    }

    public function auth()
    {
        $session = session();
        $model = new UserModel();
        $phone = $this->request->getVar('phone');
        $password = $this->request->getVar('user_password');
        $data = $model->where('user_phone', $phone)->
        orwhere('username', $phone)->first();

        if ($data) {
            $pass = $data['user_password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'user_id'           => $data['id'],
                    'user_name'         => $data['user_name'],
                    'user_phone'        => $data['user_phone'],
                    'user_role'              => $data['role'],
                    'logged_in'         => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/');
            } else {
                $session->setFlashdata('msg', 'Password Salah');
                return redirect()->to('/login')->withInput();
            }
        } else {
            $session->setFlashdata('msg', 'Email atau Username tidak ada');
            return redirect()->to('/login')->withInput();
        }
    }
    
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }

}