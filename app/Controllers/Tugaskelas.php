<?php

namespace App\Controllers;

class Tugaskelas extends BaseController
{
    public function index()
    {
        return view('welcomeMessage');
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
