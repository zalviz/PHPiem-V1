<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * backpanel management
 */
class Backpanel extends PHPIEM_Controller
{
	/**
	 * constructor
	 * @return mixed $this
	 */
	public function __construct()
	{
		parent::__construct();
		if (!$this->islogin || !$this->isactive)
			redirect('login');
	}

	/**
	 * index pages
	 * @return  string url: /backpanel
	 */
	public function Index()
	{
		$data['pagetitle'] = 'Dashboard';
		$this->renderpage('admin/dashboard', $data);
	}

	/**
	 * events pages
	 * @return string url: /backpanel/events
	 */
	public function events()
	{
		$this->load->model('eventsmodel');
		$this->load->helper('panel');

		$dtc['contents'] = $this->eventsmodel->get_event_datas();
		$dtc['idtbl'] = 'datatable-buttons';
		$dtc['clstbl'] = 'table table-striped table-bordered';
		$dtc['dturl'] = site_url('backpanel/event');
		$dtc['colink'] = 1;
		$dtc['dcolink'] = 0;

		$dat['ci'] = $this;
		$dat['content'] = $this->_createdatatable($dtc);
		$dat['label'] = "Event List";
		$data['content'] = create_panel($dat);
		$this->renderpage('admin/plain-page', $data);
	}

	public function event()
	{
		if ( ! $this->session->userdata('_eventid') 
			&& $this->session->userdata('_eventid') != (int)$this->uri->segment(3) 
			&& $this->eventid == 0 )
		{
			$this->session->set_userdata( '_eventid', (int)$this->uri->segment(3) );
			$this->eventid = (int)$this->uri->segment(3);
		}

		if ( ! $this->uri->segment(3) ) {
			if ( $this->eventid != 0 )
				redirect('/backpanel/event/' . $this->eventid, 'refresh');

			redirect('/backpanel/events', 'refresh');
		}

		if ( is_int( (int)$this->uri->segment(3) ) )
		{
			$this->_manage_event();
		}
		else 
		{
			$this->_save_event();
		}
	}

	public function Page()
	{
		switch ($this->uri->segment(3)) {
			case 'create':
				break;
			case 'save':
				# code...
				break;
			case 'delete':
				# code...
				break;
			case 'view':
				# code...
				break;
			case 'update':
				# code...
				break;
			default:
				break;
		}
	}

	public function User()
	{
		switch ($this->uri->segment(3)) {
			case 'new':
				# code...
				break;
			case 'add':
				# code...
				break;
			case 'delete':
				# code...
				break;
			case 'view':
				# code...
				break;
			case 'update':
				# code...
				break;
			default:
				# code...
				break;
		}
	}

	public function site_settings()
	{
		$this->load->helper(array('formgen', 'card'));

		/*
		 * url: /backpanel/site-settings/$i
		 * redirect ke url: /backpanel/events
		 */
		switch ($this->uri->segment(3)) {
			case 'general':
				$data['content'] = '';
				$data['pagetitle'] = 'General Settings';
				$this->renderpage('admin/plain-page', $data);
				break;
			case 'email':
				$data['content'] = '';
				$data['pagetitle'] = 'Email Settings';
				$this->renderpage('admin/plain-page', $data);
				break;
			case 'email-template':
				$data['content'] = '';
				$data['pagetitle'] = 'Email Templates';
				$this->renderpage('admin/plain-page', $data);
				break;
			case 'ticket-template':
				$data['content'] = '';
				$data['pagetitle'] = 'Ticket Templates';
				$this->renderpage('admin/plain-page', $data);
				break;
			case 'about':
				$data['content'] = '';
				$data['pagetitle'] = 'About PHP Indonesia Event Management';
				$this->renderpage('admin/plain-page', $data);
				break;
			default:
				redirect(site_url('/backpanel/site-settings/general'),'refresh');
				break;
		}
	}

	private function _manage_event()
	{
		switch ($this->uri->segment(4)) {
			/*
			 * url: /backpanel/event/$i/checkin
			 * scanner untuk chekin ticket event
			 */
			case 'checkin':
				$this->_scanner();
				break;

			/*
			 * url: /backpanel/event/$i/attendee
			 * tabel peserta event
			 */
			case 'attendee':
				$this->_attendee();
				break;

			/*
			 * url: /backpanel/event/$i/feedback
			 * tabel feedback
			 */
			case 'feedback':
				$this->_feedback();
				break;

			/*
			 * url: /backpanel/event/$i/forms
			 * tabel form
			 */
			case 'forms':
				$this->_forms();
				break;

			/*
			 * url: /backpanel/event/$i/forms
			 * tabel form
			 */
			case 'tab':
				$this->_tab();
				break;

			/*
			 * url: /backpanel/event/$i/settings
			 * untuk mengatur event
			 */
			case 'settings':
				$this->_settings();
				break;

			/*
			 * url: /backpanel/event/event-type
			 * untuk mengatur event
			 */
			case 'event-type':
				$this->_settings();
				break;

			/*
			 * url: /backpanel/event/
			 * redirect ke url: /backpanel/events
			 */
			default:
				$this->_eventdashboard();
				break;
		}
	}

