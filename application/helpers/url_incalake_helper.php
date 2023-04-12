<?php
	
	// Generamos la url en base la dirección de la pagina principal
if(!function_exists('url'))
{
	function url($url = null) {
		return base_url($url);
	}
}
?>