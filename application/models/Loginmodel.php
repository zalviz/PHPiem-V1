<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 **/
class Loginmodel extends CI_Model
{
	protected $usename = '';
	protected $password = '';
	protected $errorcount = 0;
	public $msg = '';

	public function __construct()
	{
		parent::__construct();
		$this->username = $this->input->post('username');
		$this->password = $this->input->post('password');
		$this->errorcount = $this->session->userdata('errpwd');
	}

	public function login()
	{
		if($this->username != '' && $this->password != '')
		{
			$qry = $this->db->get_where('users', array('login_name' => $this->username));
			if( $qry->row() != null )
			{
				$res = $qry->row();
				if( password_verify($this->password, $res->password) )
				{
					if($res->isadmin)
						$this->session->set_userdata('_isadmin', true);
					
					$loginsession = array(
						'_islogin' 		=> true,
						'_isactive' 	=> true,
						'_userlogin' 	=> $res->uid
					);
					
					$this->session->set_userdata( $loginsession );
					$this->msg = 'Access granted!';
				}
				else {
					if( $this->errorcount >= 5 )
					{
						$this->msg = 'your account has been locked!';
					}
					else {
						$this->session->set_userdata('errpwd', $this->errorcount + 1);
						$this->msg = 'Invalid password, access denied!';
					}
				}
			}
			else {
				$this->msg = 'Username not found, please provide valid username';
			}
		}
		else {
			$this->msg = 'Username and password cannot empty!';
		}
	}
}