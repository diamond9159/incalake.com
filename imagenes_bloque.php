<?php
 /*script para copiado de imagenes en bloque*/

/*retornar id-num de la carperta*/
 
 /* $thumb =  resize_image($nuevaruta,200,150);
  $rutathumb = $ruta_carpeta.'thumbs/'.$url_extencion;
  $extencion[1]=='png'?imagepng($thumb,$rutathumb):imagejpeg($thumb,$rutathumb);*/
/*fin de la funcion para redimencionar las imagenes*/
//////////////////////////////////////////////////////////////////////////////////////////////////////
///
function registroAutomatico(){
	$carpeta_principal = 'galeria/admin/';

	function getIDbyName($val){
	   $folder = null;
	      switch ($val) {
	      case 'docs': $folder = 0;break;
	      case 'full-slider': $folder = 1;break;
	      case 'short-slider': $folder = 2;break;
	      case 'relateds': $folder = 3;break;
	      case 'recursos': $folder = 4;break;
	      case 'politicas': $folder = 5;break;
	      case 'other-images': $folder = 6;break;
	      case 'other-docs': $folder = 7;break;
	    }
	  return $folder;
	}
	/*funcion para redimencionar la imagen*/
  function resize_image($file, $extencion, $w, $h) {
      list($width, $height) = getimagesize($file);
      $src = $extencion=='png'?imagecreatefrompng($file):imagecreatefromjpeg($file);
      $dst = imagecreatetruecolor($w, $h);
      imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
      return $dst;
 }
/////////////////////////////////////////////////////////////////////////////////////////////////////////
	function archivos($rutaa,$files=false){

	  $folderes = array();
	  foreach(glob($rutaa.'/*',$files?null:GLOB_ONLYDIR) as $dir) {
	    $nombreReal = str_replace($rutaa.'/', '', $dir);
	    if($nombreReal!='thumbs')$folderes[] =  $nombreReal;
	    
	  }

	  return $folderes;
	  //return preg_grep('/^([^.])/',scandir($rutaa,1));
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	  $carpetas = archivos($carpeta_principal);
	$big_sql = array();//construir values;
	 // var_dump($carpetas);
	  $carpetasMulti = array();
	  foreach ($carpetas as $value) {
	    $contenido = array();

	    $subFolder = archivos($carpeta_principal.$value);
	    foreach($subFolder as $value2){
	      $carpeta_2 = $carpeta_principal.$value.'/'.$value2;
	      $subFolder_3 = archivos($carpeta_2,true);

	      foreach ($subFolder_3 as $value3) {
	      	
	      	$carpeta_3 = $carpeta_2.'/'.$value3;
	      	//$nivel_3_files = array();
	      	 if(is_dir($carpeta_3)){
	      	 	//echo($value3.',');
	      	 	$nivel3[$value3]=archivos($carpeta_3,true);
	      	 	foreach ($nivel3[$value3] as $value4) {
	      	 		if(is_file($carpeta_3.'/'.$value4)){
	      	 		   $big_sql[] = "(".getIDbyName($value).",'$value2/$value3','$value4',1)";
	      	 		   /*crear thumbs*/
	      	 		   $extencion = explode('.',$value4);
	      	 		   if($extencion[1]=='png' or $extencion[1]=='jpg'){
	      	 		   	  $thumb =  resize_image($carpeta_3.'/'.$value4,$extencion[1],200,150);
					      $rutathumb = $carpeta_3.'/thumbs/';
					      if(!is_dir($rutathumb)){
					        mkdir($rutathumb, 0777, true);//crear carpeta de thumbnails
                            chmod($rutathumb, 0777);
                          }
					      $extencion[1]=='png'?imagepng($thumb,$rutathumb.$value4):imagejpeg($thumb,$rutathumb.$value4);
	      	 		   }

					   /*fin crear thumbs*/
	      	 		}
	      	 	}
	      	 	//$nivel3[] = archivos($carpeta_3,true);
		     } else {
		     	$big_sql[] = "(".getIDbyName($value).",'$value2','$value3',1)";
		     	$nivel3[]=$value3;

		     	/*crear thumbs*/
	      	 	 $extencion = explode('.',$value3);
	      	 	 if(@$extencion[1]=='png' or @$extencion[1]=='jpg'){
	      	 		  $thumb =  resize_image($carpeta_2.'/'.$value3,$extencion[1],200,150);
					  $rutathumb = $carpeta_2.'/thumbs/';
					   if(!is_dir($rutathumb)){
					        mkdir($rutathumb, 0777, true);//crear carpeta de thumbnails
                            chmod($rutathumb, 0777);
                        }
					 $extencion[1]=='png'?imagepng($thumb,$rutathumb.$value3):imagejpeg($thumb,$rutathumb.$value3);
	      	 	  }

				/*fin crear thumbs*/
		     }
	      }
	      
	      $contenido[$value2] = @$nivel3;
	      //$contenido[$value2][]
	    }
	    //$carpetasMulti[$value] = archivos($ruta.'/'.getnombreByID($_GET['getCarpetas']).'/'.$value);}
	    $carpetasMulti[$value] = $contenido;
	  }
	  //var_dump($carpetasMulti);
	  //sleep(3);
	  //echo (count($carpetasMulti));
	  //var_dump($big_sql);
	   $conn = new mysqli('localhost', 'root', '', 'cms_incalake');
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 
		$conn->query("DELETE FROM galeria");
		$sql = "INSERT INTO galeria (tipo_archivo,carpeta_archivo,url_archivo,id_usuarios) VALUES ".implode(',', $big_sql);

		if ($conn->query($sql) === TRUE) {
		    echo "Ejecutado correctamente.!";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}

	   $conn->close();
} 
if(isset($_GET['generar']))registroAutomatico();
 //  echo $sql;
?>
<a href="?generar">Generar registro automatico</a>