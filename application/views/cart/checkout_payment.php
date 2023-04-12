<?php
 header("Access-Control-Allow-Origin: *");

?>
<?php $step = 3;  require('navbar_payment.php')  ?>
<?php 
    if(count(json_decode($_COOKIE['cart'], true)) == 0) {
        redirect('/', 'location');
    } 
?>
<?php 
    $uri = $_SERVER['REQUEST_URI'];
    $language = 'en';
    $arrayUri = array();
    if ( !empty(trim($uri)) ) {
        $arrayUri = explode("/",$uri);
        $language = mb_strtolower($arrayUri[1]);
    }

    //echo $language;
?>

<!-- =================================================================== -->
<style>
    .div-title-cart{
    font-weight: 700;
    display: inline-flex;
    padding: 1% 2%;
    }
    #accordion .form-group {
    margin-right: 0;
    margin-left: 0;
    }
    #accordion .card-block{
    margin: 2% 0 ;
    }
    #accordion .card-header{
        background: #fff;
    }
    #accordion .card.active{
        border-left: 3px solid #007bff;
    }
    .input-group .form-control{
z-index:1 !important;
}
.card-block .btn{
    white-space: normal !important;
}
</style>
<script>
var language = document.documentElement.lang;

$(document).on('show.bs.collapse ','#collapseOne' ,function () {
$('#checkbox_tarjeta').prop('checked', true);
$(this).parent('.card').addClass('active');
});
$(document).on('hide.bs.collapse ','#collapseOne' ,function () {
$('#checkbox_tarjeta').prop('checked', false);
$(this).parent('.card').removeClass('active');
});
//
$(document).on('show.bs.collapse ','#collapseTwo' ,function () {
$('#checkbox_paypal').prop('checked', true);
$(this).parent('.card').addClass('active');
});
$(document).on('hide.bs.collapse ','#collapseTwo' ,function () {
$('#checkbox_paypal').prop('checked', false);
$(this).parent('.card').removeClass('active');
});
//
$(document).on('show.bs.collapse ','#collapseThree' ,function () {
$('#checkbox_transferencia').prop('checked', true);
$(this).parent('.card').addClass('active');
});
$(document).on('hide.bs.collapse ','#collapseThree' ,function () {
$('#checkbox_transferencia').prop('checked', false);
$(this).parent('.card').removeClass('active');
});
</script>
<?php 
    //echo "ID PRODUCTOS: ".json_encode($idProductos)."<br/>";
    //echo "STRING ID PRODCUTOS: ".$string_id_productos."<br/>";
    //echo "METODO PAGO: ".$metodo_pago_paypal;
