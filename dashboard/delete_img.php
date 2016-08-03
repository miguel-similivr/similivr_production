<?php
include_once '../../includes/contentdb_connect.php';
include_once '../../includes/content-config.php';
include_once '../../includes/functions.php';
 
require '../aws.phar';
use Aws\S3\S3Client;

sec_session_start();

$deletefile = $_POST["deletefile"];
$deleteid = $_POST["deleteid"];
$deleter = $_SESSION['username'];

$s3Client = S3Client::factory(array(
		    'profile' => 'similivr001',
		    'region'  => 'us-west-2',
		    'version' => 'latest'
		));

$bucket = 'similivruploads001';
$keyname = $deleter."/".$deletefile;

$result = $s3Client->deleteObject(array(
    'Bucket' => $bucket,
    'Key'    => $keyname
));

if ($delete_stmt = $contentmysqli->prepare("DELETE FROM contenturl WHERE (id = ? AND username = ?)")) {
		  $delete_stmt->bind_param('ss', $deleteid, $deleter);
		  // Execute the prepared query.
		  if (!$delete_stmt->execute()) {
		  		//error line here
		      header('Location: dashboard.php?error=301');
			exit;
			}
		}

header("Location: dashboard.php");
?>