<?php

function prize_draw($st, $n = range('a', 'z'), $weights = [1, 4, 4, 5, 2, 1]){
	$st = explode(',', $st);
	foreach ($st as $firstname) {
		$firstname = trim($firstname);
		$ranks = array_intersect( explode("", $firstname), $n );
	}
	return $ranks;
}

var_dump(prize_draw('COLIN,AMANDBA,AMANDAB,CAROL,PauL,JOSEPH'));