function createcontentpanel(contentobject) {
	var contentcontainer = document.getElementById("contentcontainer");
	var contentdiv = document.createElement("div");
	contentdiv.className = "row panel panel-default";

	var thumbnail = document.createElement("div");
	thumbnail.className = "col-lg-3 col-xs-12 thumb";
	thumbnail.innerHTML = "<img class='img-responsive' src='" + contentobject.contentobjecturl + "'/>";

	var text = document.createElement("div");
	text.className = "col-lg-8 col-xs-10 col-xs-offset-1 textcontent";

	var url = document.createElement("p");
	url.innerHTML =  "Source: <a href=" + contentobject.contentobjecturl + ">" + contentobject.contentobjecturl +"</a>";

	var playerurl = "https://simili.io/player.html?id=" + contentobject.contentobjectid + "&user=" + contentobject.contentobjectuser;
	var playerlink = document.createElement("p");
	playerlink.innerHTML = "Link to player (click for preview): <a href='" + playerurl + "'>" + playerurl + "</a>";

	var embed = document.createElement("p");
	embed.innerHTML = "Embed code: <br><code>&ltiframe src='" + playerurl + "' height=\"200\" width=\"300\" style=\"border:none;\" allowfullscreen&gt&lt/iframe&gt</code>";

	var deleteform = document.createElement("form");
	deleteform.name = "deleteForm";
	deleteform.method = "POST";
	deleteform.action = "delete_img.php";

	var deletebtn  = document.createElement("input");
	deletebtn.name = "deletebtn";
	deletebtn.className = "btn";
	deletebtn.value = "Delete";
	deletebtn.type = "submit";

	var deletefile  = document.createElement("input");
	deletefile.name = "deletefile";
	deletefile.id = "deletefile";
	deletefile.value = contentobject.contentobjecturl.split('/')[5];
	deletefile.type = "hidden";


	var deleteid  = document.createElement("input");
	deleteid.name = "deleteid";
	deleteid.id = "deleteid";
	deleteid.value = contentobject.contentobjectid;
	deleteid.type = "hidden";
	
	contentcontainer.appendChild(contentdiv);
	contentdiv.appendChild(thumbnail);
	contentdiv.appendChild(text);
	text.appendChild(url);
	text.appendChild(playerlink);
	text.appendChild(embed);
	thumbnail.appendChild(deleteform);
	deleteform.appendChild(deletebtn);
	deleteform.appendChild(deletefile);
	deleteform.appendChild(deleteid);
}