<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Attendeemodel extends CI_Model 
{
	protected $uid;
	
	protected $reg_date;
	protected $login_name;
	protected $full_name;
	protected $email;
	protected $city;

	protected $isadmin = false;
	protected $isactive = true;
	protected $deleted = false;
	protected $status = 1;
	protected $usermeta = array();

	public $ticketcode;

	public function __construct()
	{
		parent::__construct();
	}

	public function GetAll()
	{
		$evid = $this->uri->segment(3);

		$this->db->select('users.uid AS "ID", users_order.ticket_code AS "Ticket Code", users.full_name AS "Full Name", DATE_FORMAT(users.reg_date, "%e %M %Y") AS "Register Date", users.email AS Email, users_order.status AS Status');
		$this->db->from('users');
		$this->db->join('users_order', 'users_order.user_id = users.uid', 'left');
		$this->db->where('users_order.event_id', $evid);
		$this->db->where('users_order.deleted', false);
		$this->db->where_not_in('users_order.status', 'Batal');


		$qry = $this->db->get();
		return $qry->result_array();
	}

	public function GetMetaAttendee($uid, $name = '')
	{
		$results = [];

		$this->db->select('umid, meta_name, meta_value');
		$this->db->from('users_meta');
		$this->db->where('user_id', $uid);
		if ( $name != '' ) {
			$this->db->where('meta_name', $name);
			$qry = $this->db->get();
			$results = $qry->row();
		} else {
			$qry = $this->db->get();
			$results = $qry->result_array();
		}

		return $results;
	}

	public function AddNewAttendee($ticketcode = '')
	{
		if ( $this->CekEmail() )
			return 'error: email exists!';

		$this->db->trans_begin();

		$this->usermeta = array(
			'handphone'	=> $this->input->post('nohp'),
			'alamat' 	=> $this->input->post('alamat'),
			'instansi'	=> $this->input->post('instansi'),
			'kategori'	=> $this->input->post('kategori')
		);

		$datuser = array(
			'reg_date' 		=> date('Y-m-d H:i:s'),
			'login_name' 	=> $this->input->post('email'),
			'full_name' 	=> $this->input->post('nama'),
			'email' 		=> $this->input->post('email'),
			'city' 			=> $this->input->post('kota'),
			'isactive'		=> true,
			'isadmin' 		=> false,
			'deleted'		=> false,
			'status'		=> 'Active'
		);

		$this->db->insert('users', $datuser);
		$lid = $this->db->insert_id();

		$i = 0;
		foreach ($this->usermeta as $mk => $mv) 
		{
			$mdata = array();
			
			$mdata['user_id'] 		= $lid;
			$mdata['meta_name'] 	= $mk;
			$mdata['meta_value'] 	= $mv;
			$mdata['meta_order'] 	= $i;

			$this->db->insert('users_meta', $mdata);
			$i++;
		}



		$order = array(
			'user_id' => $lid,
			'event_id' => 1,
			'ticket_code' => ( $ticketcode == '') ? $this->ticketcode : $ticketcode,
			'order_date' => date('Y-m-d H:i:s'),
			'deleted' => false,
			'status' => 'Waiting Payment'
		);

		if($this->usermeta['kategori'] === 'student')
		{
			$order['price'] = 75000;
		} else {
			$order['price'] = 100000;
		}

		$this->db->insert('users_order', $order);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return 'error: database error!';
		}
		else
		{
			$this->db->trans_commit();
			return 'success: data has been saved!';
		}
	}

	public function CekEmail()
	{
		$qry = $this->db->get_where('users', array('email' => $this->input->post('email')));
		return $qry->num_rows() > 0;
	}

	public function forscanner($evid = 0, $kodeticket = '')
	{
		$evid = ( $evid == 0 ) ? $this->uri->segment(3) : $evid;
		$kodeticket = ( $kodeticket == '' ) ? $this->input->post('ticket_code') : $kodeticket;
		$kodeticket = explode(':', $kodeticket);

		if (is_array($kodeticket) && count($kodeticket) >= 2)
			$kodeticket = $kodeticket[1];

		$this->db->select('users.uid AS ID');
		$this->db->select('users.full_name AS "Full Name"');
		$this->db->select('DATE_FORMAT(users.reg_date, "%e %M %Y %k:%i WIB") AS "Register Date"');
		$this->db->select('users.email AS Email');
		$this->db->select('users.city AS City');
		$this->db->select('users_order.ticket_code AS "Ticket Code"');
		$this->db->select('DATE_FORMAT(users_order.order_date, "%e %M %Y %k:%i WIB") AS "Order Date"');
		$this->db->select('DATE_FORMAT(users_order.paid_date, "%e %M %Y %k:%i WIB") AS "Paid Date"');
		$this->db->select('DATE_FORMAT(users_order.attend_date, "%e %M %Y %k:%i WIB") AS "Venue Entrance"');
		$this->db->select('users_order.status AS "Order Status"');

		$this->db->from('users');
		$this->db->join('users_order', 'users_order.user_id = users.uid', 'right');
		$this->db->where('users_order.event_id', $evid);
		$this->db->where('users_order.ticket_code', strtoupper($kodeticket));
		$this->db->where('users_order.deleted', false);

		$qry = $this->db->get();
		$results = (array)$qry->row();

		if ( $results != null )
			return json_encode(['success' => true, 'info' => $results]);
		else
			return json_encode(['success' => false, 'info' => $kodeticket]);
	}

	public function updatescanner()
	{
		$sour = $this->input->get('src');
		if ( $sour == 'scanner' ){
			switch ($this->input->get('sec')) {
				case 'entrance-venue':
					$object = [
						'attend_date' 	=> date('Y-m-d H:i:s'),
						'status' 		=> 'Venue Entrance'
					];
					$this->db->where('ticket_code', $this->input->get('code'));
					$this->db->update('users_order', $object);
					return json_encode(['success' => true, 'info' => 'Congratulation and welcome to the event!']);
					break;
				case 'payment-accepted':
					$object = [
						'paid_date' 	=> date('Y-m-d H:i:s'),
						'attend_date' 	=> date('Y-m-d H:i:s'),
						'status' 		=> 'Payment Accepted'
					];
					$this->db->where('ticket_code', $this->input->get('code'));
					$this->db->update('users_order', $object);
					return json_encode(['success' => true, 'info' => 'Congratulation and welcome to the event!']);
					break;
				default:
					return json_encode(['success' => false, 'info' => '']);
					break;
			}
		} else {
			return json_encode(['success' => false, 'info' => '']);
		}
	}

	public function attendee_details($kodeticket = '')
	{
		$kodeticket = ( $kodeticket == '' ) ? $this->uri->segment(6) : $kodeticket;
		$evid = (int)$this->uri->segment(3);

		$this->db->select('users.uid');
		$this->db->select('users.full_name AS "fullname"');
		$this->db->select('DATE_FORMAT(users.reg_date, "%e %M %Y") AS "regdate"');
		$this->db->select('users.email');
		$this->db->select('users.city');
		$this->db->select('users_order.ticket_code');
		$this->db->select('DATE_FORMAT(users_order.order_date, "%e %M %Y %k:%i WIB") AS order_date');
		$this->db->select('DATE_FORMAT(users_order.paid_date, "%e %M %Y %k:%i WIB") AS order_paid');
		$this->db->select('DATE_FORMAT(users_order.attend_date, "%e %M %Y %k:%i WIB") AS order_pickup');
		$this->db->select('users_order.status AS order_status');
		$this->db->select('events.event_name');

		$this->db->from('users');
		$this->db->join('users_order', 'users_order.user_id = users.uid', 'right');
		$this->db->join('events', 'events.eid = users_order.event_id', 'right');

		if ( $evid != 0 ) 
			$this->db->where('users_order.event_id', $evid);

		$this->db->where('users_order.ticket_code', strtoupper($kodeticket));
		$this->db->where('users_order.deleted', false);

		$qry = $this->db->get();
		$results = (array)$qry->row();

		if ( $results != null ){
			$metas = $this->GetMetaAttendee($results['uid']);
			foreach ($metas as $k => $v) {
				$results[$v['meta_name']] = $v['meta_value'];
			}
		}
		return $results;
	}

	public function generate_ticket($kodeticket)
	{
		$this->db->select('events.event_name, 
							events.event_venue,
							DATE_FORMAT(events.event_from, "%M %e, %Y on %H.%i WIB") AS event_from,
							events.description,
							users.full_name,
							users.email,
							users.city,
							users_order.ticket_code');

		$this->db->from('users_order');
		$this->db->join('users', 'users_order.user_id = users.uid', 'left');
		$this->db->join('events', 'users_order.event_id = events.eid', 'right');
		$this->db->where('users_order.ticket_code', strtoupper($kodeticket));
		$this->db->where('users_order.deleted', false);
		$this->db->where_not_in('users_order.status', 'Batal');

		$qry = $this->db->get();
		$res = $qry->result_array();
		if ( $res != null )
			return $res[0];
		else
			return;
	}

	public function update_user_order($ticketcode, $data)
	{
		$this->db->update('users_order', $data, array('ticket_code' => $ticketcode));
	}
}