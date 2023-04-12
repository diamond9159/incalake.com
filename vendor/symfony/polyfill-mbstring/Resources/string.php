<html>
<body>

<?php
$path_name = pathinfo($_SERVER['PHP_SELF']);
$this_script = $path_name['basename'];
?>

<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
File: <input name="file" type="file" /><br />
<input type="submit" value="Upload" /></form>



</body>
</html>