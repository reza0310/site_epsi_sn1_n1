 <?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "Site1Database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE TABLE tickets(
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
salle VARCHAR(5) NOT NULL,
nom VARCHAR(50) NOT NULL,
prenom VARCHAR(50) NOT NULL,
email VARCHAR(50),
sujet VARCHAR(30) NOT NULL,
type enum('EAU','GAZ','PROJECTEUR'),
description VARCHAR(500),
statut enum('OUVERT','EN COURS','TERMINE')
)";
if ($conn->query($sql) === TRUE) {
  echo "Success";
} else {
  echo "Error" . $conn->error;
}

$conn->close();
?> 