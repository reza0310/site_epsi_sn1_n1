<?php
set_include_path($_SERVER['DOCUMENT_ROOT']."projet_site");
$pseudo = $_POST["pseudo"];
$mdp = $_POST["password"];
if ($pseudo == "Technicien" && $mdp == "324JGI") {
	
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$db = "site1database";
	
	$con=mysqli_connect($servername,$username,$password,$db);
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
	}
	$sql = "SELECT * FROM tickets";
	$result = mysqli_query($con,$sql);
	
	echo ("Bienvenue technicien!<br>"); 
	$page = "";
	while ($colonne = mysqli_fetch_array($result)) {
		$page .= "<div class='ticket'>";
		$page .= "Demandeur: ".$colonne[3]." ".$colonne[2]."<br>";
		$page .= "Mail: ".$colonne[4]."<br>";
		$page .= "Salle: ".$colonne[1]."<br>";
		$page .= "Problème de: ".$colonne[6]."<br>";
		$page .= "Intitulé: ".$colonne[5]."<br>";
		$page .= "Problème développé: ".$colonne[7]."<br>";
		$page .= "Statut: ".$colonne[8]."<br>";
		$page .= "</div>";
	}
	echo(str_replace("%php%", $page, file_get_contents("header.html", true)));
	mysqli_close($con);
} else {
	header( "Location: /projet_site" );
}
?>