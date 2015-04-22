var room = {
	"id": window.location.hash.substr(1, 2)
};

var message = {
	"id": 0
}

function postMessage(event) {
	var url = event.action;
	$.get(url, {"roomID": room.id, "message": event.message.value}, function(data) {		
		var  returnData = JSON.parse(data);
		if(returnData.error) {
			alert("Error: " + returnData.message);
		}
		else {
			event.message.value = "";
		}
		
		console.log(returnData.message);
	});
	return false;
}

function getMessageData() {
	$.get("src/php/getMessage.php", {"roomID": room.id, "messageID": message.id}, function(data) {
		var  returnData = JSON.parse(data);
		if(returnData.error) {
			if(returnData.stop) clearInterval(chatLoop);
			alert("Error: " + returnData.message);
		}
		else {
			message.id = returnData.lastMessageID || message.id;
			for(i=0; i<returnData.data.length; i++) {
				addMessageDom(returnData.data[i]);
			}
		}
	});
}

chatLoop = setInterval(getMessageData, 1000);

function addMessageDom(messageData) {
	messageContainer = $("<div />", {
		"class": "message " + messageData.messageID + " " + messageData.self,
		"title": "Posted by " + messageData.first + " " + messageData.last + " on " + messageData.date
	});
	
	messageTextContainer = $("<div />", {
		"id": "textContainer",
	});
	
	messageText = $("<span />", {
		"id": "text",
		"text": messageData.message
	});
	
	messageUser = $("<span />", {
		"id": "user",
		"text": messageData.first + " " + messageData.last + ": "
	});
	
	messageDate = $("<div />", {
		"id": "date",
		"text": messageData.date
	});
	
	if($("." + messageData.messageID).length == 0) {
		
		if(Math.abs($("#messages")[0].scrollTop - ($("#messages")[0].scrollHeight - $($("#messages")[0]).height())) <= 5) {
			var autoScroll = true;
		}
		else {
			var autoScroll = false;
		}
		
		messageUser.appendTo(messageContainer);
		messageTextContainer.appendTo(messageContainer);
		messageUser.appendTo(messageTextContainer);
		messageText.appendTo(messageTextContainer);
		messageDate.appendTo(messageContainer);
		messageContainer.appendTo($("#messages"));
	}
	
	if(autoScroll) $("#messages")[0].scrollTop = $("#messages")[0].scrollHeight - $($("#messages")[0]).height();
}