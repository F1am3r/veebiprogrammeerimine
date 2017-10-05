
<?php
	require("../../../config.php");
	require("../tund5/functions.php");
	//echo $serverHost;

	//Kui on sisseloginud, siis liigume pealehele
	if(isset($_SESSION["userId"])){
		header("Location: main.php");
		exit();
	}
	$signupFirstName = "";
	$signupFamilyName = "";
	$signupEmail = "";
	$gender = "";
	$signupBirthDay = null;
	$signupBirthMonth = null;
	$signupBirthYear = null;
	$signupBirthDate = null;
	
	$loginEmail = "";
	$loginPassword = "";
	$notice = "";
	
	//vifage
	$signupFirstNameError = "";
	$signupFamilyNameError = "";
	$signupBirthDayError = "";
	$signupGenderError = "";
	$signupEmailError = "";
	$signupPasswordError = "";
	
	$loginEmailError ="";
	$loginPasswordError = "";
	
	//Kas klõpsati sisselogimis nuppu
	if(isset($_POST["signinButton"])){
	
	//kas on kasutajanimi sisestatud
	if (isset ($_POST["loginEmail"])){
		if (empty ($_POST["loginEmail"])){
			$loginEmailError ="NB! Ilma selleta ei saa sisse logida!";
		} else {
			$loginEmail = $_POST["loginEmail"];
		}
	}
	//Kas parool on sisestatud?
	if (isset ($_POST["loginPassword"])){
		if (empty ($_POST["loginPassword"])){
			$loginPasswordError ="NB! Ilma selleta ei saa sisse logida!";
		} else {
			$loginPassword = $_POST["loginPassword"];
		}
	}
	
	if(!empty($loginEmail) and !empty($_POST["loginPassword"])){
		echo "Üritame sisse logida..";
		$notice = signIn($loginEmail, $_POST["loginPassword"]);
	}
	
	}//sisselogimise klõpsu lõpp
	
	
	//kas luuakse uut kasutajat,vajutati nuppu
	if(isset($_POST["signupButton"])){
		
	
	

	//kontrollime, kas kirjutati eesnimi
	if (isset ($_POST["signupFirstName"])){
		if (empty ($_POST["signupFirstName"])){
			$signupFirstNameError ="NB! Väli on kohustuslik!";
		} else {
			$signupFirstName = test_input ($_POST["signupFirstName"]);
		}
	}

	

	//kontrollime, kas kirjutati perekonnanimi
	if (isset ($_POST["signupFamilyName"])){
		if (empty ($_POST["signupFamilyName"])){
			$signupFamilyNameError ="NB! Väli on kohustuslik!";
		} else {
			$signupFamilyName = test_input ($_POST["signupFamilyName"]);
		}
	}

	

	//kontrollime, kas kirjutati kasutajanimeks email
	if (isset ($_POST["signupEmail"])){
		if (empty ($_POST["signupEmail"])){
			$signupEmailError ="NB! Väli on kohustuslik!";
		} else {
			$signupEmail = test_input($_POST["signupEmail"]);
			$signupEmail = filter_var($signupEmail, FILTER_SANITIZE_EMAIL);
			$signupEmail = filter_var($signupEmail, FILTER_VALIDATE_EMAIL);
		}
	}

	

	if (isset ($_POST["signupPassword"])){
		if (empty ($_POST["signupPassword"])){
			$signupPasswordError = "NB! Väli on kohustuslik!";
		} else {
			//polnud tühi
			if (strlen($_POST["signupPassword"]) < 8){
				$signupPasswordError = "NB! Liiga lühike salasõna, vaja vähemalt 8 tähemärki!";
			}
		}
	}
	//kas sünni päev on sisestatud
	if (isset ($_POST["signupBirthDay"])){
		$signupBirthDay = $_POST["signupBirthDay"];
		//echo $signupBirthDay;
	}
	//Kas sünni aasta on sisestatud
	if (isset ($_POST["signupBirthYear"])){
		$signupBirthYear = $_POST["signupBirthYear"];
		//echo $signupBirthYear;
	}
	
	//Kontrollime kas kuu on sisestatud
	if( isset($_POST["signupBirthMonth"])){
		$signupBirthMonth = intval($_POST["signupBirthMonth"]);
	}
	//valiidsus
	if (isset($_POST["signupBirthDay"]) and isset($_POST["signupBirthMonth"])and isset($_POST["signupBirthYear"])){
		if(checkdate(intval($_POST["signupBirthMonth"]),intval($_POST["signupBirthDay"]),intval($_POST["signupBirthYear"]) )){
			$birthDate = date_create($_POST["signupBirthMonth"] ."/" .$_POST["signupBirthDay"] ."/" .$_POST["signupBirthYear"]);
			$signupBirthDate = date_format($birthDate, "Y-m-d");
			echo $signupBirthDate;
		}else{
			$signupBirthDayError = "Sünnikuupäev ei ole lihtsalt valiidne!";
		}
	}else{
		$signupBirthDayError = "Kuupäev on määramata!";
	}
		

	if (isset($_POST["gender"]) && !empty($_POST["gender"])){ //kui on määratud ja pole tühi
			$gender = intval($_POST["gender"]);
		} else {
			//$signupGenderError = " (Palun vali sobiv!) Määramata!";
	}
	//UUE KASUTAJA LISAMINE ANDMEBAASI
	if (empty($signupFirstNameError) and empty($signupFamilyNameError) and empty($signupBirthDayError) and empty($signupGenderError) and empty($signupEmailError) 
		and empty($signupPasswordError) and !empty($_POST["signupPassword"])){
			echo "Hakkan andmeid salvestama!";
			$signupPassword = hash("sha512", $_POST["signupPassword"]);
			
			signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
		}	
	} //uue kasutaja loomise lõpp
	
