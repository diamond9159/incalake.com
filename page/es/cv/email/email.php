<?php
	require ('email/phpmailer/PHPMailerAutoload.php');

	$nombres 	= strip_tags(stripslashes(trim($_POST['txt_nombres'])));
	$email   	= strip_tags(stripslashes(trim($_POST['txt_email'])));
	$area    	= strip_tags(stripslashes(trim($_POST['txt_area'])));
	$detalles 	= strip_tags(stripslashes(trim($_POST['txt_detalles'])));
	$archivocv 	= strip_tags(stripslashes(trim($_POST['txt_archivocv'])));
/*
	$data = array(
		"nombres" => $nombres,
		"email" => $email,
		"area" => $area,
		"detalles" => $detalles,
		"archivo" => $archivocv,
	);
*/
	$email_html = "";
	$email_html .= "<b>NOMBRES:</b> ".strtoupper($nombres)."<br/><b>EMAIL:</b> ".strtolower($email)."<br/><b>AREA:</b> ".mb_strtoupper($area)."<br/><b>MAS DETALLES:</b> ".mb_strtoupper($detalles);

	$mail = new PHPMailer;
	$mail->setFrom( $email, strtoupper( mb_strtolower($nombres)) );
	//$mail->addReplyTo( $email_incalake, 'Incalake Travel Agency');
	$mail->addAddress("reservas@incalake.com", strtoupper('ASUNTO: TRABAJA CON NOSOTROS') );
	//$mail->addAddress("edi72391@gmail.com", strtoupper('ASUNTO: TRABAJA CON NOSOTROS') );
	$mail->Subject = 'ASUNTO: TRABAJA CON NOSOTROS';
	$mail->msgHTML( utf8_decode( $email_html ) );
	$mail->AltBody = 'ASUNTO: TRABAJA CON NOSOTROS';
	$mail->addAttachment('documents/'.$archivocv,'cv.pdf');

	if (!$mail->send()) {
	    $data = array(
				'rpta' 			=> 'ERROR',
				'data' 			=> $mail->ErrorInfo,
				'voucher' 		=> $archivocv,
			); 
	} else {
	    $data = array(
				'rpta' 			=> 'OK',
				'data' 			=> '',
				'voucher' 		=> $archivocv,
			); 
	}
	echo json_encode($data);
?>