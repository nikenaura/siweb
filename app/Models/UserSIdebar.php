<?php  

namespace App\Models;

use CodeIgniter\Model;

class UserSidebar extends Model
{
    // Nama Tabel
    protected $table        = 'user';
    // Atribut yang digunakan menjadi primary key
    protected $primaryKey   = 'user_id';
    // Atribut untuk menyimpan created_at dan updated_at
    protected $allowedFields = [
        'firstname', 'user_address', 'user_phone',
        'user_name', 'user_password', 'created_at'];

    public function getUsers($id = false)
    {
        $query = $this->select('*');
        // ->where('id', $id);
        if ($id === false) {
            return $query->findAll();
        } else {
            return $query->where(['user_id' => $id])->first();
        }
    }
}