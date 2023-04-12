<!DOCTYPE html>
<html lang="<?=$language?>">
<?php
echo "<script>
        var resultado=".json_encode($oferta).";
        console.log(resultado);
        </script>";
?>
<head>
	<title><?=($language=='es'?'Oferta de tours en Peru y Bolivia':'Deal tours in Peru and Bolivia') ?> </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?=($language=='es'?'Ofertas de tours en el Lago Titicaca, Machupicchu, Uyuni, Isla del Sol, Uros, La Paz, etc':'Tour deals on Lake Titicaca, Machupicchu, Uyuni salt flats, Sun Island, Uros, La Paz, etc') ?>">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta property="og:title" content="<?=($language=='es'?'Oferta de tours en Peru y Bolivia':'Deal tours in Peru and Bolivia') ?>" />
	<meta property="og:url" content="<?=$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]?>" />
	<meta property="og:image" content="<?=(!empty($oferta[0]['imagen'])?$oferta[0]['imagen']:''.base_url().'assets/img/slider-default.png')?>"/>
	<meta property=”og:description” content="<?=($language=='es'?'Ofertas de tours en el Lago Titicaca, Machupicchu, Uyuni, Isla del Sol, Uros, La Paz, etc':'Tour deals on Lake Titicaca, Machupicchu, Uyuni salt flats, Sun Island, Uros, La Paz, etc') ?>" />
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
				$this->load->view('header/header');
				$this->load->view('header/menu');
			?>
		</header>
		<content id="content" class="content container-fluid">
			<?php
				$this->load->view('content/page/page_ofertas');
			?>
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