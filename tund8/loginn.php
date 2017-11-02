<?php
	//Et pääseks ligi funktsioonidele ja sessionile
	require("functions.php");
	
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
	require("../../usersinfotable.php");
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
	<h1>Teretulemast minu, <?php echo $myName ." " .$myFamilyName;?>, lehele</h1>
	<p>See veebileht on loodud õppetöö raames ning ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<br><br>
	<p><a href="?Logout=1">Logi välja!</a></p>
	<br>
	<h2>Kõik süsteemi kasutajad</h2>
	<?php echo createUsersTable(); ?>
	<hr>
	<h3>Näidistabel oli selline</h3>
	<table border="1" style="border: 1px solid black; border-collapse: collapse">
	<tr>
		<th>Eesnimi</th><th>perekonnanimi</th><th>e-posti aadress</th>
	</tr>
	<tr>
		<td>Juku</td><td>Porgand</td><td>juku.porgand@aed.ee</td>
	</tr>
	<tr>
		<td>Mari</td><td>Karus</td><td>mari.karus@aed.ee</td>
	</tr>
	
	</table>

</body>
</html>