<?php
	//Et pääseks ligi funktsioonidele ja sessionile
	require("functions.php");
	$notice = "";
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

	$maxWidth = 600;
	$maxHeight = 400;
	$marginHor = 10;
	$marginVer = 10;
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$target_dir = "../../pics/";
		//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);    vana variant, kus ei muuda failinime.
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
		$target_file = $target_dir .pathinfo(basename($_FILES["fileToUpload"]["name"]))["filename"] ."_" .(microtime(1)*10000) ."." .$imageFileType;
		//kas fail on valitud, failinimi olemas
		if(!empty($_FILES["fileToUpload"]["name"])){
		
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				$uploadOk = 1;
			} else {
				$notice .= "Tegemist ei ole pildiga.";
				$uploadOk = 0;
			}
		
		// Check if file already exists
		if (file_exists($target_file)) {
			$notice .= "Vabandame, see fail juba eksisteerib."."<br>";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 2000000) {
			$notice .= "Vabandust, fail on liiga suur."."<br>";
			$uploadOk = 0;
		} 
			// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			$notice .= "Vabandust, ainult JPG, JPEG, PNG & GIF failitüübid on lubatud."."<br>";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0){
			$notice .= "Teie faili ei laetud üles.";
		// if everything is ok, try to upload file
		} else {
			/*if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				$notice = "Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üles laetud.";
			} else {
				$notice .= "Vabandust, kuid faili üleslaadimisel tekkis viga.";
			}*/
			//sõltuvalt failititüübist loon objekti, mille suurust tahan muuta
			if($imageFileType == "jpg" or $imageFileType == "jpeg"){
				$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
			}
			if($imageFileType == "png"){
				$myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
			}
			if($imageFileType == "gif"){
				$myTempImage = imagecreatefromgif($_FILES["fileToUpload"]["tmp_name"]);
			}
			
			//suuruse muutmine
			//teeme kindlaks preaguse suuruse
			$imageWidth = imagesx($myTempImage);
			$imageHeight = imagesy($myTempImage);
			//arvutan suuruse suhte
			if($imageWidth > $imageHeight) {
				$sizeRatio = $imageWidth/$maxWidth;
			} else {
				$sizeRatio = $imageHeight/$maxHeight;
			}
			//tekitame uue, sobiva suurusega pildi
			$myImage = resizeImage($myTempImage, $imageWidth, $imageHeight, round($imageWidth/$sizeRatio), round($imageHeight/$sizeRatio));
			
			//lisan vesimärgi
			$stamp = imagecreatefrompng("../../graphics/hmv_logo2.png");
			$stampWidth = imagesx($stamp);
			$stampHeight = imagesy($stamp);
			$stampX = imagesx($myImage) - $stampWidth - $marginHor;
			$stampY = imagesy($myImage) - $stampHeight - $marginVer;
			imagecopy($myImage, $stamp, $stampX, $stampY, 0, 0, $stampWidth, $stampHeight);
			
			//lisan teksti
			$textToImage = "Heade mõtete veeb";
			//määrata värv
			$textColor = imagecolorallocatealpha($myImage, 255,255,255,60);
			imagettftext($myImage, 20, -45, 10, 25, $textColor, "../../graphics/VIBES.ttf", $textToImage);
			
			
			//salvestame pildi jpg
			if($imageFileType == "jpg" or $imageFileType == "jpeg"){
				if(imagejpeg($myImage, $target_file, 90)){
					$notice = "Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üles laetud.";
				} else {
					$notice .= "Vabandust, kuid faili üleslaadimisel tekkis viga.";
				}				
			}
			//png salvestamine
			if($imageFileType == "png"){
				if(imagepng($myImage, $target_file)){
					$notice = "Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üles laetud.";
				} else {
					$notice .= "Vabandust, kuid faili üleslaadimisel tekkis viga.";
				}				
			}
			//gif salvestamine
			if($imageFileType == "gif"){
				if(imagegif($myImage, $target_file)){
					$notice = "Fail ". basename( $_FILES["fileToUpload"]["name"]). " on üles laetud.";
				} else {
					$notice .= "Vabandust, kuid faili üleslaadimisel tekkis viga.";
				}				
			}
			
			//vabastan mälu
			imagedestroy($myTempImage);
			imagedestroy($myImage);
			imagedestroy($stamp);
			
		}//saab salvestada lõppeb
		} else {
			$notice = "Palun valige pildifail!";
		}
	}//if submit lõppeb
	
	function resizeImage($image, $origW, $origH, $w, $h){
		$newImage = imagecreatetruecolor($w, $h);
		imagesavealpha($newImage, true);
		$trans_colour = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
		imagefill($newImage, 0, 0, $trans_colour);
		//kuhu, kust, mis kordinaatidele x ja y, kust kordinaatidelt x ja y, uued w ja h ning originaal w ja h.
		imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $origW, $origH);
		return $newImage;
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
	<h2>Fotode lisamine!</h2>
	<form action="photoUpload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
	</form>
	<span style="color:red;"><?php echo $notice; ?></span>


</body>
</html>