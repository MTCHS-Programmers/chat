<link rel="stylesheet" type="text/css" href="src/css/style.css">

<script src="src/js/chat.js"></script>

<div id="chatContainer" class="subItem">
	<div id="messages">
	</div>
	
	<br />
	<hr />
	<br />
	<div id="textBox">
		<form action="src/php/postMessage.php" onsubmit="return postMessage(this)" >
			<input type="text" id="message" placeholder="Message" autocomplete="off" />
			<input type="submit" id="submit" />
		</form>
	</div>
</div>