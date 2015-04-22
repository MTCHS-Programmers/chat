<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . "/src/light.php");
	
	$returnData = array(
		error => true,
		message => "Error",
		stop => true
	);
	
	if(is_null($page["user"])) {
		$returnData["message"] = "You must be logged in to post messages.";
	}
	elseif(query("SELECT * FROM chatRooms WHERE roomID=" . $_GET["roomID"], "projects")["data"]->num_rows == 0) {
		$returnData["message"] = "Invalid Room ID.";
	}
	else if(query("SELECT * FROM chatMessages WHERE userID=\"" . $page["user"]["userID"] . "\" AND date > SYSDATE()-5", "projects")["data"]->num_rows >= 5) {
		$returnData["message"] = "Stop Spamming!";
		$returnData["stop"] = false;
	}
	else {
		$returnData["error"] = false;
		$returnData["message"] = "Message uploaded.";
		
		$sql = "INSERT INTO `chatMessages`(`roomID`, `userID`, `message`) VALUES (" . $_GET["roomID"] . "," . $page["user"]["userID"] . ",\"" . $_GET["message"] . "\")";
		query($sql, "projects");
	}
	
	echo json_encode($returnData);
?>