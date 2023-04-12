<?php
//var_dump($menu_language);
   $traduccion_body = arrayTraduccion('body',$language);
?>

<!DOCTYPE html>
<html lang="<?=$traduccion_body['language'];?>">
<head>
	<meta charset="utf-8">
	<title>Inca Lake Travel Agency</title>
	<meta name="description" content="" />
	<meta name="theme-color" content="#1570A6" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="robots" content="noindex, nofollow" />

	<?php
		$this->load->view('header/css');
		$this->load->view('header/js');
	?>
	
	<link rel="stylesheet" href="<?= url('assets/resources/css/header.css') ?>" />
	<link rel="stylesheet" href="<?= url('assets/resources/css/index.css') ?>" />
	<link rel="stylesheet" href="<?= url('assets/resources/css/footer.css') ?>" />
	<link rel="stylesheet" href="<?= url('assets/resources/css/product.css') ?>" />

	<link rel='stylesheet' href="<?= url('assets/resources/bootstrap/css/bootstrap.min.css') ?>" />
	<link rel='stylesheet' href="<?= url('assets/resources/fullcalendar/fullcalendar.min.css') ?>" />
	<link rel="stylesheet" href="<?= url('assets/resources/css/precios.css') ?>" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?= url('assets/resources/css/LatamSans.css') ?>">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
   	
    <script src="<?= url('assets/resources/jquery/jquery-3.2.1.min.js') ?>"></script>
   	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="<?= url('assets/resources/moment/moment.min.js') ?>"></script>
	<script src="<?= url('assets/resources/fullcalendar/fullcalendar.min.js') ?>"></script>
	<script src="<?= url('assets/resources/fullcalendar/locale-all.js') ?>"></script>

   <script src="<?= url('assets/resources/notify/notify.min.js') ?>" type="text/javascript"></script>
   
    <style>
        .transporte 
        {
            margin: 0;
        }
        .transporte li
        {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .transporte li label
        {
            padding-left: 10px;
        }

        .fc-toolbar h2 {
            margin: 0;
            color: #FFF !important;
            }
            .fc-head table thead
            {
                background: #f5f5f5 !important;
            }
            .fc-view-container
            {
                border: 3px solid white;
                background: white !important;
            }
         /*   .fc-day-header
            {
                color: #fff !important;
            }*/
        .stepwizard-step p {
            margin-top: 10px;
            font-family: Latam-Sans-Bold;
            display: inline;
            background: white;
            padding: 10px 10px;
        }
        .stepwizard-step p span {
            font-size: 12px;
        }

        .stepwizard-row {
            display: table-row;
        }

        .stepwizard {
            display: table;
            width: 100%;
            position: relative;
            margin-bottom: 30px;
        }
        .stepwizard-step .btn-default
        {
            background: #e5e5e5;
        }
        
        .stepwizard-step .btn-default:hover
        {
            z-index: 4;
            background: #e5e5e5;
        }

        .stepwizard-step .btn-primary
        {
            background: #150067;
            border: none;
        }
        .stepwizard-step button[disabled] {
            opacity: 1 !important;
            filter: alpha(opacity=100) !important;
        }

        .stepwizard-row:before {
            top: 30px;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 100%;
            height: 2px;
            background-color: #ccc;
            z-order: 0;
            z-index: -1000;
        }

        .stepwizard-step {
            display: table-cell;
         /*   text-align: center; */
            position: relative;
        }

        .btn-circle {
            width: 60px;
            height: 60px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 4;
            border-radius: 50%;
            border: 3px solid white;
        }

        .btn-next
        {
            background-color: #00B5AD !important;
            color: white;
            text-transform: capitalize;
            letter-spacing: 0.05em;
        }
        .btn-next:hover {
            color: white;
        }

        .box-circle
        {
            background: white;
            color: black;
            font-family: Roboto;
            border-radius: 50%;
            height: 50px;
            width: 50px;
            font-weight: bold;
            font-size: 20px;
            text-align: center;
            line-height: 50px;
        }

        .title-reserva
        {
            color: black;
            font-family: Latam-Sans-Bold;
        }

        .reserva-forms .bg-step2
        {
            background: #dbf0ff;
            margin-bottom: 5px;
        }

        .bg-form-person-skip-item{
            background: #95c7fb;
            color: black;
        }
        .reserva-forms .form-box
        {
            background: white;
            font-family: Latam-Sans-Bold;
            font-size: 14px;
            margin: 5px 0px;
            padding: 5px 10px;
        }

        .reserva-forms .form-box input
        {
            border: none;
            outline: none;
            box-shadow: none;
            margin: 0;
            padding: 0;
                height: 20px;
        }


        .reserva-forms .form-box label 
        {
            text-transform: uppercase;
            margin: 0;
            color: #1b0088;
            padding: 0;
        }


    </style>
</head>
	<body>
    <div>
		<header>
            <link rel="stylesheet" type="text/css" href="<?= url('assets/resources/css/') ?>">
			<?php
				$this->load->view('header/header');
				$this->load->view('header/menu');
			?>

		</header>
		<content id="content" class="content container-fluid">
			<?php
				//$this->load->view('content/page/index');
				$this->load->view('reservas/index');
			?>
		</content>
		<footer>
			<?php
				$this->load->view('footer/footer');
			?>

		</footer>

            <script src="<?=base_url(); ?>assets/resources/vue/vue.min.js" type="text/javascript"></script>
            <script src="<?=base_url(); ?>assets/resources/js/reserva.js"  type="text/javascript"></script>
    </div>
    <script type="text/javascript">
            $(document).ready(function () {

                var navListItems = $('div.setup-panel div a'),
                    allWells = $('.setup-content'),
                    allNextBtn = $('.nextBtn'),
                    allPrevBtn = $('.prevBtn');

                allWells.hide();

                navListItems.click(function (e) {
                    e.preventDefault();
                    var $target = $($(this).attr('href')),
                        $item = $(this);

                    if (!$item.hasClass('disabled')) {
                        navListItems.removeClass('btn-primary').addClass('btn-default');
                        $item.addClass('btn-primary');
                        allWells.hide();
                        $target.show();
                        $target.find('input:eq(0)').focus();
                    }
                });

                allNextBtn.click(function(){
                    var curStep = $(this).closest(".setup-content"),
                        curStepBtn = curStep.attr("id"),
                        nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                        curInputs = curStep.find("input[type='text'],input[type='url']"),
                        isValid = true;

                    $(".form-group").removeClass("has-error");
                    for(var i=0; i<curInputs.length; i++){
                        if (!curInputs[i].validity.valid){
                            isValid = false;
                            $(curInputs[i]).closest(".form-group").addClass("has-error");
                        }
                    }

                    if (isValid)
                        nextStepWizard.removeAttr('disabled').trigger('click');
                });

                allPrevBtn.click(function(){
                    var curStep = $(this).closest(".setup-content"),
                        curStepBtn = curStep.attr("id"),
                        prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

                        prevStepWizard.trigger('click');

                });

                $('div.setup-panel div a.btn-primary').trigger('click');
            });
            /* traducciones que se usaran en precios*/
            traduccionPrecios = <?=json_encode(arrayTraduccion('precios',strtolower($language)));?>;
		    idiomaGeneral = '<?=strtolower($language);?>';
	////////////////////////
    function procesarForm(){
    	  var formulario = $('#form_reserva_1');
    	  var datastring = formulario.serialize();
    	 // alert(formulario.attr('action'));
                $.ajax({
                    type: "POST",
                    url: formulario.attr('action'),
                    data: datastring,
                    success: function(datos) {
                      var estado = JSON.parse(datos);
                      if(estado.state=='success'){
                      	alert('Su peticion ha sido enviado correctamente!.');
                      	$('.sendBtn')[0].disabled=true;

                      } else if(estado.state=='error') {
                      	alert('Errores en su peticion por favor contactese a reservas@incalake.com!.');
                      }
                      else{
                      	alert('Errores en su peticion.');
                      }
                    }
                });
    }

    </script>
    <script src="<?=base_url();?>assets/resources/js/precios.js"></script>
	</body>
</html>