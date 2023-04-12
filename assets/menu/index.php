<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Menu Incalake</title>
<style>
body{
  padding: 5px;
  margin:0;
}
ul {
  list-style: none;
  padding: 0;
  margin: 0;
  background: #1E6496;
}
 
ul li {
  display: block;
  position: relative;
  float: left;
  background: transparent;
}
ul.main-navigation li {
   border-left:1px solid #346181;
} 
ul.main-navigation li:nth-child(1) {
   border-left:none;
}
/* This hides the dropdowns */
 
 
li ul { display: none; }
 
ul li a {
  display: block;
  padding: 1em;
  text-decoration: none;
  white-space: nowrap;
  color: #fff;
}
 
ul li a:hover { background: #43667F; }
 
/* Display the dropdown */
 
 
li:hover > ul {
  display: block;
  position: absolute;
}
 
li:hover li { float: none; }
 
li:hover a { background: #1F6699; }
 
li:hover li a:hover { background: #49799B; }
 
.main-navigation li ul li { border-top: 0; }
 
/* Displays second level dropdowns to the right of the first level dropdown */
 
 
ul ul ul {
  left: 100%;
  top: 0;
}
 
/* Simple clearfix */
 
 
 
ul:before,
ul:after {
  content: " "; /* 1 */
  display: table; /* 2 */
}
 
ul:after { clear: both; }
</style>
</head>
 
<body>
<?php
/*$con=mysqli_connect("localhost","root","","cms_incalake");
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
 
// Perform queries 
 
function get_menu_tree($parent_id=0) 
{
  global $con;
  $menu = "";
  $sqlquery = " SELECT * FROM menu where parent_id='" .$parent_id . "' ORDER BY menu_id ASC, prioridad ASC";
  $res=mysqli_query($con,$sqlquery);
    while($row=mysqli_fetch_array($res,MYSQLI_ASSOC)) 
  {
           $menu .="<li><a href='".$row['link']."'>".$row['menu_name']."</a>";
       
       $menu .= "<ul>".get_menu_tree($row['menu_id'])."</ul>"; //call  recursively
       
       $menu .= "</li>";
 
    }
    
    return $menu;
} */
$file = !empty($_GET['idioma'])?$_GET['idioma'].'.txt':'ES'.'.txt';
  $json = null;
  if(file_exists($file)){
        $myfile = fopen($file, "r");
      $json = @fread($myfile,filesize($file));
      fclose($myfile);
    }

//$hola = include('web/assets/menu/ES.txt');
  $json = json_decode($json,true);
  

      function get_menu_tree($parent_id=0) 

{ 
  global $json;
  //var_dump($json);
        //$colores = array('default','warning','success','info','primary','danger');
       //global $new_array_links;
        $menu = "";
      // var_dump($GLOBALS['MENU']);exit;
        //$sqlquery = " SELECT * FROM menu where status=1 and parent_id='" .$parent_id . "' ";
      

       if(is_array(@$json[$parent_id])){
         foreach($json[$parent_id] as $key => $value){
       
          $cantidad = @count($json[$value['id']]);
                 /*$menu .="<li class='list-group-item'><a href='".$value['link']."'>".$value['menu_name']."</a>";
             
             $menu .= "<ul class='list-group'>".get_menu_tree($value['menu_id'])."</ul>"; //call  recursively
             
             $menu .= "</li>";*/
           $menu .="<li><a href='".$value['url']."'>".$value['nombre'].($cantidad?' ('.$cantidad.')':null)."</a>";
       
           $menu .= "<ul>".get_menu_tree($value['id'])."</ul>"; //call  recursively
           
           $menu .= "</li>";
          
          }

        }
          
          return $menu;
      }
?>
<header>
 <div>
 <img src="../img/logo.png" width="150px" style="margin:-20px 0 -20px 0;vertical-align: middle;" />
 <select style="padding:5px;float:right" onchange="location.href='?idioma='+this.value">
  <option value="">--Idiomas--</option>
    <?php
      foreach (glob("*.txt") as $nombre_fichero) {
         echo "<option ".($file==$nombre_fichero?'selected':null).">".explode(".",$nombre_fichero)[0]."</option>";
      }
    ?>
 </select>
 </div>
<ul class="main-navigation">
<?php echo get_menu_tree();//start from root menus having parent id 0 ?>
</ul> 
</header>
 <img src="../img/slider.png" width="100%" />
</body>
</html>
