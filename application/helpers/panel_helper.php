<?php

function create_panel($data)
{
	$panel = '';
	$ci = $data['ci'];
	if( file_exists(APPPATH . 'views/admin/components/panel.php') )
		$panel = $ci->load->view('admin/components/panel', $data, true);

	return $panel;
}