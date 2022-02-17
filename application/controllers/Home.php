<?php

class Home extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    date_default_timezone_set('Asia/Jakarta');
    $this->load->model('Home_model');
    $this->load->helper(['rupiah_helper', 'timepass_helper', 'timepass_hour_helper']);

    if (!$this->session->login) {
      redirect('/');
    }
    // session
    $this->data['session'] = $this->db->get_where('user', ['id' => $this->session->id])->row_array();

    // cookie
    $this->data['cookie'] = explode("|", $_COOKIE['moso']);

    if ($this->data['session']['online'] == 0) {
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
    $data['judul'] = "Halaman Admin.";
    // get All Data
    $data['invoice'] = $this->Home_model->getInvoice();
    $data['produk'] = $this->Home_model->getProduk();
    $data['customer'] = $this->Home_model->getCustomer();

    // get new 4 data
    $data['produk4'] = $this->Home_model->get4Produk();
    $data['customer4'] = $this->Home_model->get4Customer();
    $this->load->view('template/header', $data);
    $this->load->view('home/beranda', $data);
    $this->load->view('template/footer');
  }

  public function chat()
  {
    $sql = "SELECT * FROM `chat` c INNER JOIN `user` u ON c.id_user = u.id ORDER BY c.id ASC";
    $data['pesan'] = $this->db->query($sql)->result_array();
    $this->load->view('home/chat', $data);
  }

  public function countchat()
  {
    $pesan = $this->input->post('pesan');
    if (!$pesan) {
      $this->session->set_flashdata('warning', "Anda tidak punya akses!!");
      redirect('/');
      die;
    }

    if (isset($_COOKIE['pesan'])) {
      $pesan = $_COOKIE['pesan'] + $pesan;
    }

    $nama = 'pesan';
    $value = $pesan;
    $expire = time() + (60 * 60 * 24 * 30); // expired 30 hari
    $path  = '/';

    setcookie($nama, $value, $expire, $path);
    echo $pesan;
  }

  public function countlesschat()
  {
    $id = $this->input->post('id');
    if (!$id) {
      $this->session->set_flashdata('warning', "Anda tidak punya akses!!");
      redirect('/');
      die;
    }
    delete_cookie('pesan');
  }

  public function sendchat()
  {
    $pesan = htmlspecialchars($this->input->post('pesan'));
    $id = $this->input->post('id');
    $time = time() + (60 * 60);

    if (!$pesan) {
      echo 0;
      die;
    }

    $this->db->insert('chat', ['id_user' => $id, 'pesan' => $pesan, 'time' => $time]);
    echo 1;
  }

  public function truncateChat()
  {
    $id = $this->input->post('id');
    if (!$id) {
      $this->session->set_flashdata('warning', "Anda tidak punya akses masuk kesini!");
      redirect('/home');
      die;
    }
    $this->db->truncate('chat');
    echo 1;
    if (isset($_COOKIE['pesan'])) {
      delete_cookie('pesan');
    }
    $data['message'] = "Chat telah dibersihkan";
    $data['clear'] = 1;
    $this->pusher->trigger('ci3pusher-test', 'all', $data);
  }

  public function cusDet()
  {
    $data['customer4'] = $this->Home_model->get4Customer();
    $this->load->view('home/cus', $data);
  }

  public function proDet()
  {
    $data['produk4'] = $this->Home_model->get4Produk();
    $this->load->view('home/pro', $data);
  }

  public function tambahwaktulogin()
  {
    $expire = $this->data['cookie']['2'] + (60 * 60 * 24 * 2);
    $value  = hash('sha256', $this->data['session']['id']) . "|" . $this->data['session']['id'] . '|' . $expire;
    setcookie('moso', $value, $expire, '/');
    echo date('d M Y H:i:s', $expire);
  }

  public function changePass()
  {
    $data['judul'] = "Ganti Pass.";
    $this->load->view('template/header', $data);
    $this->load->view('home/changePass', $data);
    $this->load->view('template/footer');
  }

  public function updateProfil()
  {
    $this->form_validation->set_message('max_size', "Minimal ukuran gamabr yg diupload 1MB!");

    $config['upload_path']          = './assets/img/upload';
    $config['allowed_types']        = 'jpeg|jpg|png';
    $config['max_size']             = '1000';
    $config['file_name']            = $this->data['session']['nama'];
    $this->load->library('upload', $config);
    $this->upload->overwrite = true;
    if ($this->upload->do_upload('upload')) {
      $fileUpload = $_FILES['upload']['name'];
      $ext = pathinfo($fileUpload, PATHINFO_EXTENSION);
      $data = [
        'pic' => 'upload/' . str_replace(' ', '_', $this->data['session']['nama']) . '.' . $ext
      ];
      $this->db->set($data)->where('id', $this->data['session']['id'])->update('user');
      $this->session->set_flashdata('success', "Gambar profil berhasil diganti");
      redirect('/home');
    } else {
      $this->session->set_flashdata('gagal', "Maksimal file yang bisa di upload adalah 1MB!");
      redirect('/home/changePass');
    }
  }

  public function update()
  {
    // set message
    $this->form_validation->set_message('required', "Pastikan anda mengisi kolom %s!");
    $this->form_validation->set_message('matches', "Masukan kembali %s anda sesuai dengan di atas!");
    $this->form_validation->set_message('min_length', "Masukan %s minimanl 6 karakter!");
    $this->form_validation->set_message('alpha', "Pastikan anda memasukan huruf alfabet!");
    // set rules
    $this->form_validation->set_rules('nama', 'Nama', 'alpha');
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
    $this->form_validation->set_rules('password2', 'Password', 'required|matches[password]');
    if ($this->form_validation->run() == FALSE) {
      $this->changePass();
    } else {
      $data = [
        'nama'      => $this->input->post('nama') ? $this->input->post('nama', true) : $this->data['session']['nama'],
        'password'  => password_hash($this->input->post('password', true), PASSWORD_DEFAULT)
      ];
      $this->db->set($data)->where('id', $this->data['session']['id'])->update('user');
      $this->session->set_flashdata('success', "Password berhasil diubah");
      redirect('/home');
    }
  }

  public function logout()
  {
    $total = $this->db->get_where('user', ['online' => 1, 'level' => 1])->result_array();
    $total = count($total);

    $data['message'] = $this->data['session']['id'];
    $data['total'] = $total - 1;
    $this->pusher->trigger('ci3pusher-test', 'login', $data);

    # for spesific session
    $this->session->unset_userdata('login');
    $this->session->unset_userdata('id');

    # for all session
    $this->session->sess_destroy();

    // set offline
    $this->db->set('online', 0)->where('id', $this->data['session']['id'])->update('user');

    // delete cookie
    delete_cookie('moso');

    redirect('/');
  }
}
