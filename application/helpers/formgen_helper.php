<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('formgen') )
{
	function formgen($formgens, $ci)
	{
		$form = '';
		if($formgens == null)
			return $form;

		foreach ($formgens as $k => $v) {
			if( file_exists(APPPATH . 'views/admin/components/' . $v['type'] . '.php') )
				$form .= $ci->load->view('admin/components/' . $v['type'], $v, TRUE);

			if( file_exists(APPPATH . 'views/admin/header-script/' . $v['type'] . '.php') )
				$ci->d4p['headerscript'][] = $ci->load->view('admin/header-script/' . $v['type'], $v, TRUE);

			if( file_exists(APPPATH . 'views/admin/footer-script/' . $v['type'] . '.php') )
				$ci->d4p['footerscript'][] = $ci->load->view('admin/footer-script/' . $v['type'], $v, TRUE);
		}
		return $form;
	}
}