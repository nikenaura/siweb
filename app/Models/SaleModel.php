<?php  

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    // Nama Tabel
    protected $table        = 'sale';
    // Atribut untuk menyimpan created_at dan updated_at
    protected $useTimestamps    = true;
    protected $allowedFields = [
        'sale_id', 'user_id', 'customer_id'
    ];

    public function getReport($tgl_awal, $tgl_akhir)
    {
        return $this->db->table('sale_detail as sd')
        ->select('s.sale_id, s.created_at tgl_transaksi, p.id user_id, p.firstname,
        p.lastname, , p.user_name, c.customer_id, c.name name_cust, c.no_customer,
        SUM(sd.total_price) total')
        ->join('sale s', 'sale_id')
        ->join('pengguna p', 'p.id = s.user_id')
        ->join('customer c', 'customer_id', 'left')
        ->where('date(s.created_at) >=', $tgl_awal)
        ->where('date(s.created_at) <=', $tgl_akhir)
        ->groupBy('s.sale_id')
        ->get()->getResultArray();
    }
}