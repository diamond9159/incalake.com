<?php 
	if(count(json_decode($_COOKIE['cart'], true)) == 0) {
		redirect('/', 'location');
	} 
?>
<div  id="app">
    <?php $step = 2;  require('navbar_payment.php')  ?>
    <customer-form></customer-form>
</div>