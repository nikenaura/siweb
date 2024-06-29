<?php

namespace App\Controllers;
use \App\Models\KomikModel;
use \App\Models\SupplierModel;
use \App\Models\BuyModel;
use \App\Models\BuyDetailModel;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Pembelian extends BaseController
{
    private $komik, $cart, $sup, $buy, $buyDetail;
    public function __construct()
    {
        $this->komik = new KomikModel();
        $this->sup = new SupplierModel();
        $this->buy = new BuyModel();
        $this->buyDetail = new BuyDetailModel();
        $this->cart = \Config\Services::cart();
    }

    public function index()
    {
        $this->cart->destroy();
        $dataKomik = $this->komik->getKomik();
        $dataSup = $this->sup->findAll();
        $data=[
            'title' => 'Pembelian',
            'dataKomik' => $dataKomik,
            'dataSup' => $dataSup,
        ];
        return view('pembelian/list', $data);
    }

    public function showCart()
    {
        $output ='';
        $no = 1;
        foreach ($this->cart->contents() as $items) {
            $output .= '
            <tr>
            <td>' . $no++ .'</td>
            <td>' . $items['name'] .'</td>
            <td>' . $items['qty'] .'</td>
            <td>' . number_to_currency ($items['price'], 'IDR', 'id_ID', 2) .'</td>
            <td>' . number_to_currency (($items['subtotal']), 'IDR', 'id_ID', 2)  .'</td>
            <td>
            <button id="' . $items['rowid'] . '" qty="' . $items['qty'] . '"
            class="ubah_cart btn btn-warning btn-xs" title="Ubah Jumlah"><i class="fa fa-edit"></i></button>

            <button type="button" id="' . $items['rowid'] . '" 
            class="hapus_cart btn btn-danger btn-xs">
            <i class="fa fa-trash" title="Hapus"></i></button>
            </td>
            </tr>
            ';
        }

        if (!$this->cart->contents()) {
            $output = '<tr><td colspan="7" align="center">Tidak ada transaksi!</td></tr>';
        }
        return $output;
    }

    public function loadCart()
    {
        echo $this->showCart();
    }

    public function addCart()
    {
        $this->cart->insert(array(
            'id'       => $this->request->getVar('id'),
            'qty'      => $this->request->getVar('qty'),
            'price'    => $this->request->getVar('price'),
            'name'     => $this->request->getVar('name'),
            ));
            echo $this->showCart();
    }

    public function updateCart()
    {
        $this->cart->update(array(
            'rowid'  => $this->request->getVar('rowid'),
            'qty'    => $this->request->getVar('qty')
            
        ));
        echo $this->showCart();
    }

    public function deleteCart($rowid)
    {
        $this->cart->remove($rowid);
        echo $this->showCart();
    }

    public function getTotal()
    {
        $totalBayar = 0;
        foreach ($this->cart->contents() as $items) {
            $totalBayar += $items['subtotal'];
        }
        echo number_to_currency($totalBayar, 'IDR', 'id_ID', 2);
    }

    public function pembayaran()
    {
        if (!$this->cart->contents()){
            //Transaksi kosong
            $response = [
                'status' => false,
                'msg' => "Tidak ada transaksi!",
            ];
            echo json_encode($response);
        } else{
            //Ada transaksi
            $totalBayar = 0;
            foreach ($this->cart->contents() as $items){
                $totalBayar += $items['subtotal'];
            }

            $nominal = $this->request->getVar('nominal');
            $id =  "J".time();

            if ($nominal < $totalBayar){
                $response = [
                    'status' => false,
                    'msg' => "Nominal pembayaran kurang!",
                ];
                echo json_encode($response);
            } else{
                $this->buy->save([
                    'buy_id'=>$id,
                    'user_id'=>session()->user_id,
                    'supplier_id' => $this->request->getVar('id-sup')
                ]);
                foreach($this->cart->contents() as $items){
                    $this->buyDetail->save([
                        'buy_id'=>$id,
                        'komik_id'=>$items['id'],
                        'amount'=>$items['qty'],
                        'price'=>$items['price'],
                        'total_price'=>$items['subtotal']
                    ]);

                    $komik = $this->komik->where(['komik_id' => $items['id']])->first();
                    $this->komik->save([
                            'komik_id' => $items['id'],
                            'stok' => $komik['stok'] + $items['qty'],
                    ]);

                }
                $this->cart->destroy();
                $kembalian = $nominal - $totalBayar;

                $response = [
                    'status' => true,
                    'msg' => "Pembayaran berhasil!",
                    'data' => [
                        'kembalian' => number_to_currency(
                            $kembalian,
                            'IDR', 
                            'id_IDR',
                            2
                        )
                    ]
                ];
                echo json_encode($response);
            }
        }
    }

    public function report($tgl_awal=null, $tgl_akhir=null)
    {
        $_SESSION['tgl_awal'] = $tgl_awal == null ? date('Y-m-01') : $tgl_awal;
        $_SESSION['tgl_akhir'] = $tgl_akhir == null ? date('Y-m-t') : $tgl_akhir;
        
        $tgl1 = $_SESSION['tgl_awal'];
        $tgl2 = $_SESSION['tgl_akhir'];
        
        $report = $this->buy->getReport($tgl1, $tgl2);
        $data = [
            'title'     => 'Laporan Pembelian',
            'result'    => $report,
            'tanggal'   => [
                'tgl_awal'  => $tgl1,
                'tgl_akhir' => $tgl2,
            ],
        ];
        return view('pembelian/report', $data);
    }

    public function reportPembelian($tgl_awal=null, $tgl_akhir=null)
    {
        $_SESSION['tgl_awal'] = $tgl_awal == null ? date('Y-m-01') : $tgl_awal;
        $_SESSION['tgl_akhir'] = $tgl_akhir == null ? date('Y-m-t') : $tgl_akhir;
        
        $tgl1 = $_SESSION['tgl_awal'];
        $tgl2 = $_SESSION['tgl_akhir'];
        
        $report = $this->buy->getReport($tgl1, $tgl2);
        $data = [
            'title'     => 'Laporan Pembelian',
            'result'    => $report,
            'tanggal'   => [
                'tgl_awal'  => $tgl1,
                'tgl_akhir' => $tgl2,
            ],
        ];
        return view('pembelian/reportPembelian', $data);
    }

    public function filter()
    {
        $_SESSION['tgl_awal'] = $this->request->getVar('tgl_awal');
        $_SESSION['tgl_akhir'] = $this->request->getVar('tgl_akhir');
        return $this->report($_SESSION['tgl_awal'], $_SESSION['tgl_akhir']);
    }
    
    public function exportPDF()
    {
        $tgl1 = $_SESSION['tgl_awal'];
        $tgl2 = $_SESSION['tgl_akhir'];

        $report = $this->buy->getReport($tgl1, $tgl2);
        $data = [
            'title'     => 'Laporan pembelian',
            'result'    => $report,
        ];
        $html = view('pembelian/exportPDF', $data);

        $pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->writeHTML($html);
        $this->response->setContentType('application/pdf');
        $pdf->Output('laporan-pembelian.pdf', 'I');
    }

    public function exportExcel()
    {
        $tgl1 = $_SESSION['tgl_awal'];
        $tgl2 = $_SESSION['tgl_akhir'];

        $report = $this->buy->getReport($tgl1, $tgl2);
        $spreadsheet = new Spreadsheet();

        // Tulis header atau nama kolom
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'No')
        ->setCellValue('B1', 'Nota')
        ->setCellValue('C1', 'Tgl_Transaksi')
        ->setCellValue('D1', 'User')
        ->setCellValue('E1', 'Supplier')
        ->setCellValue('F1', 'Total');

        // Tulis data ke cell
        $rows = 2;
        $no = 1;
        foreach ($report as $value) {
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $rows, $no++)
            ->setCellValue('B' . $rows, $value['buy_id'])
            ->setCellValue('C' . $rows, $value['tgl_transaksi'])
            ->setCellValue('D' . $rows, $value['firstname'] . ' ' . $value['lastname'])
            ->setCellValue('E' . $rows, $value['name_sup'])
            ->setCellValue('F' . $rows, $value['total']);
            $rows++;
        }

        // Tulis dalam format .xlsx
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan-Pembelian';

        // Redirect hasil generate xlsx ke web client
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
    }
}