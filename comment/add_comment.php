<?php
include_once '../../includes/contentdb_connect.php';
include_once '../../includes/content-config.php';
include_once '../../includes/functions.php';

sec_session_start();

$commenter = $_SESSION['username'];
$parent_id = $_POST['parentid'];
$comment_body = $_POST['commentbody'];

if ($comment_stmt = $contentmysqli->prepare("INSERT INTO comments (commenter, parent_id, comment_body, created_datetime) VALUES (?, ?, ?, NOW())")) {
		  $comment_stmt->bind_param('sss', $commenter, $parent_id, $comment_body);
		  // Execute the prepared query.
		  if (! $comment_stmt->execute()) {
	  		//error line here
	      header('Location: dashboard.php?error=301');
				exit;
			}
			header('Location: ../playercomment.php?id=94&user=test7');
		}
?>