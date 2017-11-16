<?php
	//Et pääseks ligi funktsioonidele ja sessionile
	require("functions.php");
	require("../../../config.php");
	//Kui pole sisseloginud, liigume login lehele
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}

	if(isset($_GET["Logout"])){
		session_destroy();
		header("Location: login.php");
		exit();
	}

	//kommentaare kasutame koodiblokkide nimetamiseks
	//muutujad:

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Jan-Rossi veebiprogrammerimise raames loodud leht</title>
</head>
<body>

	<h1>Teretulemast <?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
	<p>See veebileht on loodud õppetöö raames ning ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<br>
	<p><a href="main.php">Pealeht</a></p>
	<br>
	<p><a href="?Logout=1">Logi välja!</a></p>
	<br>
	<h2>Kõik süsteemi kasutajad</h2>
	<table border="1" style="border: 1px solid black; border-collapse: collapse">
	<tr>
	<th>Jrk</th><th>eesnimi</th><th>perekonnanimi</th><th>sünnipäev</th><th>e-mail</th><th>sugu</th>
	</tr>
	<tr>
	<?php echo listUsers();?>
	</tr>
	</table>


</body>
</html>