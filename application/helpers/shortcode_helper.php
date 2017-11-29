<?php defined('BASEPATH') OR exit('No direct script access allowed');

function extract_shortcode($tags, $texts)
{
	preg_match_all('/\[(.*)]/m', $texts, $finds);
	if ( $finds[1] != null )
	{
		foreach ( $finds[1] as $k => $v )
		{
			if( array_key_exists($v, $tags) )
			{
				$texts = str_replace('[' . $v . ']', $tags[$v], $texts);
			}
		}
	}
	return $texts;
}