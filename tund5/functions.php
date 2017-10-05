	
<?php
	$database = "if17_janross";
	
	//UUe kasutaja andmebaasi lisamine
	function signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword){	
	
		// ühendus serveriga!
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//käsk serverlile
		$stmt = $mysqli ->prepare("INSERT INTO vpusers (firstname, lastname, birthday, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//s - stringildele ytleme et see on string
		//i - integer
		//d- decimal/ ujukomaarv
		$stmt -> bind_param("sssiss", $signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
		//$stmt->execute();
		
		if ($stmt->execute()){
			echo("NII TORE");
			
		}else{
			echo "Tekkis viga" .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
	}

	//sisestuse kontrollime
	function test_input($data){
		$data = trim($data);//eemaldab lõpust tühiku v tabi
		$data = stripslashes($data);//eemaldab kaldkriipsud
		$data = htmlspecialchars($data);//eemaldab keelatud märgid
		return $data;
	}
	
	/* $x =8;
	$y =5;
	echo "Esimene summa on:" .($x+$y) ." \n";

	addValues();
	
	function addValues(){
		echo "Teine summa on:" .($GLOBALS["x"] + $GLOBALS["y"]) ." \n";
		$a = 4;						//lokaalne muutuja (ei esine väljaspool funktioooni)
		$b = 1;
		echo "Kolmas summa on:" .($a + $b) ." \n";
	}
	
	echo "Neljas summa on:" .($a + $b) ." \n"; */   //Saab tärn kaldkriipsue sees oleva jtu välja kommenteerida!!!!
?>