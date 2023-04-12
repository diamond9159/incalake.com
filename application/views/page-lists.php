<!DOCTYPE html>
<html lang="es">
<head>
	<title>Inca Lake Travel Agency</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#1570A6" />
	<?php
		$this->load->view('header/css');
		$this->load->view('header/js');
	?>
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/bootstrap-star-rating/css/star-rating.min.css">
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/header.css">
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/footer.css">
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/product.css">
	<script src="<?=base_url(); ?>assets/resources/js/product.js" type="text/javascript"></script>
	<script src="<?=base_url(); ?>assets/resources/bootstrap-star-rating/js/star-rating.min.js" type="text/javascript"></script>
	<script>
	$( document ).ready(function() {
		contar_categorias();
		contar_duracion();
		$('.txt_valoracion').rating({
			displayOnly: true, 
			theme: 'krajee-fa',
			size: 'xs',
			min: 0, 
			max: 5, 
			step: 0.1, 
			stars: 5,
		});
		showProducts(null,null);
	});
	</script>
</head>
	<body>
		<header>
			<?php
				$this->load->view('header/header');
				$this->load->view('header/menu');
			?>
		</header>
		<content id="content" class="content container-fluid">
		<?php echo  json_encode($activity).'<br><br>';
		echo  json_encode($duration).'<br><br>';
		echo  json_encode($category).'<br><br>';
		echo  json_encode($destiny).'<br><br>';
		echo  json_encode($lang).'<br><br>';
		echo  json_encode($breadcrumb).'<br><br>';
 ?>
			<?php
				$this->load->view('content/page/page-lists');
			?>
		</content>
		<footer>
			<?php
				$this->load->view('footer/footer');
			?>
		</footer>
	    <?php $this->load->view('script_chat'); ?>
	</body>
</html>