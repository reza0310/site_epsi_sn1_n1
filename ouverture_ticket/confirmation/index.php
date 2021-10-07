<?php
set_include_path($_SERVER['DOCUMENT_ROOT']."/projet_site");
include 'mdp.php';

$salle = $_POST["salle"];
$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$email = $_POST["email"];
$sujet = $_POST["sujet"];
$type = $_POST["type"];
$description = $_POST["description"];

// Create connection
$conn = new mysqli($servername, $username, $password, $db);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = 'INSERT INTO tickets (salle, nom, prenom, email, sujet, type, description, statut) VALUES ("'.$salle.'", 
"'.$nom.'",
"'.$prenom.'",
"'.$email.'",
"'.$sujet.'",
"'.$type.'",
"'.$description.'", "OUVERT")';

if ($conn->query($sql) === TRUE) {
	set_include_path($_SERVER['DOCUMENT_ROOT']."projet_site");
	echo(str_replace("uno", "active", str_replace("%php%", file_get_contents("page.html"), file_get_contents("header.html", true))));
} else {
	echo "Request error: " . $conn->error;
}

$conn->close();
?>