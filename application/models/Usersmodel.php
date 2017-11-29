<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usersmodel extends CI_Model 
{
	protected $uid = 0;
	protected $logname = '';
	protected $password = '';
	protected $fullname = '';
	protected $email = '';
	protected $city = '';
	protected $isadmin = false;
	protected $isactive = false;
	protected $formkey = '';
	protected $isdeleted = false;
	protected $userstat = 0;
	protected $usermeta = array();

	public function __construct()
	{
		parent::__construct();
	}

	public function get_attendee($uid = null)
	{
		$this->db->select('*');
		$this->db->where('uid', $uid);
		$this->db->not_where('deleted', $this->isdeleted);
		$this->db->from('users');
		$qry = $this->get();
		$atts = $qry->row();

		$this->db->select('*');
		$this->db->where('user_id', $uid);
		$this->db->from('users_meta');
		$qry = $this->get();
		$atts['usermeta'] = $qry->result();

		return $atts;
	}
	
	public function add_attendee()
	{
		return $this->_adduser();
	}

	public function add_admin()
	{
		$this->isactive = true;
		$this->isadmin = true;
		return $this->_adduser();
	}

	public function remove_user()
	{
		$this->db->where('user_id', $this->uid);
		$this->db->update('users', array('isdeleted', true));
	}

	public function update_user()
	{
		
	}

	public function user_login()
	{
		$logname = $this->input->post('uname');
		$logpwd = $this->input->post('upwd');

		$this->db->select('login_name, password, email');
		$this->db->from('users');
		$this->db->where('login_name', $logname);
		$qry = $this->db->get();
		$result = $qry->row();

		if( $result === NULL ) return false;

		if( password_verify($logpwd != $result->password) ) return false;

		return $result;
	}

	private function _userexists()
	{
		$this->db->select('login_name, email, password');
		$this->db->from('users');
		$this->db->where('login_name', $this->logname);
		$this->db->or_where('email', $this->email);
		$qry = $this->db->get();
		return $qry->row();
	}

	private function _genpwd($pwdstr)
	{
		return password_hash($pwdstr, PASSWORD_BCRYPT);
	}

	private function _updateuser()
	{
		$data = array(
			'complete_name' => $this->fullname,
			'city' => $this->city
		);

		$this->db->where('user_id', $this->uid);
		$this->db->update('users', $data);
	}

	private function _updatemeta()
	{
		$this->db->trans_begin();
		foreach ($this->usermeta as $mdata) {
			$this->db->where('user_id', $this->uid);
			$this->db->update('users_meta', $mdata);
		}
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
	}

	private function _adduser()
	{
		$data = array(
			'reg_date' => date('Y-m-d H:i:s'),
			'login_name' => $this->logname,
			'password' => $this->_genpwd($this->password),
			'complete_name' => $this->fullname,
			'email' => $this->email,
			'city' => $this->city,
			'isadmin' => $this->isadmin,
			'isactive' => $this->isactive,
			'formkey' => $this->formkey,
			'deleted' => $this->isdeleted,
			'status' => $this->userstat
		);

		$this->db->trans_begin();
		
		$this->db->insert('users', $data);
		$lid = $this->db->insert_id();

		foreach ($this->usermeta as $mdata) {
			$mdata['user_id'] = $lid;
			$this->db->insert('users_meta', $mdata);
		}

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}
	}
}