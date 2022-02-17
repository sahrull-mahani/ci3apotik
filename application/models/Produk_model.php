<?php 

class Produk_model extends CI_Model {
  
  public function getProdukDesc()
  {
    return $this->db->order_by('id', 'DESC')->get('tb_alat')->result_array();
  }
  
  // save Data
  public function saveProduk()
  {
    // mengembalikan format harga menjadi angka biasa
    $harga = explode(",", $this->input->post('harga', true));
    $harga = explode(" ", $harga[0]);
    $harga = explode(".", $harga[1]);
    for ($i = 0; $i < count($harga); $i++) {
      $harga[$i];
    }
    $harga = implode($harga);
    $data = [
      'nama_alat' => $this->input->post('nama_alat', true),
      'kode_alat' => $this->input->post('kode_alat', true),
      'satuan' => $this->input->post('satuan', true),
      'expired' => $this->input->post('expired', true),
      'harga' => $harga,
      'stok' => $this->input->post('stok', true)
    ];
    $this->db->insert('tb_alat', $data);
  }

  public function ubahProduk($id)
  {
    // mengembalikan format harga menjadi angka biasa
    $harga = explode(",", $this->input->post('harga', true));
    $harga = explode(" ", $harga[0]);
    $harga = explode(".", $harga[1]);
    for ($i = 0; $i < count($harga); $i++) {
      $harga[$i];
    }
    $harga = implode($harga);
    $data = [
      'nama_alat' => $this->input->post('nama_alat', true),
      'kode_alat' => $this->input->post('kode_alat', true),
      'satuan' => $this->input->post('satuan', true),
      'expired' => $this->input->post('expired', true),
      'harga' => $harga,
      'stok' => $this->input->post('stok', true)
    ];
    $this->db->set($data)->where('id', $id)->update('tb_alat');
  }
}