<!DOCTYPE html>
<html lang="<?=$language?>">
<?php
// $language=$destino['lang'];
?>
<head>
  <title><?=$resultado['actual']['titulo_pagina']?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?=$resultado['actual']['descripcion_pagina']?>">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta property="og:title" content="<?=$resultado['actual']['titulo_pagina']?>" />
  <meta property="og:url" content="<?=$resultado['actual']['url_servicio']?>" />
  <meta property="og:image" content="<?=$resultado['actual']['slider_img']?>" />
  <meta property=”og:description” content="<?=$resultado['actual']['descripcion_pagina']?>" />
<!--
  <script src="<?=base_url();?>assets/resources/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
  -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <?php
    $this->load->view('header/js');
    
  ?>
  
<!-- Global site tag (gtag.js) - Google AdWords: 946004111 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-946004111"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-946004111');
</script>
  

<?php if($resultado['actual']['id_servicio']==81){ ?>
<!-- Event snippet for Compra Garantizada conversion page -->
<script>
  /*
  gtag('event', 'conversion', {
      'send_to': 'AW-946004111/QxKVCOTJpnkQj8GLwwM',
      'value': 19.0,
      'currency': 'USD',
      'transaction_id': ''
  });
  */
</script>
<?php }?>
<style>
    .btn-carrot{
        background:#fb6d54!important;
        color:#fff;
    }
</style>
<script type="application/ld+json">
  {
  "@context": "http://schema.org",
  "@type": "ItemList",
  "itemListElement": [
  <?php foreach ($ldjson_carrusel as $key => $value){ ?>
    {
      "@type": "ListItem",
      "position": "<?=$key+1;?>",
      "item": {
        "@type": "Product",
        "url":"<?=$value['item_url'];?>",
            "name": "<?=$value['item_name'];?>",
            "image": <?=json_encode($value['item_image'])?>,
        "description":"<?=$value['item_description'];?>",
        "brand": {
          "@type": "Place",
          "name": "<?=$value['item_brand_name'];?>"
        },
        "aggregateRating": {
          "@type": "AggregateRating",
          "ratingValue": "4.4",
          "ratingCount": "95"
        },
        "offers": {
          "@type": "AggregateOffer",
          "highPrice": "<?=$value['item_offers_prince'];?>",
          "priceCurrency": "USD"
        }
      }
    }<?php if ($key+1<count($ldjson_carrusel)){ ?>,<?php } ?>

    <?php } ?>
  ]
}
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
      <!— Google Tag Manager (noscript) —>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NXX7V7S"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!— End Google Tag Manager (noscript) —>
    <header>
      <?php
        $this->load->view('header/header');
        $this->load->view('header/menu');
echo "<script>
        var resultado=".json_encode($resultado).";
        console.log(resultado);
        </script>";
      ?>
    </header>
    <content id="content" class="content container-fluid">
      <?php
        $this->load->view('content/page/page-details');
      ?>
      <?php
        // lA SUSCIRPCIÓN NO DEBE APARECER EN LAS ACTIVIDADES CON ID 640 Y 631; POR QUE SON SERVICIOS DE BUS
        if( (Integer)@$resultado['actividades'][0]['id_producto'] != 640 && (Integer)@$resultado['actividades'][0]['id_producto'] != 631  ){
            $this->load->view('footer/suscripciones');
        }
      ?>
    </content>
    <footer>
      <?php //$this->load->view('footer/footer'); ?>
    </footer>
	
    <?php $this->load->view('script_chat'); ?>
    
  </body>
    <?php
        //$this->load->view('header/js');
        $this->load->view('header/css');
    ?>
    <link rel="stylesheet" href="<?=base_url()?>assets/resources/css/individual-tour/main.css">
  
  <script type="text/javascript" src="<?= url('/assets/resources/js/moment.min.js') ?>"></script>
  <script type="text/javascript" src="<?= url('/assets/resources/js/moment-range.min.js') ?>"></script>

  <script>window['moment-range'].extendMoment(moment);</script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/galleria/1.5.7/galleria.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC2CAVXwufsdT5TX3UPk7hZ3HHw3NZl_c&libraries=places" async defer></script>
  <script src="<?=base_url()?>assets/incalakemap/inacalakeMap.js"></script>
  <link rel="stylesheet" href="<?=base_url()?>assets/resources/tabs/tab.css">

  <link rel="stylesheet" type="text/css" href="<?= url('/assets/resources/css/app_.css') ?>">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <link rel="stylesheet" href="<?=base_url(); ?>assets/resources/css/footer.css">
  <!-- integracion feijo -->
  <script type="text/javascript" src="<?= url('assets/resources/js/zabuto_calendar.js') ?>"></script>
      <script type="text/javascript" src="<?= url('assets/resources/js/helpers.js') ?>"></script>
        <script type="text/javascript" src="<?= url('assets/resources/js/dev_.js') ?>"></script>
        <script type="text/javascript" src="<?= url('assets/resources/js/js.cookie.js') ?>"></script>
        <script type="text/javascript"> var base_url = "<?= base_url() ?>"; </script>
        
        <!-- https://github.com/marcuswestin/store.js/ Library localStorage -->
        <script type="text/javascript" src="<?= url('assets/resources/js/store.legacy.min.js') ?>"></script>
        <script type="text/javascript" src="<?= url('assets/resources/js/app.js'); ?>"></script>
</html>