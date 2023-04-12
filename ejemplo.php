<?php

require("assets/email/phpmailer/PHPMailerAutoload.php");
    $Staccr = '$Staccr2018';
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "mail.staccr.net"; // SMTP a utilizar. Por ej. smtp.elserver.com
    $mail->Username = "agomez@staccr.net"; // Correo completo a utilizar
    $mail->Password = "$Staccr"; // Contraseña
    $mail->Port = 25; // Puerto a utilizar
    $mail->From = "reservas@incalake.com"; // Desde donde enviamos (Para mostrar)
    $mail->FromName = "Reservas | Incalake";
    $mail->AddAddress("agomez@staccr.net"); // Esta es la dirección a donde enviamos
    $mail->AddCC("reservas@incalake.com"); // Copia
    $mail->AddBCC("lan.gmez23@gmail.com"); // Copia oculta
    $mail->IsHTML(true); // El correo se envía como HTML
    $mail->Subject = "Prueba de función ALAN GOMEZ"; // Este es el titulo del email.
    $body = ("Hola mundo. Esta es la primer línea<br />");
    $mail->Body = $body; // Mensaje a enviar
    $mail->AltBody = ("Hola! Esta es una prueba de envío desde servidor ");
    
    $exito = $mail->Send();
    
    if($exito)
    {
        echo 'El correo fue enviado correctamente.';
    }
    else
    {
        echo 'Hubo un inconveniente. Contacta a un administrador.', ' - ', $exito;
    }

?>