<?php

namespace App\Controllers;

class Unguided extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Tugas Container'
        ];
        return view('Container', $data);
    }
}
