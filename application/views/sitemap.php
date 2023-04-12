<!DOCTYPE html>
<html lang="<?=strtolower($language);?>">
<head>
<meta name="google-site-verification" content="qy9vxQEC9LYKLrPOeKqRxhTQTCu1u7T_ReVvsvugjeY" />
<title>Incalake Sitemap</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?=($language=='es'?'Agencia de viajes en la región de Puno y el Lago Titicaca, brinda diferentes servicios turísticos a Puno, Cusco, Arequipa, La Paz, Uyuni.':'Travel agency in Puno region and Lake Titicaca, offer different services towards Puno, Cusco, Arequipa, La Paz, and Uyuni.') ?>">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta property="og:title" content="<?=($language=='es'?'Agencia de viajes en Puno y el Lago Titicaca, expertos en el área del Titicaca | Inca Lake oficial ':'Travel agency in Puno and Lake Titicaca tours, experts on Titicaca | Inca Lake official') ?>" />
	<meta property="og:url" content="<?=$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]?>" />
	<meta property=”og:description” content="<?=($language=='es'?'Mapa de sitio de la Agencia de viajes en la región de Puno y el Lago Titicaca, brinda diferentes servicios turísticos a Puno, Cusco, Arequipa, La Paz, Uyuni.':'Travel agency in Puno region and Lake Titicaca, offer different services towards Puno, Cusco, Arequipa, La Paz, and Uyuni.') ?>" />
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
		 <div class="container" style="margin:10px auto 10px auto">
		   <div class="card">
			 <div class="card-header" style="font-size:1.3em">Inca Lake Sitemap</div>
			 <div class="card-body">
	          <ul class="sitemap-list">
	<?php
		$dir = "assets/menu/";
		$file = $dir.strtoupper($language).'.txt';
		$file = file_exists($file)?$file:$dir.'EN'.'.txt';
		$json = null;
		
				$myfile = fopen($file, "r");
			$json = @fread($myfile,filesize($file));
			fclose($myfile);
			

		$json = json_decode($json,true);

		function get_sitemap_tree($json,$parent_id=0,$window=0){ 
			$menu = "";
				if(is_array(@$json[$parent_id])){
					foreach($json[$parent_id] as $key => $value){
						if(!empty($value['nombre'])){
							$cantidad = @count($json[$value['id']]);
							$menu .="<li> 
								<a ".($cantidad?'style="font-weight:bold;border-bottom:1px dashed #91c8ff"':null)." href='".($value['url']?$value['url']:'#')."'>
								<span class='".($value['icono']?$value['icono']:'fa fa-caret-right')."'></span> "
								.$value['nombre'].
								"</a>".
								($cantidad?"<ul>".get_sitemap_tree($json,$value['id'])."</ul>":null)
							."</li>"; 
						}
					
					}

					}
				
				return $menu;
		}
        echo get_sitemap_tree($json,0);
	?>
		   </ul>
	     </div>
	   </div>
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
	</body>
</html>