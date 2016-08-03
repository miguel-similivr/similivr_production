<?php
include_once '../../includes/contentdb_connect.php';
include_once '../../includes/content-config.php';
 
$error_msg = "";

$contentarray = array();

class contentobject {
	public $contentobjectuser;
	public $contentobjectid;
	public $contentobjecturl;
}
 
$currentuser = $_SESSION['username'];
if ($select_stmt = $contentmysqli->prepare("SELECT id,url FROM contenturl WHERE username = ? ORDER BY created_datetime DESC")) {
	$select_stmt->bind_param('s', $currentuser);
	// Execute the prepared query.
	$select_stmt->execute();
	$select_stmt->bind_result($displayid, $displayurl);

	while ($select_stmt->fetch()) {
		$object = new contentobject;
		$object->contentobjectuser = $currentuser;
		$object->contentobjectid = $displayid;
		$object->contentobjecturl = $displayurl;
		array_push($contentarray, $object);
   }
}
?>
