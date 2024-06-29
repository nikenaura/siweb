<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;

class Mahasiswa extends BaseController
{
    public function index()
    {
        $crud= new GroceryCrud();
        $crud->setTable('mahasiswa_1538');
        $crud->setRelation('kategori_favorit', 'book_category', 'name_category');   
        
        $crud->setTheme('datatables');

        $output = $crud->render();

        $data = [
            'title' => 'Data Mahasiswa',
            'result' => $output
        ];
        return view('mahasiswa/index', $data);

    }
    
}