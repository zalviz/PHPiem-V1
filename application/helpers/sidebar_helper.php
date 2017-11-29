<?php
// fungsi untuk membuat sidebar
public function sidebar_menu($sidemenus = array())
{
	$html = '';
	if($sidemenus != null){
		$html .= '<ul class="sidebar-nav">' . "\n";
		foreach ($sidemenus as $kmenu => $vmenu) {
			if( is_array($vmenu) || $vmenu != null){
				$childmenu = '';
				if(is_array($vmenu['children']) || $vmenu['children'] != null){
					$actmenu = ($sidemenus['activemenu'] == $vmenu['slug']) ? ' class="dropdown active"' : ' class="dropdown"';
					$childmenu = _menuchildren($vmenu['children'], $sidemenus['activechild']);
				} else {
					$actmenu = ($sidemenus['activemenu'] == $vmenu['slug']) ? ' class="active"' : '';
				}
				$deficon = ($vmenu['icon'] != '') ?  $vmenu['icon'] : 'tasks';

				$html .= '<li' . $actmenu . '>' . "\n";
				$html .= '<a href="' . $vmenu['href'] . '">' . "\n";
				$html .= '<div class="icon"><i class="fa fa-' . $deficon . '" aria-hidden="true"></i></div>' . "\n";
				$html .= '<div class="title">' . $vmenu['label'] . '</div>' . "\n";
				$html .= $childmenu;
				$html .= '</a>' . "\n";
				$html .= '</li>' . "\n";
			}
		}
		$html .= '</ul>' . "\n";
	}

	return $html;
}

private function _menuchildren($children, $activechild)
{
	$menu  = '<div class="dropdown-menu">' . "\n";
	$menu .= '<ul>' . "\n";
	foreach ($children as $kchild => $vchild) {
		$chicon = ($vchild['icon'] != '') ? '<i class="fa fa-' . $vchild['icon'] . '" aria-hidden="true"> ' : '';
		switch ($vchild['type']) {
			case 'line':
				$menu .= '<li class="line"></li>' . "\n";
				break;
			case 'section':
				$menu .= '<li class="section"></i>' . $chicon . $vchild['label'] . '</li>' . "\n";
				break;
			default:
				$menu .= '<li><a href="' . $vchild['href'] . '">' . $chicon . $vchild['label'] . '</a></li>' . "\n";
				break;
		}
	}
	$menu .= '</ul>' . "\n";
	$menu .= '</div>' . "\n";

	return $menu;
}