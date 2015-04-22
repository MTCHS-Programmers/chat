<h3>Select a Chat Room Below</h3>

<ul>
	<?php
		/* list of all chartrooms */
		$sql = "SELECT r.roomID, r.name, r.date, u.first, u.last FROM rettoph_projects.chatRooms r JOIN userList u USING(userID);";
		$roomData = query($sql)["rows"];
		foreach($roomData as $room) {
			echo "<li><a href=\"?t=2#" . $room["roomID"] . "\">" . $room["name"] . "</a></li>";
		}
	?>
</ul>