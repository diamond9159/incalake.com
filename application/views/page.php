<?php
   $traduccion_body = arrayTraduccion('body',$language);
?>
<!DOCTYPE html>
<html lang="<?=strtolower($language);?>">
<head>
<meta name="google-site-verification" content="qy9vxQEC9LYKLrPOeKqRxhTQTCu1u7T_ReVvsvugjeY" />
<title><?=($language=='es'?'Agencia de viajes en Puno y el Lago Titicaca, expertos en el área del Titicaca | Inca Lake oficial ':'Travel agency in Puno and Lake Titicaca tours, experts on Titicaca | Inca Lake official') ?> </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?=($language=='es'?'Agencia de viajes en la región de Puno y el Lago Titicaca, brinda diferentes servicios turísticos a Puno, Cusco, Arequipa, La Paz, Uyuni.':'Travel agency in Puno region and Lake Titicaca, offer different services towards Puno, Cusco, Arequipa, La Paz, and Uyuni.') ?>">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta property="og:title" content="<?=($language=='es'?'Agencia de viajes en Puno y el Lago Titicaca, expertos en el área del Titicaca | Inca Lake oficial ':'Travel agency in Puno and Lake Titicaca tours, experts on Titicaca | Inca Lake official') ?>" />
	<meta property="og:url" content="<?=$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]?>" />
	<meta property="og:image" content="<?=$slider_index[0]['imagen']?>" />
	<meta property=”og:description” content="<?=($language=='es'?'Agencia de viajes en la región de Puno y el Lago Titicaca, brinda diferentes servicios turísticos a Puno, Cusco, Arequipa, La Paz, Uyuni.':'Travel agency in Puno region and Lake Titicaca, offer different services towards Puno, Cusco, Arequipa, La Paz, and Uyuni.') ?>" />
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/flag/flag.min.css">
	<?php
		$this->load->view('header/css');
		$this->load->view('header/js');
	?>
	<!--link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/header.css"-->
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/index.css">
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
		<content id="content" class="content container-fluid" style="padding:0;">
			<?php $this->load->view('content/page/index'); ?>
		</content>
		<footer class="footer">
			<?php $this->load->view('footer/footer'); ?>
		</footer>
    
	</body>

</html>