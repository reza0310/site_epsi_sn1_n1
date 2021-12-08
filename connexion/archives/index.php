<?php
set_include_path($_SERVER['DOCUMENT_ROOT']."/projet_site");
session_start();
if (password_verify($_SESSION["password"], "$2y$10\$jhPhoMionbSvkR7JyAGZrOH1nrmIXJO/l.NuBq5yfYi2GOaXzC5WW")) {
	include 'mdp.php';
	
	$con=mysqli_connect($servername,$username,$password,$dbname);
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
	}
	$sql = "SELECT * FROM tickets WHERE statut='TERMINE'";
	$result = mysqli_query($con,$sql);
	
	echo ("Bienvenue technicien!<br>"); 
	$page = "";
	while ($colonne = mysqli_fetch_array($result)) {
		$page .= "<div class='ticket ferme'>";
		$page .= "Demandeur: ".$colonne[3]." ".$colonne[2]."<br>";
		$page .= "Mail: ".$colonne[4]."<br>";
		$page .= "Salle: ".$colonne[1]."<br>";
		$page .= "Problème de: ".$colonne[6]."<br>";
		$page .= "Intitulé: ".$colonne[5]."<br>";
		$page .= "Problème développé: ".$colonne[7]."<br>";
		$page .= "Statut: ".$colonne[8]."<br>";
		$page .= "</div>";
	}
	$page .= "<form method='post' action='/projet_site/connexion/problemes/index.php'><input name='pseudo' type='hidden' value='Technicien'><input type='submit' value='Retourner aux tickets'></form>";
	echo(str_replace("dos", "active", str_replace("%php%", $page, file_get_contents("header.html", true))));
	mysqli_close($con);
} else {
	header( "Location: /projet_site" );
}
?>