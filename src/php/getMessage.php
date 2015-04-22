<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/src/light.php");
	
	$returnData = array(
		error => true,
		message => "Error",
		data => array(),
		lastMessageID => null
	);
	
	if(is_null($page["user"])) {
		$returnData["message"] = "You must be logged in to view messages.";
	}
	elseif(query("SELECT * FROM chatRooms WHERE roomID=" . $_GET["roomID"], "projects")["data"]->num_rows == 0) {
		$returnData["message"] = "Invalid Room ID.";
	}
	else {
		$returnData["error"] = false;
		$returnData["message"] = "Messages getted.";
		
		$sql = "SELECT m.messageID, m.message, m.date, u.first, u.last FROM `chatMessages` m JOIN rettoph_main.userList u USING(userID) WHERE roomID=" . $_GET["roomID"] . " AND messageID > " . $_GET["messageID"] . " ORDER BY messageID ASC";
		$returnData["data"] = query($sql, "projects")["rows"];
		for($i=0; $i<count($returnData["data"]); $i++) {
			if($returnData["data"][$i]["first"] == $page["user"]["first"] && $returnData["data"][$i]["last"] == $page["user"]["last"]) {
				$returnData["data"][$i]["self"] = true;
			}
			
			$returnData["lastMessageID"] = $returnData["data"][$i]["messageID"];
		}
	}
	
	echo json_encode($returnData);
?>