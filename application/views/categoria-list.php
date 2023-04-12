<!DOCTYPE html>
<html lang="<?=$language?> ">
<head>
	<title><?=($language=='es'?'Tour filtrados por '.str_replace("-"," ",$destino['breadcrumb'][2]['txt']):'Tours filter by '.str_replace("-"," ",$destino['breadcrumb'][2]['txt'])) ?> </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?=($language=='es'?'En esta página encontrarás los tours filtrados por ':'On this page you will find the tours filtered by ') ?><?=str_replace("-"," ",$destino['breadcrumb'][2]['txt']) ?>">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta property="og:title" content="<?=($language=='es'?'Tour filtrados por '.str_replace("-"," ",$destino['breadcrumb'][2]['txt']):'Tours filter by '.str_replace("-"," ",$destino['breadcrumb'][2]['txt'])) ?>" />
	<meta property="og:url" content="<?=$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]?>" />
	<meta property="og:image" content="<?=$slider['imagen']?>" />
	<meta property="og:description" content="<?=($language=='es'?'En esta página encontrarás los tours filtrados por ':'On this page you will find the tours filtered by ') ?><?=str_replace("-"," ",$destino['breadcrumb'][2]['txt']) ?>" />
  	<?php
		$this->load->view('header/css');
		$this->load->view('header/js');
	?>
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/bootstrap-star-rating/css/star-rating.min.css">
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/header.css">
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/footer.css">
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/page-lists.css">
</head>
	<body>
		<header>
			<?php
			$this->load->view('header/header');
				$this->load->view('header/menu');
			?>
		</header>
		<content id="content" class="content">
		<br/>
			<?php
				$this->load->view('content/categoria/category-list');
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