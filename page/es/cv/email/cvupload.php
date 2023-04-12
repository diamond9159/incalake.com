<?php 
$carpetaAdjunta="documents/";
// Contar envían por el plugin
$Imagenes =count(isset($_FILES['archivopdf']['name'])?$_FILES['archivopdf']['name']:0);
$infoImagenesSubidas = array();
for($i = 0; $i < $Imagenes; $i++) {
	// El nombre y nombre temporal del archivo que vamos para adjuntar
	$nombreArchivo=isset($_FILES['archivopdf']['name'][$i])?$_FILES['archivopdf']['name'][$i]:null;
	$nombreTemporal=isset($_FILES['archivopdf']['tmp_name'][$i])?$_FILES['archivopdf']['tmp_name'][$i]:null;
	
	$rutaArchivo=$carpetaAdjunta.$nombreArchivo;
	
	move_uploaded_file($nombreTemporal,$rutaArchivo);
	
	$infoImagenesSubidas[$i]=array("caption"=>"$nombreArchivo","height"=>"120px","url"=>"cv/delete.php","key"=>$nombreArchivo);
	$ImagenesSubidas[$i]="<embed  height='100%' width='100%' src='cv/".$rutaArchivo."' class='file-preview-pdf'>";
	}
$arr = array("file_id"=>0,"overwriteInitial"=>true,"initialPreviewConfig"=>$infoImagenesSubidas,
			 "initialPreview"=>$ImagenesSubidas);
echo json_encode($arr);
?>