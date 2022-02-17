<?php

class Users extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    if (!$this->session->login) {
      redirect('/');
    }
    // session
    $this->data['session'] = $this->db->get_where('user', ['id' => $this->session->id])->row_array();
    
    // cookie
    $this->data['cookie'] = explode("|", $_COOKIE['moso']);
    
    if($this->data['session']['online'] == 0) {
        delete_cookie('moso');
        redirect('/');
        die;
    }
  }

  public function index()
  {
    $data['judul'] = "Daftar Users";
    $data['users'] = $this->db->get_where('user', ['level' => 1])->result_array();
    $data['usersOn'] = $this->db->get_where('user', ['level' => 1, 'online' => 1])->result_array();
    $this->load->view('template/header', $data);
    $this->load->view('users/index', $data);
    $this->load->view('template/footer');
  }

  public function tambah()
  {
    $data['judul'] = "Tambah users.";
    $this->load->view('template/header', $data);
    $this->load->view('users/tambah', $data);
    $this->load->view('template/footer');
  }

  public function tambahUser()
  {
    // set message
    $this->form_validation->set_message('required', "Pastikan anda mengisi kolom %s!");
    $this->form_validation->set_message('valid_email', "Pastikan anda memasukan email yang benar!");
    $this->form_validation->set_message('matches', "Masukan kembali %s anda sesuai dengan di atas!");
    $this->form_validation->set_message('min_length', "Masukan %s minimanl 6 karakter!");
    // set rules
    $this->form_validation->set_rules('nama', 'Nama', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
    $this->form_validation->set_rules('password2', 'Password', 'required|matches[password]');
    if ($this->form_validation->run() == FALSE) {
      $this->tambah();
    } else {
      $pass = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
      $data = [
        'nama'      => $this->input->post('nama'),
        'username'  => $this->input->post('email'),
        'password'  => $pass,
        'pic'       => 'profile.jpg',
        'level'     => 1
      ];
      $this->db->insert('user', $data);
      $this->session->set_flashdata('success', "User berhasil ditambahkan");
      redirect('/users');
    }
  }

  public function hapus($id)
  {
    $this->db->delete('user', ['id' => $id]);
    $this->session->set_flashdata('success', "User berhasil dihapus");
    redirect('/users');
  }

  public function reset($id)
  {
    $pass = password_hash("qwerty12345", PASSWORD_DEFAULT);
    $this->db->set('password', $pass)->where('id', $id)->update('user');
    $this->session->set_flashdata('success', "Password berhasil direset");
    redirect('/users');
  }
}
