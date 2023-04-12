<!DOCTYPE html>
<html lang="<?=$language;?>">
<head>
	<title><?=($language=='es'?'Encuentra todo los destinos turisticos en la región sur del Perú / norte de Bolivia':'Find all touristic destination in South region of Peru ') ?> </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?=($language=='es'?'Encuentra el destino favorito de tu elección ':'Find your favorite destination') ?>">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta property="og:title" content="<?=($language=='es'?'Encuentra todo los destinos turisticos en la región sur del Perú / norte de Bolivia':'Find all touristic destination in South region of Peru ') ?>" />
	<meta property="og:url" content="<?=$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]?>" />
	<meta property="og:image" content="<?=$destinos[0]['imagen_slider']?>" />
	<meta property=”og:description” content="<?=($language=='es'?'Encuentra el destino favorito de tu elección ':'Find your favorite destination') ?>" />
	<?php
		$this->load->view('header/css');
		$this->load->view('header/js');
		echo "<script>
        var resultado=".json_encode($destinos).";
        console.log(resultado);
        </script>";
	?>
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/header.css">
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/footer.css">
</head>
	<body>
		<header>
			<?php
			/*inicio de las funciones para las urls*/
            function retornaURL($idioma,$uri){
             return  base_url($idioma.'/'.$uri);
            }
               
                $datos['url_idiomas'] = array(
                    'ES'=>retornaURL('es','destinos'),
                    'EN'=>retornaURL('en','destinations'),
                    'FR'=>retornaURL('fr','destinations'),
                    'DE'=>retornaURL('de','destinations')
                );
            /*fin de las funciones para el envio de url $datos*/
				$this->load->view('header/header',$datos);
				$this->load->view('header/menu');
			?>
		</header>
		<content id="content" class="content container-fluid">
			<?php
				$this->load->view('content/page/page-destinos');
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