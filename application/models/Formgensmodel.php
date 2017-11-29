<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Formgensmodel extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_form()
	{
		$this->db->select();
		$this->db->where();
		$this->db->from('formgen');
		$fqry = $this->db->get();

		$this->db->select();
		$this->db->where();
		$this->db->from('formgen_element');
		$eqry = $this->db->get();
	}

	public function create_form()
	{
		$frmdt = array(
			'create_date' 	=> now(),
			'form_event_id' => '',
			'form_owner' 	=> '',
			'form_tite' 	=> '',
			'form_class' 	=> '',
			'form_tag_id' 	=> '',
			'form_method' 	=> '',
			'form_action' 	=> '',
			'form_success' 	=> '',
			'form_failed' 	=> '',
			'form_warning' 	=> '',
			'form_deleted' 	=> false,
			'status' 		=> 1
		);

		$this->db->trans_begin();
		
		$this->db->insert('formgen', $frmdt);
		$lid = $this->db->insert_id();

		foreach ($eldts as $el) {
			$eldt = array(
				'elm_form_id' 	=> $lid,
				'elm_label'		=> '',
				'elm_required'	=> '',
				'elm_uid'		=> '',
				'elm_eid'		=> '',
				'elm_class'		=> '',
				'elm_enum'		=> '',
				'elm_warning'	=> ''
			);

			$this->db->insert('formgen_element', $eldt);
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

	public function remove_form()
	{
		$this->db->where('fid', $this->uid);
		$this->db->update('formgen', array('deleted', true));
	}

	public function update_form(){}

	public function forms_exists()
	{
		$eid = $this->userdata->post();
		
	}
}