//Tekitame kuupäeva valiku
	$signupDaySelectHTML = "";
	$signupDaySelectHTML .= '<select name="signupBirthDay">' ."\n";
	$signupDaySelectHTML .= '<option value="" selected disabled>päev</option>' ."\n";
	for ($i = 1; $i < 32; $i ++){
		if($i == $signupBirthDay){
			$signupDaySelectHTML .= '<option value="' .$i .'" selected>' .$i .'</option>' ."\n";
		} else {
			$signupDaySelectHTML .= '<option value="' .$i .'">' .$i .'</option>' ." \n";
		}
	}
	$signupDaySelectHTML.= "</select> \n";
	
	
	//tekitan sünnikuuvaliku
	$monthNamesEt = ["jaanuar","veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
	$signupMonthSelectHTML = "";
	$signupMonthSelectHTML .= '<select name = "signupBirthMonth">' ."\n";
	$signupMonthSelectHTML .= '<option value="" selected disabled>kuu </option>' ."/n";
	foreach($monthNamesEt as $key=>$month){
		if($key+ 1 === $signupBirthMonth){
			$signupMonthSelectHTML .= '<option value="' .($key + 1) .'" selected>' .$month ."</option> \n";
		}	else{
				$signupMonthSelectHTML .= '<option value="' .($key + 1) .'">' .$month ."</option> \n";
		}
	}
	$signupMonthSelectHTML .= "</select> \n";
	
		//Tekitame aasta valiku
	$signupYearSelectHTML = "";
	$signupYearSelectHTML .= '<select name="signupBirthYear">' ."\n";
	$signupYearSelectHTML .= '<option value="" selected disabled>aasta</option>' ."\n";
	$yearNow = date("Y");
	for ($i = $yearNow; $i > 1900; $i --){
		if($i == $signupBirthYear){
			$signupYearSelectHTML .= '<option value="' .$i .'" selected>' .$i .'</option>' ."\n";
		} else {
			$signupYearSelectHTML .= '<option value="' .$i .'">' .$i .'</option>' ."\n";
		}		
	}
	$signupYearSelectHTML.= "</select> \n";
	

?>

<!DOCTYPE html>

<html lang="et">

<head>
	<meta charset="utf-8">
	<title>Sisselogimine või uue kasutaja loomine</title>
</head>

<body>

	<h1>Logi sisse!</h1>
	<p>Siin harjutame sisselogimise funktsionaalsust.</p>

	

	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	
		<label>Kasutajanimi (E-post): </label><br>		
		<input name="loginEmail" type="email" value="<?php echo $loginEmail; ?>">		
		<span><?php echo $loginEmailError; ?></span>
		<br><br>		
		<input name="loginPassword" placeholder="Salasõna" type="password">
		<span><?php echo $loginPasswordError; ?></span>		
		<br><br>		
		<input name="signinButton" type="submit" value="Logi sisse">
		<span><?php echo $notice; ?></span>
		
	</form>

	
	<h1>Loo kasutaja</h1>
	<p>Kui pole veel kasutajat....</p>

	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	
		<label>Eesnimi:</label>
		<br> 
		<input name="signupFirstName" type="text" value="<?php echo $signupFirstName; ?>">	
		<span><?php echo $signupFirstNameError; ?></span>
		<br><br>		
		<label>Perekonnanimi:</label>
		<br>
		<input name="signupFamilyName" type="text" value="<?php echo $signupFamilyName; ?>">	
			<span><?php echo $signupFamilyNameError; ?></span>
		<br><br>	
		<label>Sisestage oma sünnikuupäev</label>
		<br>
		<?php
			echo  $signupYearSelectHTML;
			echo  $signupMonthSelectHTML;
			echo  $signupDaySelectHTML;
		?>
		<span><?php echo $signupBirthDayError; ?></span>
		<br><br>	
		<label>Mees:</label><input type="radio" name="gender" value="1" checked <?php if ($gender == '1') {echo 'checked';} ?>>		
		<label>Naine:</label><input type="radio" name="gender" value="2" <?php if ($gender == '2') {echo 'checked';} ?>>		
		<br><br>		
		<input name="signupEmail" type="email" value="<?php echo $signupEmail; ?>">		
		<span><?php echo $signupEmailError; ?></span>
		<br><br>		
		<label>Parool:</label><br> <input name="signupPassword" placeholder="Salasõna" type="password">		
		<span><?php echo $signupPasswordError; ?></span>
		<br>		
		<p><input name="signupButton" type="submit" value="Registreeri"></p>
		
		
	</form>

		

</body>

</html>