<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PHPIEM_Controller extends CI_Controller 
{
	protected $islogin = true;
	protected $isactive = false;
	protected $isadmin = false;
	protected $eventid = 0;
	protected $userlogin = 0;
	protected $pagetitle = '';

	protected $headerdata = [];

	protected $sidemenus = [];

	protected $footer_js = [];
	protected $footer_script = [];
	protected $footer_docready = [];

	protected $statusorders = [
		['label' => 'Waiting Payment', 'icon' => 'money', 'short' => 'pending-payment', 'desc' => 'waiting for payment'],
		['label' => 'Payment Accepted', 'icon' => 'heart', 'short' => 'payment-accepted', 'desc' => 'payment has been recieved and accepted'],
		['label' => 'Sending Ticket', 'icon' => 'qrcode', 'short' => 'sending-ticket', 'desc' => 'sending ticket by email'],
		['label' => 'Venue Entrance', 'icon' => 'university', 'short' => 'entrance-venue', 'desc' => 'attendee has been entrance to hall venue']
	];

	/*
	 * d4p AKA data for page
	 * best way to build data for every controller method
	 */
	public $d4p = array();

	public function __construct()
	{
		parent::__construct();
		now('Asia/Jakarta');

		$this->load->model('appsmodel');

		$this->islogin = $this->session->userdata('_islogin');
		$this->isactive = $this->session->userdata('_isactive');
		$this->isadmin = $this->session->userdata('_isadmin');
		$this->userlogin = $this->session->userdata('_userlogin');
		$this->eventid = (int)$this->session->userdata('_eventid');
		$this->_initializeunit();
	}

	/*
	 * every page want complete template should be use this method or keep use $this->load->view('template');
	 */
	public function renderpage($view, $data = array())
	{
		if( $data != null )
			$this->d4p = array_merge($this->d4p, $data);

		$this->pagetitle = ( ! isset( $data['pagetitle'] ) ) ? 'Dashboard' : $data['pagetitle'];
		$this->d4p['pagetitle'] = $this->pagetitle;

		$this->_headerdata();
		array_push($this->footer_js, ['jsfile' => 'js/custom.min.js', 'dist' => true, 'defer' => true]);
		$this->_footerdata();
		$this->_sidebarmenu();

		if ($this->islogin && $this->router->fetch_class() == "backpanel")
		{
			$this->load->view('admin/header', $this->d4p);
			$this->load->view($view, $this->d4p);
			$this->load->view('admin/footer', $this->d4p);
		}
	}

	private function _initializeunit()
	{
		$menus = unserialize($this->_getSetting('admin_main_menu'));

		if ( $this->uri->segment(1) === 'backpanel' && $this->uri->segment(2) === 'event' )
		{
			$this->eventid = (int)$this->uri->segment(3);
			$array = array(
				'_eventid' => $this->eventid
			);
			
			$this->session->set_userdata( $array );

			$eventmenu = $this->_getSetting('admin_event_menu');
			$eventmenu = unserialize($eventmenu);
			$eventmenu = json_decode( str_replace('[eventid]', (string)$this->eventid, json_encode( $eventmenu ) ), true );
			$sectionsidebar = array( array('label' => 'Event Dashboards', 'url' => '/backpanel/event', 'listmenu' => $eventmenu) );
		}
		else {
			$this->session->unset_userdata('_eventid');
			$sectionsidebar = array( array('label' => 'Main Dashboard', 'url' => '/backpanel/site-settings', 'listmenu' => $menus) );
		}

		$this->sidemenus = $sectionsidebar;
		$this->footer_js = ['jquery/dist/jquery.min.js', 'bootstrap/dist/js/bootstrap.min.js', 'fastclick/lib/fastclick.js', 'nprogress/nprogress.js'];
		// 'malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js'

		$this->footer_docready = [];

		$headerattribute = [
			['src' => 'vendors/bootstrap/dist/css/bootstrap.min.css'],
			['src' => 'vendors/font-awesome/css/font-awesome.min.css'],
			['src' => 'vendors/nprogress/nprogress.css'],
			['type' => 'http-equiv', 'src' => 'Content-Type', 'content' => 'text/html; charset=UTF-8'],
			['type' => 'http-equiv', 'src' => 'X-UA-Compatible', 'content' => 'IE=edge'],
			['type' => 'meta', 'name' => 'viewport', 'content' => 'width=device-width, initial-scale=1'],
			['type' => 'meta', 'name' => 'robot', 'content' => 'noindex/nofollow']
			// ['src' => 'vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css']
		];

		$this->headerdata = $headerattribute;
	}

	private function _sidebarmenu()
	{
		$menusidebar = '';
		if( $this->sidemenus != null )
		{
			foreach ($this->sidemenus as $k => $section)
			{
				$menusidebar .= '<div class="menu_section">';
				$menusidebar .= '<h3>' . $section['label'] . '</h3>';
				$menusidebar .= '<ul class="nav side-menu">';
				foreach ($section['listmenu'] as $menu) {
					$menusidebar .= $this->load->view('admin/components/menuitems', $menu, true);
				}
				$menusidebar .= '</ul>';
				$menusidebar .= '</div>';
			}
		}
		$this->d4p['sidemenu'] = $menusidebar;
	}

	private function _footerdata()
	{
		if ($this->footer_js != null)
		{
			$fjs = '';
			foreach ( $this->footer_js as $js ) {
				if( is_array($js) )
				{
					$chrset = ( @$js['charset'] ) ? ' charset="utf-8"' : '';
					$async = ( @$js['async'] ) ? ' async' : '';
					$defer = ( @$js['defer'] ) ? ' defer' : '';
					$distr = ( isset($js['dist']) ) ? @$js['dist'] : false;
					$extern = ( isset($js['external']) ) ? @$js['external'] : false;

					$js = $js['jsfile'];

					if ( $distr )
					{
						$fjs .= '<script src="' . base_url() . 'dist/' . $js . '" type="text/javascript"'.$chrset.$async.$defer.'></script>' . "\n";
					} else  {
						if ( $extern )
							$fjs .= '<script src="' . $js . '" type="text/javascript"'.$chrset.$async.$defer.'></script>' . "\n";
						else
							$fjs .= '<script src="' . base_url() . 'vendors/' . $js . '" type="text/javascript"'.$chrset.$async.$defer.'></script>' . "\n";
					}
				} else {
					$fjs .= '<script src="' . base_url() . 'vendors/' . $js . '" type="text/javascript"></script>' . "\n";
				}
			}
			$this->d4p['jsfiles'] = $fjs;
		}

		if ($this->footer_docready != null)
		{
			$docreadystr = '';
			foreach ($this->footer_docready as $docready) {
				$docreadystr .= $this->load->view('admin/footer-docready/' . $docready['script'], $docready['content'], TRUE) . "\n";
			}
			$this->d4p['docreadyscript'] = $docreadystr;
		}

		if ( $this->footer_script != null )
		{
			$jscstr = '';
			foreach ($this->footer_script as $jsc) {
				$jscstr .= $this->load->view($jsc, TRUE) . "\n";
			}
			$this->d4p['jsscript'] = $jscstr;
		}
	}

	private function _headerdata()
	{
		array_push($this->headerdata, ['src' => 'dist/css/custom.min.css']);
		$charset = '';
		$equiv = '';
		$headermeta = '';
		$headerlink = '';
		$headerstyle = '';
		$headerjs = '';
		$headerdr = '';
		
		if ( ! empty($this->headerdata) ){
			foreach ($this->headerdata as $hsk => $hs) {
				switch (@$hs['type']) {
					case 'charset':
						$charset = '<meta charset="' . $hs['content'] . '">' . "\n";
						break;
					case 'http-equiv':
						$equiv .= '<meta http-equiv="' . $hs['src'] . '" content="' . $hs['content'] . '">' . "\n";
						break;
					case 'meta':
						$headermeta .= '<meta name="' . $hs['name'] . '" content="' . $hs['content'] . '">' . "\n";
						break;
					case 'css':
						$headerstyle .= $this->load->view('admin/header-codes/' . @$hs['src'], $hs['content'], TRUE) . "\n";
						break;
					case 'js':
						$headerjs .= $this->load->view('admin/header-codes/' . $hs['src'], $hs['content'], TRUE) . "\n";
						break;
					case 'link':
						$headerlink .= '<link href="' . $hs['src'] . '" rel="' . ( @$hs['rel'] != '' ) ? @$hs['rel'] : 'stylesheet' . '">' . "\n";
					default:
						$headerlink .= '<link href="' . site_url($hs['src'])  . '" rel="stylesheet">' . "\n";
						break;
				}
			}
		}

		$headerall  = ( $charset == '' ) ? '<meta charset="utf-8">' . "\n" : $charset;
		$headerall .= ( $equiv == '' ) ? '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' : $equiv . "\n";
		$headerall .= $headermeta . "\n";
		$headerall .= '<title>' . $this->pagetitle . ' | PHP Indonesia Event Management</title>' . "\n";
		$headerall .= $headerlink;
		$headerall .= ( $headerstyle != '' ) ? "<style type=\"text/css\">\n". str_replace("\n", '', $headerstyle) ."</style>\n" : "";
		if ( $headerjs != '' || $headerdr != '')
		{
			$headerall .= '<script type="text/javascript">' . "\n";
			$headerall .= ( $headerjs != '' ) ? str_replace("\n", '', $headerjs) : '';
			if ( $headerdr != '' )
			{
				$headerall .= '$(document).ready(function(){';
				$headerall .= str_replace("\n", '', $headerdr);
				$headerall .= '});';
			}
			$headerall .= '</script>';
		}

		$this->d4p['headerdata'] = $headerall;
	}

	private function _notifbuble(){}

	private function _getSetting($key = '')
	{
		if ( $key != '' )
			return $this->appsmodel->get_option($key);
	}

	private function _getsettings($keys = [], $like = false)
	{
		if ( empty($keys) )
			return;

		if (! is_array($keys) && $like )
			return $this->appsmodel->get_options($keys, $like);
		else
			return $this->appsmodel->get_options($keys);
	}

	protected function _sending_ticket($tcode)
	{
		$this->load->model('attendeemodel');
		$this->load->model('eventsmodel');

		$cont = [];
		$sbj = 'Your Ticket Ready!';
		$mailto = '';
		$nameto = '';

		$exid = explode('-', $tcode);
		$id = (count($exid) == 1) ? $tcode : @$exid[1];

		$cont = $this->attendeemodel->attendee_details($id);
		$nameto = $cont['fullname'];
		$mailto = $cont['email'];

		$pdffile = FCPATH . 'dist/images/ticket/ticket-' . $id . '.pdf';
		$this->_generate_ticket($id, $pdffile);
		
		$emtpl = $this->eventsmodel->get_settings($this->uri->segment(3), 'email_sending_ticket');
		foreach($cont as $k => $v)
			$emtpl = str_replace('['.$k.']', $v, $emtpl);

		if ( $this->_sending_email($mailto, $nameto, $sbj, $emtpl, $pdffile) ){
			unlink($pdffile);
			return true;
		} else {
			unlink($pdffile);
			return false;
		}
	}

	protected function _email_event_confirmation($confirm = '', $id = '')
	{
		$msg  = '';
		if ( $confirm == ''){
			$msg  = 'Use confirmation action name. Already name are: [event-order | getseat | payment-accepted | payment-failed]';
			$msg .= 'Use user id on parameter 2';
			return $msg;
		}

		$this->load->model('attendeemodel');
		$this->load->model('eventsmodel');

		$evid = $this->uri->segment(3);

		$cont = [];
		$sbj = '';
		$mailto = '';
		$nameto = '';
		
		$exid = explode('-', $id);
		$id = (count($exid) < 2) ? $id : $exid[1];

		$cont = $this->attendeemodel->attendee_details($id);
		$nameto = $cont['fullname'];
		$mailto = $cont['email'];
		
		$emtpl = $this->eventsmodel->get_settings((int)$evid, 'email_tpl_event_' . $confirm);
		foreach($cont as $k => $v)
			$emtpl = str_replace('['.$k.']', $v, $emtpl);

		$sbjstr = explode('_', $confirm);
		foreach($sbjstr as $strk){
			if ($sbjstr[0] != $strk)
				$sbj .= ucfirst(strtolower($confirm));
		}
		$sbj .= $sbj . ' ' . $sbjstr[0];

		return $this->_sending_email($mailto, $nameto, $sbj, $emtpl);
	}

	protected function _sending_email($emailto, $nameto, $subject = '', $content = [], $attachment = '', $tmpl = '', $tempbase = 'main')
	{
		$this->load->library('email');
		$config = [];
		$cfgs = $this->_getsettings('ci_email_', true);
		
		foreach ($cfgs as $cfgkey => $cfg) {
			$config[ substr($cfg['option_name'], 9)] = $cfg['option_value'];
		}

		$this->email->initialize($config);
		$this->email->from($config['smtp_user'], 'Panitia Surabaya Developer Day');

		$fortpl['content'] = $content;

		$emaicontent = $this->load->view('email/' . $tempbase, $fortpl, TRUE);

		$this->email->to($emailto, $nameto);
		$this->email->subject($subject);
		$this->email->message($emaicontent);

		if ($attachment != ''){
			if (is_array($attachment)){
				$this->email->attach($attachment['file'], $attachment['disp'], $attachment['newname'], $attachment['mime']);
			} else {
				$this->email->attach($attachment);
			}
		}

		return $this->email->send();
	}

	protected function _createdatatable($content = [])
	{
		$this->load->helper('datatable');
		array_push($this->footer_js, 
			'iCheck/icheck.min.js',
			'datatables.net/js/jquery.dataTables.min.js',
			'datatables.net-bs/js/dataTables.bootstrap.min.js',
			'datatables.net-buttons/js/dataTables.buttons.min.js',
			'datatables.net-buttons-bs/js/buttons.bootstrap.min.js',
			'datatables.net-buttons/js/buttons.flash.min.js',
			'datatables.net-buttons/js/buttons.html5.min.js',
			'datatables.net-buttons/js/buttons.print.min.js',
			'datatables.net-fixedheader/js/dataTables.fixedHeader.min.js',
			'datatables.net-keytable/js/dataTables.keyTable.min.js',
			'datatables.net-responsive/js/dataTables.responsive.min.js',
			'datatables.net-responsive-bs/js/responsive.bootstrap.js',
			'datatables.net-scroller/js/dataTables.scroller.min.js',
			'jszip/dist/jszip.min.js',
			'pdfmake/build/pdfmake.min.js',
			'pdfmake/build/vfs_fonts.js'
		);
		array_push($this->headerdata, ['src' => 'vendors/iCheck/skins/flat/green.css'],
			['src' => 'vendors/datatables.net-bs/css/dataTables.bootstrap.min.css'],
			['src' => 'vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css'],
			['src' => 'vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css'],
			['src' => 'vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css'],
			['src' => 'vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css']
		);

		array_push($this->footer_docready, ['script' => 'datatable', 'content' => $content]);
		return create_datatable($content);
	}

	protected function _generate_qrcode($kode, $qrloc = ''){
		$this->load->library('QRcode');

		if ($qrloc == '')
			$qrloc = FCPATH . 'dist/images/ticket/qrcode-'.time().'.png';

		$outerFrame = 1;
		$pixelPerPoint = 16;

		$kode = "SDD2017:" . $kode;

		$frame = QRcode::text($kode, false, QR_ECLEVEL_M);
		$h = count($frame);
		$w = strlen($frame[0]);

		$imgW = $w + 2 * $outerFrame; 
		$imgH = $h + 2 * $outerFrame;
		$base_image = imagecreate($imgW, $imgH);

		$col[0] = imagecolorallocate($base_image,255,255,255); // BG, white
		$col[1] = imagecolorallocate($base_image,0,0,0);     // FG, black 

		imagefill($base_image, 0, 0, $col[0]);

		for($y=0; $y<$h; $y++) { 
			for($x=0; $x<$w; $x++) { 
				if ($frame[$y][$x] == '1') { 
					imagesetpixel($base_image,$x+$outerFrame,$y+$outerFrame,$col[1]);  
				} 
			} 
		} 

		$target_image = imagecreate($imgW * $pixelPerPoint, $imgH * $pixelPerPoint); 
		imagecopyresized( 
			$target_image,
			$base_image,
			0, 0, 0, 0, 
			$imgW * $pixelPerPoint, $imgH * $pixelPerPoint, $imgW, $imgH 
		);
		imagedestroy($base_image);
		ImagePng($target_image, $qrloc);
		ImageDestroy($target_image);
	}

	protected function _generate_code_ticket()
	{
		$saltes = ["A","C","D","E","F","G","H","J","K","L","M","N","P","Q","R","S","T","U","V","W","X","Y","Z","2","3","4","5","6","7","8","9"];
		$kr = array_rand($saltes, 6);
		$hashes = '';
		$hashed = '';

		for ($i = 0; $i < count($kr); $i++)
			$hashes .= $saltes[$kr[$i]];

		return $hashes;
	}

	protected function _generate_ticket($kodeticket, $filename = '')
	{
		$this->load->helper(array('dompdf/dompdf', 'file'));
		$this->load->model('attendeemodel');

		$data = $this->attendeemodel->generate_ticket($kodeticket);

		if ( !$data )
			return;

		$hashqrcode = $kodeticket;
		$qrloc = FCPATH . 'dist/images/ticket/qrcode-' . $kodeticket . '.png';
		$this->_generate_qrcode($hashqrcode, $qrloc);

		$data['logo'] = $this->_b64fromimg(FCPATH . 'dist/images/ticket/logo-sdd2017.png');
		$data['qrcode'] = $this->_b64fromimg($qrloc, true);
		$data['ticket'] = $this->_b64fromimg(FCPATH . 'dist/images/ticket/ticket.png');

		$tmpdf = $this->load->view('ticket/ticket', $data, true);
		if ($filename != '')
			file_put_contents($filename, pdf_create( $tmpdf, 'ticket.pdf'));
	}

	protected function _b64fromimg($img, $del = false)
	{
		$path = $img;
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$datastring = file_get_contents($path);
		if ($del)
			unlink($path);
		return 'data:image/' . $type . ';base64,' . base64_encode($datastring);
	}

	// public function __get(){}

	// public function __set(){}
}