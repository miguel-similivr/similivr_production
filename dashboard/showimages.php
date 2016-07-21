<?php
include_once '../../includes/contentdb_connect.php';
include_once '../../includes/content-config.php';
 
$error_msg = "";
 
$currentuser = $_SESSION['username'];
if ($select_stmt = $contentmysqli->prepare("SELECT id,url FROM contenturl WHERE username = ? ORDER BY created_datetime DESC")) {
	$select_stmt->bind_param('s', $currentuser);
	// Execute the prepared query.
	$select_stmt->execute();
	$select_stmt->bind_result($displayid, $displayurl);

	while ($select_stmt->fetch()) {
		echo "<div class='row panel panel-default'>";
			echo "<div class='col-lg-3 col-xs-12 thumb'>";
				echo "<img class='img-responsive' src=$displayurl alt='$displayurl'>";
			echo "</div>";
			echo "<div class='col-lg-8 col-xs-10 col-xs-offset-1 textcontent'>";
				echo "<p>url: <a href=$displayurl>$displayurl</a></p>";
				echo "<p>Link to player (click for preview): <a href='https://simili.io/player.html?id=$displayid&user=$currentuser'>https://simili.io/player.html?id=$displayid&user=$currentuser</a></p>";
				echo "<p>";
				echo "embed code:";
				echo "<code><p>&ltiframe src=\"https://simili.io/player.html?id=$displayid&user=$currentuser\" height=\"200\" width=\"300\" style=\"border:none;\" allowfullscreen&gt&lt/iframe&gt</p></code>";
				echo "</p>";
			echo "</div>";
		echo "</div>";
   }
}
?>
