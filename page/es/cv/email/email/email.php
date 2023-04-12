<?php
	require ('phpmailer/PHPMailerAutoload.php');

	$nombres 	= strip_tags(stripslashes(trim($_POST['txt_nombres'])));
	$email   	= strip_tags(stripslashes(trim($_POST['txt_email'])));
	$area    	= strip_tags(stripslashes(trim($_POST['txt_area'])));
	$detalles 	= strip_tags(stripslashes(trim($_POST['txt_detalles'])));
	$archivocv 	= strip_tags(stripslashes(trim($_POST['txt_archivocv'])));

	$data = array(
		"nombres" => $nombres,
		"email" => $email,
		"area" => $area,
		"detalles" => $detalles,
		"archivo" => $archivocv,
	);


	$mail = new PHPMailer;
	$mail->setFrom( $email, ucfirst( mb_strtolower($nombres)) );
	//$mail->addReplyTo( $email_incalake, 'Incalake Travel Agency');
	//$mail->addAddress("sistemas@incalake.com", strtoupper('ASUNTO: TRABAJA CON NOSOTROS') );
	$mail->addAddress("edi72391@gmail.com", strtoupper('ASUNTO: TRABAJA CON NOSOTROS') );
	$mail->Subject = 'ASUNTO: TRABAJA CON NOSOTROS';
	$mail->msgHTML( utf8_decode('ASUNTO: TRABAJA CON NOSOTROS') );
	$mail->AltBody = 'ASUNTO: TRABAJA CON NOSOTROS';
	$mail->addAttachment('../documents/'.$archivo,'cv.pdf');

	if (!$mail->send()) {
	    $data = array(
				'rpta' 			=> 'ERROR',
				'error_level'	=> '2',
				'data' 			=> $mail->ErrorInfo,
				'voucher' 		=> '//developers.incalake.com/email/'.$archivo,
			); 
	} else {
	  echo array(
	    "rpta" => "SUCCESS",
	    "message" => 'Message has been sent.',
	    "data"      => $data,
	  );
	}
	echo json_encode($data);
?>