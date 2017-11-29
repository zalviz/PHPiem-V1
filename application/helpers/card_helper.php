<?php
function create_card($carddata)
{
	$card  = '<div class="col-md-' . $carddata['col'] . '">';
	$card .= '<div class="card">';
	$card .= '<div class="card-header">';
	$card .= $carddata['title'];
	$card .= '</div>';
	$card .= '<div class="card-body">';
	$card .= $carddata['body'];
	$card .= '</div>';

	return $card;
}