	private function _eventdashboard()
	{
		$data['pagetitle'] = 'Event Dashboards';
		$this->renderpage('admin/dashboard', $data);
	}

	private function _checkin()
	{
	}

	private function _attendee()
	{
		switch ($this->uri->segment(5)) {
			case 'new':
				$formdata = array(
					'email' 	=> $this->input->post('email'),
					'nama' 		=> $this->input->post('nama'),
					'nohp' 		=> $this->input->post('nohp'),
					'alamat'	=> $this->input->post('alamat'),
					'kota' 		=> $this->input->post('kota'),
					'instansi' 	=> $this->input->post('instansi'),
					'kategori' 	=> $this->input->post('kategori')
				);

				$msg = $this->session->flashdata('addnewresult');

				if ( $msg != null )
				{
					if ( 'success: data has been saved!' == $msg )
					{
						$formdata = array(
							'email' 	=> '',
							'nama' 		=> '',
							'nohp' 		=> '',
							'alamat'	=> '',
							'kota' 		=> '',
							'instansi' 	=> '',
							'kategori' 	=> ''
						);
					}
				} else {
					$msg = '';
				}

				$formdata['message'] = $msg;
				$formdata['kategori_options'] = array('student' => 'Student', 'developer' => 'Developer');

				$datapanel['content'] = $this->load->view('admin/components/addattendee', $formdata, true);
				$datapanel['label'] = 'New Attendee';
				$data['content'] = $this->load->view('admin/components/panel', $datapanel, true);
				$data['pagetitle'] = 'Add New Attendee';
				$this->renderpage('admin/plain-page', $data);
				break;
			case 'add':
				$this->load->library('user_agent');
				$this->load->model('attendeemodel');
				if( $this->input->post('email') != '' && 
					$this->input->post('nama') != '' && 
					$this->input->post('nohp') != '' &&
					$this->input->post('kategori') != ''){

					$cod = $this->_generate_code_ticket();
					$mmssgg = $this->attendeemodel->AddNewAttendee($cod);
					$this->session->set_flashdata('addnewresult', $mmssgg);
					if ($mmssgg != 'error: email exists!')
						$this->_email_event_confirmation('confirmation_register', $cod);
				} else {
					$this->session->set_flashdata('addnewresult', 'Require empty!');
				}
				redirect($this->agent->referrer());
				break;
			case 'delete':
				$this->load->library('user_agent');
				$this->load->model('attendeemodel');
				$this->attendeemodel->update_user_order($this->uri->segment(6), ['deleted' => true]);
				redirect($this->agent->referrer());
				break;
			case 'view':
				$this->load->model('attendeemodel');

				$datapanel = [];
				$dataprofile = $this->attendeemodel->attendee_details();

				$qrloc = FCPATH . 'dist/images/ticket/qrcode-'.time().'.png';
				$this->_generate_qrcode($dataprofile['ticket_code'], $qrloc);
				$dataprofile['qrcodeimg'] = $this->_b64fromimg($qrloc, true);
				$dataprofile['statusorders'] = $this->statusorders;

				$datapanel['label'] = 'Attendee Personal Profile';
				$datapanel['content'] = $this->load->view('admin/components/profile', $dataprofile, true);

				$data['pagetitle'] = $dataprofile['fullname'];
				$data['content'] = $this->load->view('admin/components/panel', $datapanel, true);
				$this->renderpage('admin/plain-page', $data);
				break;
			case 'update':
				$this->load->model('attendeemodel');
				$this->load->library('user_agent');
				switch ($this->input->get('sec')) {
					case 'sendticket':
						$this->_sending_ticket($this->uri->segment(6));
						$this->attendeemodel->update_user_order($this->uri->segment(6), ['status' => 'Sending Ticket']);
						$this->session->set_flashdata('info', 'Sending Ticket');
						redirect($this->agent->referrer());
						break;
					case 'sending-ticket':
						$this->_sending_ticket($this->uri->segment(6));
						$this->attendeemodel->update_user_order($this->uri->segment(6), ['status' => 'Sending Ticket']);
						$this->session->set_flashdata('info', 'Sending Ticket');
						redirect($this->agent->referrer());
						break;
					case 'payment-accepted':
						$this->attendeemodel->update_user_order($this->uri->segment(6), ['status' => 'Payment Accepted', 'paid_date' => date('Y-m-d H:i:s')]);
						$this->_email_event_confirmation('confirmation_payment_accepted', $this->uri->segment(6));
						$this->session->set_flashdata('info', 'Payment Accepted');
						redirect($this->agent->referrer());
						break;
					case 'payment-failed':
						$this->attendeemodel->update_user_order($this->uri->segment(6), ['status' => 'Waiting Payment', 'paid_date' => null, 'attend_date' => null]);
						$this->_email_event_confirmation('confirmation_payment_accepted', $this->uri->segment(6));
						$this->session->set_flashdata('info', 'Waiting Payment');
						redirect($this->agent->referrer());
						break;
					case 'venue-reminder':
						$this->_email_event_confirmation('reminder_venue', $this->uri->segment(6));
						redirect($this->agent->referrer());
						break;
					case 'payment-reminder':
						$this->_email_event_confirmation('reminder_payment', $this->uri->segment(6));
						redirect($this->agent->referrer());
						break;
					case 'entrance-venue':
						$this->attendeemodel->update_user_order($this->uri->segment(6), ['status' => 'Venue Entrance', 'attend_date' => date('Y-m-d H:i:s')]);
						$this->_email_event_confirmation('entrance_venue', $this->uri->segment(6));
						redirect($this->agent->referrer());
					default:
						redirect($this->agent->referrer());
						break;
				}
				break;
			default:
				$this->load->model('attendeemodel');
				$this->load->model('eventsmodel');
				$this->load->helper('panel');

				$dtc['contents'] = $this->attendeemodel->GetAll();
				$dtc['idtbl'] = 'datatable-buttons';
				$dtc['clstbl'] = 'table table-striped table-bordered';
				$dtc['dturl'] = site_url('backpanel/event/'.$this->eventid.'/attendee/view');
				$dtc['colink'] = 2;
				$dtc['dcolink'] = 1;

				$dat['ci'] = $this;
				$dat['content'] = $this->_createdatatable($dtc);
				$dat['label'] = "Event List";
				$data['content'] = create_panel($dat);
				$this->renderpage('admin/plain-page', $data);
				break;
		}
	}

