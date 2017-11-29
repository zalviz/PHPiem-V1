<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Eventsmodel extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function event_exists()
	{
		if($this->eid == 0)
			return false;

		$query = $this->db->get_where('events', array('eid' => $this->eid, 'deleted' => false));
		if($query->row() != null)
			return true;
	}

	public function get_event_datas()
	{
		$uid = $this->session->userdata('_userlogin');

		$this->db->select('eid, event_name AS "Event Title", DATE_FORMAT(event_from, "%e %M %Y") AS Date, event_venue AS Venue, status AS Status');
		if ( $uid != 1 )
			$this->db->where('event_owner', $uid);

		$this->db->where('deleted', false);
		$query = $this->db->get('events');
		$results = array();
		foreach ( $query->result_array() as $row ) {
			$fields = array();
			foreach ( $row as $kcolumn => $column ) {
				if ( $kcolumn != 'eid' ){
					if ( $kcolumn == 'event_name' )
						$fields[$kcolumn] = '<a href="' . site_url('/backpanel/event/' . $row['eid']) . '">' . $column . '</a>';
					else
						$fields[$kcolumn] = $column;
				}
			}
			$results[] = $fields;
		}
		return $query->result_array();
	}

	public function get_event()
	{

	}

	public function create_event()
	{
		$exptime = explode( ' - ', $this->input->post('event_time') );
		$time_from = $exptime[0];
		$time_to = $exptime[1];

		$post_data_event = array(
			'event_create' 	=> date('Y-m-d H:i:s'),
			'event_update' 	=> date('Y-m-d H:i:s'),
			'event_owner' 	=> 1,
			'event_name' 	=> $this->input->post('event_name'),
			'event_slug' 	=> url_title($this->input->post('event_name'), 'dash', true),
			'event_venue' 	=> $this->input->post('event_venue'),
			'event_from' 	=> date('Y-m-d H:i:s', strtotime( $time_from ) ),
			'event_to' 		=> date('Y-m-d H:i:s', strtotime( $time_to ) ),
			'short_desc' 	=> $this->input->post('short_desc'),
			'description' 	=> $this->input->post('desc'),
			'deleted' 		=> false,
			'status' 		=> 'Waiting Registration'
		);

		$this->db->trans_begin();
		
		$this->db->insert('events', $post_data_event);
		$ei = $this->db->insert_id();

		if ( $this->input->post('events_meta') )
		{
			$i = 0;
			foreach ($this->input->post('events_meta') as $mk => $mv) {
				$metas = array(
					'event_id' 		=> $ei,
					'meta_name' 	=> $mk,
					'meta_value' 	=> $mv,
					'meta_order' 	=> $i
				);
				$this->db->insert('events_meta');
				$i++;
			}
		}

		if ( $this->db->trans_status() === FALSE )
		{
			$this->db->trans_rollback();
		}
		else
		{
			$this->db->trans_commit();
		}
	}

	public function remove_event()
	{
		$this->deleted = true;
		$this->update_event();
	}

	public function update_event()
	{
		$this->db->update('events', $this, array('eid' => $this->input->eid));
	}

	public function add_event_type()
	{
		$typedata = array(
			'et_name' 	=> $this->input->post('type_name'),
			'et_slug' 	=> $this->input->post('type_slug'),
			'et_parent' => $this->input->post('type_parent'),
			'deleted' 	=> false,
			'status' 	=> $this->input->post('type_status')
		);

		$this->db->insert('events_type', $typedata);
	}

	public function remove_event_type($etid = 0)
	{
		$data = array(
			'deleted' 	=> true
		);
		$this->db->where('etid', $etid);
		$this->db->update('events_type', $data);
	}

	public function update_event_type()
	{
		$typedata = array(
			'et_name' 	=> $this->input->post('type_name'),
			'et_slug' 	=> $this->input->post('type_slug'),
			'et_parent' => $this->input->post('type_parent'),
			'status' 	=> $this->input->post('type_status')
		);
		$this->db->where('etid', $this->eid);
		$this->db->insert('events_type', $typedata);
	}

	public function get_settings($eid, $metaname)
	{
		$this->db->select('meta_value');
		$this->db->where('event_id', $eid);
		$this->db->where('meta_name', $metaname);
		$this->db->from('events_meta');
		$qry = $this->db->get();
		if ( $qry->row_array() != null )
			return $qry->row_array()['meta_value'];
		else
			return '';
	}
}