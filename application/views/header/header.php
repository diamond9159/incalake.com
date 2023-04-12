<?php
    if(@$url_idiomas){
     foreach($menu_language as $key => $value){
       $menu_language[$key]['uri_servicio'] = (@$url_idiomas[$value['codigo']]?$url_idiomas[$value['codigo']]:base_url(strtolower($value['codigo'])));
     
      }
    } 
echo "<script>var base_url='".base_url()."'</script>";
?>
<script type="text/javascript" src="<?= url('assets/resources/js/js.cookie.js') ?>"></script>

<script>
(function () {
    var cx = '014210685266793079517:tb6pzsyd9ti';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = false;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +'//www.google.com/cse/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<!-- Modal -->
<div class="modal fade" id="searchGoogleModal2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >INCA LAKE</h5>
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
<!--styles-->
<style>
	#searchGoogleModal2 iframe, #searchGoogleModal2 .gsc-adBlock{
    display: none !important;
    visibility: hidden !important;
  }
</style>
<?php
//var_dump($menu_language);
$traduccion_header = arrayTraduccion('header',$language);
$this->load->view('php/mobile-detect/Mobile_Detect.php');
$detect = new Mobile_Detect;
/*
$data_contac="<div class='text-center col-12 col-sm col-md-auto div-contact div-tooltip' style='align-self: center;' data-toggle='tooltip' data-html='true' title='
".($language=='es'?'<div class="bg-success text-light"> Necesitas ayuda?</div>
llamanos al <b>(+51)984434731</b> o escribenos a  <b>reservas@incalake.com</b>, en breve un ejecutivo se pondra encontacto contigo.':'
<div class ="bg-success text-light"> Need help?</div>
call us at <b>(+51)984434731</b> or write to <b>reservas@incalake.com</b>, soon an executive will meet you')."'>
<a href='https://api.whatsapp.com/send?phone=51984434731' target='_blank'><span class='fa fa-whatsapp bg-success text-white'></span></a>
			  	<span class='' style='color: #fff;width: 100%;'>
			  		<span class='phone'><span class='fa fa-phone'></span> (+51) 984434731</span>
			  		<span class='mail'><span class='fa fa-envelope'></span> reservas@incalake.com</span>
			  	</span>
			  </div>";
*/
function generarEnlaceWhatsapp( $phone , $_language ){
    return ("<a href='https://api.whatsapp.com/send?phone=".trim($phone)."' target='_blank' title='".($_language==="es"?"Abrir Whatsapp":"Open Whatsapp")."' >
            <i class='fa fa-whatsapp text-success'></i>
        </a>&nbsp;"); 
}
$data_contac="
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
<?php if ($detect->isMobile()	): ?>
	<div class="row col-md-12 div-header-main" >	
			<?php echo 	$data_contac; ?>
	</div>
<style>
.mm-menu.mm-shadow-page:after{
    width: 5px !important;
}
</style>		
	<?php else: ?>
	<script>
$(document).ready(function(){
$('.div-header-main').prependTo('header>nav');
});
	</script>	
		<div class="row col-md-12 div-header-main" style="position:static">
	<div class="col-sm col-md"></div>
	<div class="col-sm col-md-auto col-4" id="redes_sociales">
<a title="Blog" href="//incalake.com/blog/" target="_blank"><img src="<?=base_url()?>assets/img/wordpress.png" style="height: 15px;opacity: 0.9;"></a>
	<a title="Trip Advisor" href="https://www.tripadvisor.com.pe/Attraction_Review-g298442-d3265896-Reviews-Inca_Lake_Day_Tours-Puno_Puno_Region.html" target="_blank"><img src="<?=base_url()?>assets/img/tripadvisor.png" style="height: 15px;opacity: 0.9;"></a>
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
					foreach($menu_language as $menu){
                        if($menu['uri_servicio'] && !@$url_idiomas){
                            $tmp_base_url = base_url(mb_strtolower($menu['codigo']).'/'.$this->uri->segment(2).'/'.$menu['uri_servicio']);
                        } elseif(@$url_idiomas){
                            $tmp_base_url = $menu['uri_servicio'];
                        }
                        else $tmp_base_url = base_url(mb_strtolower($menu['codigo'].'/'.$menu['uri_servicio']));
						
                        
						$tmp_id_link = "link-lang-".mb_strtolower($menu['codigo']);
						$tmp_cod_lang = $menu['codigo'];
						$tmp_cod_lang_icon=strtolower($menu['codigo']);
                        $tmp_cod_lang_icon = $tmp_cod_lang_icon!='en'?$tmp_cod_lang_icon:'us';
						echo "<a href='$tmp_base_url' id='$tmp_id_link' class='dropdown-item'><strong><i class='$tmp_cod_lang_icon flag'></i> $tmp_cod_lang</strong></a>";
					}
				?>
			</div>
		</div>
	</div>
	<div class="col-sm col-md-auto col-4">
		<a class="btn btn-link" style="position: relative;color: #fff;" href="/<?=$language?>/checkout/cart">
                <i class="fa fa-shopping-cart" style="font-size:1.5em;" aria-hidden="true"></i>
                <span class="badge badge-pill badge-danger" id="count-cart" style="position:absolute;right:0;top:0"></span>
              </a>
	</div>
	<?php echo 	$data_contac; ?>
</div>
<?php endif ?>
<script>
$(document).ready(function() {
    $('.dropdown-submenu a.test').on("click", function(e) {
        $(this).next('ul').toggle();
        e.stopPropagation();
        e.preventDefault();
    });
    $('#input_lol').keyup(function(e) {
        var code = e.which;
        if (code == 13) {
            $('.btn-search').click(); //Trigger search button click event
            $("#searchGoogleModal2").modal();
        }
    });
    $(".btn-search").click(function() {
        //alert("hola");
        var input = $("#input_lol");
        var element = google.search.cse.element.getElement('searchresults-only0');
        element.execute(input.val());
        $("#search_modal").val(input.val());
        //$("#search").val('');
    });
    $('#search_modal').keypress(function(e) {
        if (e.which == 13) { //Enter key pressed
            $('.btn-search-button').click(); //Trigger search button click event
        }
    });
    /*para los dropdown*/
    $('.dropdown-toggle').dropdown()
});
$(document).on('click', '.btn-search-button', function(event) {
    var input = $("#search_modal");
    var element = google.search.cse.element.getElement('searchresults-only0');
    element.execute(input.val());
});
$(document).on('click', '.btn-search-button-mobile', function(event) {
    $("#searchGoogleModal2").modal();
    $('#search_modal').focus();
});

$('#search_modal').addClass('form-control').css('width', '100%');
</script>
<style>	
.div-header-main{
	/*background: var(--color-primary);*/
	background: #1a4c80;
	color: #ddd;
	margin: 0 !important;
}
em.mm-counter+a.mm-next{
	width: 100% !important;
}
/*estilos a los botones de las redes sociales*/
#redes_sociales> a{
	color:#eee;
    margin-left:3px;
    text-decoration:none;
	padding:5px;
	display:block;
	float:left;

}
#redes_sociales> a:hover{
	color:white;
}
#redes_sociales{  
}
</style>