	private function _forms()
	{
		switch ($this->uri->segment(5)) {
			case 'create':
				break;
			case 'save':
				# code...
				break;
			case 'delete':
				# code...
				break;
			case 'view':
				# code...
				break;
			case 'update':
				# code...
				break;
			default:
				break;
		}
	}

	private function _feedback()
	{
		switch ($this->uri->segment(5)) {
			case 'view':
				# code...
				break;
			default:
				$this->_checkin();
				$this->load->model('eventsmodel');
				$this->load->helper('datatable');

				$data['content'] = datatable($this->eventsmodel->get_event_datas());
				$this->renderpage('admin/datatables', $data);
				break;
		}
	}

	private function _tab()
	{
		switch ($this->uri->segment(5)) {
			case 'create':
				break;
			case 'save':
				# code...
				break;
			case 'delete':
				# code...
				break;
			case 'view':
				# code...
				break;
			case 'update':
				# code...
				break;
			default:
				break;
		}
	}

	private function _settings()
	{
		$eventid = $this->uri->segment(3);
		switch ($this->uri->segment(5)) {
			case 'general':
				$data['content'] = '';
				$data['pagetitle'] = 'General Settings';
				$this->renderpage('admin/plain-page', $data);
				break;
			case 'forms':
				$data['content'] = '';
				$data['pagetitle'] = 'Forms Templates';
				$this->renderpage('admin/plain-page', $data);
				break;
			case 'email-template':
				array_push($this->footer_js, 
					'bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js', 
					'jquery.hotkeys/jquery.hotkeys.js', 
					'google-code-prettify/src/prettify.js');

				array_push($this->headerdata, ['src' => 'vendor/google-code-prettify/bin/prettify.min.css']);
				array_push($this->footer_docready, ['script' => 'textarea-session', 'content' => ['editor' => '#editor']]);

				$tsdata['editor'] = 'editor';
				$tsdata['formname'] = 'email_confirmation';

				$paneldata['content'] = $this->load->view('admin/components/textarea-session', $tsdata, true);
				$paneldata['label'] = 'Email Confirmation';

				$data['content'] = $this->load->view('admin/components/panel', $paneldata, true);
				$data['pagetitle'] = 'Email Templates';
				$this->renderpage('admin/plain-page', $data);
				break;
			case 'notification':
				$data['content'] = '';
				$data['pagetitle'] = 'Notification Forms';
				$this->renderpage('admin/plain-page', $data);
				break;
			case 'update':
				break;
			default:
				redirect(site_url('/backpanel/event/'.$eventid.'/settings/general'),'refresh');
				break;
		}
	}

