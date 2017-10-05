	
<?php

	session_start();
	$database = "if17_janross";
	
	//Sisselogimise funtsioon
	function signIn($email, $password){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli ->prepare("SELECT id, email, password FROM vpusers WHERE email = ?");
		$stmt ->bind_param("s",$email);
		$stmt ->bind_result($id, $emailFromDb, $passwordFromDb);
		$stmt->execute();
		
		//KOntrollime kasutajat
		if($stmt->fetch()){
			$hash = hash("sha512", $password);
			if($hash == $passwordFromDb){
			$notice = "Kõik korras, logisimegi sisse";
			
			//salvestame sessioonimuutujad
			$_SESSION["userId"] = $id;
			$_SESSION["userEmail"] = $emailFromDb;
			
			//liigume pealehele
			header("Location: main.php");
			exit();
			
			} else {
				$notice = "Sisestasite vale salasõna!";
			}
		} else {
			$notice = "Sellist kasutajat(" .$email .") ei eksisteeri";
		}
		return $notice;
	}
	
	
	
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