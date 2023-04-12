<?php
	if(@$url_idiomas)
	{
	 	foreach($menu_language as $key => $value)
	 	{
	   	$menu_language[$key]['uri_servicio'] = (@$url_idiomas[$value['codigo']]?$url_idiomas[$value['codigo']]:base_url(strtolower($value['codigo'])));
	  }
	} 
?>


<!-- Modal -->
<div class="modal fade" id="searchGoogleModal2" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">INCA LAKE</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="height:550px;overflow-y:scroll">
				<table class="table" style="margin-bottom: 0px;">
					<tr>
						<td><input type="search" id="search_modal" placeholder="<?=($language=='es'?'Busca experiencias y lugares':'Look for experiences and places');?>"></td>
						<td><button class="btn-search-button btn btn-primary" style="padding: 9px 15px;"><i class="fa fa-search"></i></button></td>
					</tr>
				</table>
				<gcse:searchresults-only enableAutoComplete="true"></gcse:searchresults-only>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>


<?php

	$traduccion_header = arrayTraduccion('header', $language);

	function generarEnlaceWhatsapp( $phone , $_language )
	{
		return ("<a href='https://api.whatsapp.com/send?phone=".trim($phone)."' target='_blank' title='".($_language==="es"?"Abrir Whatsapp":"Open Whatsapp")."' >
				<i class='fa fa-whatsapp text-success'></i>
			</a>&nbsp;"); 
	}

	$data_contac = "
		<div class='text-center col-12 col-sm col-md-auto div-contact div-tooltip' style='align-self: center;'>
			<span class='' style='color: #fff;width: 100%;'>
				".generarEnlaceWhatsapp("51982769453",$language)."
				<a href='tel:51982769453' title='".($language==="es"?"Realizar llamar":"Make a call")."' class='text-white'>
					<span class='phone'><i class='fa fa-phone'></i> (+51) 982769453</span>
				</a> | 
				".generarEnlaceWhatsapp("51984434731",$language)."
				<a href='tel:51984434731' title='".($language==="es"?"Realizar llamar":"Make a call")."' class='text-white'>
					<span class='phone'><i class='fa fa-phone'></i> (+51) 984434731</span>
				</a> | 
				
				<a href='mailto:reservas@incalake.com' title='".($language==="es"?"Escribir email":"Type email")."' class='text-white'><span class='mail'><span class='fa fa-envelope'></span> reservas@incalake.com</span></a>
			</span>
		</div>";

?>
	

<!-- aparece el menu en modo movil o web segun dependa -->
<style>

	#header-movil {
	  display: none;
	}
	
	@media(max-width: 425px) {
		
    #header-web {
      display: none;
    }
	
    #header-movil {
      display: block;
    }
		
	}
	
</style>
	

<!-- mostrar si es un movil -->	
<div class="row col-md-12 div-header-main" id="header-movil"> 
	<?php echo 	$data_contac; ?>
</div>	
	
	
<!-- mostrar si es web -->
<div id="header-web"> 
	
	<div class="row col-md-12 div-header-main" style="position:static">
		
		<div class="col-sm col-md"></div>
	
		<div class="col-sm col-md-auto col-4" id="redes_sociales">
			
			<a title="Blog" href="//incalake.com/blog/" target="_blank">
				<img src="<?=base_url()?>assets/img/wordpress.png" style="height: 15px;opacity: 0.9;">
			</a>

			<a title="Trip Advisor" href="https://www.tripadvisor.com.pe/Attraction_Review-g298442-d3265896-Reviews-Inca_Lake_Day_Tours-Puno_Puno_Region.html" target="_blank">
				<img src="<?=base_url()?>assets/img/tripadvisor.png" style="height: 15px;opacity: 0.9;">
			</a>

			<a title="Facebook" href="https://facebook.com/incalake" target="_blank"><img src="<?=base_url()?>assets/img/facebook.png" style="height: 15px;opacity: 0.9;"></a>
			<a title="Twitter" href="https://twitter.com/#!/incalake" target="_blank"><img src="<?=base_url()?>assets/img/twitter.png" style="height: 15px;opacity: 0.9;"></a>
			<a title="YouTube" href="https://youtube.com/user/incalake" target="_blank"><img src="<?=base_url()?>assets/img/youtube.png" style="height: 15px;opacity: 0.9;"></a>

		</div>

		<div class="col-sm col-md-auto col-3" style="border-left:1px solid #1e5893;border-right:1px solid #1e5893">
			<div class="dropdown show">
				<a class="btn btn-link dropdown-toggle" style="color: #fff;" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="<?=strtolower(preg_match('[EN|en]',$language)?'us':$language);?> flag"></i>
					<?=$language;?>
				</a>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
					<?php
						foreach($menu_language as $menu)
						{
							if($menu['uri_servicio'] && !@$url_idiomas)
								$tmp_base_url = base_url(mb_strtolower($menu['codigo']).'/'.$this->uri->segment(2).'/'.$menu['uri_servicio']);
							elseif(@$url_idiomas)
								$tmp_base_url = $menu['uri_servicio'];
							else 
								$tmp_base_url = base_url(mb_strtolower($menu['codigo'].'/'.$menu['uri_servicio']));
							
							
							$tmp_id_link = "link-lang-".mb_strtolower($menu['codigo']);
							$tmp_cod_lang = $menu['codigo'];
							$tmp_cod_lang_icon=strtolower($menu['codigo']);
							$tmp_cod_lang_icon = $tmp_cod_lang_icon != 'en' ? $tmp_cod_lang_icon : 'us';
							echo "<a href='$tmp_base_url' id='$tmp_id_link' class='dropdown-item'><strong><i class='$tmp_cod_lang_icon flag'></i> $tmp_cod_lang</strong></a>";
						}
					?>
				</div>
			</div>
		</div>

		<!-- shopping cart -->
		<div class="col-sm col-md-auto col-4">
			<a class="btn btn-link" style="position: relative;color: #fff;" href="/<?=$language?>/checkout/cart">
				<i class="fa fa-shopping-cart" style="font-size:1.5em;" aria-hidden="true"></i>
					<span class="badge badge-pill badge-danger" id="count-cart" style="position:absolute;right:0;top:0"></span>
			</a>
		</div>

		<?php echo 	$data_contac; ?>

	</div>

</div>