	private function _event_create()
	{
		$this->load->helper('form');
		$this->load->helper('formgen');
		
		$data['formaction'] = 'backpanel/event/setting/save';
		$data['pagetitle'] = 'Create Event';

		$eventform = array(
			array(
				'type' 	=> 'section',
				'label' => 'Event Information'
			),
			array(
				'type' 	=> 'text',
				'label' => 'Event Title',
				'id' 	=> 'event_name',
				'grid' 	=> 6
			),
			array(
				'type'	=> 'text',
				'label' => 'Event Venue',
				'id'	=> 'event_venue',
				'grid'	=> 6
			),
			array(
				'type'	=> 'date-time-range',
				'label' => 'Event Time',
				'id'	=> 'event_time'
			),
			array(
				'type'	=> 'textarea',
				'label' => 'Short Description',
				'id'	=> 'short_desc',
				'grid'	=> 6
			),
			array(
				'type'	=> 'tinymce',
				'label' => 'Description',
				'id'	=> 'desc',
				'grid'	=> 6
			), 
			array(
				'type'	=> 'submit-cancel',
				'label' => 'Description',
				'id'	=> 'submit',
				'grid'	=> 6
			)
		);
		
		$data['fields'] = $eventform;
		$form['id'] = 'kerja';

		$paneldata['content'] = formgen($eventform, $this);
		$paneldata['label'] = 'General Information';
		$data['content'] = $this->load->view('admin/components/panel', $paneldata, TRUE);
		$this->renderpage('/admin/forms', $data);
	}

	private function _save_event()
	{
		switch ( $this->uri->segment(3) ) {
			case 'event-type':
				$this->_event_type();
				break;
			case 'create':
				$this->_event_create();
				break;
			case 'setting':
				$this->load->model('eventsmodel');
				$this->load->helper('form');
				$this->load->library('form_validation');

				if ( $this->uri->segment(4) === 'save' )
				{
					$this->form_validation->set_rules('event_name', 'Event Title', 'required');
					$this->form_validation->set_rules('event_venue', 'Event Venue', 'required');

					if ( ! $this->form_validation->run() )
						$this->eventsmodel->create_event();
				}
				break;
			default:
				# code...
				break;
		}
	}

	private function _event_type()
	{
		$this->load->library('form_validation');

		$this->load->helper('form');
		$this->load->helper('formgen');

		$paneldata['label'] = 'General Information';
		$paneldata['content'] = '';

		$data['formaction'] = 'backpanel/event/settings/save';
		$data['pagetitle'] = 'Event Type Management';
		$data['content'] = $this->load->view('admin/components/panel', $paneldata, TRUE);
		$this->renderpage('admin/forms', $data);
	}

	private function _scanner()
	{
		$this->load->model('attendeemodel');
		
		switch ($this->uri->segment(5)) {
			case 'check-data':
				echo $this->attendeemodel->forscanner();
				exit;
				break;
			case 'scan-update':
				echo $this->attendeemodel->updatescanner();
				break;
			default:
				$dashboard['pagetitle'] = 'Event Check-In';

				$scanpaneldata['label'] = "Ticket Scanner";
				$scanpaneldata['content'] = '<div id="outdiv" class="embed-responsive embed-responsive-4by3">
				<video id="video-scanner" class="embed-responsive-item"></video>
				<canvas id="canvas-scanner" class="embed-responsive-item"></canvas></div>
				<div id="result">scan</div>';
				$scanpaneldata['panelgrid'] = 6;
				$scanpanel = $this->load->view('admin/components/widget', $scanpaneldata, TRUE);

				$scandatabox['label'] = "Attendee Information";
				$scandatabox['content'] = '<div id="infobox" style="display: none;"><table class="table table-hover" id="personal-data"></table>
					<a id="payfirst" class="btn btn-warning" href="'.site_url('backpanel/event/'.$this->uri->segment(3).'/scan-update').'?sec=payment-accepted&src=scanner">Payment</a>
					<a id="approve" class="btn btn-success" href="'.site_url('backpanel/event/'.$this->uri->segment(3).'/scan-update').'?sec=entrance-venue&src=scanner">Approve</a>
					<a id="decline" class="btn btn-danger" href="#">Decline</a></div>';
				$scandatabox['panelgrid'] = 6;
				$scandatapanel = $this->load->view('admin/components/widget', $scandatabox, TRUE);

				array_push($this->headerdata, ['type' => 'css', 'src' => 'qrscaner.css', 'content'=> [] ]);

				array_push($this->footer_js, 'webrtc/DetectRTC.min.js', 'webrtc/detect.js');

				$dashboard['content'] = $scanpanel . $scandatapanel;
				$this->renderpage('admin/plain-page', $dashboard);
				break;
		}
	}
}