<?php
set_include_path($_SERVER['DOCUMENT_ROOT']."projet_site");
$servername = "localhost";
$username = "root";
$password = "root";
$db = "site1database";

$id = $_POST["ticket"];
$statut = $_POST["statut"];

$con=mysqli_connect($servername,$username,$password,$db);
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
$sql = "UPDATE tickets SET statut = '".$statut."' WHERE id='".$id."'";
$result = mysqli_query($con,$sql);
 
$page = "";
$page .= "Votre changement a bien été pris en compte!";
$page .= "<form method='post' action='index.php'><input name='pseudo' type='hidden' value='Technicien'><input name='password' type='hidden' value='324JGI'><input type='submit' value='Retour'></form>";

echo(str_replace("%php%", $page, file_get_contents("header.html", true)));
mysqli_close($con);
?>