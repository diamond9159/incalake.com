<? 
$to      = 'agomez@staccr.net'; 
$subject = 'The test for php mail function'; 
$message = 'Hello'; 
$headers = 'From: test@test.com' . "\r\n" . 
    'Reply-To: test@test.com' . "\r\n" . 
    'X-Mailer: PHP/' . phpversion(); 
mail($to, $subject, $message, $headers); 
?>   