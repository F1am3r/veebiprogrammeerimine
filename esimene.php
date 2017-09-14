<?php
	//kommentaare kasutame koodiblokkide nimetamiseks
	//muutujad:
	$myName = "Jan-Ross";
	$myFamilyName = "Liiver";
	
	//hindan päeva osa
	$hourNow = date("H");
	$partOfDay = "";
	if ($hourNow < 8){
		$partOfDay = "varajane hommik";
	}
	if ($hourNow >= 8 and $hourNow < 16){
		$partOfDay = "koolipäev";
	}
	if ($hourNow >16){
		$partOfDay = "Vaba aeg";
	}
	echo "<p>Hetkel on: " .$partOfDay;
	echo "</p>";
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
	<p>Kodus lisasin oma arvutist selle lõigu siia juurde</p>
	<?php 
		echo "<p>Algas php õppimine!</p>";
		echo "<p>Täna on "; 
		echo date("d.m.Y.") ." Kell oli lehe avamise hetkel " .date("H:i:s");
		echo "</p>";
	?>
	

</body>
</html>