<?php  

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // Nama Tabel
    protected $table        = 'pengguna';
    // Atribut yang digunakan menjadi primary key
    protected $primaryKey   = 'id';
    // Atribut untuk menyimpan created_at dan updated_at
    protected $allowedFields = [
        'firstname', 'lastname', 'role', 'user_name',
        'user_email', 'user_password', 'created_at'];

    public function getUsers($id = false)
    {
        $query = $this->select('*');
        // ->where('id', $id);
        if ($id === false) {
            return $query->findAll();
        } else {
            return $query->where(['id' => $id])->first();
        }
    }
}