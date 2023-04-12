<!DOCTYPE html>
<html lang="es">
<head>
	<title><?=($language=='es'?'Tours filtrados por categorías':'Tours filter by categories') ?> </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?=($language=='es'?'En esta página encontrarás los tours filtrados por su respectiva categoria, por ejemplo: místico, de aventura, vivencial, etc.':'In this page you will find the tours filter by their respective category. I.e: Mystical tours, of adventure, homestay, etc.') ?>">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta property="og:title" content="<?=($language=='es'?'Tours filtrados por categorías':'Tours filter by categories') ?>" />
	<meta property="og:url" content="<?=$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]?>" />
	<meta property="og:image" content="<?=$menu_categoria[0]['imagen_categoria']?>" />
	<meta property=”og:description” content="<?=($language=='es'?'En esta página encontrarás los tours filtrados por su respectiva categoria, por ejemplo: místico, de aventura, vivencial, etc.':'In this page you will find the tours filter by their respective category. I.e: Mystical tours, of adventure, homestay, etc.')?>" />
	<?php
		$this->load->view('header/css');
		$this->load->view('header/js');
	?>
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/header.css">
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/footer.css">

</head>
	<body>
		<header>
			<?php
				$this->load->view('header/header');
				$this->load->view('header/menu');
			?>
		</header>
		<content id="content" class="content">
			<?php
				$this->load->view('content/categoria/index');
			?>
      <?php
        $this->load->view('footer/suscripciones');
      ?>
		</content>
		<footer class="footer">
			<?php 
				$this->load->view('footer/footer'); 
			?>
		</footer>
	    <?php $this->load->view('script_chat'); ?>
	</body>
</html>