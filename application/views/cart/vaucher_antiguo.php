
<!DOCTYPE html>
<html>
<style type="text/css">
	@page { margin: 0px; }
body { margin: 0px; }
</style>
<head>
	<title>Boleta generada</title>
	<style>
	.div_principal{
		border:1px solid #1a4c80;
	}
	.titulo_principal{
		background: #1a4c80;
		height: 50px;
		font-size: 20px;
		color:white;
		text-transform: uppercase;
	}
	.titulo_principal img{
		width: 100px;
		float:left;
		margin:0 0 0 5px;
	}
	.titulo_principal span{
		float:left;
		margin:12px 0 0 10px;
	}
    .img_logo{
    	border:1px solid red;
    }
	</style>

</head>
<body>
 <div class="div_principal">
	<div class="titulo_principal">
	    <img src="http://incalake.com/img/logo-white.png" />
		<span>Pasarela de pagos - INCALAKE</span>
	</div>
	
		<table>

		<tr><td>
		<table><tr>
		<td><img src="<?= url('/assets/img/bank/efectivo.jpg') ?>" width="130px"></td><td>
			<h1>Codigo de pago (CIP) : 231155</h1>
			</td>
			</tr></table>
			<p style="font-size: 11px;">
			Este código de pago no constituye una reserva confirmada sino hasta la realización del pago a través de los de lo contrario este expirará
			canales mencionados.Transportes Cruz del Sur - WEB se reserva el derecho a finalizar un pedido antes del
			tiempo indicado; en este caso el código CIP quedaría sin efecto.
			</p></td>
			<td style="text-align: center;background: #ccc;padding: 10px;width: 250px;">
				
				<?php  
					$sum = 0;
					$purchases = json_decode($_COOKIE['purchases'], true);
						foreach ($purchases as $p) {
							$sum+=$p['total_tour'];
						}
						foreach ($purchases as $p) {
							foreach($p['recursos'] as $r)
								$sum+=$r['precio']*$r['cantidad'];
						}
					?>
					<h2>Total a pagar:<br>
				$ <?= $sum ?></h2>
				(Incluido IGV)<br>
				Lunes 25/12/12 04:45 p.m. de lo contratio este expirará.
			</td>
		</tr>
		algo de prueba
		</table>
	</div>
	<br>
	<div style="font-size: 14px;">

		<div style="text-align: center;background: #333;color:white;padding: 7px;">
			FORMAS DE PAGO
		</div><p style="text-align: center;">
		Imprima esta orden de pago y acérquese a cualquiera de estos centros autorizados para efectuar el pago:
		PAGAR POR.</p>
		<table style="text-align:center;margin:0 auto;">
			<tr>
				<td>INTERNET -- </td>
				<td>AGENTES -- </td>
				<td>AGENCIAS</td>
			</tr>
		</table>
	</div>
	<!-- toda las formas de pago -->
	<div style="border:1px solid #111;padding: 5px;">
		
		<div style="background:red">
		 <img class="img_logo" src="http://incalake.com/paga/img/paypal.png" width="70px" />
		</div>
		<p>Permite a sus usuarios realizar pagos y transferencias a través de Internet sin compartir la información financiera con el destinatario, con el único requerimiento de que estos dispongan de correo electrónico.</p>
		<h2>¿Puedo usar Paypal para pagar los tours o servicios que tenga con Inca Lake?</h2>
		<p>
		Aceptamos pagos por Paypal (que implica también Tarjetas de crédito/debito Visa, Mastercard, American Express); esto le genera una comisión adicional del 4.9% + 0.3USD al total requerido.</p>

        <p>Puede calcular la comisión que se le genera en el siguiente enlace: <a href="https://salecalc.com/paypal?p=100&e=0&f=0&l=pe&r=1&m=2&c=0">https://salecalc.com/paypal?p=100&e=0&f=0&l=pe&r=1&m=2&c=0</a></p>

        <h2>Pasos a Seguir para Transferir el Dinero.</h2>
        <p>Nosotros le enviaremos una solicitud de pago incluyendo los gastos de comision paypal el cual sera enviado directamente a su correo electronico. Luego siga los pasos de acuerdo a las imagenes...</p>
        <img src="http://incalake.com/paga/img/gmail.jpg" width="100%" />
        <h2>Confirmación de pago a través de Paypal</h2>
		<img src="https://farm6.staticflickr.com/5036/14013878840_0411799970_o.jpg" width="100%" />
		<h2>Pago con cuenta paypal</h2>
		
		<img src="https://farm6.staticflickr.com/5496/14197996382_4ec977810a_o.jpg" width="100%" />

		
	</div>

	<div style="border:1px solid #111;padding: 5px;">
		<img src="http://incalake.com/paga/img/visa.png?>" width="120px">
		<p>Nota: Aceptamos tarjetas de crédito y débito visa con recargo adicional del 5%</p>
		<h2>1: Ingrese al siguiente enlace:</h2>
		<a href="https://www.multimerchantvisanet.com/formularioweb/formulariopago.asp?codtienda=448785702">https://www.multimerchantvisanet.com/formularioweb/formulariopago.asp?codtienda=448785702</a>
		<p>Le aparecerá un formulario en blanco para que pueda ser llenado por usted</p>
		<img src="http://incalake.com/grid/images/visa1.jpg" width="100%" />
		<h2>2: Una vez dentro deberá llenar la información siguiente</h2>
		<p>Número de compra: <span style="color:#3E8F62">001 (Este número es referencial, puede dejarlo en blanco)</span>
