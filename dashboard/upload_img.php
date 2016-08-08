<?php
include_once '../../includes/contentdb_connect.php';
include_once '../../includes/content-config.php';
include_once '../../includes/functions.php';

require '../aws.phar';

use Aws\S3\S3Client;

sec_session_start();

$uploader = $_SESSION['username'];
$uploadOk = 1;
$input_error ="";

$bucket = 'similivruploads001';

$target_dir = "/var/www/simili.io/public_html/uploads/";
$file_basename = basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$temp_file = $_FILES["fileToUpload"]["tmp_name"];
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

list($upload_width, $upload_height) = getimagesize($temp_file);


if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //"File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        //"File is not an image.";
        header("Location: dashboard.php?error=101");
        exit;
        $uploadOk = 0;

    }
}

if ($_FILES["fileToUpload"]["size"] > 10000000) {
    //File is too large;
    $uploadOk = 0;
    header("Location: dashboard.php?error=100");
    exit;
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "JPEG") {
    //"Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
    header("Location: dashboard.php?error=101");
    exit;
} /*else {
		try {
			$ratio = $upload_width / $upload_height;
			if ($ratio != 2) {
		    //"Sorry, this is not an equirectangular image.";
		    $uploadOk = 0;
		    header("Location: dashboard.php?error=102");
		    exit;
			}
		} catch (Exception $e) {
			//"Sorry, this is not an equirectangular image.";
			$uploadOk = 0;
			header("Location: dashboard.php?error=102");
			exit;
		}
}*/

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
  }
}

if ($currentuploads+1>$maxuploads) {
	$uploadOk = 0;
	header("Location: dashboard.php?error=401");
	exit;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $upload_status = "Sorry, your file/url was not uploaded.";
// if everything is ok, try to upload file
} 
else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
  	$upload_status = "Your upload is processing now! Please wait while we do our magic.";

  	$imagick = new \Imagick(realpath($target_file));

  	$imagick->resizeImage(4096,2048,imagick::FILTER_LANCZOS, 1);

  	$imagick->writeImage($target_file);

		$s3Client = S3Client::factory(array(
		    'profile' => 'similivr001',
		    'region'  => 'us-west-2',
		    'version' => 'latest'
		));

		$result = $s3Client->putObject(array(
		    'Bucket'     => $bucket,
		    'Key'        => $uploader.'/'.$file_basename,
		    'SourceFile' => $target_file
		    )
		);

		$s3Client->waitUntil('ObjectExists', array(
		    'Bucket' => $bucket,
		    'Key'    => $uploader.'/'.$file_basename
		));

		$plainUrl = $s3Client->getObjectUrl($bucket, $uploader.'/'.$file_basename);

		if ($insert_stmt = $contentmysqli->prepare("INSERT INTO contenturl (username, url, created_datetime) VALUES (?, ?, NOW())")) {
		  $insert_stmt->bind_param('ss', $uploader, $plainUrl);
		  // Execute the prepared query.
		  if (! $insert_stmt->execute()) {
	  		//error line here
	      header('Location: dashboard.php?error=301');
				exit;
			}
			unlink($target_file);
		}
	}
}
header("Location: dashboard.php");
?>
