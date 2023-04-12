<!DOCTYPE html>
<html lang="<?=$language?>">
<?php
echo "<script>
        var resultado=".json_encode($mas_comprados).";
        console.log(resultado);
        </script>";
?>
<head>
	<title><?=($language=='es'?'SuperVentas de tours en Peru y Bolivia':'BestSelling tours in Peru and Bolivia') ?> </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?=($language=='es'?'SuperVentas de tours en el Lago Titicaca, Machupicchu, Uyuni, Isla del Sol, Uros, La Paz, etc':'Tour BestSelling on Lake Titicaca, Machupicchu, Uyuni salt flats, Sun Island, Uros, La Paz, etc') ?>">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta property="og:title" content="<?=($language=='es'?'SuperVentas de tours en Peru y Bolivia':'BestSelling tours in Peru and Bolivia') ?>" />
	<meta property="og:url" content="<?=$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]?>" />
	<meta property="og:image" content="<?=(!empty($mas_comprados[0]['imagen'])?$mas_comprados[0]['imagen']:''.base_url().'assets/img/slider-default.png')?>"/>
	<meta property=”og:description” content="<?=($language=='es'?'SuperVentas de tours en el Lago Titicaca, Machupicchu, Uyuni, Isla del Sol, Uros, La Paz, etc':'Tour BestSelling on Lake Titicaca, Machupicchu, Uyuni salt flats, Sun Island, Uros, La Paz, etc') ?>" />
	<?php
		$this->load->view('header/css');
		$this->load->view('header/js');
	?>
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/flag/flag.min.css">
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/header.css">
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/footer.css">
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/ofertas.css">
</head>
	<body>
		<header>
			<?php
				function retornaURL($idioma,$uri){
             return  base_url($idioma.'/'.$uri);
            }
               
                $datos['url_idiomas'] = array(
                    'ES'=>retornaURL('es','superventas'),
                    'EN'=>retornaURL('en','bestselling'),
                    'FR'=>retornaURL('fr','bestselling'),
                    'DE'=>retornaURL('de','bestselling')
                );
				$this->load->view('header/header',$datos);
				$this->load->view('header/menu');
			?>
		</header>
		<content id="content" class="content container-fluid">
			<div class="container-fluid">
				<div class="row justify-content-center">
					<?php
						$this->load->view('mas_comprados_index.php');
					?>
				</div>
			</div>
			      <?php
        $this->load->view('footer/suscripciones');
      ?>
		</content>
		<footer class="footer">
			<?php $this->load->view('footer/footer'); ?>
		</footer>
	    <?php $this->load->view('script_chat'); ?>
	</body>
</html>