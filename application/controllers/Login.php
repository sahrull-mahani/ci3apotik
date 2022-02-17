<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		if ($this->session->login) {
			redirect('/home');
			die;
		} elseif (isset($_COOKIE['moso'])) {
			$id = explode('|', $_COOKIE['moso']);

			// set session
			$data = [
				'id'		=> $id['1'],
				'login'	=> true
			];
			$res = $this->db->get_where('user', ['id' => $id['1']])->row_array();
			if ($res['online'] == 0) {
				delete_cookie('moso');
				redirect('/');
				die;
			}
			$this->session->set_userdata($data);
			redirect('/home');
			die;
		}

		// set pusher js
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
		$this->load->view('login/index');
	}

	public function process()
	{
		// set message
		$this->form_validation->set_message('required', "Kolom %s tidak boleh kosong!");
		$this->form_validation->set_message('valid_email', "Pastikan anda memasukan email yang valid!");
		$this->form_validation->set_message('min_length', "Minimal %s 6 karakter!");

		// set rules
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

		if ($this->form_validation->run() == FALSE) {
			$this->index();
		} else {
			$user = $this->input->post('email');
			$pass = $this->input->post('password');

			$res = $this->db->get_where('user', ['username' => $user])->row_array();

			if (count($res) > 0) {
				if (password_verify($pass, $res['password'])) {
					if ($res['online'] == 0) {
						// set session
						$data = [
							'id'		=> $res['id'],
							'login'	=> true
						];
						$this->session->set_userdata($data);

						// set cookie
						$name   = 'moso';
						// 	$expire = time() + (60 * 60) + 120; //test 
						$expire = time() + (60 * 60) + (60 * 60 * 24 * 7); // expired 7 hari
						$value  = hash('sha256', $res['id']) . "|" . $res['id'] . '|' . $expire;
						$path  = '/';

						setcookie($name, $value, $expire, $path);

						// set online
						$this->db->set('online', 1)->where('id', $res['id'])->update('user');

						$total = $this->db->get_where('user', ['online' => 1, 'level' => 1])->result_array();
						$total = count($total);

						$data['message'] = $res['id'];
						$data['total'] = $total;
						$this->pusher->trigger('ci3pusher-test', 'login', $data);

						redirect('/home');
					} else {
						$this->session->set_flashdata('gagal', "User saat ini sedang online!");
						redirect('/');
					}
				} else {
					$this->session->set_flashdata('gagal', "Password anda salah!");
					redirect('/');
				}
			} else {
				$this->session->set_flashdata('gagal', "Username yang anda masukan salah!");
				redirect('/');
			}
		}
	}
}
