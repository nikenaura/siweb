<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;

class Supplier extends BaseController
{
    public function index()
    {
        $crud= new GroceryCrud();
        $crud-> setTable('supplier');
        $crud->setLanguage('Indonesian');
        
        //Ubah Nama Kolom
        $crud->displayAs(array(
            'name' => 'Nama',
            'gender' => 'L/P',
            'address' => 'Alamat',
            'phone' => 'Telp',
        ));

        $crud->setTheme('datatables');

        $crud->setRule('name', 'Nama', 'required', [
            'required' => '{field} harus diisi!'
        ]);

        $output = $crud->render();

        $data = [
            'title' => 'Data Supplier',
            'result' => $output
        ];
        return view('supplier/index', $data);

    }
    
}