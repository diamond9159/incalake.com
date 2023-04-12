<?php

	$traduccion_body = arrayTraduccion('body',$language);
	//$this->load->view('php/mobile-detect/Mobile_Detect.php');
	//$this->load->view('php/browser.php');
	
	// set titulo y descripcion segun al idioma
	if($language=='es')
	{
	   $titulo = 'Agencia de viajes en Puno y el Lago Titicaca, expertos en el área del Titicaca | Inca Lake travel agency';
	  $descripcion = 'Agencia de viajes en la región de Puno y el Lago Titicaca, brinda diferentes servicios turísticos a Puno, Cusco, Arequipa, La Paz, Uyuni,  con precios económicos y varias formas de pago.';
	  $keywords = 'inca, lake, tour, puno, peru, paquetes, turismo puno, inca lake, agencia de viajes puno';
	} 
	else 
	{
	  $titulo = 'Travel agency in Puno and Lake Titicaca tours, experts on Titicaca | Inca Lake travel agency';
	  $descripcion = 'Travel agency in Puno region and Lake Titicaca, offer different services towards Puno, Cusco, Arequipa, La Paz, and Uyuni, with low prices and several forms of payment.';
	  $keywords = 'inca, lake, tour, puno, peru, packages, tourism puno, inca lake, travel agency puno';
	}
	
?>


