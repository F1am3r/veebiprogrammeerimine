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
	
	//kommentaare kasutame koodiblokkide nimetamiseks
	//muutujad:
	$myName = "Jan-Ross";
	$myFamilyName = "Liiver";
	$picDir = "../../pics/";
	$picFiles = [];
	$picFileTypes = ["jpg", "jpeg", "png", "gif"];
	
	
	$allFiles = array_slice(scandir($picDir),2);
	foreach ($allFiles as $file){
		$fileType = pathinfo($file, PATHINFO_EXTENSION);
		if (in_array($fileType, $picFileTypes) == true){
			array_push($picFiles, $file);
		}
	}
	
	//var_dump($allFiles);
	//$picFiles = array_slice($allFiles,2);
	//var_dump($picFiles);
	$picFileCount = count($picFiles);
	$picNumber = mt_rand(0,$picFileCount -1);
	$picFile = $picFiles[$picNumber];
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
	<br>
	<p><a href="usersIdeas.php">Head mõtted</a></p>
	<br>
	<p><a href="?Logout=1">Logi välja!</a></p>
	<br>
	<img src="<?php echo $picDir . $picFile;?>" alt="Tallinna Ülikool">
</body>
</html>