Monto a pagar: Precio + 5%; en este caso es $100 (precio) + $5 (comisión)
Llene sus datos de tarjeta y ponga correctamente su correo electrónico
Dele clic al botón pagar</p>
		<img src="http://incalake.com/grid/images/visa2.jpg" width="100%" />
        <h2>3: Recibirá una confirmación de pago a su correo electrónico</h2>
        <p>Una vez hecho el pago envíenos una copia a reservas@incalake.com y su reserva estará confirmada</p>
        <img src="http://incalake.com/grid/images/visa3.jpg" width="50%" />
	</div>


	<div style="border:1px solid #111;padding: 5px;">
		<img src="http://incalake.com/paga/img/WesternUnion.jpg" width="120px">
		<table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <td colspan="2">
                                                    <center><img class="img-responsive" src="http://incalake.com/paga/img/WesternUnion.jpg">
                                                    </center>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody class="alert-info">
                                            <tr>
                                                <td><b>Nombres</b>
                                                </td>
                                                <td>Hugo Richard</td>
                                            </tr>
                                            <tr>
                                                <td><b>Apellidos</b>
                                                </td>
                                                <td>Molina Paredes</td>
                                            </tr>
                                            <tr>
                                                <td><b>Documento de Identidad</b> <small>(D.N.I.)</small>
                                                </td>
                                                <td>46373144</td>
                                            </tr>
                                            <tr>
                                                <td><b>Dirección /Domicilio</b>
                                                </td>
                                                <td>Jr. 2 de Mayo 1108</td>
                                            </tr>
                                            <tr>
                                                <td><b>Ciudad/País</b>
                                                </td>
                                                <td>Puno / Perú</td>
                                            </tr>
                                            <tr>
                                                <td><b>Teléfono</b> <small>(si es requerido)</small>
                                                </td>
                                                <td>(0051) 949755305</td>
                                            </tr>
                                        </tbody>
                                    </table>
		
	</div>
	
	<div style="border:1px solid #111;padding: 5px;">
		<img src="http://incalake.com/paga/img/moneyGram.jpg" width="120px">
		<table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <td colspan="2">
                                                    <center><img class="img-responsive" src="http://incalake.com/paga/img/moneyGram.jpg">
                                                    </center>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody class="alert-info">
                                            <tr>
                                                <td><b>Nombres</b>
                                                </td>
                                                <td>Hugo Richard</td>
                                            </tr>
                                            <tr>
                                                <td><b>Apellidos</b>
                                                </td>
                                                <td>Molina Paredes</td>
                                            </tr>
                                            <tr>
                                                <td><b>Documento de Identidad</b> <small>(D.N.I.)</small>
                                                </td>
                                                <td><b>46373144</b>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><b>Dirección /Domicilio</b>
                                                </td>
                                                <td>Jr. 2 de Mayo 1108</td>
                                            </tr>
                                            <tr>
                                                <td><b>Ciudad/País</b>
                                                </td>
                                                <td>Puno / Perú</td>
                                            </tr>
                                            <tr>
                                                <td><b>Teléfono</b> <small>(si es requerido)</small>
                                                </td>
                                                <td>(0051) 949755305</td>
                                            </tr>
                                        </tbody>
                                    </table>
		
	</div>

	<div style="border:1px solid #111;padding: 5px;">
	    <h2>Pago Por Master Card, American Express, JCB, Discover Network y DC International</h2>
		<img src="http://incalake.com/paga/img/master-card.gif" width="120px">
		<img src="http://incalake.com/paga/img/american-express.jpg" width="120px">
		<img src="http://incalake.com/paga/img/jcb-cards.png" width="120px">
		<img src="http://incalake.com/paga/img/discover-network.jpeg" width="120px">
		<img src="http://incalake.com/paga/img/diner-club-international.png" width="120px">
		<p>Se aceptan tarjetas de crédito y débito MasterCard / American Express / JCB / Discover y Diners Club con recargo adicional del 4%</p>
		<h2>Pasos a Seguir para Transferir el Dinero.</h2>
		<p>1: Le enviaremos un enlace de pago; al abrirlo encontrará nuestra solicitud de pago:</p>
		<img src="http://incalake.com/paga/img/paso-01.jpg" width="50%">
		<p>
		2: Rellene en el campo su email por duplicado y su país de origen.
		</p>
		<img src="http://incalake.com/paga/img/paso-02.png" width="50%">
		<p>3: Una vez seleccione su país de origen, podrá elegir la moneda en la que se le cobrará; si bien puede pagar en moneda local, le recomendamos pagar en USD (United States Dollar). </p>
		<p>Posteriormente podrá llenar sus datos de tarjeta para pagar.</p>
		<p>Le hacemos recuerdo que existe una comisión por pago de tarjetas del 4% al precio del servicio o tour.</p>
		<img src="http://incalake.com/paga/img/paso-03.jpg" width="50%" >
		<p>4: Una vez haya hecho el pago, le llegará el voucher a su correo electrónico, una vez recibamos el pago, le confirmaremos los servicios que haya contratado con nosotros por email.</p>
	</div>

	<div style="border:1px solid #111;padding: 5px;">
	    <h2>Pago Por Master Card, American Express, JCB, Discover Network y DC International</h2>
		<img src="http://incalake.com/paga/img/american-express.jpg" width="120px">
		<p>Se aceptan tarjetas de crédito y débito MasterCard / American Express / JCB / Discover y Diners Club con recargo adicional del 4%</p>
		<h2>Pasos a Seguir para Transferir el Dinero.</h2>
		
		<p>1: Le enviaremos un enlace de pago; al abrirlo encontrará nuestra solicitud de pago:</p>
		<img src="http://incalake.com/paga/img/paso-01.jpg" width="50%">
		<p>2: Rellene en el campo su email por duplicado y su país de origen.</p>
		<img src="http://incalake.com/paga/img/paso-02.png" width="50%">
		<p>3: Una vez seleccione su país de origen, podrá elegir la moneda en la que se le cobrará; si bien puede pagar en moneda local, le recomendamos pagar en USD (United States Dollar). </p>
		<p>Posteriormente podrá llenar sus datos de tarjeta para pagar.</p>
		<p>Le hacemos recuerdo que existe una comisión por pago de tarjetas del 4% al precio del servicio o tour.</p>
		
	</div>

</body>
</html>
