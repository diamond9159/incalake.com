<div id="app">
    <?php $step = 1;  require('navbar_payment.php')  ?>
    <checkout-carro></checkout-carro>
</div>
<style>
<style>
.div-img-activity,.card-img-gif {
    position: relative;
    width: 100%;
}

.img-card {
  opacity: 1;
  display: block;
  width: 100%;
  height: auto;
  transition: .5s ease;
  backface-visibility: hidden;
  cursor: pointer;
}

.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  color: #000;
}

.card-img-gif:hover .img-card, .div-img-activity:hover .img-card {
  opacity: 0.3;
}

.card-img-gif:hover .middle, .div-img-activity:hover .middle {
  opacity: 1;
}
.gift_selected{
	padding: 0 !important;
}

</style>

