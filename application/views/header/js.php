<!-- Global site tag (gtag.js) - Google Analytics by froy -->
<script src="https://www.googletagmanager.com/gtag/js?id=UA-109542775-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-109542775-1');
  gtag('config', 'AW-946004111');
</script>
<?php
// Ya no mostramos el código por que hemos agregago arriba el gtag('config', 'AW-946004111');
if(false){
?>
<!-- Global site tag (gtag.js) - Google AdWords: 946004111 -->
<script src="https://www.googletagmanager.com/gtag/js?id=AW-946004111"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-946004111');
</script>
<?php
}
?>
<script src="<?=base_url();?>assets/resources/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?=base_url(); ?>assets/resources/js/incalake.js" type="text/javascript"></script>
<script src="<?=base_url(); ?>assets/resources/popper.js/umd/popper.min.js"></script>
<script src="<?=base_url(); ?>assets/resources/bootstrap4/js/bootstrap.min.js"></script>
<script src="<?=base_url();?>assets/resources/notify/notify.min.js" type="text/javascript"></script>
<!--  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.es.min.js"></script>
<script src="<?=base_url();?>assets/resources/js/suscripciones.js" type="text/javascript"></script>
<!--  -->
<script >
/*fin del funcion de personalizar el menu derecho*/
/*
window.$zopim || function(a, b) {
console.log('000');
    var c = $zopim = function(a) {
            c._.push(a);
console.log('1111');
        },
        d = c.s = a.createElement(b),
        e = a.getElementsByTagName(b)[0];
    c.set = function(a) {
console.log('2222');
        c.set._.push(a)
    }, c._ = [], c.set._ = [], d.async = !0, d.setAttribute("charset", "utf-8"), d.src = "//v2.zopim.com/?1IklAHllvGDF4LzNvH49FK65Snt4sk3I", c.t = +new Date, d.type = "text/javascript", e.parentNode.insertBefore(d, e)
}(document, "script");
*/

</script>
<div class="modal  bd-example-modal-sm" id="myModal_ver_browser" style="background-color: rgba(0, 0, 0, 0.52) !important;">
  <div class="modal-dialog modal-md" style="margin-top: 25%;">
    <div class="modal-content">
      
      <div class="modal-header bg-primary text-light">
        <h5 class="modal-title" id="exampleModalLabel"><?=(strtolower($language)=='es'?'Recomendación':'Recommendation')?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-justify">
        <?=(strtolower($language)=='es'?'Le recomendamos utilizar <a href="//www.google.es/chrome" target="_blank"><b>"Google Chrome"</b></a>, <a href="https://www.mozilla.org/es-ES/firefox/new/" target="_blank"><b>"Mozilla Firefox"</b></a>  o <b>actualizar su navegador</b> para mejorar la <b>velocidad</b>, compatibilidad de <b>nuevas tecnologias</b> y sobre todo su <b>comodidad y mejor experiencia</b>':'We recommend you use <a href="//www.google.com/intl/en/chrome" target="_blank"><b>"Google Chrome"</b></a>, <a href="https://www.mozilla.org/es-ES/firefox/new/" target="_blank"><b>"Mozilla Firefox"</b></a> or update your browser to improve speed, <b>compatibility of new technologies</b> and especially its quality and<b> better experience </b>');?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn_close_browser" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn_ok_browser" data-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>
<?php
$this->load->view('php/browser.php');
    $browser = new Browser();
    $name_browser=$browser->getBrowser();
    $ver_browser=$browser->getVersion();
?>
  <script>
// Get the modal
var name_browser=('<?=$name_browser;?>').toUpperCase();
var ver_browser=<?=json_encode(explode(".", $ver_browser)); ?>;

console.log(name_browser.toUpperCase()+' '+ver_browser[0]);
var modal = document.getElementById('myModal_ver_browser');
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];
var btn_close =document.getElementsByClassName("btn_close_browser")[0];
var btn_ok=document.getElementsByClassName("btn_ok_browser")[0];
// btn.onclick = function() {
//     modal.style.display = "block";
// }
span.onclick = function() {
    modal.style.display = "none";
}
btn_close.onclick=function(){
  modal.style.display='none';
}
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

var today = new Date();
var fecha_actual = parseInt(today.getFullYear()+''+today.getMonth()+''+today.getDate());
if (typeof(Storage) !== "undefined") {
    // Store
    if (localStorage.getItem("modal_browser_help")==null) {
      localStorage.setItem('modal_browser_help',parseInt(parseInt(today.getFullYear()+''+today.getMonth())+''+(today.getDate()+5)));
    }
} else {
    console.log("Sorry, your browser does not support Web Storage...");
}
if (fecha_actual>localStorage.getItem('modal_browser_help')) {


switch(name_browser) {
    case 'OPERA':
        if (ver_browser[0]>=11.51) {}else{modal.style.display = 'block';}
        break;
    case 'EDGE':
        if (ver_browser[0]>=15) {}else{modal.style.display = 'block';}
        break;
    case 'CHROME':
        if (ver_browser[0]>=61) {}else{modal.style.display = 'block';}

        break;
    case 'FIREFOX':
        if (ver_browser[0]>=52) {}else{modal.style.display = 'block';}
        break;
    case 'SAFARI':
        if (ver_browser[0]>=10.1) {}else{modal.style.display = 'block';}
        break;
    default:
        modal.style.display = 'block';
}
// modal.style.display = 'block';
    btn_ok.onclick=function(event){
      localStorage.setItem('modal_browser_help',parseInt(parseInt(today.getFullYear()+''+today.getMonth())+''+(today.getDate()+5)));
modal.style.display = "none";
              console.log(localStorage.getItem("modal_browser_help"));
    }
}  
</script>
<!-- Script añadido por froy el 20-08-2018 -->
<!--script type='text/javascript' data-cfasync='false'>window.purechatApi = { l: [], t: [], on: function () { this.l.push(arguments); } }; (function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({c: '134a44db-cbe2-4118-a301-f77c5b8dc830', f: true }); done = true; } }; })();</script-->
<!-- Start of HubSpot Embed Code -->
<!--script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/4849465.js"></script-->
<!-- End of HubSpot Embed Code -->
<!-- fin script añadido el 20-08-2018 -->
