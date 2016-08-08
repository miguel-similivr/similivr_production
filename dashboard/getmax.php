<?php
include_once '../../includes/contentdb_connect.php';
include_once '../../includes/content-config.php';
 
$error_msg = "";
if ($cur_stmt = $contentmysqli->prepare("SELECT COUNT(*) FROM contenturl WHERE username=?")){
  $cur_stmt->bind_param('s', $_SESSION['username']);
  $cur_stmt->execute();
  $cur_stmt->bind_result($currentuploads);
  while ($cur_stmt->fetch()) {
  }
}

if ($max_stmt = $contentmysqli->prepare("SELECT maxuploads FROM uploadlimit WHERE username=?")){
  $max_stmt->bind_param('s', $_SESSION['username']);
  $max_stmt->execute();
  $max_stmt->bind_result($maxuploads);
  while ($max_stmt->fetch()) {
  	$uploadsleft = $maxuploads-$currentuploads;
  	echo '<h2 class="col-lg-12" style="text-align: center;">You have '.$uploadsleft.' remaining uploads</h1>';
  }
}
?>
