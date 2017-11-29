<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('user_agent');
	}

	public function Index()
	{
		$this->session->set_userdata('_isadmin', false);
		$this->session->set_userdata('_islogin', false);
		$this->session->set_userdata('_isactive', false);
		redirect($this->agent->referrer());
	}
}