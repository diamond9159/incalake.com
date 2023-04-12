<?php

//echo json_encode($data);

?>
<div class="email">
<?php if (!empty($data)): ?>
	<h3>Hola, la siguiente es una reserva de confirmación instantánea..!</h3>
	<table border="1" cellspacing="0" cellpadding="0">
		<caption></caption>
		<thead>
		<!--	
			<tr>
				<th></th>
				<th></th>
			</tr>
		-->
		</thead>
		<tbody>
			<tr>
				<td colspan="2" style="text-align:center; background:#337ab7; color: white;"><strong>DATOS DE CONTACTO DEL CLIENTE</strong></td>
			</tr>
			<tr>
				<td>Nombres del Cliente</td>
				<td><?=@$data['nombres_cliente'];?></td>
			</tr>
			<tr>
				<td>Teléfono del Cliente</td>
				<td><?=@$data['telefono_cliente'];?></td>
			</tr>
			<tr>
				<td>E-mail del Cliente</td>
				<td><?=@$data['email_cliente'];?></td>
			</tr>
			<tr>
				<td>Nacionalidad del Cliente</td>
				<td><?=@$data['nacionalidad_cliente'];?></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center; background:#337ab7; color: white;"><strong>INFORMACIÓN SOBRE LOS CLIENTES</strong></td>
			</tr>
			<?php foreach ($data['items'] as $k => $val): ?>
			<tr>
				<td><?=strtolower(trim(@$val['nombre_articulo'])) === 'adult'?'Adultos':@$val['nombre_articulo'] ?></td>
				<td><?=@$val['cantidad'];?> Personas</td>
			</tr>
			<?php endforeach ?>
			<tr>
				<td colspan="2" style="text-align:center; background:#337ab7; color: white;"><strong>INFORMACIÓN SOBRE EL SERVICIO AL CLIENTE</strong></td>
			</tr>
			<tr>
				<td>Servicio/Actividad</td>
				<td><?=mb_strtoupper(@$data['titulo_producto']);?></td>
			</tr>
			<tr>
				<td>Fecha de Servicio</td><?setlocale(LC_ALL,"es_ES");?>
				<td><?=@$data['fecha_servicio'];?></td>
			</tr>
			<?php if (!empty($data['hora_inicio_servicio'])): ?>
			<tr>
				<td>Hora Inicio del Servicio</td>
				<td><?=@$data['hora_inicio_servicio'];?></td>
			</tr>	
			<?php endif ?>
			<?php if ( !empty($data['duracion_servicio']) ): ?>
			<tr>
				<td>Duración Aproximada del Servicio</td>
				<td><?=@$data['duracion_servicio'];?></td>
			</tr>	
			<?php endif ?>
			<?php if ( !empty($data['incluye_producto']) ): ?>
			<tr>
				<td>El Servicio Incluye</td>
				<td><?=@$data['incluye_producto'];?></td>
			</tr>	
			<?php endif ?>
			<!--			
			<tr>
				<td colspan="2" style="text-align:center; background:#337ab7; color: white;"><strong>DATOS PERSONALES DEL CLIENTE</strong></td>
			</tr>
			<?php foreach (@$info_cliente['datos_clientes'] as $keyDC => $valueDC): ?>
			<tr>
				<td colspan="2" style="text-align:center; background:#F58D0C; color: white;"><strong>CLIENTE N° <?=($keyDC+1)?></strong></td>
			</tr>
			<?php foreach ($valueDC as $keyIndex => $valueIndex): ?>
			<tr>
				<?php
					$jsonCampoFormulario = json_decode(@$valueIndex['nombre_campo'], true);
				?>
				<td><?=$jsonCampoFormulario['es']?></td>
				<td><?=@$valueIndex['value_campo_formulario'];?></td>
			</tr>
			<?php endforeach ?>
			<?php endforeach ?>
		    -->
		</tbody>
	</table>
<?php else: ?>
	
<?php endif ?>
</div>
<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
<style type="text/css">
	.email{
		font-family: 'Quicksand', sans-serif;
		font-size: 14px;
	}
	table{
		border: #337ab7 solid 0.1em;
		color: #337ab7;
		font-weight: bold;
		font-size: 14px;
	}
	table td{
		padding: 0.2em;
	}
</style>