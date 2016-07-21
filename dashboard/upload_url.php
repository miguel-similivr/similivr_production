<?php
include_once '../../includes/contentdb_connect.php';
include_once '../../includes/content-config.php';
 
if (isset($_POST['username'],$_POST['url'])) {
    // Sanitize and validate the data passed in
		$uname = $_POST['username'];
    $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);

    //Testing if this is a valid URL
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        // Not a valid url
        header("Location: dashboard.php?error=201");
        exit;
    } 

    else {
	    // Insert the new url into the database 
	    if ($insert_stmt = $contentmysqli->prepare("INSERT INTO contenturl (username, url, created_datetime) VALUES (?, ?, NOW())")) {
	        $insert_stmt->bind_param('ss', $uname, $url);
	        // Execute the prepared query.
	        if (! $insert_stmt->execute()) {
	        		//error line here
	            header('Location: ../index.php');
	        }
	    }
	    header('Location: dashboard.php');
    }
}
?>