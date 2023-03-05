<?php

namespace App\Controllers;

class Tugas extends BaseController
{
    public function index()
    {
        return view('welcome');
    }

    public function data_diri()
    {
        return view('data_diri');
    }

    public function pengalaman_organisasi()
    {
        return view('pengalaman_org');
    }
}
