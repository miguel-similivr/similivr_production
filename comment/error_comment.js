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

  } else if (error_code == '801') {
  	outputError("com_error","Error 801: parent is not set.");
  }
})();