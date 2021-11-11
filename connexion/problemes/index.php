<?php
set_include_path($_SERVER['DOCUMENT_ROOT']."/projet_site");
include 'mdp.php';
$pseudo = $_POST["pseudo"];
if (isset($_POST["password"])) {
	$mdp = $_POST["password"];
} else {
	session_start();
	$mdp = $_SESSION["password"];
}

$con=mysqli_connect($servername,$username,$password,$dbname);
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

$query = "SELECT * FROM clients WHERE mail='$pseudo'";
$result = $con->query($query);
$row = $result->fetch_array(MYSQLI_NUM);
if ($pseudo == "Technicien" && password_verify($mdp, "$2y$10\$jhPhoMionbSvkR7JyAGZrOH1nrmIXJO/l.NuBq5yfYi2GOaXzC5WW")) {
	$sql = "SELECT * FROM tickets WHERE NOT statut='TERMINE'";
	$result = mysqli_query($con,$sql);
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
		$_SESSION["password"] = $mdp;
	}
	
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
		if ($colonne[8] == "OUVERT") {
			$page .= "<form method='post' action='changer.php'><input name='ticket' type='hidden' value='".$colonne[0]."'><input name='statut' type='hidden' value='EN COURS'><input type='submit' value=\"S'en occuper\"></form>";
		} else if ($colonne[8] == "EN COURS") {
			$page .= "<form method='post' action='changer.php'><input name='ticket' type='hidden' value='".$colonne[0]."'><input name='statut' type='hidden' value='TERMINE'><input type='submit' value='Clore'></form>";
		}
		$page .= "</div>";
	}
	$page .= "<form method='post' action='/projet_site/connexion/archives/index.php'><input type='submit' value='Aller aux archives'></form>";
	echo(str_replace("dos", "active", str_replace("%php%", $page, file_get_contents("header.html", true))));
} elseif ($row == null or !password_verify($mdp, $row[1])) {
	header( "Location: /projet_site" );
} else {
	$sql = "SELECT * FROM tickets WHERE email='$pseudo'";
	$result = mysqli_query($con,$sql);
	
	echo ("Bienvenue client!<br>"); 
	$page = "";
	while ($colonne = mysqli_fetch_array($result)) {
		$page .= "<div class='ticket'>";
		$page .= "Salle: ".$colonne[1]."<br>";
		$page .= "Problème de: ".$colonne[6]."<br>";
		$page .= "Intitulé: ".$colonne[5]."<br>";
		$page .= "Problème développé: ".$colonne[7]."<br>";
		$page .= "Statut: ".$colonne[8]."<br>";
		$page .= "</div>";
	}
	echo(str_replace("dos", "active", str_replace("%php%", $page, file_get_contents("header.html", true))));
}
mysqli_close($con);
?>