<?php  

namespace App\Models;

use CodeIgniter\Model;

class KomikModel extends Model
{
    // Nama Tabel
    protected $table        = 'komik';
    // Atribut yang digunakan menjadi primary key
    protected $primaryKey   = 'komik_id';
    // Atribut untuk menyimpan created_at dan updated_at
    protected $useTimestamps    = true;
    protected $allowedFields = [
        'judul', 'slug', 'tahun_rilis', 'penulis', 'harga', 'diskon',
        'stok', 'cover', 'komik_category_id'
    ];

    public function getKomik($slug = false)
    {
        $query = $this->table('komik')
            ->join('komik_category', 'komik_category_id');
        
        if ($slug == false)
            return $query->get()->getResultArray();
        return $query->where(['slug' => $slug])->first();
    }
}