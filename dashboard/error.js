(function() {
	function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
  }

  function outputError(type, msg) {
  	var error_slot = document.getElementById(type);
  	var error_message = document.createElement("P");
  	var text = document.createTextNode(msg);
  	error_message.appendChild(text);
  	error_slot.appendChild(error_message);
  }

  var error_code = getParameterByName('error');
  var url_error = '';
  var img_error = '';

  if (error_code == null) {

  } else if (error_code == '101') {
  	outputError("img_error","Error 101: The file you are trying to upload is not an image.");
  } else if (error_code == '102') {
  	outputError("img_error","Error 102: The image you are trying to upload is not in 2:1 aspect ratio.");
  } else if (error_code == '100') {
    outputError("img_error","Error 100: The image you are trying to upload is too large (max 10mb).");
  } else if (error_code == '201') {
  	outputError("url_error","Error 201: The URL you entered is invalid.");
  } else if (error_code == '401') {
    outputError("img_error","Error 401: Maximum uploads reached.");
  }
})();