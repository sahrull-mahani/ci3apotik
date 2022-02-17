<?php 

class Home_model extends CI_Model {

  // Get All Data
  public function getInvoice()
  {
    return $this->db->get('tb_invoice')->result_array();
  }

  public function getProduk()
  {
    return $this->db->get('tb_alat')->result_array();
  }
  
  public function getCustomer()
  {
    return $this->db->get('tb_customer')->result_array();
  }


  // get new 4 data
  public function get4Produk()
  {
    return $this->db->limit(4)->order_by('id', 'DESC')->get('tb_alat')->result_array();
  }

  public function get4Customer()
  {
    return $this->db->limit(4)->order_by('kode_customer', 'DESC')->get('tb_customer')->result_array();
  }
}