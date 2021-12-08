<?php
set_include_path($_SERVER['DOCUMENT_ROOT']."/projet_site");
include 'mdp.php';
session_start();
if (password_verify($_SESSION["password"], "$2y$10\$jhPhoMionbSvkR7JyAGZrOH1nrmIXJO/l.NuBq5yfYi2GOaXzC5WW")) {
	$id = $_POST["ticket"];
	$statut = $_POST["statut"];

	$con=mysqli_connect($servername,$username,$password,$dbname);
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  exit();
	}
	$sql = "UPDATE tickets SET statut = '".$statut."' WHERE id='".$id."'";
	$result = mysqli_query($con,$sql);

	if ($statut == "TERMINE") {
		$today = getdate();
		$date = $today["year"]."-".$today["mon"]."-".$today["mday"];
		mysqli_query($con, "UPDATE tickets SET date_fin = '".$date."' WHERE id = '".$id."'");
		
		$data = mysqli_fetch_array(mysqli_query($con, "SELECT email, sujet FROM tickets WHERE id = '".$id."'"));
		$email = $data[0];
		$ticket = $data[1];
		$headers = array(
			'From' => 'cloture@odaame.org',
			'X-Mailer' => 'PHP/' . phpversion()
		);
		mail($email, "Cloture de ticket", "Bonjour! Nous vous informons que votre ticket intitulé ".$ticket." vient d'être clôt. Cordialement, PHP.", $headers);
	}

	$page = "Votre changement a bien été pris en compte!";
	$page .= "<form method='post' action='index.php'><input name='pseudo' type='hidden' value='Technicien'><input type='submit' value='Retour'></form>";

	echo(str_replace("dos", "active", str_replace("%php%", $page, file_get_contents("header.html", true))));
	mysqli_close($con);
}
?>
