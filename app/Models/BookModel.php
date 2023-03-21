<?php  

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    // Nama Tabel
    protected $table        = 'book';
    // Atribut yang digunakan menjadi primary key
    protected $primaryKey   = 'book_id';
    // Atribut untuk menyimpan created_at dan updated_at
    protected $useTimestamps    = true;
    protected $allowedFields = [
        'title', 'slug', 'author', 'release_year', 'price', 'discount',
        'stock', 'cover', 'book_category_id'
    ];

    public function getBook($slug = false)
    {
        $query = $this->table('book')
            ->join('book_category', 'book_category_id');
        
        if ($slug == false)
            return $query->get()->getResultArray();
        return $query->where(['slug' => $slug])->first();
    }
}