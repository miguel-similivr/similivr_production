<?php
include_once '../includes/contentdb_connect.php';
include_once '../includes/content-config.php';
include_once '../includes/functions.php';

sec_session_start();

if ($select_stmt = $contentmysqli->prepare("SELECT commenter,comment_body,created_datetime FROM comments WHERE parent_id = 94 ORDER BY created_datetime DESC")) {
	// Execute the prepared query.
	$select_stmt->execute();
	$select_stmt->bind_result($commenter, $comment_body, $created_datetime);

	while ($select_stmt->fetch()) {
		echo "<div class='row'>";
			echo "<div class='col-lg-12'>";
				echo "<p><b>$commenter</b> on <b>$created_datetime</b>: $comment_body </p>";
			echo "</div>";
		echo "</div>";
   }
}
?>