?>
<div class="container-fluid" style="padding-top: 50px;">
    <div class="row justify-content-center">
        <div class="col-12 col-xs-12 col-md-7 col-lg-7">
        <h5 class="div-title-cart bg-primary text-light"><span class="fa fa-th-list"></span>&nbsp; <?=translateCart('seleccione_metodo_de_pago') ?> </h5>
            <div id="accordion" role="tablist" class="accordion" aria-multiselectable="true">
                <?php
                    $displayMetodoPago = ' block';
                    $activePaypal = '';
                    $displayPaypal = '';
                    $activeCulqi  = 'active';
                    $displayCulqi = 'show';
                ?>
    
                <?php
                    $displayAll = ' block';
                ?>

                <!-- Si $metodo_pago_paypal es mayor a cero entonces solo mostramos el método de pago paypal-->
                <?php 
                    if ( (Integer)$metodo_pago_paypal > 0 ){
                        $displayMetodoPago = ' none';
                        $activePaypal = 'active';
                        $displayPaypal = 'show';

                        $activeCulqi  = '';
                        $displayCulqi = '';
                    }

                ?>
                
                <?php if ( (Integer)$metodo_pago_paypal === 0 ): ?>
                <div class="card active">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="text-decoration: none !important;" >
                        <div class="card-header" role="tab" id="headingOne">
                            <h5 class="mb-0">
                            <input type="checkbox" id="checkbox_tarjeta" checked>
                              <strong>
                              <span class="fa fa-credit-card"></span> <?=translateCart('pagar_con_tarjeta')?></strong>
                            </h5>
                        </div>
                    </a>

                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-block">
                            <div class="text-left col form-group">
                                <span class="fa fa-cc-visa fa-2x" title="VISA"></span>
                                <span class="fa fa-cc-mastercard fa-2x" title="MASTERCARD"></span>
                                <span class="fa fa-cc-diners-club fa-2x" title="DINERS CLUB"></span>
                                <span class="fa fa-cc-amex fa-2x" title="AMERICAN EXPRESS"></span>
                                <span class="fa fa-cc-jcb fa-2x" title="JCB"></span>
                                <span class="fa fa-credit-card fa-2x" title="UNION PAY"></span>
                            </div>
                            <form action="" method="POST" id="culqi-card-form">
                                <div class="container">
                                    <div class="form-group row">
                                        <label for="card[email]" class="col-12 col-md-12 col-lg-5 col-form-label-md">
                                            <strong><?=translateCart('email')?></strong></label>
                                        <div class="col-12 col-md-10 col-lg-7">
                                        <div class=" input-group">
                                            <span class="input-group-addon fa fa-envelope-o"></span>
                                            <input type="email" size="20" data-culqi="card[email]" id="card[email]" value="" class="form-control" name="txtCulqiEmail" autofocus />
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="card[number]" class="col-12 col-md-12 col-lg-5 col-form-label-md">
                                            <strong><?=translateCart('numero_tarjeta')?> <span id="spanCardTypeText"></span></strong>
                                        </label>
                                        <div class="col-12 col-md-10 col-lg-7">
                                            <div class=" input-group">
                                                <span class="input-group-addon" id="spanCardType"><i class="fa fa-credit-card"></i></span>
                                                <input type="tel" size="20" data-culqi="card[number]" id="card[number]" value="" class="form-control" name="txtCulqiCard">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="card[cvv]" class="col-12 col-md-12 col-lg-5 col-form-label-md"><strong><?=translateCart('codigo_seguridad')?></strong></label>
                                        <div class="col-6 col-md-6 col-lg-4">
                                            <div class=" input-group">
                                                <span class="input-group-addon fa fa-lock"></span>
                                                <input type="tel" size="4" data-culqi="card[cvv]" id="card[cvv]" value="" class="form-control" name="txtCulqiCcv">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fecha_expiracion" class="col-12 col-md-12 col-lg-5 col-form-label-md"><strong><?=translateCart('fecha_expiracion')?></strong></label>
                                        <div class="col-12 col-md-12 col-lg-7  form-inline">
                                            <input type="tel" size="2" data-culqi="card[exp_month]" id="card[exp_month]" value="" class="form-control form-control-warning col-4 col-md-3 col-lg-4 txtCulqiExpireMonth" name="txtCulqiExpireMonth" maxlength="2" onkeypress="return justNumbers(event);" placeholder="MM">
                                            <span class="col-1 col-md-1 col-lg-1"><big>/</big></span>
                                            <input type="tel" size="4" data-culqi="card[exp_year]" id="card[exp_year]" value="" class="form-control form-control-warning col-4 col-md-4 col-lg-5" name="txtCulqiExpireYear" maxlength="4" onkeypress="return justNumbers(event);" placeholder="YYYY">
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-success btn-culqi" type="button" id="btn-culqi"><?=translateCart('pagar_ahora')?></button><span id="data-culqi-initialize"></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="text-decoration: none !important;">
                        <div class="card-header" role="tab" id="headingTwo">
                            <h5 class="mb-0">
                                <input type="checkbox" id="checkbox_paypal">
                                  <strong>
                                  <span class="fa fa-cc-paypal"></span> <?=translateCart('pagar_con_paypal')?></strong>
                            </h5>
                        </div>
                    </a>
                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="card-block">
                            <div class="paypalFormHtml" id="paypalFormHtml"></div>
                            <div class="text-center">
                            <div class="row justify-content-md-center">
                                <div class="col-4 col-xs-6 col-md-6 col-lg-6">
                                    <img src="https://shop.incalake.com/img/paypal-and-others-cards.png" class="img-responsive img-thumbnail">
                                </div>
                            </div><br/>
                                <button class="btn btn-primary btn-paypal" type="button" id="btn-paypal"><?=translateCart('pagar_ahora')?></button><span id="data-paypal-initialize"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif ?>

                <?php if ( (Integer)$metodo_pago_paypal === 1 ): ?>
                <div class="card" style="display: none;">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="text-decoration: none !important;" >
                        <div class="card-header" role="tab" id="headingOne">
                            <h5 class="mb-0">
                            <input type="checkbox" id="checkbox_tarjeta" checked>
                              <strong>
                              <span class="fa fa-credit-card"></span> <?=translateCart('pagar_con_tarjeta')?></strong>
                            </h5>
                        </div>
                    </a>

                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-block">
                            <div class="text-left col form-group">
                                <span class="fa fa-cc-visa fa-2x" title="VISA"></span>
                                <span class="fa fa-cc-mastercard fa-2x" title="MASTERCARD"></span>
                                <span class="fa fa-cc-diners-club fa-2x" title="DINERS CLUB"></span>
                                <span class="fa fa-cc-amex fa-2x" title="AMERICAN EXPRESS"></span>
                                <span class="fa fa-cc-jcb fa-2x" title="JCB"></span>
                                <span class="fa fa-credit-card fa-2x" title="UNION PAY"></span>
                            </div>
                            <form action="" method="POST" id="culqi-card-form">
                                <div class="container">
                                    <div class="form-group row">
                                        <label for="card[email]" class="col-12 col-md-12 col-lg-5 col-form-label-md">
                                            <strong><?=translateCart('email')?></strong></label>
                                        <div class="col-12 col-md-10 col-lg-7">
                                        <div class=" input-group">
                                            <span class="input-group-addon fa fa-envelope-o"></span>
                                            <input type="email" size="20" data-culqi="card[email]" id="card[email]" value="" class="form-control" name="txtCulqiEmail" autofocus />
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="card[number]" class="col-12 col-md-12 col-lg-5 col-form-label-md">
                                            <strong><?=translateCart('numero_tarjeta')?> <span id="spanCardTypeText"></span></strong>
                                        </label>
                                        <div class="col-12 col-md-10 col-lg-7">
                                            <div class=" input-group">
                                                <span class="input-group-addon" id="spanCardType"><i class="fa fa-credit-card"></i></span>
                                                <input type="tel" size="20" data-culqi="card[number]" id="card[number]" value="" class="form-control" name="txtCulqiCard">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="card[cvv]" class="col-12 col-md-12 col-lg-5 col-form-label-md"><strong><?=translateCart('codigo_seguridad')?></strong></label>
                                        <div class="col-6 col-md-6 col-lg-4">
                                            <div class=" input-group">
                                                <span class="input-group-addon fa fa-lock"></span>
                                                <input type="tel" size="4" data-culqi="card[cvv]" id="card[cvv]" value="" class="form-control" name="txtCulqiCcv">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fecha_expiracion" class="col-12 col-md-12 col-lg-5 col-form-label-md"><strong><?=translateCart('fecha_expiracion')?></strong></label>
                                        <div class="col-12 col-md-12 col-lg-7  form-inline">
                                            <input type="tel" size="2" data-culqi="card[exp_month]" id="card[exp_month]" value="" class="form-control form-control-warning col-4 col-md-3 col-lg-4 txtCulqiExpireMonth" name="txtCulqiExpireMonth" maxlength="2" onkeypress="return justNumbers(event);" placeholder="MM">
                                            <span class="col-1 col-md-1 col-lg-1"><big>/</big></span>
                                            <input type="tel" size="4" data-culqi="card[exp_year]" id="card[exp_year]" value="" class="form-control form-control-warning col-4 col-md-4 col-lg-5" name="txtCulqiExpireYear" maxlength="4" onkeypress="return justNumbers(event);" placeholder="YYYY">
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-success btn-culqi" type="button" id="btn-culqi"><?=translateCart('pagar_ahora')?></button><span id="data-culqi-initialize"></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card active">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="text-decoration: none !important;">
                        <div class="card-header" role="tab" id="headingTwo">
                            <h5 class="mb-0">
                                <input type="checkbox" id="checkbox_paypal" checked>
                                  <strong>
                                  <span class="fa fa-cc-paypal"></span> <?=translateCart('pagar_con_paypal')?></strong>
                            </h5>
                        </div>
                    </a>
                    <div id="collapseTwo" class="collapse show" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="card-block">
                            <div class="paypalFormHtml" id="paypalFormHtml"></div>
                            <div class="text-center">
                            <div class="row justify-content-md-center">
                                <div class="col-4 col-xs-6 col-md-6 col-lg-6">
                                    <img src="https://shop.incalake.com/img/paypal-and-others-cards.png" class="img-responsive img-thumbnail">
                                </div>
                            </div><br/>
                                <button class="btn btn-primary btn-paypal" type="button" id="btn-paypal"><?=translateCart('pagar_ahora')?></button><span id="data-paypal-initialize"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif ?>

                <?php if ( (Integer)$metodo_pago_paypal === 2 ): ?>
                <div class="card active">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="text-decoration: none !important;" >
                        <div class="card-header" role="tab" id="headingOne">
                            <h5 class="mb-0">
                            <input type="checkbox" id="checkbox_tarjeta" checked>
                              <strong>
                              <span class="fa fa-credit-card"></span> <?=translateCart('pagar_con_tarjeta')?></strong>
                            </h5>
                        </div>
                    </a>

                    <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                        <div class="card-block">
                            <div class="text-left col form-group">
                                <span class="fa fa-cc-visa fa-2x" title="VISA"></span>
                                <span class="fa fa-cc-mastercard fa-2x" title="MASTERCARD"></span>
                                <span class="fa fa-cc-diners-club fa-2x" title="DINERS CLUB"></span>
                                <span class="fa fa-cc-amex fa-2x" title="AMERICAN EXPRESS"></span>
                                <span class="fa fa-cc-jcb fa-2x" title="JCB"></span>
                                <span class="fa fa-credit-card fa-2x" title="UNION PAY"></span>
                            </div>
                            <form action="" method="POST" id="culqi-card-form">
                                <div class="container">
                                    <div class="form-group row">
                                        <label for="card[email]" class="col-12 col-md-12 col-lg-5 col-form-label-md">
                                            <strong><?=translateCart('email')?></strong></label>
                                        <div class="col-12 col-md-10 col-lg-7">
                                        <div class=" input-group">
                                            <span class="input-group-addon fa fa-envelope-o"></span>
                                            <input type="email" size="20" data-culqi="card[email]" id="card[email]" value="" class="form-control" name="txtCulqiEmail" autofocus />
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="card[number]" class="col-12 col-md-12 col-lg-5 col-form-label-md">
                                            <strong><?=translateCart('numero_tarjeta')?> <span id="spanCardTypeText"></span></strong>
                                        </label>
                                        <div class="col-12 col-md-10 col-lg-7">
                                            <div class=" input-group">
                                                <span class="input-group-addon" id="spanCardType"><i class="fa fa-credit-card"></i></span>
                                                <input type="tel" size="20" data-culqi="card[number]" id="card[number]" value="" class="form-control" name="txtCulqiCard">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="card[cvv]" class="col-12 col-md-12 col-lg-5 col-form-label-md"><strong><?=translateCart('codigo_seguridad')?></strong></label>
                                        <div class="col-6 col-md-6 col-lg-4">
                                            <div class=" input-group">
                                                <span class="input-group-addon fa fa-lock"></span>
                                                <input type="tel" size="4" data-culqi="card[cvv]" id="card[cvv]" value="" class="form-control" name="txtCulqiCcv">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fecha_expiracion" class="col-12 col-md-12 col-lg-5 col-form-label-md"><strong><?=translateCart('fecha_expiracion')?></strong></label>
                                        <div class="col-12 col-md-12 col-lg-7  form-inline">
                                            <input type="tel" size="2" data-culqi="card[exp_month]" id="card[exp_month]" value="" class="form-control form-control-warning col-4 col-md-3 col-lg-4 txtCulqiExpireMonth" name="txtCulqiExpireMonth" maxlength="2" onkeypress="return justNumbers(event);" placeholder="MM">
                                            <span class="col-1 col-md-1 col-lg-1"><big>/</big></span>
                                            <input type="tel" size="4" data-culqi="card[exp_year]" id="card[exp_year]" value="" class="form-control form-control-warning col-4 col-md-4 col-lg-5" name="txtCulqiExpireYear" maxlength="4" onkeypress="return justNumbers(event);" placeholder="YYYY">
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-success btn-culqi" type="button" id="btn-culqi"><?=translateCart('pagar_ahora')?></button><span id="data-culqi-initialize"></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> 

                <div class="card" style="display: none;">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="text-decoration: none !important;">
                        <div class="card-header" role="tab" id="headingTwo">
                            <h5 class="mb-0">
                                <input type="checkbox" id="checkbox_paypal">
                                  <strong>
                                  <span class="fa fa-cc-paypal"></span> <?=translateCart('pagar_con_paypal')?></strong>
                            </h5>
                        </div>
                    </a>
                    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="card-block">
                            <div class="paypalFormHtml" id="paypalFormHtml"></div>
                            <div class="text-center">
                            <div class="row justify-content-md-center">
                                <div class="col-4 col-xs-6 col-md-6 col-lg-6">
                                    <img src="https://shop.incalake.com/img/paypal-and-others-cards.png" class="img-responsive img-thumbnail">
                                </div>
                            </div><br/>
                                <button class="btn btn-primary btn-paypal" type="button" id="btn-paypal"><?=translateCart('pagar_ahora')?></button><span id="data-paypal-initialize"></span>
                            </div>
                        </div>
                    </div>
                </div> 
                <?php endif ?>
                <!--
                <div class="card" style="display: <?php echo $displayMetodoPago;?>">
                    -->
                <div class="card" style="display: none;">
                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="text-decoration: none !important;">
                        <div class="card-header" role="tab" id="headingThree">
                            <h5 class="mb-0">
                                <input type="checkbox" id="checkbox_transferencia">
                                <strong><span class="fa fa-money"></span>
                                <?=translateCart('transferencia_bancaria')?></strong>
                            </h5>
                        </div>
                    </a>
                    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="card-block">
                        <div class="container">
                            <form name="f1" id="f1" action="#" method="post" class="alignet-form-vpos2">
                                <div class="container">
                                    <input type="hidden" name="acquirerId" value="144" id="acquirerId"/>
                                    <input type="hidden" name="idCommerce" value="8909" id="idCommerce"/>
                                    <input type="hidden" name="purchaseOperationNumber" value="" id="purchaseOperationNumber"/>
                                    <input type="hidden" name="purchaseAmount" value="" id="purchaseAmount"/>
                                    <input type="hidden" name="purchaseCurrencyCode" value="" id="purchaseCurrencyCode"/>
                                    <input type="hidden" name="language" value="SP" id="language" /> <!-- SP = ESPAÑOL, EN = INGLÉS -->
                                    
                                    <div class="form-group row">
                                        <label class="col-12 col-md-12 col-lg-5 col-form-label-md">
                                            <strong><?=translateCart('nombres')?></strong></label>
                                        <div class="col-12 col-md-10 col-lg-7">
                                            <input type="text" name="shippingFirstName" value="" class="form-control" id="shippingFirstName" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-12 col-md-12 col-lg-5 col-form-label-md">
                                            <strong><?=translateCart('apellidos')?></strong></label>
                                        <div class="col-12 col-md-10 col-lg-7">
                                            <input type="text" name="shippingLastName" value="" class="form-control" id="shippingLastName" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-12 col-md-12 col-lg-5 col-form-label-md">
                                            <strong><?=translateCart('email')?></strong></label>
                                        <div class="col-12 col-md-10 col-lg-7">
                                            <input type="email" name="shippingEmail" value="" class="form-control" id="shippingEmail" />
                                        </div>
                                    </div>   
                                    <div class="form-group row">
                                        <label class="col-12 col-md-12 col-lg-5 col-form-label-md">
                                            <strong><?=translateCart('pagar_con')?></strong></label>
                                        <div class="col-12 col-md-10 col-lg-7">
                                            <select name="tipo_moneda" id="tipo_moneda" class="form-control tipo_moneda">
                                                <option value="840"><?=translateCart('dolares');?></option>
                                                <option value="604"><?=translateCart('soles');?></option>
                                            </select>
                                            <small class="help-block"><?=translateCart('mensaje_tipo_moneda');?></small>
                                        </div>
                                    </div> 

                                    <input type="hidden" name="shippingAddress" value="Jr. Cajamarca 619"/>
                                    <input type="hidden" name="shippingZIP" value="21001"/>
                                    <input type="hidden" name="shippingCity" value="PUNO"/>
                                    <input type="hidden" name="shippingState" value="PUNO"/>
                                    <input type="hidden" name="shippingCountry" value="PE"/>
                                    
                                    <input type="hidden" name="descriptionProducts" value="Actividad Inca Lake" id="descriptionProducts" />
                                    <input type="hidden" name="programmingLanguage" value="PHP" id="programmingLanguage" />
                                    <!--Ejemplo envío campos reservados en parametro reserved1.-->
                                    <input type="hidden" name="reserved1" value=""/>
                                    <input type="hidden" name="purchaseVerification" value="" id="purchaseVerification"/>
                                    <div class="form-group text-center">        
                                        <!--
                                        <input type="button" onclick="javascript:AlignetVPOS2.openModal('https://integracion.alignetsac.com/')" value="PAGAR AHORA" class="btn btn-success">
                                        -->
                                        <button type="button" class="btn btn-success btn-transferencia-bancaria" id="btn-transferencia-bancaria"><?=translateCart('pagar_ahora');?></button><span id="data-pym-initialize"></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!--
                        <div class="row" style="margin:0;">
                            <div class="col-12 col-sm-6 col-md-6">
                                <?=translateCart('giro_internacional');?>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <a href="#" onclick="registerPaymentGlobal('giro')" class="btn btn-primary"><?=translateCart('pagar_por_giro')?></a>
                            </div>
                            <hr class="col-12">
                            <div class="col-12 col-sm-6 col-md-6">
                                <?=translateCart('transferencia_bancaria');?>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <a href="#" onclick="registerPaymentGlobal('transferencia')"  target="_blank" class="btn btn-primary"><?=translateCart('pagar_por_transferencia');?></a>
                            </div>
                        </div>
                        -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Resumen del -->
        <div class="col-12 col-xs-12 col-md-5 col-lg-5" id="app">
            <resumen-carro :cart="cart"></resumen-carro>
        </div>
    </div>
</div>
<br/><br/><br/>
<!-- <script type="text/javascript">
if(history.forward(1)){
    window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button" //chrome
    window.onhashchange=function(){window.location.hash="no-back-button";}
}
</script> -->
