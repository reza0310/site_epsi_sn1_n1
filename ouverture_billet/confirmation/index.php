<?php
$servername = "localhost";
$username = "root";
$password = "root";

$salle = $_POST["salle"];
$nom = $_POST["nom"];
$prenom = $_POST["prenom"];
$email = $_POST["email"];
$sujet = $_POST["sujet"];
$type = $_POST["type"];
$description = $_POST["description"];

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO tickets VALUES ('"+$salle+"', '"+$nom+"', '"+$prenom+"', '"+$email+"', '"+$sujet+"', '"+$type+"', '"+$description+"')";
if ($conn->query($sql) === TRUE) {
	set_include_path("D:\\site_n_1");
	echo(str_replace("%php%", file_get_contents("page.html"), file_get_contents("header.html", true)));
} else {
	echo "Request error: " . $conn->error;
}

$conn->close();
?>