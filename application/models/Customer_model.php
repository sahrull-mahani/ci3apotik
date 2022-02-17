<?php 

class Customer_model extends CI_Model {
  public function getCustomerDesc()
  {
    return $this->db->order_by('kode_customer', "DESC")->get('tb_customer')->result_array();
  }

  public function saveCustomer()
  {
    $data = [
      'kode_customer' => $this->input->post('kode_customer'),
      'nama_customer' => $this->input->post('nama_customer'),
      'alamat' => $this->input->post('alamat'),
      'telp' => $this->input->post('telp'),
      'faks' => $this->input->post('faks'),
      'email' => $this->input->post('email'),
      'konfir' => 0
    ];
    $this->db->insert('tb_customer', $data);
  }
  
  public function updateCustomer($id)
  {
    $data = [
      'nama_customer' => $this->input->post('nama_customer'),
      'alamat' => $this->input->post('alamat'),
      'telp' => $this->input->post('telp'),
      'faks' => $this->input->post('faks'),
      'email' => $this->input->post('email'),
      'konfir' => 0
    ];
    $this->db->set($data)->where('kode_customer', $id)->update('tb_customer');
  }
}