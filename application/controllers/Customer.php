<?php

class Customer extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Customer_model');
    if (!$this->session->login) {
      redirect('/');
    }
    // session
    $this->data['session'] = $this->db->get_where('user', ['id' => $this->session->id])->row_array();
    
    // cookie
    $this->data['cookie'] = explode("|", $_COOKIE['moso']);

    // total customer
    $this->data['customer'] = $this->db->get('tb_customer')->result_array();
    
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
    $data['judul'] = "Customer";
    $data['customer'] = $this->Customer_model->getCustomerDesc();
    $data['validations'] = $this->session->flashdata('validations');

    $this->load->view('template/header', $data);
    $this->load->view('customer/index', $data);
    $this->load->view('template/footer');
  }

  public function tambah()
  {
    $data['judul'] = "Tambah Customer";

    $this->load->view('template/header', $data);
    $this->load->view('customer/tambah', $data);
    $this->load->view('template/footer');
  }

  public function simpan()
  {
    // set message
    $this->form_validation->set_message('required', "Pastikan anda mengisi kolom %s!");
    $this->form_validation->set_message('is_unique', "%s yang anda masukan sudah terdaftar!");
    $this->form_validation->set_message('numeric', "Pastikan anda memasukan nomor!");
    $this->form_validation->set_message('valid_email', "Pastikan anda memasukan email yang benar!");
    // set rules
    $this->form_validation->set_rules('kode_customer', 'Kode Customer', 'required|is_unique[tb_customer.kode_customer]');
    $this->form_validation->set_rules('nama_customer', 'Nama Customer', 'required');
    $this->form_validation->set_rules('alamat', 'Alamat', 'required');
    $this->form_validation->set_rules('telp', 'Telepon', 'required|numeric');
    $this->form_validation->set_rules('faks', 'Faks', 'required|numeric');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    if ($this->form_validation->run() == FALSE) {
      $this->tambah();
    } else {
      $data['total'] = count($this->data['customer']) + 1;
      $data['message'] = "Customer berhasil ditambahkan";
      $this->pusher->trigger('ci3pusher-test', 'customer', $data);
      $this->Customer_model->saveCustomer();
      $this->session->set_flashdata('success', "Data berhasil ditambahkan");
      redirect('/customer');
    }
  }

  public function ubah()
  {
    // set message
    $this->form_validation->set_message('required', "Pastikan anda mengisi kolom %s!");
    $this->form_validation->set_message('numeric', "Pastikan anda memasukan nomor!");
    $this->form_validation->set_message('valid_email', "Pastikan anda memasukan email yang benar!");
    // set rules
    $this->form_validation->set_rules('kode_customer', 'Kode Customer', 'required');
    $this->form_validation->set_rules('nama_customer', 'Nama Customer', 'required');
    $this->form_validation->set_rules('alamat', 'Alamat', 'required');
    $this->form_validation->set_rules('telp', 'Telepon', 'required|numeric');
    $this->form_validation->set_rules('faks', 'Faks', 'required|numeric');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    if ($this->form_validation->run() == FALSE) {
      $this->session->set_flashdata('validations', validation_errors());
      redirect('/customer');
    } else {
      $data['message'] = "Customer berhasil diubah";
      $this->pusher->trigger('ci3pusher-test', 'customer', $data);
      $this->Customer_model->updateCustomer($this->input->post('kode_customer'));
      $this->session->set_flashdata('success', "Data berhasil diubah");
      redirect('/customer');
    }
  }

  public function delete($id)
  {
    $data['total'] = count($this->data['customer']) - 1;
    $data['message'] = "Customer berhasil dihapus";
    $this->pusher->trigger('ci3pusher-test', 'customer', $data);
    $this->db->delete('tb_customer', ['kode_customer' => $id]);
    $this->session->set_flashdata('success', "Data berhasil dihapus");
    redirect('/customer');
  }

  public function reset($id)
  {
    $pass = password_hash("qwerty12345", PASSWORD_DEFAULT);
    $this->db->set('password', $pass)->where('id', $id)->update('user');
    $this->session->set_flashdata('success', "User berhasil di reset");
    redirect('/users');
  }
}
