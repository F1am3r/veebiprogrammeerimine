<?php

	//Et pääseks ligi funktsioonidele ja sessionile
	require("functions.php");
	require("editideafunctions.php");
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

	if(isset($_POST["ideaButton"])){
		updateIdea($_POST["id"], test_input($_POST["idea"]), $_POST["ideaColor"]);
		header("Location: ?id=" .$_POST["id"]);
	
	}
	
	if (isset($_GET["delete"])){
		deleteIdea($_GET["id"]);
		header("Location: usersIdeas.php");
		exit();
	}
	
	
	if (isset($_GET["id"])){
		$idea = getSingleIdea($_GET["id"]);
	}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Jan-Rossi veebiprogrammerimise raames loodud leht</title>
</head>
<body>
	<h1>Head mõtted</h1>
	<p>See veebileht on loodud õppetöö raames ning ei 
	sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<p><a href="usersIdeas.php">Tagasi mõtete lehele</a></p>
	<br>
	<p><a href="?Logout=1">Logi välja</a></p>
	<hr>
	<h2>Toimeta mõtet</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<input name="id" type="hidden" value="<?php echo $_GET["id"] ?>">
		<label>Hea mõte: </label>
		<textarea name="idea"><?php echo $idea->text;?></textarea>
		<br>
		<label>Mõttega seonduv värv: </label>
		<input name="ideaColor" type="color" value="<?php echo $idea->color ?>">
		<br>
		<input name="ideaButton" type="submit" value="Salvesta muudatus!">
		<span><?php echo $notice; ?></span>
		<input name="deleteIdea" type="submit" value="Kustuta kommentaar!">
	</form>
	<p><a href="?id=<?=$_GET['id'];?>&delete=1">Kustuta </a> see mõte </p>
	<!-- <a href="?id=19&delete=1"> -->
	</hr>
	

</body>
</html>