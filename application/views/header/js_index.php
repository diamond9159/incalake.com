<!-- Global site tag (gtag.js) - Google Analytics by froy -->

<?php 
	//$detect = new Mobile_Detect; 
	//$temp=$detect->isMobile()?1:0;
?>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109542775-1"></script>

<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'UA-109542775-1');
	gtag('config', 'AW-946004111');
</script>


<script>

window.addEventListener('load', function() 
{
	console.log('All assets are loaded');
	
	// load css 
	$('html').append(`
		<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/font-awesome/css/font-awesome.4.7.0.min.css" media="none" onload="if(media!='all')media='all'">
		<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/flag/flag.min.css" media="none" onload="if(media!='all')media='all'">  
		<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/index.css" media="none" onload="if(media!='all')media='all'">
		<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/footer.css" media="none" onload="if(media!='all')media='all'">
		<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/ofertas.css" media="none" onload="if(media!='all')media='all'">
	`);


	$('.dropdown-menu a.dropdown-toggle').on('click', function(e) 
	{
		if (!$(this).next().hasClass('show')) 
			$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
	  
		var $subMenu = $(this).next(".dropdown-menu");
		$subMenu.toggleClass('show');
		
		$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
			$('.dropdown-submenu .show').removeClass("show");
		});
		
		return false;
	});

	
	setTimeout(peticion, 5000);
	
	function peticion()
	{
		$("header").append(`<?=$this->load->view('header/header_index.php');?>`);
		
		$.ajax({
			url: '<?=base_url()?>menu/menuweb/'+document.documentElement.lang+'/'+detectPhone(),
			type: 'GET',
			dataType: 'html',
			data: {},
		}).done(function(data) 
		{
			$("header").append(data);
			
			if(!detectPhone())
			{
				$('#main-menu').smartmenus();
			}
			
			else
			{
				$(function() 
				{
					$("#menu").mmenu({
						extensions      : [ "shadow-page", "theme-white", "pagedim-black" ],
						counters        : true,
						searchfield     : {
							resultsPanel    : true
						},
						navbar          : {
							title           : "TOURS INCALAKE"
						},
						navbars     : [{
							content: [
								'<span style="line-height: 52px;"><a href="tel:+51949755305" class="fa fa-phone"></a></span>',
								'<span><img src="//incalake.com/img/logo_2.png" /></span>',
								'<span style="line-height: 52px;"><a href="sms://+51949755305?body=I%27m%20interested%20in%20your%20product.%20Please%20contact%20me." class="fa fa-envelope"></a></span>',
								"searchfield"
							]
						}, true]
					}, 
					{}).on( 'click',
						'a[href^="#/"]',
						function() 
						{
							alert( "Thank you for clicking, but that's a demo link." );
							return false;
						}
					);
				});
			}


			(function () 
			{
				var cx = '014210685266793079517:tb6pzsyd9ti';
				var gcse = document.createElement('script');
				gcse.type = 'text/javascript';
				gcse.async = false;
				gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +'//www.google.com/cse/cse.js?cx=' + cx;
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(gcse, s);
			})();
  
  
			//cookies
			var cartCliente;
		
			if(Cookies.get('cart')) 
			  cartCliente = JSON.parse(Cookies.get('cart'));
			else 
			{
				Cookies.set('cart', []);
				cartCliente = [];
			}

			if(cartCliente.length)
			{
				$("#count-cart").show();
				$("#count-cart").text(cartCliente.length);
			}
			else 
				$("#count-cart").hide();


			/*para el buscador*/
			$('#input_lol').keyup(function(e)
			{
				var code = e.which;
				if(code==13)
				{
					$('.btn-search').click(); //Trigger search button click event
					$("#searchGoogleModal2").modal();
				}
			});
  
			$(".btn-search").click(function () 
			{
				var input = $("#input-search");
				var element = google.search.cse.element.getElement('searchresults-only0');
				element.execute(input.val());
				$("#search_modal").val(input.val());
			});
  
			$('#search_modal').keypress(function (e) 
			{
				if (e.which == 13) 
					$('.btn-search-button').click();
			});


			$(document).on('click', '.btn-search-button', function(event) 
			{
				var input = $("#search_modal");
				var element = google.search.cse.element.getElement('searchresults-only0');
				element.execute(input.val());
			});
			
			$(document).on('click', '.btn-search-button-mobile', function(event) 
			{
				$("#searchGoogleModal2").modal();
				$('#search_modal').focus();
			});
			
			$(".div-destinos-index").append(`<?=$this->load->view('destinos_index.php');?>`);
			  
			for (var i = 0; i < destinos.length; i++) 
				$("#id-"+destinos[i].id_temp_destino).find(".img-activity").attr('src', $("#id-"+destinos[i].id_temp_destino).find(".img-activity").data('img'));

			$(".div-ofertas-index").append(`<?=$this->load->view('ofertas_index.php');?>`);
			
			<?php $mas_comprados['type_mas_comprados'] = 1; ?>
			
			$(".div-comprados-index").append(`<?=$this->load->view('mas_comprados_index.php',$mas_comprados);?>`);


			<?php
				$temp_list='';
				$temp_img_list='';
				foreach ($slider_index  as $key => $value)
				{
					if(!empty($value) && $key>=1)
					{
						$temp_list .= '<li data-target="#slider-index" data-slide-to="'.$key.'"></li>';
						$temp_img_list .= 
						'<div class="carousel-item">
							<img class="d-block w-100 img-slider" src="'.$value['imagen'].'" alt="First slide">
							<div class="carousel-caption">
								<h3 class="title carousel tour"><a href="'.$value['url'].'">'.$value['titulo'].'</a></h3>
								<p class="d-sm-none d-none d-md-block">'.$value['descripcion'].'</p>
							</div>
							<div class="fondo-slider"></div>
						</div>';
					}
				}
			?>
			
			
			console.log(`<?=json_encode($slider_index);?>`);
			
			$('#slider-index .carousel-indicators').append(`<?=$temp_list;?>`);
			$('#slider-index .carousel-inner').append(`<?=$temp_img_list;?>`);
			$("footer").append(`<?=$this->load->view('footer/footer_index.php');?>`);
			
			$('.div-header-main').prependTo($('.incalake-menu'));
		
			
		}).fail(function(e) {
			console.log(e.responseText);
		});

	}

}); 

