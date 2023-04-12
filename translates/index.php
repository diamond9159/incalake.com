<?php
function arrayTraduccion($archivo,$idioma='en',$default='en'){
     require $archivo.'.php';//buscar archivo que tiene variable $palabras.
     foreach($palabras as $key => $value)
     	$palabra[$key] = !empty($palabras[$key][$idioma])?$palabras[$key][$idioma]:$palabras[$key][$default];
     return $palabra;
 }
    $palabra = arrayTraduccion('menu','es');
    echo json_encode($palabra);
    $palabras = arrayTraduccion('header','es');
    echo json_encode($palabra);

?>