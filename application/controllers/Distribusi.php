<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class Distribusi extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Distribusi_model');
    $this->load->helper('Rupiah_helper');
    $this->load->helper('Tanggal_indo_helper');
    if (!$this->session->login) {
      redirect('/');
    }
    // session
    $this->data['session'] = $this->db->get_where('user', ['id' => $this->session->id])->row_array();
    
    // cookie
    $this->data['cookie'] = explode("|", $_COOKIE['moso']);

    // total customer
    $this->data['distribusi'] = $this->db->get('tb_invoice')->result_array();
    
    if($this->data['session']['online'] == 0) {
        delete_cookie('moso');
        redirect('/');
        die;
    }
    
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
    $data['judul'] = "Distriusi.";
    $data['distribusi'] = $this->Distribusi_model->getInvoice();
    $this->load->view('template/header', $data);
    $this->load->view('distribusi/index', $data);
    $this->load->view('template/footer');
  }

  public function jumlahStok()
  {
    $alat = $this->input->post('alat');
    $result = $this->db->get_where('tb_alat', ['kode_alat' => $alat])->row_array();

    if ($result) {
      echo $result['stok'] . "|" . $result['harga'];
    } else {
      echo "--- Pilih Produk";
    }
  }

  public function tambah()
  {
    $data['judul'] = "Tambah barang";
    $data['dataAlat'] = $this->Distribusi_model->getAlat();
    $data['dataSementaraAlat'] = $this->Distribusi_model->getSementara();
    $data['dataCustomer'] = $this->Distribusi_model->getCustomer();
    $this->load->view('template/header', $data);
    $this->load->view('distribusi/tambah', $data);
    $this->load->view('template/footer');
  }

  public function tambahProduk()
  {
    // print_r($this->Distribusi_model->saveProdukSementara());die;
    // set message
    $this->form_validation->set_message('required', "Pastikan anda mengisi kolom %s!");
    $this->form_validation->set_message('is_unique', "%s yang anda masukan sudah terdaftar!");
    $this->form_validation->set_message('numeric', "Pastikan anda memasukan nomor!");
    $this->form_validation->set_message('valid_email', "Pastikan anda memasukan email yang benar!");
    $this->form_validation->set_message('max_length', "Maksimal 2 angka!");
    // set rules
    $this->form_validation->set_rules('alatSelect', 'Produk', 'required');
    $this->form_validation->set_rules('stok', 'Stok', 'numeric');
    $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
    $this->form_validation->set_rules('disc', 'Diskon', 'numeric|max_length[2]');
    if ($this->form_validation->run() == FALSE) {
      $this->tambah();
    } else {
      $this->Distribusi_model->saveProdukSementara();
      $this->session->set_flashdata('sucToast', "Data berhasil ditambahkan");
      redirect('/distribusi/tambah');
      $data['total'] = count($this->data['distribusi']);
      $data['message'] = "Distribusi berhasil ditambahkan";
      $this->pusher->trigger('ci3pusher-test', 'distribusi', $data);
    }
  }

  // hapus produk dari table sementara {Di Halaman Tambah}
  public function hapus($id)
  {
    $alat = $this->db->get_where('tb_alat', ['kode_alat' => $id])->result_array();
    $sementara = $this->db->get_where('tb_sementara', ['kode_alat' => $id])->result_array();
    $this->db->set('stok', $alat[0]['stok'] + $sementara[0]['jumlah'])->where('kode_alat', $id)->update('tb_alat');
    $this->db->delete('tb_sementara', ['kode_alat' => $id]);
    $this->session->set_flashdata('sucToast', "Data berhasil dihapus!");
    redirect('/distribusi/tambah');
  }

  public function simpan()
  {
    $customer = $this->input->post('customer');

    if (!$customer) {
      $this->session->set_flashdata('warning', "Anda tidak punya akses masuk kesini!");
      redirect('/home');
      die;
    }

    $this->db->set('konfir', 1)->where('kode_customer', $customer)->update('tb_customer');

    // total alat
    $sementara = $this->db->get('tb_sementara')->result_array();

    for ($i = 0; $i < count($sementara); $i++) {
      $total[$i] = $sementara[$i]['jumlah'];
    }

    $total = array_sum($total);

    // buat tanggal sekarang
    $tanggal = date("d/") . bulanIni() . "/" . date("Y");

    // Buat Invoice
    $invoice = "INV/" . date("d") . "/" . $customer . "/" . substr("000{$total}", -3) . "/" . random_int(1, 1000);

    $data = [
      'kode_customer' => $customer,
      'jumlah_alat'   => $total,
      'tanggal'       => $tanggal,
      'invoice'       => $invoice
    ];

    // pindahkan dari table sementara ke tabel pesan
    $this->db->query("INSERT INTO tb_pesan (kode_alat, nama_alat, kode_customer, harga, disc, jumlah) SELECT kode_alat, nama_alat, '$customer', harga, disc, jumlah FROM tb_sementara");

    $this->db->insert('tb_invoice', $data);
    $this->db->truncate('tb_sementara');
    $data['total'] = count($this->data['distribusi']) + 1;
    $data['message'] = "Distribusi berhasil ditambah";
    $this->pusher->trigger('ci3pusher-test', 'distribusi', $data);
    echo "berhasil";
  }

  public function hapusInv($id)
  {
    $data['total'] = count($this->data['distribusi']) - 1;
    $data['message'] = "Distribusi berhasil dihapus";
    $this->pusher->trigger('ci3pusher-test', 'distribusi', $data);
    $this->db->set('konfir', 0)->where('kode_customer', $id)->update('tb_customer');
    $this->db->delete('tb_invoice', ['kode_customer' => $id]);
    $this->db->delete('tb_pesan', ['kode_customer' => $id]);
    $this->session->set_flashdata('success', "Data berhasil dihapus");
    redirect('/distribusi');
  }

  public function edit($id)
  {
    $sql = $this->Distribusi_model->getCustomerByID($id);
    $data['judul'] = "Edit barang";
    $data['dataAlat'] = $this->Distribusi_model->getAlat();
    $data['dataSementaraAlat'] = $this->Distribusi_model->getSementaraByID($id);
    $data['dataCustomer'] = $this->Distribusi_model->getCustomer();
    $data['kodeCustomer'] = $id;
    $data['namaCustomer'] = @$sql['nama_customer'];
    $this->load->view('template/header', $data);
    $this->load->view('distribusi/edit', $data);
    $this->load->view('template/footer');
  }

  public function editProduk()
  {
    $kodeCus = $this->input->post('kodeCustomer');

    // set message
    $this->form_validation->set_message('required', "Pastikan anda mengisi kolom %s!");
    $this->form_validation->set_message('is_unique', "%s yang anda masukan sudah terdaftar!");
    $this->form_validation->set_message('numeric', "Pastikan anda memasukan nomor!");
    $this->form_validation->set_message('valid_email', "Pastikan anda memasukan email yang benar!");
    $this->form_validation->set_message('max_length', "Maksimal 2 angka!");
    // set rules
    $this->form_validation->set_rules('alatSelect', 'Produk', 'required');
    $this->form_validation->set_rules('stok', 'Stok', 'numeric');
    $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|numeric');
    $this->form_validation->set_rules('disc', 'Diskon', 'numeric|max_length[2]');
    if ($this->form_validation->run() == FALSE) {
      $this->edit($kodeCus);
    } else {
      $this->Distribusi_model->updateProdukSementara($kodeCus);
      $this->session->set_flashdata('sucToast', "Data berhasil ditambahkan");
      redirect("/distribusi/edit/$kodeCus");
    }
  }

  public function hapusEdit($kdAlat, $kdCus)
  {
    $alat = $this->db->get_where('tb_alat', ['kode_alat' => $kdAlat])->result_array();
    $pesan = $this->db->get_where('tb_pesan', ['kode_alat' => $kdAlat, 'kode_customer' => $kdCus])->result_array();
    $this->db->set('stok', $alat[0]['stok'] + $pesan[0]['jumlah'])->where('kode_alat', $kdAlat)->update('tb_alat');
    $this->db->delete('tb_pesan', ['kode_alat' => $kdAlat, 'kode_customer' => $kdCus]);
    $this->session->set_flashdata('sucToast', "Data berhasil dihapus!");
    redirect("/distribusi/edit/$kdCus");
  }

  public function simpanEdit()
  {
    $customer = $this->input->post('customer');

    if (!$customer) {
      $this->session->set_flashdata('warning', "Anda tidak punya akses masuk kesini!");
      redirect('/home');
      die;
    }

    // total alat
    $pesan = $this->db->get_where('tb_pesan', ['kode_customer' => $customer])->result_array();

    for ($i = 0; $i < count($pesan); $i++) {
      $total[$i] = $pesan[$i]['jumlah'];
    }

    $total = array_sum($total);

    $this->db->set(['jumlah_alat' => $total])->where('kode_customer', $customer)->update('tb_invoice');
    echo "berhasil";;
  }

  public function invoice($kdCus)
  {
    $jumlahPesan = $this->db->get_where('tb_pesan', ['kode_customer' => $kdCus])->result_array();
    $max = 10;
    $tot = ceil(count($jumlahPesan) / $max);
    $sql = "SELECT * FROM `tb_pesan` p INNER JOIN `tb_customer` c ON p.kode_customer = c.kode_customer INNER JOIN `tb_invoice` i ON c.kode_customer = i.kode_customer WHERE p.kode_customer = '$kdCus'";
    $query = $this->db->query($sql)->row_array();

    $data['judul'] = "Invoice $kdCus";
    $data['max']   = $max;
    $data['tot']   = $tot;
    $data['dataCustomer'] = $query;
    $data['jumlahPesan'] = $jumlahPesan;
    $data['kdCus']  = $kdCus;

    $this->load->view('distribusi/invoice', $data);
  }

  public function excel($kdCus)
  {
    $pesan = $this->db->get_where('tb_pesan', ['kode_customer' => $kdCus])->result_array();
    $jlhPesan = count($pesan);

    $sql = "SELECT * FROM `tb_pesan` p INNER JOIN `tb_customer` c ON p.kode_customer = c.kode_customer INNER JOIN `tb_invoice` i ON c.kode_customer = i.kode_customer WHERE p.kode_customer = '$kdCus'";
    $data = $this->db->query($sql)->row_array();

    $n = 0;
    foreach ($pesan as $row) {
      $n++;
      $ttl = $row['harga'] * $row['jumlah'] - ($row['disc'] / 100) * $row['harga'] * $row['jumlah'];
      $total[$n] = $ttl;
    }

    $spreadsheet = new Spreadsheet();

    // jumlah maximal data tampil
    $max = 10;

    // total looping dibulatkan keatas
    $tot = ceil($jlhPesan / $max);
    $rowCount = 0;

    $loop = 1;

    for ($i = 1; $i <= $tot; $i++) {

      // HEADER
      $spreadsheet->getActiveSheet()
        ->setCellValue('A' . $loop, "PT MAKNA KARYA SELARAS")
        ->setCellValue('A' . ($loop + 1), "Trading & Logistik")
        ->setCellValue('A' . ($loop + 2), "Jl. Kalimantan")
        ->setCellValue('A' . ($loop + 3), "Liluwo, Gorontalo 96126")
        ->setCellValue('F' . ($loop + 2), "Telp:")
        ->setCellValue('F' . ($loop + 3), "Faks:")
        ->setCellValue('G' . ($loop + 2), "(0435) - 833628")
        ->setCellValue('G' . ($loop + 3), "(0435) - 833628")
        ->setCellValue('A' . ($loop + 4), "Kepada:")
        ->setCellValue('A' . ($loop + 5), "Alamat:")
        ->setCellValue('B' . ($loop + 4), $data['nama_customer'])
        ->setCellValue('B' . ($loop + 5), $data['alamat'])
        ->setCellValue('D' . ($loop + 4), "Telp:")
        ->setCellValue('D' . ($loop + 5), "Faks:")
        ->setCellValue('D' . ($loop + 6), "Email:")
        ->setCellValue('E' . ($loop + 4), $data['telp'])
        ->setCellValue('E' . ($loop + 5), empty($data['faks']) ? '-' : $data['faks'])
        ->setCellValue('E' . ($loop + 6), $data['email'])
        ->setCellValue('F' . ($loop + 4), "No Faktur:")
        ->setCellValue('F' . ($loop + 5), "Jatuh Tempo:")
        ->setCellValue('F' . ($loop + 6), "Kontak:")
        ->setCellValue('H' . ($loop + 4), $data['invoice'])
        ->setCellValue('H' . ($loop + 5), "")
        ->setCellValue('H' . ($loop + 6), "APOTEK")
        ->setCellValue('A' . ($loop + 8), "Tanggal")
        ->setCellValue('B' . ($loop + 8), "No. Item")
        ->setCellValue('C' . ($loop + 8), "Deksripsi")
        ->setCellValue('F' . ($loop + 8), "Jlh")
        ->setCellValue('G' . ($loop + 8), "Harga + PPN")
        ->setCellValue('H' . ($loop + 8), "Diskon")
        ->setCellValue('J' . ($loop + 8), "Total");

      $row = 9 + $loop;
      // menampilkan data Pesan 
      $sql3 = "SELECT * FROM `tb_pesan` p INNER JOIN `tb_alat` a ON p.kode_alat = a.kode_alat WHERE p.kode_customer = '$kdCus' LIMIT $rowCount, $max";
      // $query3 = $this->db->table("tb_pesan")->join("tb_alat", "tb_pesan.kode_alat = tb_alat.kode_alat")->limit($max, $rowCount)->where('kode_customer', $kdCus)->get()->getResultArray();
      $query3 = $this->db->query($sql3)->result_array();
      foreach ($query3 as $baris) {
        $spreadsheet->getActiveSheet()
          ->setCellValue('A' . $row, $baris['expired'])
          ->setCellValue('B' . $row, strtoupper($baris['kode_alat']))
          ->setCellValue('C' . $row, ucwords($baris['nama_alat']))
          ->setCellValue('F' . $row, $baris['jumlah'])
          ->setCellValue('G' . $row, rupiah($baris['harga']))
          ->setCellValue('H' . $row, $baris['disc'] == 0 ? '0 %' : $baris['disc'] . ' %')
          ->setCellValue('J' . $row, rupiah($baris['jumlah'] * $baris['harga'] - ($baris['disc'] / 100) * $baris['jumlah'] * $baris['harga']));

        // Merge Cell
        $spreadsheet->getActiveSheet()->mergeCells('B' . ($loop + 5) . ':C' . ($loop + 6));
        $spreadsheet->getActiveSheet()->mergeCells("E" . ($loop + 6) . ":E" . ($loop + 7));
        $spreadsheet->getActiveSheet()->mergeCells("F" . ($loop + 4) . ":G" . ($loop + 4));
        $spreadsheet->getActiveSheet()->mergeCells("F" . ($loop + 5) . ":G" . ($loop + 5));
        $spreadsheet->getActiveSheet()->mergeCells("F" . ($loop + 6) . ":G" . ($loop + 6));
        $spreadsheet->getActiveSheet()->mergeCells("C" . ($loop + 8) . ":E" . ($loop + 8));
        $spreadsheet->getActiveSheet()->mergeCells("H" . ($loop + 8) . ":I" . ($loop + 8));
        $spreadsheet->getActiveSheet()->mergeCells("J" . ($loop + 8) . ":M" . ($loop + 8));
        $spreadsheet->getActiveSheet()->mergeCells("C" . $row . ":E" . $row);
        $spreadsheet->getActiveSheet()->mergeCells("H" . $row . ":I" . $row);
        $spreadsheet->getActiveSheet()->mergeCells("J" . $row . ":M" . $row);

        // Alignment
        $spreadsheet->getActiveSheet()->getStyle('B' . ($loop + 5) . ':C' . ($loop + 6))->getAlignment()->setVertical(Alignment::VERTICAL_TOP)->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('E' . ($loop + 6) . ':E' . ($loop + 7))->getAlignment()->setVertical(Alignment::VERTICAL_TOP)->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('F' . ($loop + 2) . ':F' . ($loop + 3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('D' . ($loop + 4) . ':D' . ($loop + 6))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('F' . ($loop + 4) . ':F' . ($loop + 6))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('C' . ($loop + 8))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('G' . ($loop + 8))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('H' . ($loop + 8))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('J' . ($loop + 8))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('J' . ($loop + 8) . ':J' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $spreadsheet->getActiveSheet()->getStyle('H' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // set Borders
        $spreadsheet->getActiveSheet()->getStyle('A' . ($loop + 8) . ':M' . ($loop + 8))->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('00000000'));
        $spreadsheet->getActiveSheet()->getStyle('A' . ($loop + 8) . ':M' . ($loop + 8))->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('00000000'));

        // set Font
        $spreadsheet->getActiveSheet()->getStyle('A' . ($loop))->getFont()->setSize(40);
        $spreadsheet->getActiveSheet()->getStyle('A' . ($loop + 8) . ':J' . ($loop + 8))->getFont()->setBold(true);

        $row++;
      }

      $loop = $loop + 29;
      $rowCount = $rowCount + $max;
    }

    // =============== TOTAL ============================
    $spreadsheet->getActiveSheet()->setCellValue('G' . $row, "Subtotal Faktur");
    $spreadsheet->getActiveSheet()->setCellValue('A' . ($row), "Rekening BCA: An PT. MAKNA 797 5516 385");
    $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 1), "Rekening Mandiri: An PT. MAKNA 150 00 1610394");
    $spreadsheet->getActiveSheet()->setCellValue('G' . ($row + 2), "Total");
    $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 3), "Admin");
    $spreadsheet->getActiveSheet()->setCellValue('C' . ($row + 3), "Penerima");
    $spreadsheet->getActiveSheet()->setCellValue('A' . ($row + 6), "Yuli");
    $spreadsheet->getActiveSheet()->setCellValue('C' . ($row + 6), "....................");

    $spreadsheet->getActiveSheet()->setCellValue('J' . $row, rupiah(array_sum($total)));
    $spreadsheet->getActiveSheet()->setCellValue('J' . ($row + 2), rupiah(array_sum($total)));

    $spreadsheet->getActiveSheet()->mergeCells("J" . $row . ":M" . $row);
    $spreadsheet->getActiveSheet()->mergeCells("J" . ($row + 2) . ":M" . ($row + 2));

    $spreadsheet->getActiveSheet()->getStyle('A10:J' . ($row + 7))->getFont()->setSize(38)->setName('Arial');
    $spreadsheet->getActiveSheet()->getStyle('A' . ($row) . ':A' . ($row + 1))->getFont()->setSize(32)->setName('Arial');

    $spreadsheet->getActiveSheet()->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    $spreadsheet->getActiveSheet()->getStyle('G' . ($row + 2))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

    $spreadsheet->getActiveSheet()->getStyle('A' . $row . ':M' . $row)->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('00000000'));
    // =============== /.TOTAL ============================

    // set Zoom Scale
    $spreadsheet->getActiveSheet()->getSheetView()->setZoomScale(50);

    // Set no gridlines
    $spreadsheet->getActiveSheet()->setShowGridlines(False);

    // font
    $spreadsheet->getActiveSheet()->getStyle('A2:M9')->getFont()->setSize(38)->setName('Arial');

    // set Paper
    $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);
    $spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);
    $spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(0);
    // set margins
    $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.748031);
    $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.23622);
    $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.23622);
    $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.748031);
    $spreadsheet->getActiveSheet()->getPageMargins()->setHeader(0.314961);
    $spreadsheet->getActiveSheet()->getPageMargins()->setFooter(0.314961);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('A')
      ->setWidth(40);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('B')
      ->setWidth(37);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('C')
      ->setWidth(44);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('D')
      ->setWidth(23);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('E')
      ->setWidth(65);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('F')
      ->setWidth(15);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('G')
      ->setWidth(47);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('H')
      ->setWidth(22);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('I')
      ->setWidth(9);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('J')
      ->setWidth(9);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('K')
      ->setWidth(9);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('L')
      ->setWidth(9);

    // LEBAR KOLOM
    $spreadsheet->getActiveSheet()
      ->getColumnDimension('M')
      ->setWidth(20);

    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Print Faktur {' . $kdCus . '}.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    die;
  }
}