<!DOCTYPE html> 
<html lang="<?=strtolower($language);?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="google-site-verification" content="qy9vxQEC9LYKLrPOeKqRxhTQTCu1u7T_ReVvsvugjeY" />
	<title><?=$titulo;?></title>
	
	<?php $this->load->view('header/css_index'); ?>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?=$descripcion;?>">
	<meta name="keywords" content="<?=$keywords;?>">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta property="og:title" content="<?=$titulo;?>" />
	<meta property="og:url" content="<?=$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]?>" />
	<meta property="og:image" content="<?=$slider_index[0]['imagen']?>" />
	<meta property=”og:description” content="<?=$descripcion;?>" />
  
	<?php
		$idiomas = ['es','en','pt','de','fr'];
		$html_alternate = null;
		foreach ($idiomas as $value) 
			$html_alternate .= "\t <link rel='alternate' hreflang='$value' href='//incalake.com/$value' />\n";
		echo $html_alternate;
	?>
	
	<script src="<?=base_url(); ?>assets/resources/js/global_index_js.js"></script>
	<script src="<?=base_url(); ?>assets/resources/js/detect-phone.js"></script>
	<script src="<?=base_url(); ?>assets/resources/js/detect-browser.js"></script>
	
	<!-- Google Tag Manager -->
	<script>
		(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-NXX7V7S');
	</script>

</head>


<body>
	
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXX7V7S"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

	
	<header class="container-fluid" style="padding:0;">
		<a href="" target="_blank"></a>
	</header>
	
	<content id="content" class="content container-fluid" style="padding:0;">
	  <?php $this->load->view('content/page/index_index'); ?>
	</content>
	
	<footer class="footer">
	</footer>
	
	
	<div class="modal bd-example-modal-sm" id="myModal">
	  <div class="modal-dialog modal-md">
		<div class="modal-content">
		  <div class="modal-header bg-primary text-light">
			<h5 class="modal-title" id="exampleModalLabel"><?=(strtolower($language)=='es'?'Recomendacion':'Recommendation')?></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body text-justify">
			<?=(strtolower($language)=='es'?'Le recomendamos utilizar <a href="//www.google.es/chrome" target="_blank"><b>"Google Chrome"</b></a>, <a href="https://www.mozilla.org/es-ES/firefox/new/" target="_blank"><b>"Mozilla Firefox"</b></a>  o <b>actualizar su navegador</b> para mejorar la <b>velocidad</b>, compatibilidad de <b>nuevas tecnologias</b> y sobre todo su <b>comodidad y mejor experiencia</b>':'We recommend you use <a href="//www.google.com/intl/en/chrome" target="_blank"><b>"Google Chrome"</b></a> or update your browser to improve speed, <b>compatibility of new technologies</b> and especially its quality and<b> better experience </b>');?>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary btn_close_browser" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary btn_ok_browser" data-dismiss="modal">Ok</button>
		  </div>
		</div>
	  </div>
	</div>
	
	
	<?php
		//$browser = new Browser();
		$this->load->view('header/js_index');
	?>
	
	<?php
		//$browser = new Browser();
		//$name_browser=$browser->getBrowser();
		//$ver_browser=$browser->getVersion();
	?>
	
	<script>
		
		// Get the modal
		var browser = getBrowserInfo().split(' ');
		
		var name_browser = browser[0].toUpperCase();
		var ver_browser = parseFloat(browser[1]);

		var modal = document.getElementById('myModal');
		var btn = document.getElementById("myBtn");
		var span = document.getElementsByClassName("close")[0];
		var btn_close =document.getElementsByClassName("btn_close_browser")[0];
		var btn_ok=document.getElementsByClassName("btn_ok_browser")[0];

		span.onclick = function() {
			modal.style.display = "none";
		}
		btn_close.onclick=function(){
		  modal.style.display='none';
		}
		window.onclick = function(event) {
			if (event.target == modal) 
				modal.style.display = "none";
		}

		if (typeof(Storage) !== "undefined") 
		{
			// Store
			if (sessionStorage.getItem("modal_browser_help")==null) 
			  sessionStorage.setItem('modal_browser_help', 1);
		}else 
			console.log("Sorry, your browser does not support Web Storage...");

		if (sessionStorage.getItem("modal_browser_help")==1) 
		{
			switch(name_browser) 
			{
				case 'OPERA':
					if (ver_browser>=11.51) {}else{modal.style.display = 'block';}
					break;
				case 'EDGE':
					if (ver_browser>=15) {}else{modal.style.display = 'block';}
					break;
				case 'CHROME':
					if (ver_browser>=61) {}else{modal.style.display = 'block';}
					break;
				case 'FIREFOX':
					if (ver_browser>=52) {}else{modal.style.display = 'block';}
					break;
				case 'SAFARI':
					if (ver_browser>=10.1) {}else{modal.style.display = 'block';}
					break;
				default:
					modal.style.display = 'block';
			}
			
			// modal.style.display = 'block';
			btn_ok.onclick=function(event)
			{
				sessionStorage.setItem('modal_browser_help', 0);
				modal.style.display = "none";
				console.log(sessionStorage.getItem("modal_browser_help"));
			}
		}  
	</script>
	
	<style>
		.modal{
			background: #000000a3;
		}
		/*header*/.header{z-index: 1 !important;}
		.carousel-caption .title a{color:#fff;text-transform:capitalize;font-weight:700}.fondo-slider{position:absolute;height:100%;top:0;background:#00000012;width:100%;box-shadow:inset 0 -1px 20px 1px #000}#slider-index{min-height:150px}#slider-index .carousel-item{padding:0;height:400px;overflow:hidden;-webkit-transition-property:opacity;transition-property:opacity}#slider-index .carousel-inner .carousel-item,#slider-index .carousel-inner .carousel-item.active.left,#slider-index .carousel-inner .carousel-item.active.right{opacity:1}#slider-index .carousel-item.active{opacity:1}#slider-index .img-slider{width:100%;height:auto;opacity:1;position:absolute;left:-100%;right:-100%;top:-100%;bottom:-100%;margin:auto;min-height:100%;min-width:100%}.carousel-indicators{z-index:1}.carousel-caption{top:20px;bottom:0}#slider-index .carousel-item .carousel-caption{opacity:0;transition:opacity 1.5s ease-in-out}#slider-index .carousel-item.active .carousel-caption{opacity:1}@media (max-width: 600px){#slider-index .carousel-item{height:200px}#slider-index .carousel-caption{top:20px;bottom:0;top:auto;width:100%;padding:1%;right:0;left:0;background:rgba(43,153,47,0.62)}#slider-index .title.carousel.tour{font-size:14px;margin:0}}.div-description-porque-elegirnos{color:#fff}.div-description-porque-elegirnos>:first-child{padding:10px;background:#2b992f}.div-porque-elegirnos{background:#0667ac;margin:0;padding:0}.div-porque-elegirnos .item-porque-elegirnos{padding:0}.div-porque-elegirnos .item-porque-elegirnos>a{width:100%!important;color:#fff!important}.div-porque-elegirnos .item-porque-elegirnos>a:hover{background:#1a4c80;border:none}.div-porque-elegirnos .item-porque-elegirnos>a.active{background:#1a4c80;border:none}.div-txt-porque-elegirnos{display:flex!important;align-items:center!important}.div-porque-elegirnos .txt-porque-elegirnos:nth-child(n+2){margin-left:2%}.inputWithIcon{position:relative}.inputWithIcon span{height:100%;position:absolute}.inputWithIcon input[type=text]:focus + span{color:#1e90ff}.inputWithIcon.inputIconBg span{background-color:#2cae4a;color:#fff;padding:9px 7px;right:0}.inputWithIcon.inputIconBg input[type=text]:focus + span{color:#fff;background-color:#1e90ff}.div-search{position:absolute;top:55%;width:100%;text-align:center;z-index:1}@media (max-width: 768px){.div-search{position:relative}}.div-title .div-content-title{margin:2% 0}.image-tour .div-img{position:relative;background:rgba(0,0,0,0.16);height:200px}.image-tour figcaption{position:absolute;text-align:right;color:#e5e5e5;line-height:16px;font-weight:700;transition:.2s;text-align:left;text-transform:capitalize;bottom:0;left:0;padding:1%;background:#bd00ff;margin-bottom:2%;margin-left:2%}.image-tour figcaption hr{border:none;border-bottom:1px solid #c9c9c9;margin-top:10px;margin-right:0;width:100%}.image-tour figcaption strong{font-size:16px}.image-tour figcaption small{font-size:19px;letter-spacing:1px}.image-tour figcaption div a{border:1px solid #f5f5f5;width:170px;padding:5px 20px;color:#fff;font-weight:700;font-size:13px}.div-full{width:100%!important;padding:0!important;margin:0!important}.div-destino{margin-bottom:1%;padding:0!important}.card-destino{background:#fff;box-shadow:0 0 5px 0 rgba(0,0,0,0.5);position:relative}.card-destino ul{padding-left:15px;list-style-type:square;color:#039BE5}.card-destino ul li a{color:#000;text-transform:capitalize}.card-destino ul li a:hover{color:#007bff}.text-content-destino{font-size:15px;padding:5px}.txt-div-destino>span{font-weight:700}.div-result-search{padding:0!important;margin:0!important;border-right:solid 1px #ddd;border-left:solid 1px #ddd;border-bottom:solid 1px #ddd}.div-result-search .div-result-content-default{margin:0;padding:1.5% 0;display:none}.div-result-search .div-result-content-search{margin:0;padding:1.5% 0;display:none}.div-result-search .div-result-content-search #coincidencias_locations,.div-result-search .div-result-content-search #coincidencias_activities{padding:0}.div-result-search .div-txt-search-destiny,.div-result-search .div-txt-search-activity{border-bottom:solid 1px #ddd;padding-top:.5%;padding-bottom:.5%}.div-result-search .div-destiny-search{background:#4bb436;color:#f5f5f5}.div-result-search .div-activity-search{background:#4bb436;color:#f5f5f5}.div-result-search ul{list-style-type:none;padding:0}.div-result-search ul li a{color:#000;text-transform:capitalize}.div-result-search ul li:hover a{color:#007bff}.div-result-search #solo-cuando-no-encuentra{display:none}</style> <style>
		/*OFERTAS*/
		.div-content-ofertas{position:absolute;height:100%;width:100%;top:0;background:rgba(21,155,27,0.81)}.div-count-ofertas{position:absolute;width:100%;text-align:center;right:0;font-size:2rem;color:#fff}.div-count-ofertas .num{font-size:3rem;font-weight:700}.div_ver_ofertas{position:absolute;bottom:21%;width:100%;text-align:center;right:0;font-size:1rem;font-weight:700;color:#fff}.div_ver_ofertas a{color:#fff}.div_ver_ofertas span{border:solid 1px #fff;padding:3%;cursor:pointer}.div_ver_ofertas span:hover{background:#28a22d}.color-text-10{color:#fff!important}  
		/*footer          */
		.title-panel.list-group-item {
			font-weight: 700;
			background: none;
			color: #aaa8a8;
			border: none;
			cursor: pointer;
		}
		.title-panel.list-group-item:hover{
			background: none;
			color: #fff;
		}
		.sublinks ul li a{
			color: #f5f5f5;
		}
		.sublinks ul li a:hover{
			color: #fff ;
		}
		footer .panel {
			background: none !important;
		}          
	</style>
	
	<script>
		const loc_act = JSON.parse(`<?=json_encode($search)?>`);
		console.log(loc_act);
		const language = JSON.parse('<?=json_encode($language)?>');
		//const destinos = JSON.parse(`<?=json_encode($destinos)?>`);
		console.log(destinos);
		var locations = [];
		var activities = [];
		// Abrir div donde se muestrar resultados
		function abrir_div_resultados()
		{
			if(!!locations.length || !!activities.length){
				mostrar_filtrados();
			}else if(document.getElementById('input-search').value.trim().length>0)
			{
				let tmp_html = `
				<!--<div>
					No se encontraron resultados
				</div>-->
				<button type="button" class="btn btn-primary" onclick="abrirModalDeGoogle()">
					Buscar "${document.getElementById('input-search').value.trim()}" en google
				</button>
				`;
		
				$('.div-result-content-default').css('display','none');
				$('.div-result-content-search').css('display','block');
			}else
			{
				$('.div-result-content-default').css('display','block');
				$('.div-result-content-search').css('display','none');
			}
		}
		// Cuando hace keyup mostramos coincidencias, si hay caracteres
		function mostrar_filtrados()
		{
			let text = $("#input-search").val()?$("#input-search").val():'';
			text = text.trim().toLowerCase();
			if(text=='')
			{
				$('.div-result-content-default').css('display','block');
				$('.div-result-content-search').css('display','none');
				return;
			}
			locations  = loc_act.location.filter(function(location){
				return location.descripcion.toLowerCase().indexOf(text) != -1;
			}).sort(function(a,b)
			{
				if (a.count < b.count ) 
					return 1;
				if (a.count > b.count) 
					return -1;
				return 0;
			});
			var temp_a=[];
			var temp_b=[];
			activities = loc_act.activity.filter(function(activity){
				return activity.descripcion.toLowerCase().indexOf(text) != -1;
			}).sort(function (a, b) 
			{
				temp_a=a.duracion.split("!");
				temp_b=b.duracion.split("!");
				console.log(temp_a[1]);
				if (temp_a[1]+temp_a[0] > temp_b[1]+temp_b[0] )
					return 1;
				if (temp_a[1]+temp_a[0] < temp_b[1]+temp_b[0]) 
					return -1;
				return 0;
			});
	  
			text_locations = '';
			text_activities = '';
			var lenguaje="<?=$language;?>"
			lenguaje=='es'?temp_actividades='actividad':temp_actividades='activity';
			locations.forEach(function(location){
				text_locations = text_locations + `
					<div class="col-md-12 text-left div-txt-search-destiny">
						<a style="width:100%; display:inline-block;" href="${location.url}" ><b class="float-right text-dark">${location.count} 
						${location.count>1?(lenguaje=='es'?temp_actividades+'es':temp_actividades.substring(0,7)+'ies'):(temp_actividades)}</b><b>${location.descripcion}
						</b></a>
					</div>
				`;
			});
			var array_duraciones=[];
			if ("<?=$language;?>"=="es") 
				array_duraciones = ['minuto','hora','dia'];
			else
				array_duraciones = ['minute','hour','day']
	

			activities.forEach(function(activity)
			{
				var duracion = ' -- ';
				if(activity.duracion)
				{
					duracion = activity.duracion.split('!');
					duracion[1] = array_duraciones[duracion[1]];
					duracion = duracion[0] +' '+duracion[1]+ (parseInt(duracion[0])>1?'s':'');
				}
			
			
				text_activities = text_activities + `
					<div class="col-md-12 text-left div-txt-search-activity">
						<b class="pull-right">${duracion}</b>
						<b><a href="${activity.url}">${activity.descripcion}
						</a></b>
					</div>
				`;
			});
	  
			if(!!locations.length) 
			{
				text_locations = `
					<div class="col-md-12 div-destiny-search text-left">
						<b>${language=='es'?'Destinos Populares':'Popular Destinations'}
						<span class="float-right">${language=='es'?'#Actividades':'#Activities'}</span></b>
					</div>
				` + text_locations;
			}
	  
			if(!!activities.length) 
			{
				text_activities = `
					<div class="col-md-12 div-activity-search text-left">
						<b>${language=='es'?'Recorridos y actividades':'Tours and Activities'}
						<span class="pull-right">${language=='es'?'Duraci&oacute;n':'Duration'}</span></b>
					</div>
				` + text_activities;
			}
	  
			let tmp_html = '';
			if(!locations.length && !activities.length)
			{
				tmp_html = `
				<button type="button" class="btn btn-primary" onclick="abrirModalDeGoogle()">
					Buscar "${document.getElementById('input-search').value.trim()}" 
					</button>
				`;
			}
	  
	  
			$('#coincidencias_locations').html(text_locations);
			$('#coincidencias_activities').html(text_activities);
			
			if (text_activities.length==0&&text_locations.length==0&&document.getElementById('input-search').value.trim().length>0) 
			
				$('#solo-cuando-no-encuentra').css('display', 'block');
			
			else
				$('#solo-cuando-no-encuentra').css('display', 'none');
	  
			$('.div-result-content-default').css('display','none');
			$('.div-result-content-search').css('display','inline-block');
		}
	  
		function abrirModalDeGoogle()
		{
			$("#input_lol").val($("#input-search").val());
			$('.btn-search').click();//Trigger search button click event
		}
	  
		$(document).on('keyup',"#input-search",mostrar_filtrados);
		
		$(document).on('keyup', '#input-search', function(event) 
		{
			var code = event.which;
			$("#input_lol").val($("#input-search").val());
			if(code==13)
				$('.btn-search').click();//Trigger search button click event
		});
	  
	  
	
		var focus = false;
		$("#input-search,.div-result-search").mouseenter(function() {
			focus = true;
		}).mouseleave(function() {
			focus = false;
		});
		
		$(document).on('click', 'html', function(event) 
		{
			if (!focus) 
			{
				$('.div-result-content-default').css('display','none');
				$('.div-result-content-search').css('display','none');
			}
		});
		$(document).on('click', '#input-search', function(event) {
			abrir_div_resultados();
		});
		// modal comentarios
		$(document).ready(function($) {
			$('#comentariosModal').on('hidden.bs.modal', function (e) {
				$('#comentariosModal .embed-responsive-item').attr('src', '');
			})
			$('#comentariosModal').on('show.bs.modal', function (e) {
				$('#comentariosModal .embed-responsive-item').attr('src', $('.btn-view-coments').data("urlvideo"));
			})
		});
		
		$('#slider-index').carousel({
			interval: 6000,
			pause:'hover'
		});

		$(document).on('click', '.div-txt-search-destiny a', function(event) 
		{
			var expires;
			var date = new Date();
			date.setTime(date.getTime() + (1 * 24 * 60 * 60 * 1000));
			expires = "; expires=" + date.toGMTString();

			document.cookie = escape('url_destino') + "=" + escape($(this).children().first().html()) + expires + "; path=/";
		});  
	</script>
	
	<?php $this->load->view('script_chat'); ?>
	
</body>


 <?php if( false ){ ?> <!-- Ya no mostramos los feeds del blog por motivos de SEO -->
	
	<script type="text/javascript">
		jQuery(document).ready(function($) 
		{
			$.ajax("https://incalake.com/blog/feed/", {
				accepts:{
					xml:"application/rss+xml"
				},
				dataType:"xml",
				success:function(data) {
					var count = 0;
					var htmlPosts = '';
					htmlPosts += 	'<div class="col-11 col-sm-11 col-lg-10">'+
										'<hr class="col-md-12">'+
											'<div class="row">'+
												'<div class="col-md-12 text-center div-title">'+
													'<h4 class="div-content-title">'+
														'<strong><?=(mb_strtolower(@$language)==="es"?"NUESTROS ÚLTIMOS POSTS":"OUR LAST POSTS")?></strong></h4>'+
												'</div>';
												
					$(data).find("item").each(function()
					{
						var el = $(this);
						if(count <= 3) 
						{
							htmlPosts +=    '<div class="col-12 col-sm-6 col-md-3 col-xl-3">'+
												'<div class="card">'+
													'<div class="card-header pb-0 mb-0" style="background:#1e6496;">'+
														'<a href="'+el.find('link').text()+'" style="text-decoration:none;" target="_blank"><h5 class="card-title text-white" title="'+(el.find('title').text())+'"><span class="fa fa-rss-square text-warning"></span> '+(el.find('title').text()).substr(0,35)+'...</h5></a>'+
													'</div>'+
													'<div class="card-body" style="min-height:25em;max-height:25em;width:100%;overflow-y:hidden;">'+
														'<p class="card-text text-justify">'+el.find('description').text()+'</p>'+	
													'</div>'+
													'<div class="card-footer text-center p-0">'+
														'<button class="fa fa-facebook-square btn text-primary button" data-sharer="facebook" data-url="'+el.find('link').text()+'"></button>'+
														'<button class="fa fa-twitter-square btn text-primary button" data-sharer="twitter" data-title="'+el.find('title').text()+'" data-hashtags="awesome, sharer.js" data-url="'+el.find('link').text()+'"></button>'+
														'<button class="fa fa-whatsapp btn text-success button" data-sharer="whatsapp" data-title="'+el.find('title').text()+'" data-url="'+el.find('link').text()+'"></button>'+
													'</div>'+
												'</div>'+
											'</div>';
						}
						count++;
					});
					
					htmlPosts += 		'</div>'+
								'</div>';
					$('.div-posts-index').empty().append(htmlPosts);
				}	
			});
		});
	</script>
	
	<?php } ?>
	
	<script src="https://cdn.jsdelivr.net/npm/sharer.js@0.3.3/sharer.min.js"></script>
	
</html>
