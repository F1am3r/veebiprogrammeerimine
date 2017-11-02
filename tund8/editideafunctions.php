	
<?php


	$database = "if17_janross";
	require("../../../config.php");
	

	//Sisselogimise funtsioon
	function getSingleIdea($editId){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli ->prepare("SELECT idea, ideacolor FROM vpuserideas WHERE id=?");
		echo $mysqli->error;
		$stmt-> bind_param("i", $editId);
		$stmt -> bind_result($idea, $color);
		$stmt->execute();
		$ideaObject = new stdclass();
		if($stmt->fetch()){
			$ideaObject -> text = $idea;
			$ideaObject -> color = $color;
		} else {
			//sellist mõtet polnudki
			$stmt->close();
			$mysqli->close();
			header("Location: usersIdeas.php");
			exit();
		}
		
		$stmt->close();
		$mysqli->close();
		return $ideaObject;
	}

	function updateIdea($id, $idea, $color){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli ->prepare("UPDATE vpuserideas SET idea=?, ideacolor=? WHERE id=?");
		echo $mysqli->error;
		$stmt-> bind_param("ssi",$idea, $color, $id);
		$stmt->execute();
		echo $stmt->error;
		$stmt->close();
		$mysqli->close();
	}

	function deleteIdea($id){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli ->prepare("UPDATE vpuserideas SET deleted = NOW() WHERE id=?");
		echo $mysqli->error;
		$stmt-> bind_param("i", $id);
		$stmt->execute();
		
		$stmt->close();
		$mysqli->close();
	}
	
	

?>