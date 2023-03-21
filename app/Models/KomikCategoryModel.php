<?php  

namespace App\Models;

use CodeIgniter\Model;

class KomikCategoryModel extends Model
{
    // Nama Tabel
    protected $table        = 'komik_category';
    // Atribut yang digunakan menjadi primary key
    protected $primaryKey   = 'komik_category_id';
}