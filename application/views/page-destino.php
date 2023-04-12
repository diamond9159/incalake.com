<?php


// var_dump(var_cookie)


if (count($destino['activity'])==0) {    
$url_destino =(@$_COOKIE["url_destino"]?explode(",", @$_COOKIE["url_destino"]):[]);

	 $var_cookie=array();
 $var_cookie['uri']=array();
 $var_cookie['positon']=0;

$url= $_SERVER['REQUEST_URI'];
if ($url_destino) {
		if (@$_COOKIE["uri"]) {
			$var_temp_cookie=json_decode(@$_COOKIE["uri"],true);
			$temp_sum=$var_temp_cookie['positon'];
			$var_cookie['uri']=$url_destino;
			if (count($url_destino )-1>$temp_sum) {
				$var_cookie['positon']=($url_destino!=@$var_temp_cookie['uri']?0:$temp_sum+1);
			}else{
				$var_cookie['positon']=count($url_destino )-1;
			}			
			 	// setcookie("uri",json_encode($var_cookie),time()-1);
			setcookie("uri",json_encode($var_cookie),time()+36000);
			echo "exsite";
			var_dump($var_cookie);

			 

		}else{

			$var_cookie['uri']=$url_destino;
			setcookie("uri",json_encode($var_cookie),time()+36000);
			echo "no exsite";
			var_dump($var_cookie);
			

		}
		
}else{

}

// 	 $var_cookie=array();
//  $var_cookie['uri']=array();
//  $var_cookie['positon']=0;
//  if ($url_destino){
// 	if (!@$_COOKIE["uri"]) {
// 		// $url_destino=explode(",", $_COOKIE["url_destino"]);
// 		$var_cookie['uri']=$url_destino;
// 		setcookie("uri",json_encode($var_cookie),time()+36000);
// 		echo "111111111";
// 	}else{
//  	$var_temp_cookie=json_decode($_COOKIE["uri"],true);
//  	var_dump($var_temp_cookie);
//  	$var_cookie['uri']=$var_temp_cookie['uri'];
//  	$var_cookie['positon']=$var_temp_cookie['positon']+1;
//  	setcookie("uri",json_encode($var_cookie),time()+36000);
//  	echo "222222222222";
//  }
//  }
 $url_temp=base_url().strtolower($language)."/".(strtolower($language)=='es'?'destino':'destination')."/".str_replace(" ", "-",trim($var_cookie['uri'][$var_cookie['positon']]))."/".str_replace(" ", "+",trim($var_cookie['uri'][0]));
echo $url_temp;
//  	// setcookie("uri",json_encode($var_cookie),time()-1);

// // var_dump();
// echo json_encode($var_cookie);
// echo $url_temp;
// echo count($var_cookie['uri'])-1;
 echo "<script>location.href=('".$url_temp."');</script>";
//     exit();

}
?>
<!DOCTYPE html>
<html lang="<?=$language;?>">
<?php
// $language=$destino['lang'];
// echo json_encode($slider);
?>
<head>
	<title><?=($language=='es'?'Encuentra todas las actividades asociadas al destino '.$destino['breadcrumb'][2]['txt']:'Shows all activities related to destination '.$destino['breadcrumb'][2]['txt']) ?> </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?=$destino['breadcrumb'][2]['txt'] ?>">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta property="og:title" content="<?=($language=='es'?'Encuentra todas las actividades asociadas al destino '.$destino['breadcrumb'][2]['txt']:'Shows all activities related to destination '.$destino['breadcrumb'][2]['txt']) ?>" />
	<meta property="og:url" content="<?=$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]?>" />
	<meta property="og:image" content="<?=$destino['actual']['slider_img']?>" />
	<meta property=”og:description” content="<?=$destino['breadcrumb'][2]['txt'] ?>" />
	<?php
		$this->load->view('header/css');
		$this->load->view('header/js');
	?>
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/header.css">
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/footer.css">
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/page-lists.css">
</head>
	<body>
		<header>
			<?php
            /*inicio de las funciones para las urls*/
            function retornaURL($idioma,$uri){
             return  base_url($idioma.'/'.$uri);
            }
            $destino = $this->uri->segment(3);
               
                $datos['url_idiomas'] = array(
                    'ES'=>retornaURL('es','destino').'/'.$destino,
                    'EN'=>retornaURL('en','destination').'/'.$destino,
                    'FR'=>retornaURL('fr','destination').'/'.$destino,
                    'DE'=>retornaURL('de','destination').'/'.$destino
                );
            /*fin de las funciones para el envio de url $datos*/
				$this->load->view('header/header',$datos);
				$this->load->view('header/menu');
			?>
		</header>
		<content id="content" class="content container-fluid">
			<?php
				$this->load->view('content/page/page-destino');
			?>
      <?php
        $this->load->view('footer/suscripciones');
      ?>
		</content>
		<footer>
			<?php $this->load->view('footer/footer'); ?>
		</footer>
	    <?php $this->load->view('script_chat'); ?>
	</body>
</html>