<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Produk extends CI_Controller
{
  public function __construct() 
  {
    parent::__construct();
    $this->load->model('Produk_model');
    $this->load->helper('Rupiah_helper');
    if (!$this->session->login) {
      redirect('/');
    }
    // session
    $this->data['session'] = $this->db->get_where('user', ['id' => $this->session->id])->row_array();
    
    // cookie
    $this->data['cookie'] = explode("|", $_COOKIE['moso']);

    // total produk
    $this->data['produk'] = $this->db->get('tb_alat')->result_array();
    
    if($this->data['session']['online'] == 0) {
        delete_cookie('moso');
        redirect('/');
        die;
    }

    // set pusher
    require FCPATH . 'vendor/autoload.php';
    $options = array(
      'cluster' => 'ap1',
      'useTLS' => true
    );
    $this->pusher = new Pusher\Pusher(
      'b7a2020658dd085fd51c',
      '79cd32ab75d670f3fd68',
      '1327420',
      $options
    );
  }

  public function index()
  {
    $data['judul'] = "Tambah Produk";
    $data['produk'] = $this->Produk_model->getProdukDesc();
    $data['validations'] = $this->session->flashdata('validations');

    $this->load->view('template/header', $data);
    $this->load->view('produk/index', $data);
    $this->load->view('template/footer');
  }

  // tambah prduk
  public function tambahProduk()
  {
    $data['judul'] = "Tambah produk";

    $this->load->view('template/header', $data);
    $this->load->view('produk/tambah', $data);
    $this->load->view('template/footer');
  }

  // process tambah produk
  public function saveProduk()
  {
    // set message
    $this->form_validation->set_message('required', "Kolom %s Tidak Boleh Kosong");
    $this->form_validation->set_message('is_unique', "Periksa kembali %s anda. yang anda masukan sudah terdaftar!");
    // set rules
    $this->form_validation->set_rules('nama_alat', 'Nama', 'required');
    $this->form_validation->set_rules('kode_alat', 'Kode Alat', 'required|is_unique[tb_alat.kode_alat]');
    $this->form_validation->set_rules('satuan', 'Satuan', 'required');
    $this->form_validation->set_rules('harga', 'Harga', 'required');
    $this->form_validation->set_rules('stok', 'Stok', 'required');

    if ($this->form_validation->run() == FALSE) {
      $this->tambahProduk();
    } else {
      $data['total'] = count($this->data['produk']) + 1;
      $data['message'] = "Produk berhasil ditambahkan";
      $this->pusher->trigger('ci3pusher-test', 'produk', $data);
      $this->Produk_model->saveProduk();
      $this->session->set_flashdata('success', 'Data berhasil ditambahkan');
      redirect('/produk');
    }
  }

  // process update produk
  public function updateProduk($id)
  {
    // set rules
    $this->form_validation->set_rules('nama_alat', 'Nama', 'required', ['required' => "Kolom %s tidak boleh kosong"]);
    $this->form_validation->set_rules('kode_alat', 'Kode Alat', 'required', ['required' => "Kolom %s tidak boleh kosong"]);
    $this->form_validation->set_rules('satuan', 'Satuan', 'required', ['required' => "Kolom %s tidak boleh kosong"]);
    $this->form_validation->set_rules('harga', 'Harga', 'required', ['required' => "Kolom %s tidak boleh kosong"]);
    $this->form_validation->set_rules('stok', 'Stok', 'required', ['required' => "Kolom %s tidak boleh kosong"]);

    if ($this->form_validation->run() == FALSE) {
      $this->session->set_flashdata('validations', validation_errors());
      redirect('/produk');
    } else {
      $this->Produk_model->ubahProduk($id);
      $data['message'] = "Produk berhasil diubah";
      $this->pusher->trigger('ci3pusher-test', 'produk', $data);
      $this->session->set_flashdata('success', 'Data berhasil diupdate');
      redirect('/produk');
    }
  }

  // delete produk
  public function deleteProduk($id)
  {
    $this->db->delete('tb_alat', ['id' => $id]);
    $data['total'] = count($this->data['produk']) - 1;
    $data['message'] = "Produk berhasil diahpus";
    $this->pusher->trigger('ci3pusher-test', 'produk', $data);
    $this->session->set_flashdata('success', 'Data berhasil dihapus');
    redirect('/produk');
  }

  public function exportXL()
  {
    $spreadsheet = new Spreadsheet();

    $spreadsheet->getActiveSheet()
      ->setCellValue('A1', "NAMA ALAT")
      ->setCellValue('B1', "KODE ALAT")
      ->setCellValue('C1', "SATUAN")
      ->setCellValue('D1', "EXPIRED")
      ->setCellValue('E1', "HARGA")
      ->setCellValue('F1', "STOK");

    //freeze pane
    $spreadsheet->getActiveSheet()->freezePane('A2');

    // set Zoom Scale
    $spreadsheet->getActiveSheet()->getSheetView()->setZoomScale(140);

    // alignment
    $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // font
    $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getFont()->setSize(12)->setBold(true);

    // fill
    $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF8C56');

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('A')
      ->setWidth(33);
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('B')
      ->setWidth(10);
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('C')
      ->setWidth(10);
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('D')
      ->setWidth(15);
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('E')
      ->setWidth(12);
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('F')
      ->setWidth(7);

    $col = 2;
    $data = $this->db->get('tb_alat')->result_array();

    foreach ($data as $dt) {
      $spreadsheet->getActiveSheet()
        ->setCellValue("A$col", $dt['nama_alat'])
        ->setCellValue("B$col", $dt['kode_alat'])
        ->setCellValue("C$col", $dt['satuan'])
        ->setCellValue("D$col", $dt['expired'])
        ->setCellValue("E$col", $dt['harga'])
        ->setCellValue("F$col", $dt['stok']);
      $col++;
    }

    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Export Excel Table Produk _' . date("d-m-Y") . '.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    die;
  }

  public function import()
  {
    $data['judul'] = "Import produk";
    $data['validations'] = $this->session->flashdata('validations');

    $this->load->view('template/header', $data);
    $this->load->view('produk/import', $data);
    $this->load->view('template/footer');
  }

  public function importXL()
  {
    $fileUpload = $_FILES['importexcel']['name'];
    $ext = pathinfo($fileUpload, PATHINFO_EXTENSION);
    if ($ext !== "xlsx" && $ext !== 'xls' && $ext !== 'csv') {
      $this->session->set_flashdata('validations', "Pastikan anda memasukan file excel!");
      redirect('/produk/import');
      die;
    }
    if ($ext == 'csv') {
      $render = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
    } elseif ($ext == 'xls') {
      $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
    } else {
      $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    }

    $spreadsheet = $render->load($_FILES['importexcel']['tmp_name']);

    $sheetdata = $spreadsheet->getActiveSheet()->toArray();
    $sheetcount = count($sheetdata);

    if ($sheetcount > 1) {
      $err = 0;
      $suc = 0;
      $dataSave = [];
      foreach ($sheetdata as $data => $row) {
        if ($data == 0) {
          continue;
        }

        $namaAlat = $row[0];
        $kodeAlat = $row[1];
        $satuan = $row[2];
        $expired = $row[3];
        $harga = $row[4];
        $stok = $row[5];

        if ($kodeAlat == null) {
          $this->session->set_flashdata('gagal', "Pastikan kode alat anda tidak kosong!!");
          redirect('/produk/import');
        }

        $cekKDA = $this->db->get_where('tb_alat', ['kode_alat' => $kodeAlat])->result_array();

        if (count($cekKDA) > 0) {
          $err++;
        } else {
          $dataSave[] = [
            'nama_alat'   => $namaAlat,
            'kode_alat'   => $kodeAlat,
            'satuan'      => $satuan,
            'expired'     => $expired,
            'harga'       => $harga,
            'stok'        => $stok
          ];
          $suc++;
        }
      }
      if ($err > 0) {
        $this->session->set_flashdata('gagal', "Periksa kembali data yang anda masukan. " . $err . " gagal di upload. Kode alat belum dimasukan");
        redirect('/produk/import');
      }
      $this->db->insert_batch('tb_alat', $dataSave);
      $this->session->set_flashdata('success', "Data yang berhasil ditambahkan adalah " . $suc);
      $data = [];
      $data['total'] = count($this->data['produk']);
      $data['message'] = "Produk berhasil ditambahkan";
      $this->pusher->trigger('ci3pusher-test', 'produk', $data);
      redirect('/produk');
    }
  }

  public function templateXL()
  {
    $spreadsheet = new Spreadsheet();

    $spreadsheet->getActiveSheet()
      ->setCellValue('A1', "NAMA ALAT")
      ->setCellValue('B1', "KODE ALAT")
      ->setCellValue('C1', "SATUAN")
      ->setCellValue('D1', "EXPIRED")
      ->setCellValue('E1', "HARGA")
      ->setCellValue('F1', "STOK");

    // set Zoom Scale
    $spreadsheet->getActiveSheet()->getSheetView()->setZoomScale(140);

    // alignment
    $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    // font
    $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getFont()->setSize(12)->setBold(true);

    // fill
    $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF76C5D1');

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('A')
      ->setWidth(35);
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('B')
      ->setWidth(20);
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('C')
      ->setWidth(10);
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('D')
      ->setWidth(15);
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('E')
      ->setWidth(17);
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('F')
      ->setWidth(9);

    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Template Import Excel.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    die;
  }
}
