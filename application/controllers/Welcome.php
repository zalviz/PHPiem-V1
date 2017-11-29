<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends PHPIEM_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = array(
			'email' 	=> $this->input->post('email'),
			'nama' 		=> $this->input->post('nama'),
			'nohp' 		=> $this->input->post('nohp'),
			'alamat'	=> $this->input->post('alamat'),
			'kota' 		=> $this->input->post('kota'),
			'instansi' 	=> $this->input->post('instansi'),
			'kategori' 	=> $this->input->post('kategori')
		);

		$data['kategori_options'] = array('' => 'Who you are?', 'student' => 'Student', 'developer' => 'Developer');

		if( $this->input->post('email') != '' && 
			$this->input->post('nama') != '' && 
			$this->input->post('nohp') != '' &&
			$this->input->post('alamat') != '' &&
			$this->input->post('kota') != '' &&
			$this->input->post('instansi') != '' &&
			$this->input->post('kategori') != ''){
			
			$this->load->model('attendeemodel');
			$cod = $this->_generate_code_ticket();
			$this->attendeemodel->$ticketcode = $cod;
			$this->attendeemodel->AddNewAttendee();
			$this->_email_event_confirmation('confirmation_register', $cod);
		}
			
		$this->load->view('frontpage', $data);
	}
}
