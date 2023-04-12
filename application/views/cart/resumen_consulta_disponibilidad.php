<?php 
	$c = ConsultaDisponibilidad_::where('id',$id_consultar_disponibilidad)
		 ->join('producto', 'producto.id_producto', 'consulta_disponibilidad.id_producto')->first();
	
	$resumen = ConsultaDisponibilidadResumen_::where('id_consultar_disponibilidad', $id_consultar_disponibilidad)->get();
?>
<strong>Nombres: </strong> <?= $c->nombres ?> <?= $c->apellidos ?> - <?= $c->pais ?><br>
<strong>Email: </strong> <?= $c->email ?> <br>
<strong>Telefono: </strong> <?= $c->telefono ?> 
<hr>
<table>
	<tr>
	<td><img src="<?= $c->img_thumb ?>"></td>
		<td>
			<h3><?= $c->titulo_producto ?></h3>
			
				<strong>Fecha solicitada del servicio: </strong> <?= $c->fecha_servicio ?> <br>
				<strong>Horario: </strong> <?= $c->horario ?>
			<hr>
			<table >
				<?php foreach($resumen as $r): ?>
					<tr>
						<td><strong><?= $r->descripcion ?> x <?= $r->cantidad ?></strong> &nbsp; &nbsp; &nbsp; &nbsp; </td><td> <?= $r->precio ?> USD</td>
					</tr>
				<?php endforeach; ?>
			</table>

			Pagina de referencia : <a href="<?= $c->url_page ?>"><?= $c->url_page ?></a>
		</td>
	</tr>
</table>




