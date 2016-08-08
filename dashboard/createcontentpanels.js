var ispreviewing = false;

function createiframe(url, previewbtnelement) {
	if (ispreviewing == false) {
		var iframediv = document.createElement('div');
		iframediv.className = "col-lg-12";
		iframediv.id = "iframediv";

		var iframe = document.createElement('iframe');
		iframe.src = url;
		//iframe.height = "600px";
		iframe.width = "100%";
		iframe.style.border = "none";
		iframe.style.display = "block";
		iframe.setAttribute('allowFullScreen', '');

		previewbtnelement.appendChild(iframediv);
		iframediv.appendChild(iframe)

		ispreviewing = true;
	} else  {
		document.getElementById("iframediv").remove();
		ispreviewing = false;

		if (document.getElementById("iframediv").src == url) {
			return;
		} else {
			createiframe(url, previewbtnelement);
		}
	}
}

function createsharelinks(contentbody, playerlink, embed) {
	contentbody.appendChild(playerlink);
	contentbody.appendChild(embed);
}

function createcontentpanel(contentobject, index) {
	var contentcontainer = document.getElementById("contentcontainer");
	var contentdiv = document.createElement("div");
	contentdiv.className = "card col-lg-12 col-xs-12"//"row panel panel-default";
	contentdiv.id = "content-"+index.toString();

	var thumbnail = document.createElement("div");
	thumbnail.className = "col-lg-12 col-xs-12 thumb card-img-top";
	thumbnail.innerHTML = "<img class='img-responsive' src='" + contentobject.contentobjecturl + "'/>";

	var contentbody = document.createElement("div");
	contentbody.className = "col-lg-12 col-xs-12 textcontent card-block";

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
	deletebtn.className = "btn delete";
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

	var previewbtn  = document.createElement("button");
	previewbtn.id = "previewbtn-"+index.toString();
	previewbtn.className = "btn preview";
	previewbtn.onclick = function(){createiframe(playerurl, contentdiv)};
	previewbtn.innerHTML = "Preview";

	var sharebtn  = document.createElement("button");
	sharebtn.id = "sharebtn-"+index.toString();
	sharebtn.className = "btn share";
	sharebtn.innerHTML = "Share";
	sharebtn.onclick = function(){createsharelinks(contentbody, playerlink, embed)};
	
	contentcontainer.appendChild(contentdiv);
	contentdiv.appendChild(thumbnail);
	contentdiv.appendChild(contentbody);
	//text.appendChild(url);
	contentbody.appendChild(deleteform);
	//contentbody.appendChild(previewbtn);
	//contentbody.appendChild(sharebtn);
	contentbody.appendChild(playerlink);
	contentbody.appendChild(embed);
	deleteform.appendChild(deletebtn);
	deleteform.appendChild(deletefile);
	deleteform.appendChild(deleteid);
	

	$("#"+previewbtn.id).on('touchstart', function(){
		createiframe(playerurl, contentdiv);
	});
}