</script>


<script>

	$(document).ready(function()
	{
		$('.dropdown-submenu a.test').on("click", function(e)
		{
			$(this).next('ul').toggle();
			e.stopPropagation();
			e.preventDefault();
		});
	  
		/*para los dropdown*/
		$('.dropdown-toggle').dropdown()
	});


	$('#search_modal').addClass('form-control').css('width', '100%');
	
</script>


<?php
	//$this->load->view('header/menu-mobil-js.php');
	//$this->load->view('header/menu-desktop-js.php');
?>


<script src="//incalake.com/mobile/menu.all.js"></script>
<script src="<?=base_url(); ?>assets/resources/js/jquery.smartmenus.min.js"></script>


<script>

	// HEADER
	$(document).ready(function() 
	{
		if(detectPhone()) // cargar script para menu phone
		{

			$('head').append(`<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/mmenu/demo.css"  media="none" onload="if(media!='all')media='all'">`)
			$('head').append(`<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/header.m.css"  media="none" onload="if(media!='all')media='all'">`)
			$('head').append(`<link rel="stylesheet" href="//incalake.com/mobile/menu.all.css"  media="none" onload="if(media!='all')media='all'"/>`)
			
			
			var count = 0;
			
			
			$('.mm-listview>li').click(function()
			{
				count += 1;

				if(count==1)
					$('.mm-hasbtns>.mm-title').css('background','#2376B1');
				else if(count==2)
					$('.mm-hasbtns>.mm-title').css('background','#1c84cf');
				else
					$('.mm-hasbtns>.mm-title').css('background','#1E6496');                 
			});

			$('.mm-hasbtns').click(function()
			{
				count -= 1;

				if(count==1)
					$('.mm-hasbtns>.mm-title').css('background','#2376B1');
				else if(count==2)
					$('.mm-hasbtns>.mm-title').css('background','#1c84cf');
				else
					$('.mm-hasbtns>.mm-title').css('background','#1E6496');
			});

			var temp_scroll=0;
			$(window).scroll(function(event)
			{
			  var st = $(this).scrollTop();

				if(st > 106)
					$('.header').css({'position':'fixed','top': '0px'});
				else 
					$('.header').css({'position':'relative','top': 'auto'});
			  
			  temp_scroll=st;
			});
			
			$('.precio_tour_gral').parent().css('margin','0px');



			$('#div-mm-close,.mm-blocker').click(function()
			{
			  $('#menu').removeClass("mm-opened");
			  $('html').removeClass('mm-opened mm-blocking mm-background mm-opening');
			});

			$('.header>a').click(function()
			{
				$('#menu').addClass("mm-opened");
				$('html').addClass('mm-opened mm-blocking mm-background mm-opening');
			});

			$('.mm-search').prepend('<div class="input-group-addon fa fa-search" style="width: auto;float: left;border: none;"></div>');
			$('.mm-search input').css('width','87%');

		
			var temp_lag_html=document.documentElement.lang;
			console.log(temp_lag_html.toUpperCase());
			if (temp_lag_html.toLowerCase()=='es') 
				$(".mm-search input").attr("placeholder", "Busque su destino: ejemplo: Uros, Machupicchu, Uyuni, etc");
			else
				$(".mm-search input").attr("placeholder", "Find your destination: e.g. Uros, Machupicchu, Uyuni, etc");

		}


		else // cargar script para modo desktop 
		{
			$('head').append(`<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/menu-desktop.css" media="none" onload="if(media!='all')media='all'">`)

	    var $mainMenuState = $('#main-menu-state');

	    if ($mainMenuState.length) 
	    {
	      // animate mobile menu
	      $mainMenuState.change(function(e) 
	      {
	        var $menu = $('#main-menu');
	        
	        if(this.checked)
	          $menu.hide().slideDown(250, function() { $menu.css('display', ''); });
	        else 
	          $menu.show().slideUp(250, function() { $menu.css('display', ''); });
	      });

	      // hide mobile menu beforeunload
	      $(window).on('beforeunload unload', function() 
	      {
	        if($mainMenuState[0].checked)
	          $mainMenuState[0].click();
	      });
	    }


	    $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function(event) 
	    {
	      event.preventDefault(); 
	      event.stopPropagation(); 
	      $(this).parent().siblings().removeClass('open');
	      $(this).parent().toggleClass('open');
	    });


		  var primera_barra = $('.div-header-main');

		  $(window).scroll(function(event)
		  {
		    var primera_barra = $('.div-header-main');
		    var st = $(this).scrollTop();  
		    var el_menu = $('.incalake-menu');
		    
		    if(st > primera_barra.height())
		      el_menu.addClass('menu_fixed')
		    else 
		      el_menu.removeClass('menu_fixed');
		    
		    temp_scroll=st;
		  });

		}


		$('.div-header-main').prependTo('header>nav');


		
	});
	
</script>
