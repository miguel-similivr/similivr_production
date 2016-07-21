<?php
include_once '../../includes/contentdb_connect.php';
include_once '../../includes/content-config.php';

$contentid=$_GET['id'];
$contentuser=$_GET['user'];

if ($select_stmt = $contentmysqli->prepare("SELECT url FROM contenturl WHERE ((id = ?) AND (username = ?)) ")) {
	$select_stmt->bind_param('ss', $contentid, $contentuser);
	$select_stmt->execute();
	$select_stmt->bind_result($displayurl);
	if ($select_stmt->fetch()){
		echo $displayurl;
	}
}
?>
