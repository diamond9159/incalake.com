<?php header('Content-Type: application/javascript'); ?>

$(document).ready(function(){
<?php $detect = new Mobile_Detect; ?>
<?php if ($detect->isMobile()) { ?>

<?php } else { ?>
    $('header>nav').appendTo('.div-header-main');
<?php } ?>
var nav = $('header>nav');

var lastScrollTop = 0;

$(window).scroll(function(event){
var st = $(this).scrollTop();

if (st > lastScrollTop || st < 109){ // downscroll code // console.log("Scroll down");
    nav.removeClass("navbar-fixed-top").addClass('navbar-custom'); } else { // upscroll code // console.log("Scroll
    up"); nav.addClass("navbar-fixed-top").removeClass('navbar-custom'); } lastScrollTop=st; // console.log(st); });
    $('.panel').find('.panel-title').append('<span class="fa fa-chevron-down" style="float:right;"></span>');
    });