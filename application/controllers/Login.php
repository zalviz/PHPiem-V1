<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('loginmodel');
		if($this->session->userdata('_islogin')){
			if($this->session->userdata('_isadmin'))
				redirect('backpanel');
			else
				redirect('attendee');
		}
	}

	public function Index()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		if($username != '' && $password != '')
			$this->loginmodel->login();

		if($this->loginmodel->msg == 'Access granted!')
			redirect('backpanel');

		$data['username'] = $username;
		$data['msg'] = $this->loginmodel->msg;
		
		$this->load->view('login', $data);
	}
}