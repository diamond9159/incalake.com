<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Pruebas</title>
	
    

</head>
<body>
    ssssss
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.js"></script>
    <script type="text/javascript">
    
    $(document).ready(function(){
        enviar_correo();
    });
    
    function enviar_correo(){
        var codRes = "515";
        $.ajax({
            url: 'https//incalake.com/operador/enviarEmail/'+parseInt(codRes),
            type: 'POST',
            dataType: 'json',
            data: {cr: codRes},
        }).done(function(data) {
            console.log("success");
        }).fail(function(e) {
            console.log(e.responseText);
        });
    }
    </script>
</body>
</html>