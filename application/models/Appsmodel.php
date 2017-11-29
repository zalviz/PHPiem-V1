<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Appsmodel extends CI_Model 
{
	public $ticket_code;

	public function __construct()
	{
		parent::__construct();
	}

	public function get_option($key, $autoload = 'yes')
	{
		$this->db->select('option_value');
		$this->db->from('appsettings');
		$this->db->where('option_name', $key);
		$this->db->where('autoload', $autoload);
		$qry = $this->db->get();

		return ($qry->num_rows() == 0) ? '' : $qry->row()->option_value;
	}

	public function get_options($keys = [], $like = false)
	{
		$this->db->select('option_name ,option_value');
		$this->db->from('appsettings');

		if (! is_array($keys) && $like)
			$this->db->like('option_name', str_replace('%', '', $keys));

		if (is_array($keys))
			$this->db->where_in('option_name', $keys);

		$qry = $this->db->get();
		return $qry->result_array();
	}

	public function add_option($key, $value = '')
	{
		if(!is_array($key)){
			$this->db->select('option_value');
			$this->db->from('appsettings');
			$this->db->where('option_name', $key);
			$qry = $this->db->get();

			$dv = array('option_name' => $key, 'option_value' => $value, 'autoload' => 'yes');

			if($qry->num_rows() == 0){
				$this->db->insert('appsettings', $dv);
			}
			else{
				$this->db->where('option_name', $key);
				$this->db->update('appsettings', $dv);
			}
		}
		else
			$this->_add_bulk($key);
	}

	public function update_option($key, $value)
	{
		$this->add_option($key, $value);
	}

	public function remove_option($key)
	{
		$this->db->where('option_name', $key);
		$this->db->delete('appsettings');
	}

	public function updatemenu($location)
	{
		// $menus = array(
		// 	array(
		// 		'label' => 'Dashboard',
		// 		'slug' => 'dashboard',
		// 		'icon' => 'tasks',
		// 		'href' => 'backpanel',
		// 		'children' => array(
		// 			'type' => '',
		// 			'label' => 'Children',
		// 			'slug' => 'children',
		// 			'icon' => 'file-o',
		// 			'href' => 'href'
		// 		)
		// 	)
		// );

		$this->update_option('menu_' . $location, serialize($menus));
	}

	public function getmenu($location)
	{
		$menu = unserialize($this->get_option('menu_' . $location));
		$menu['activemenu'] = $this->uri->segment(3);
		$menu['activechild'] = $this->uri->segment(4);
		return $menu;
	}

	private function _add_bulk($keys)
	{
		$check = array_keys($keys);
		$this->db->select('option_name');
		$this->db->from('appsettings');
		$this->db->where_in('option_name', $check);
		$qry = $this->db->get();

		$checks = array();

		if($qry->num_rows() != 0){
			foreach ($qry->result() as $row) {
				$checks[] = $row->option_name;
			}
		}

		$vdata = array();
		foreach ($keys as $k => $v) {
			if($checks == null && !in_array($k, $checks))
				$vdata[] = array('option_name' => $k, 'option_value' => $v, 'autoload' => 'yes');
		}
		$this->db->insert_batch('appsettings', $vdata);
	}

	private function _get_bulk($keys)
	{
		$this->db->select('option_name');
		$this->db->from('appsettings');
		$this->db->where_in('option_name', $keys);
		$qry = $this->db->get();

		$result = array();

		if($qry->num_rows() != 0){
			foreach ($qry->result() as $row) {
				$result[$row->option_name] = $row->option_value;
			}
		}
		return $result;
	}

	private function _remove_bulk($keys)
	{
		$this->db->where_in('option_name', $keys);
		$this->db->delete('appsettings');
	}

	public function oldregister()
	{
		$qry = $this->db->get('register');
		return $qry->result_array();
	}

	public function migrasidata($user, $meta, $order)
	{
		$this->db->trans_begin();
		$this->db->insert('users', $user);
		$lid = $this->db->insert_id();

		$i = 0;
		foreach ($meta as $mk => $mv) 
		{
			$mdata = array();
			
			$mdata['user_id'] 		= $lid;
			$mdata['meta_name'] 	= $mk;
			$mdata['meta_value'] 	= $mv;
			$mdata['meta_order'] 	= $i;

			$this->db->insert('users_meta', $mdata);
			$i++;
		}

		$order['user_id'] = $lid;

		$this->db->insert('users_order', $order);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}
	}

	public function loadallticketcode($eid)
	{
		$this->db->select('ticket_code');
		$this->db->where('event_id', $eid);
		$this->db->where('status', 'Payment Accepted');
		$this->db->from('users_order');
		$qry = $this->db->get();
		$res = [];
		if ( $qry->result_array() != null ){
			foreach ( $qry->result_array() as $key => $value) {
				$res[] = $value['ticket_code'];
			}
		}
		return $res;
	}
}