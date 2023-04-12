<script src="//incalake.com/mobile/menu.all.js"></script>
   
<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/mmenu/demo.css"  media="none" onload="if(media!='all')media='all'">
<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/header.m.css"  media="none" onload="if(media!='all')media='all'">
<link rel="stylesheet" href="//incalake.com/mobile/menu.all.css"  media="none" onload="if(media!='all')media='all'"/>
	

<script>
	
	$(document).ready(function()
	{
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

		$(document).ready(function()
		{
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

	  });  
	});

</script>