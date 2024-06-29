<?php  

namespace App\Models;

use CodeIgniter\Model;

class BuyModel extends Model
{
    // Nama Tabel
    protected $table        = 'buy';
    // Atribut untuk menyimpan created_at dan updated_at
    protected $useTimestamps    = true;
    protected $allowedFields = [
        'buy_id', 'user_id', 'supplier_id'
    ];

    public function getReport($tgl_awal, $tgl_akhir)
    {
        return $this->db->table('buy_detail as bd')
        ->select('b.buy_id, b.created_at tgl_transaksi, p.id user_id, p.firstname,
        p.lastname, , p.user_name, s.supplier_id, s.name name_sup, s.no_supplier,
        SUM(bd.total_price) total')
        ->join('buy b', 'buy_id')
        ->join('pengguna p', 'p.id = b.user_id')
        ->join('supplier s', 'supplier_id', 'left')
        ->where('date(b.created_at) >=', $tgl_awal)
        ->where('date(b.created_at) <=', $tgl_akhir)
        ->groupBy('b.buy_id')
        ->get()->getResultArray();
    }
}