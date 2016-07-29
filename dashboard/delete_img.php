<?php
include_once '../../includes/contentdb_connect.php';
include_once '../../includes/content-config.php';
 
require '../aws.phar';
use Aws\S3\S3Client;

$s3Client = S3Client::factory(array(
		    'profile' => 'similivr001',
		    'region'  => 'us-west-2',
		    'version' => 'latest'
		));

$bucket = 'similivruploads001';
$keyname = '*** Your Object Key ***';

$result = $s3->deleteObject(array(
    'Bucket' => $bucket,
    'Key'    => $keyname
));
?>