<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

set_include_path($_SERVER['DOCUMENT_ROOT'].'/projet_site');
include 'mdp.php';

$salle = $_POST["salle"];
$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$email = $_POST["email"];
$sujet = $_POST["sujet"];
$type = $_POST["type"];
$description = $_POST["description"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// Compte
$sql = "SELECT * FROM clients WHERE mail='{$email}'";
$result = mysqli_fetch_array(mysqli_query($conn,$sql));
if ($result == null) {
	$chars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
	$mdp = "";
	for ($i = 0; $i < 11; $i++) {
		$mdp .= $chars[rand(0, count($chars)-1)];
	}
	$hash = password_hash($mdp, PASSWORD_DEFAULT);
	$headers = array(
		'From' => 'mdp@odaame.org',
		'X-Mailer' => 'PHP/' . phpversion()
	);
	$sql = "INSERT INTO clients (mail, mdp) VALUES ('{$email}', '{$hash}')"; 	
	if ($conn->query($sql) === TRUE) {
		mail($email, "Votre mot de passe", "Bonjour! Nous avons constaté que le ticket que vous venez de créer votre tout premier ticket sur notre site. Pour accéder à sa progression, de celui-ci et des suivants, nous vous avons créé un compte. Votre mot de passe est donc '".$mdp."'. Cordialement, PHP.", $headers);
	} else {
		echo "Request error: " . $conn->error;
	}
}

// Ticket
$today = getdate();
$date = $today["year"]."-".$today["mon"]."-".$today["mday"];
$sql = 'INSERT INTO tickets (salle, nom, prenom, email, sujet, type, description, statut, date_debut) VALUES ("'.$salle.'", 
"'.$nom.'",
"'.$prenom.'",
"'.$email.'",
"'.$sujet.'",
"'.$type.'",
"'.$description.'", 
"OUVERT",
"'.$date.'")';

$headers = array(
	'From' => 'ouverture@odaame.org',
	'X-Mailer' => 'PHP/' . phpversion()
);
mail($email, "Ouverture de ticket", "Bonjour! Nous confirmons la bonne réception de votre ticket. Cordialement, PHP.", $headers);

if ($conn->query($sql) === TRUE) {
	echo(str_replace("quatro", "active", str_replace("%php%", file_get_contents("page.html"), file_get_contents("header.html", true))));
} else {
	echo "Request error: " . $conn->error;
}

$conn->close();
?>
