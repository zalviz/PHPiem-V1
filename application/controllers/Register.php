<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	public function __construct()
	{
		parent::__construct();

		$this->load->model('attendeemodel');
		$this->load->model('appsmodel');
		
		$this->load->library('email');

		$this->load->helper('shortcode');
        
        $config = array();
        $config['charset'] = 'utf-8';
        $config['useragent'] = 'Codeigniter';
        $config['protocol'] = "smtp";
        $config['mailtype'] = "html";
        $config['smtp_host'] = "ssl://smtp.fg-phpindosby.com";
        $config['smtp_port'] = "465";
        $config['smtp_timeout'] = "400";
        $config['smtp_user'] = "info@fg-phpindosby.com";  //Email 
        $config['smtp_pass'] = "illafgsby2017";  //Password Email
        $config['crlf'] = "\r\n"; 
        $config['newline'] = "\r\n"; 
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);
	}

	public function Index()
	{
		if($this->input->post() == null)
		{
			print "Warning: you have no permission to this page!";
			exit;
		}

		if( $this->input->post('email') != '' && 
			$this->input->post('nama') != '' && 
			$this->input->post('nohp') != '' &&
			$this->input->post('alamat') != '' &&
			$this->input->post('kota') != '' &&
			$this->input->post('instansi') != '' &&
			$this->input->post('kategori') != '')
		{
			$msg = $this->attendeemodel->AddNewAttendee();
			if( $msg == 'success: data has been saved!'){
				$this->email->from("info@fg-phpindosby.com");
				$this->email->to($this->input->post('email'));

				$body = extract_shortcode( $this->input->post(), $this->appsmodel('mail_confirm_register') );
				$this->email->message($body);
				$this->email->send();
			}

			print $msg;
			exit;
		} else {
			print "Error: required field cannot blank!";
			exit;
		}
	}
}