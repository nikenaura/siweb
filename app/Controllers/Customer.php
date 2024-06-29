<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;

class Customer extends BaseController
{
    public function index()
    {
        $crud= new GroceryCrud();
        $crud-> setTable('customer');
        $crud->setLanguage('Indonesian');
        
        
        //Ubah Nama Kolom
        $crud->displayAs(array(
            'name' => 'Nama',
            'gender' => 'L/P',
            'address' => 'Alamat',
            'phone' => 'Telp',
        ));

        // Menampilkan dan Mengubah Kolom
        // $crud->columns(['name', 'no_customer', 'gender', 'address', 'email, phone']);
        //  $crud->unsetColumns(['created_at', 'updated_at', 'deleted_at']); // Pilih salah satu aja
        
        // Filter data yang mau ditampilin
        // $crud->where('deleted_at', null);

        // Data field yang ga dibutuhin pas edit atau nambah data
        //  $crud->unsetAddFields(['created_at', 'updated_at', 'deleted_at']);
        //  $crud->unsetEditFields(['created_at', 'updated_at', 'deleted_at']);

        // Nonaktifin Tombol
        // $crud->unsetAdd(); // Nonaktifin tombol Tambah Data

        $crud->setTheme('datatables');

        $crud->setRule('name', 'Nama', 'required', [
            'required' => '{field} harus diisi!'
        ]);

        $output = $crud->render();

        $data = [
            'title' => 'Data Customer',
            'result' => $output
        ];
        return view('customer/index', $data);

    }
    
}