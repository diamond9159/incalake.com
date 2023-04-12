<?php
  $detalles_pagina;//varible que contiene toda la informacion de la pagina
?>
<!DOCTYPE html>
<html lang="<?=strtolower(@$language);?>">
<head>
<meta name="google-site-verification" content="qy9vxQEC9LYKLrPOeKqRxhTQTCu1u7T_ReVvsvugjeY" />
<title><?=$detalles_pagina['titulo'];?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?=$detalles_pagina['descripcion'];?>">
	<meta name="keywords" content="<?=$detalles_pagina['keywords'];?>">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta property="og:title" content="<?=$detalles_pagina['titulo'];?>" />
	<meta property="og:url" content="<?=$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]?>" />
	<meta property=”og:description” content="<?=$detalles_pagina['descripcion'];?>" />
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/flag/flag.min.css">
	<?php
		$this->load->view('header/css');
		$this->load->view('header/js');
	?>

	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/footer.css">

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109542775-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-109542775-1');
</script>
</head>
	<body>
		<header>
			<?php
				$this->load->view('header/header');
				$this->load->view('header/menu');
			?>
		</header>
		<content>
		 <div style="margin:10px">
		    <?php
				echo $detalles_pagina['contenido'];
			?>
	     </div>
	</content>
	<footer class="footer">
			<?php $this->load->view('footer/footer'); ?>
	</footer>
	<style>
		.sitemap-list,.sitemap-list ul{
			list-style:none;
		}
		.sitemap-list > li{
			margin-bottom:10px;
			background:#f5f5eb;
			padding:3px;
			font-size:1em;
		}
		.sitemap-list  ul{
			margin-bottom:10px;

		}

	</style>
	    <?php $this->load->view('script_chat'); ?>
	</body>
</html>