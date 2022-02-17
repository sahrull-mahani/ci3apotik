<?php

class Distribusi_model extends CI_Model
{
  public function getInvoice()
  {
    $sql = "SELECT * FROM `tb_invoice` i INNER JOIN `tb_customer` c ON i.kode_customer = c.kode_customer";
    $sql = $this->db->query($sql)->result_array();
    return $sql;
  }

  public function getCustomer()
  {
    return $this->db->get('tb_customer')->result_array();
  }

  public function getAlat()
  {
    return $this->db->get('tb_alat')->result_array();
  }

  public function getSementara()
  {
    $sql = "SELECT * FROM `tb_sementara` s INNER JOIN `tb_alat` a ON s.kode_alat = a.kode_alat";
    $sql = $this->db->query($sql)->result_array();
    return $sql;
  }

  public function getSementaraByID($id)
  {
    $sql = "SELECT * FROM `tb_pesan` p INNER JOIN `tb_alat` a ON p.kode_alat = a.kode_alat WHERE p.kode_customer = '$id'";
    $sql = $this->db->query($sql)->result_array();
    return $sql;
  }

  public function getAlatPesan($kdCus)
  {
    $sql = "SELECT * FROM `tb_pesan` p INNER JOIN `tb_alat` a ON p.kode_alat = a.kode_alat WHERE kode_customer ='$kdCus'";
    $sql = $this->db->query($sql)->result_array();
    return $sql;
  }

  public function getCustomerByID($id)
  {
    return $this->db->get_where('tb_customer', ['kode_customer' => $id])->row_array();
  }

  public function saveProdukSementara()
  {
    $alat = $this->input->post('alatSelect');
    $alat = explode('|', $alat);
    $kode = $alat[0];
    $nama = $alat[1];
    $jumlah = $this->input->post('jumlah');
    $alat = $this->db->get_where('tb_alat', ['kode_alat' => $kode])->row_array();
    $harga = $alat['harga'] * $jumlah;

    // cek jika ada alat yang sama di tabel sementara
    $kodeSM = $this->db->get_where('tb_sementara', ['kode_alat' => $kode])->row_array();
    if($kodeSM > 0) {
      $data = [
        'harga'     => $kodeSM['harga'] + $harga,
        'jumlah'    => $jumlah + $kodeSM['jumlah'],
      ];
      $this->db->set($data)->where('kode_alat', $kode)->update('tb_sementara');
    }else{
      $data = [
        'kode_alat' => $kode,
        'nama_alat' => $nama,
        'harga'     => $harga,
        'disc'      => $this->input->post('disc', true) ? $this->input->post('disc', true) : 0,
        'jumlah'    => $jumlah,
      ];
      $this->db->insert('tb_sementara', $data);
    }
    $this->db->set('stok', $alat['stok'] - $jumlah)->where('kode_alat', $kode)->update('tb_alat');
  }

  public function updateProdukSementara($kodeCus)
  {
    $alat = $this->input->post('alatSelect');
    $alat = explode('|', $alat);
    $kode = $alat[0];
    $nama = $alat[1];
    $jumlah = $this->input->post('jumlah');
    $alat = $this->db->get_where('tb_alat', ['kode_alat' => $kode])->row_array();
    $harga = $alat['harga'] * $jumlah;

    // cek jika ada alat yang sama di tabel sementara
    $kodeSM = $this->db->get_where('tb_pesan', ['kode_alat' => $kode, 'kode_customer' => $kodeCus])->row_array();
    if($kodeSM > 0) {
      $data = [
        'harga'     => $kodeSM['harga'] + $harga,
        'jumlah'    => $jumlah + $kodeSM['jumlah'],
      ];
      $this->db->set($data)->where(['kode_alat' => $kode, 'kode_customer' => $kodeCus])->update('tb_pesan');
    }else{
      $data = [
        'kode_alat' => $kode,
        'nama_alat' => $nama,
        'kode_customer' => $kodeCus,
        'harga'     => $harga,
        'disc'      => $this->input->post('disc', true) ? $this->input->post('disc', true) : 0,
        'jumlah'    => $jumlah,
      ];
      $this->db->insert('tb_pesan', $data);
    }
    $this->db->set(['stok' => $alat['stok'] - $jumlah])->where(['kode_alat' => $kode])->update('tb_alat');
  }
}
