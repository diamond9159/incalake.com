
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
				
			<!-- 	<?php  
					// $sum = 0;
					// $purchases = json_decode($_COOKIE['purchases'], true);
					// 	foreach ($purchases as $p) {
					// 		$sum+=$p['total_tour'];
					// 	}
					// 	foreach ($purchases as $p) {
					// 		foreach($p['recursos'] as $r)
					// 			$sum+=$r['precio']*$r['cantidad'];
					// 	}
					?>
					<h2>Total a pagar:<br>
				$ <?= $sum ?></h2> -->
				<h2>$0.00</h2>
				(Incluido IGV)<br>
				Lunes 25/12/12 04:45 p.m. de lo contratio este expirará.
			</td>
		</tr>
		</table>
	</div>
</body>
</html>
