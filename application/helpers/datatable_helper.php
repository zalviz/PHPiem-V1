<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('create_datatable') )
{
	function create_datatable($dts)
	{
		$contents = $dts['contents'];
		$tbl = '<table id="'.$dts['idtbl'].'" class="'.$dts['clstbl'].'">';
		$headstring = '';
		$heads = ( isset($dts['head']) ) ? @$dts['head'] : [];
		if( $heads == null )
			$heads = array_keys($contents[0]);

		$headstring .= '<thead><tr>';
		foreach ($heads as $head) {
			$headstring .= '<th>' . $head . '</th>';
		}
		$headstring .= '</tr></thead>';

		$tbody = '<tbody>';
		foreach ($contents as $ktr => $tr) {
			$tbody .= '<tr>';
			foreach ($tr as $ktd => $td) {
				$tbody .= '<td>' . $td . '</td>';
			}
			$tbody .= '</tr>';
		}
		$tbody .= '</tbody>';

		$tbl .= $headstring . $tbody;
		$tbl .= '</table>';

		return $tbl;
	}
}