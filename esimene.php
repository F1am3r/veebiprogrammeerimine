<?php
	//kommentaare kasutame koodiblokkide nimetamiseks
	//muutujad:
	$myName = "Jan-Ross";
	$myFamilyName = "Liiver";
	$monthNamesEt = ["midaiganes","jaanuar","veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	//var_dump($monthNamesEt); see näitab kogu array-d ehk kogu massiivi
	//echo($monthNamesEt[9]); kuidas massiivist näidata kindlat muutujat
	$monthNow = $monthNamesEt[date("n")];
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
	
	//vanusega tegelemine
	//var_dump($_POST);
	//echo $_POST["birthYear"];
	$myBirthYear;
	$ageNotice = "";
	if (isset($_POST["birthYear"]) and $_POST["birthYear"] != 0){
		$myBirthYear = $_POST["birthYear"];
		$myAge = date("Y") - $_POST["birthYear"];
		$ageNotice = "<p>Te olete umbkaudu " .$myAge ." aastat vana. </p>";
		
		$ageNotice .= "<p>Olete elanud järgnevatel aastatel:</p> <ul>";
		for ($i = $myBirthYear; $i <= date("Y"); $i++){
			$ageNotice .= "<li>" .$i ."</li>";
		}
		$ageNotice .= "</ul>";
		}
	//suurendamine 1 võrra mingit muutajat saab eri moodi $i++/$i+=1/$i=$i+1
	/*for ($i = 0; $i < 5; $i++) {
		echo "ha";
	}*/
	
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
		echo date("d. ") .$monthNow .date(" Y.") ." Kell oli lehe avamise hetkel " .date("H:i:s") ." Hetkel on: " .$partOfDay;
		echo "</p>";
	?>
	<h2>Natuke vanusest</h2>
	<form method="POST">
		<label>Teie sünniaasta</label>
		<input name="birthYear" id="birthYear" type="number" value="<?php echo $myBirthYear; ?>" min="1900" max="2017">
		<input name="submitBirthYear" type="submit" value="Sisesta">
	</form>
	<?php
		if ($ageNotice != ""){
			echo $ageNotice;
		}
	?>
	
</body>
</html>