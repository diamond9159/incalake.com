<?php 


    function trans($string, $lang) {
        $diccionary = [
            "carrito" => [
                "es" => 'CARRITO',
                "en" => 'CART',
            ],
            "informacion_cliente" => [
                "es" => 'INFORMACIÓN DEL CLIENTE',
                "en" => 'CUSTOMER INFORMATION',
            ],
            "pago" => [
                "es" => "PAGO",
                "en" => "PAYMENT",
            ],
            "confirmacion" => [
                "es" => "CONFIRMACIÓN",
                "en" => "CONFIRMATION",
            ],
        ];

        if(isset($diccionary[$string][$lang])) {
            return $diccionary[$string][$lang];
        } else {
            return $diccionary[$string]["en"];
        }
    }
?>
 <div class="d-flex checkout-steps">
    <div class="align-self-center container text-center">
        <ul>
            <li class="<?= $step>=1?'tab-ckeck':'' ?>" >
                <a href="<?= $step>=2?url('/'.$language.'/checkout/cart'):'#' ?>" >
                    <span class="ok ok-number force-brand-border-color "><span>1</span></span>
                    <strong data-toggle="tooltip" title="Paso 1" data-placement="bottom"><?= trans('carrito', $language) ?></strong>
                </a>
            </li>
            <hr class="force-brand-border-color">
            <li class="<?= $step>=2?'tab-ckeck':'' ?>" >
                <a href="<?= $step>=3?url('/'.$language.'/checkout/customer'):'#' ?>" >
                    <span class="ok ok-number force-brand-border-color "><span>2</span></span>
                    <strong data-toggle="tooltip" title="Paso 2" data-placement="bottom"><?= trans('informacion_cliente', $language) ?></strong>
                </a>
            </li>
            <hr class="force-brand-border-color">
            <li class="<?= $step>=3?'tab-ckeck':'' ?>" >
                <a href="<?= $step>=4?url('/'.$language.'/checkout/payment'):'#' ?>" >
                    <span class="ok ok-number force-brand-border-color "><span>3</span></span>
                    <strong data-toggle="tooltip" title="Paso 3" data-placement="bottom"><?= trans('pago', $language) ?></strong>
                </a>
            </li>
            <hr class="force-brand-border-color">
            <li class="<?= $step>=4?'tab-ckeck':'' ?>">
                <a href="" >
                    <span class="ok ok-number force-brand-border-color "><span>4</span></span>
                    <strong  data-toggle="tooltip" title="Paso 4" data-placement="bottom"><?= trans('confirmacion', $language) ?></strong>
                </a>
            </li>
        </ul>
    </div>
</div>
