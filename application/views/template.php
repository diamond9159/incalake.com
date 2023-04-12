<?php
   $traduccion_body = arrayTraduccion('body',$language);
?>
<!DOCTYPE html>
<html lang="<?=strtolower($language);?>">
<head>
  <title><?= isset($title)?$title:'' ?></title>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!--  -->
   <!-- CSS -->
      <link rel="stylesheet" type="text/css" href="<?= url('/assets/resources/css/app_.css') ?>">
  <link rel="stylesheet" href="<?=base_url()?>assets/resources/css/individual-tour/styles.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/resources/css/individual-tour/main.css">
  <link href="<?=base_url()?>assets/resources/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/galleria/1.5.7/galleria.min.js"></script>
  <!--<script src="galleria/plugins/flickr/galleria.flickr.min.js"></script>-->
  <link rel="stylesheet" href="node_modules/semantic-ui-flag/flag.min.css">

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC2CAVXwufsdT5TX3UPk7hZ3HHw3NZl_c&libraries=places" async defer></script>
  <script src="<?=base_url()?>assets/incalakemap/inacalakeMap.js"></script>

  <link rel="stylesheet" href="<?=base_url()?>assets/resources/tabs/tab.css">
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700">
  <style>
    body{
      font-family: 'Source Sans Pro' !important;
    }
    select {
      width: 100%
    }
    .select2-container .select2-selection--single {
      height: 40px;
      padding-top: 5px;
    }
    .select2-selection__arrow {
      top: 7px;
    }

    .sky-tabs{
      font-family: 'Source Sans Pro' !important;
    }
  </style>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

	<?php
		$this->load->view('header/css');
		$this->load->view('header/js');
	?>
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/flag/flag.min.css">
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/header.css">
	<link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/footer.css">

<!-- Global site tag (gtag.js) - Google AdWords: 946004111 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-946004111"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-946004111');
</script>
  
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NXX7V7S');</script>
<!-- End Google Tag Manager -->
</head>
	<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXX7V7S"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

		<header>
			<?php
            /*inicio de las funciones para las urls*/
                $datos['url_idiomas'] = array(
                    'ES'=>base_url('es/checkout/cart'),
                    'EN'=>base_url('en/checkout/cart'),
                    'FR'=>base_url('fr/checkout/cart'),
                    'DE'=>base_url('de/checkout/cart'),
                    'BR'=>base_url('br/checkout/cart'),
                    'IT'=>base_url('it/checkout/cart')
                );
            /*fin de las funciones para el envio de url $datos*/
				$this->load->view('header/header',$datos);
				$this->load->view('header/menu');
			?>
		</header>
		 <main>
          <content id="content">
            <?= $contents ?>
          </content>        
      </main>
    <footer>
			<?php $this->load->view('footer/footer'); ?>
		</footer>

  <!-- integracion feijo -->
    <script>
      [].slice.call( document.querySelectorAll('a[href="#"') ).forEach( function(el) {
          el.addEventListener( 'click', function(ev) { ev.preventDefault(); } );
      });
    </script>
    <!-- moment --> 
    <script type="text/javascript" src="<?= url('/assets/resources/js/select2.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('/assets/resources/js/moment.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('/assets/resources/js/moment-range.min.js') ?>"></script>
    <script>window['moment-range'].extendMoment(moment);</script>
    <script type="text/javascript" src="<?= url('assets/resources/js/helpers.js') ?>"></script>
    <script type="text/javascript" src="<?= url('assets/resources/js/dev_.js'); ?>"></script>
    <script type="text/javascript" src="<?= url('assets/resources/js/zabuto_calendar.js') ?>"></script>

    <script type="text/javascript"> var base_url = "<?= base_url() ?>"; </script>
    <script type="text/javascript" src="<?= url('assets/resources/js/store.legacy.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('assets/resources/js/app.js'); ?>"></script>

    <?= isset($script)?$script:'' ?>
     
  </body>
</html>
